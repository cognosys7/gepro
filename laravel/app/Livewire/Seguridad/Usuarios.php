<?php

namespace App\Livewire\Seguridad;

use App\Auth\LegadoUserProvider;
use App\Support\Procedimiento;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Locked;
use Livewire\Component;
use RuntimeException;
use Throwable;

/**
 * Usuarios (antes UsuariosVista / UsuariosLN). Se registran desde el DNI: primero se busca a la persona
 * en general.tgpersona y, si no esta, en BDRENIEC (como el sistema actual). Graban
 * seguridad.paInsertaDatosUsuarioPersonal (persona, personal y usuario), paActualizaDatosUsuarioPersonal,
 * paEliminaDatosUsuarioPersonal y paActualizaClaveUsuario (la clave vuelve a ser el DNI).
 * Los perfiles de cada usuario se asignan en App\Livewire\Seguridad\UsuarioPerfiles.
 */
class Usuarios extends Component
{
    use Grilla;

    public bool $abierto = false;

    /** 'dni': se pide el DNI; 'datos': formulario con los datos de la persona */
    public string $paso = 'dni';

    #[Locked]
    public ?int $idUsuario = null;

    #[Locked]
    public ?int $idPersona = null;

    #[Locked]
    public ?int $idPersonal = null;

    #[Locked]
    public ?int $unidad = null;

    /** De donde salieron los datos al registrar: 'persona' (ya registrada), 'reniec' o '' (se escriben) */
    #[Locked]
    public string $origen = '';

    public array $datos = [];

    public function columnas(): array
    {
        return [
            'dni' => ['DNI', 'u.usunombre', true],
            'usuario' => ['Usuario', 'u.usuldap', true],
            'persona' => ['Persona', "p.PerApePaterno + ' ' + p.PerApeMaterno + ' ' + p.PerNombres", true],
            'perfiles' => ['Perfiles', "(SELECT STRING_AGG(CAST(RTRIM(s.sisabreviatura) + ': ' + RTRIM(pf.pefnombre) AS varchar(max)), ' · ') WITHIN GROUP (ORDER BY s.sisabreviatura) FROM seguridad.tsusuarioperfil up INNER JOIN seguridad.tsperfil pf ON pf.idperfil = up.upsperfil AND pf.pefestado = 1 INNER JOIN seguridad.tsmodulo m ON m.idmodulo = pf.pefmodulo AND m.modestado = 1 INNER JOIN seguridad.tssistema s ON s.IdSistema = m.modsistema AND s.sisestado = 1 WHERE up.upsusuario = u.idusuario AND up.upsestado = 1)", false],
        ];
    }

    /** Usuarios activos con persona y personal activos (como paListarUsuariosFlexigrid) */
    private function base()
    {
        return DB::table('seguridad.tsusuario as u')
            ->join('general.tgpersona as p', 'p.IdPersona', '=', 'u.usupersona')
            ->join('general.trpersonal as r', 'r.prhpersona', '=', 'p.IdPersona')
            ->where('u.usuestado', 1)->where('p.PerEstado', 1)->where('r.prhestado', 1);
    }

    private function fila(int $id): ?object
    {
        return $this->base()->where('u.idusuario', $id)
            ->first(['u.idusuario', 'u.usunombre', 'u.usuldap', 'p.IdPersona', 'r.idpersonal', 'r.prhunidadorganica', 'p.PerApePaterno', 'p.PerApeMaterno', 'p.PerNombres', 'p.PerFecNacimiento', 'p.PerSexo', 'p.PerNroDocumento']);
    }

    private function vacios(): array
    {
        return ['dni' => '', 'usuario' => '', 'paterno' => '', 'materno' => '', 'nombres' => '', 'nacimiento' => '', 'sexo' => '1'];
    }

    public function nuevo(): void
    {
        $this->resetErrorBag();
        $this->idUsuario = $this->idPersona = $this->idPersonal = $this->unidad = null;
        $this->origen = '';
        $this->datos = $this->vacios();
        $this->paso = 'dni';
        $this->abierto = true;
    }

    /** Busca el DNI: en las personas registradas y, si no esta, en RENIEC (BuscarVisitaForm del sistema actual) */
    public function verificar(): void
    {
        if ($this->idUsuario) {
            return;
        }
        $this->datos['dni'] = trim((string) ($this->datos['dni'] ?? ''));
        $this->validate(['datos.dni' => ['required', 'digits:8']], [], ['datos.dni' => 'DNI']);
        $dni = $this->datos['dni'];

        //EL DNI ES EL NOMBRE DE USUARIO (usunombre): NO PUEDE HABER DOS
        $existente = DB::table('seguridad.tsusuario')->where('usuestado', 1)->where('usunombre', $dni)->exists();
        $persona = DB::table('general.tgpersona')->where('PerEstado', 1)
            ->where('PerDocumento', (int) config('gepro.seguridad.documento_dni'))->where('PerNroDocumento', $dni)
            ->orderBy('IdPersona')->first();
        if ($existente || ($persona && DB::table('seguridad.tsusuario')->where('usuestado', 1)->where('usupersona', $persona->IdPersona)->exists())) {
            $this->addError('datos.dni', 'Ya hay un usuario con ese DNI.');

            return;
        }

        $datos = ['dni' => $dni] + $this->vacios();
        $this->idPersona = null;
        if ($persona) {
            $this->idPersona = (int) $persona->IdPersona;
            $this->origen = 'persona';
            $datos = array_merge($datos, [
                'paterno' => trim((string) $persona->PerApePaterno),
                'materno' => trim((string) $persona->PerApeMaterno),
                'nombres' => trim((string) $persona->PerNombres),
                'nacimiento' => $persona->PerFecNacimiento ? Carbon::parse($persona->PerFecNacimiento)->format('Y-m-d') : '',
                'sexo' => (string) (int) $persona->PerSexo === '0' ? '0' : '1',
            ]);
        } elseif ($reniec = $this->reniec($dni)) {
            $this->origen = 'reniec';
            $datos = array_merge($datos, $reniec);
        } else {
            $this->origen = '';
        }
        $datos['dni'] = $dni;
        $this->datos = $datos;
        $this->resetErrorBag();
        $this->paso = 'datos';
    }

    /** Datos de la persona en BDRENIEC (dbo.MostrarDatosPorDNI), o null si no esta o no hay conexion */
    private function reniec(string $dni): ?array
    {
        try {
            $f = DB::connection('reniec')->table('dbo.DataReniec')->where('Dni', $dni)
                ->first(['ApellidoPaterno', 'ApellidoMaterno', 'Nombres', 'FechaNacimiento', 'Sexo']);
        } catch (Throwable $e) {
            report($e);

            return null;
        }
        if (! $f) {
            return null;
        }

        return [
            'paterno' => mb_substr(trim((string) $f->ApellidoPaterno), 0, 30),
            'materno' => mb_substr(trim((string) $f->ApellidoMaterno), 0, 30),
            'nombres' => mb_substr(trim((string) $f->Nombres), 0, 40),
            'nacimiento' => $f->FechaNacimiento ? Carbon::parse($f->FechaNacimiento)->format('Y-m-d') : '',
            //EN RENIEC 1 = HOMBRE Y 2 = MUJER; EN tgpersona 1 = HOMBRE Y 0 = MUJER
            'sexo' => (string) (int) $f->Sexo === '2' ? '0' : '1',
        ];
    }

    public function editar(int $id): void
    {
        $f = $this->fila($id);
        if (! $f) {
            return;
        }
        $this->resetErrorBag();
        $this->idUsuario = (int) $f->idusuario;
        $this->idPersona = (int) $f->IdPersona;
        $this->idPersonal = (int) $f->idpersonal;
        $this->unidad = $f->prhunidadorganica !== null ? (int) $f->prhunidadorganica : null;
        $this->origen = '';
        $this->datos = [
            'dni' => trim((string) $f->usunombre),
            'usuario' => trim((string) $f->usuldap),
            'paterno' => trim((string) $f->PerApePaterno),
            'materno' => trim((string) $f->PerApeMaterno),
            'nombres' => trim((string) $f->PerNombres),
            'nacimiento' => $f->PerFecNacimiento ? Carbon::parse($f->PerFecNacimiento)->format('Y-m-d') : '',
            'sexo' => (string) (int) $f->PerSexo === '0' ? '0' : '1',
        ];
        $this->paso = 'datos';
        $this->abierto = true;
    }

    public function cerrar(): void
    {
        $this->abierto = false;
        $this->resetErrorBag();
    }

    /** Vuelve a pedir el DNI (solo al registrar) */
    public function otroDni(): void
    {
        if (! $this->idUsuario) {
            $this->resetErrorBag();
            $this->paso = 'dni';
        }
    }

    public function guardar(): void
    {
        if ($this->paso !== 'datos') {
            $this->verificar();

            return;
        }
        $this->datos = array_map(fn ($v) => is_string($v) ? trim($v) : $v, $this->datos);
        foreach (['paterno', 'materno', 'nombres'] as $c) {
            $this->datos[$c] = mb_strtoupper((string) ($this->datos[$c] ?? ''), 'UTF-8');
        }
        $this->datos['usuario'] = strtoupper((string) ($this->datos['usuario'] ?? ''));
        $this->validate([
            'datos.dni' => ['required', 'digits:8'],
            //EL INGRESO ACEPTA EL DNI O ESTE NOMBRE: SIN LOS CARACTERES QUE EL LOGIN QUITA (', ;, %)
            'datos.usuario' => ['nullable', 'max:20', 'regex:/^[A-Z0-9._@-]+$/'],
            'datos.paterno' => ['required', 'max:30'],
            'datos.materno' => ['required', 'max:30'],
            'datos.nombres' => ['required', 'max:40'],
            'datos.nacimiento' => ['required', 'date_format:Y-m-d', 'before:today', 'after:1900-01-01'],
            'datos.sexo' => ['required', 'in:0,1'],
        ], ['datos.usuario.regex' => 'El usuario solo puede tener letras, números y . _ @ -'], [
            'datos.dni' => 'DNI', 'datos.usuario' => 'usuario', 'datos.paterno' => 'apellido paterno', 'datos.materno' => 'apellido materno',
            'datos.nombres' => 'nombres', 'datos.nacimiento' => 'fecha de nacimiento', 'datos.sexo' => 'sexo',
        ]);
        $usuario = $this->datos['usuario'];
        if ($usuario !== '' && $this->usuarioOcupado($usuario)) {
            $this->addError('datos.usuario', 'Ese nombre de usuario ya lo usa otra persona.');

            return;
        }
        //YYYYMMDD: NO DEPENDE DEL IDIOMA DE LA SESION (paInsertaDatosUsuarioPersonal USA SET LANGUAGE 'english')
        $nacimiento = str_replace('-', '', $this->datos['nacimiento']);

        try {
            if ($this->idUsuario) {
                if (! $this->fila($this->idUsuario)) {
                    $this->cerrar();
                    $this->dispatch('aviso', tipo: 'error', mensaje: 'El usuario ya no existe.');

                    return;
                }
                Procedimiento::ejecutar('seguridad.paActualizaDatosUsuarioPersonal', [
                    'pIdUsuario' => $this->idUsuario, 'pIdPersona' => $this->idPersona, 'pIdPersonal' => $this->idPersonal,
                    'pPerApePaterno' => $this->datos['paterno'], 'pPerApeMaterno' => $this->datos['materno'], 'pPerNombres' => $this->datos['nombres'],
                    'pPerSexo' => (int) $this->datos['sexo'], 'pPerFecNacimiento' => $nacimiento, 'pusuldap' => $usuario,
                    'pprhunidadorganica' => $this->unidad ?? (int) config('gepro.seguridad.unidad_organica'), 'pUsuario' => (int) Auth::id(),
                ]);
                $mensaje = 'Usuario actualizado.';
            } else {
                $dni = $this->datos['dni'];
                if (DB::table('seguridad.tsusuario')->where('usuestado', 1)->where('usunombre', $dni)->exists()) {
                    $this->addError('datos.dni', 'Ya hay un usuario con ese DNI.');

                    return;
                }
                //CLAVE INICIAL: EL DNI (LA MISMA REGLA DEL INGRESO; paActualizaClaveUsuario LA DEJA IGUAL)
                $r = Procedimiento::ejecutar('seguridad.paInsertaDatosUsuarioPersonal', [
                    'pIdPersona' => $this->idPersona ?? 0, 'pPerDocumento' => (int) config('gepro.seguridad.documento_dni'), 'pPerNroDocumento' => $dni,
                    'pPerApePaterno' => $this->datos['paterno'], 'pPerApeMaterno' => $this->datos['materno'], 'pPerNombres' => $this->datos['nombres'],
                    'pusuclave' => LegadoUserProvider::claveLegado($dni, $dni, $dni, ''), 'pPerSexo' => (int) $this->datos['sexo'],
                    'pPerFecNacimiento' => $nacimiento, 'pusuldap' => $usuario,
                    'pprhunidadorganica' => (int) config('gepro.seguridad.unidad_organica'), 'pUsuario' => (int) Auth::id(),
                ]);
                if ($r['id'] === '2') {
                    $this->addError('datos.dni', 'Esa persona ya tiene usuario.');

                    return;
                }
                $mensaje = 'Usuario registrado. Su clave es su DNI; asígnele sus perfiles.';
            }
        } catch (RuntimeException $e) {
            $this->addError('general', 'No se pudo grabar: '.$e->getMessage());

            return;
        }
        $this->dispatch('aviso', tipo: 'ok', mensaje: $mensaje);
        $this->cerrar();
    }

    /** Si otro usuario activo ya entra con ese nombre (su usuldap o su DNI) */
    private function usuarioOcupado(string $usuario): bool
    {
        return DB::table('seguridad.tsusuario')->where('usuestado', 1)
            ->when($this->idUsuario, fn ($q) => $q->where('idusuario', '<>', $this->idUsuario))
            ->where(fn ($q) => $q->whereRaw('UPPER(usuldap) = ?', [$usuario])->orWhere('usunombre', $usuario))
            ->exists();
    }

    public function eliminar(int $id): void
    {
        $f = $this->fila($id);
        if (! $f) {
            return;
        }
        if ($id === (int) Auth::id()) {
            $this->dispatch('aviso', tipo: 'error', mensaje: 'No puede eliminar su propio usuario.');

            return;
        }
        try {
            Procedimiento::ejecutar('seguridad.paEliminaDatosUsuarioPersonal', ['pidUsuario' => $id, 'pidPersonal' => (int) $f->idpersonal, 'pUsuario' => (int) Auth::id()]);
            $this->dispatch('aviso', tipo: 'ok', mensaje: 'Usuario eliminado.');
        } catch (RuntimeException $e) {
            $this->dispatch('aviso', tipo: 'error', mensaje: 'No se pudo eliminar: '.$e->getMessage());
        }
    }

    /** La clave vuelve a ser el DNI */
    public function reiniciarClave(int $id): void
    {
        if (! $this->fila($id)) {
            return;
        }
        try {
            Procedimiento::ejecutar('seguridad.paActualizaClaveUsuario', ['pidUsuario' => $id, 'pUsuario' => (int) Auth::id()]);
            $this->dispatch('aviso', tipo: 'ok', mensaje: 'Clave reiniciada: ahora es el DNI del usuario.');
        } catch (RuntimeException $e) {
            $this->dispatch('aviso', tipo: 'error', mensaje: 'No se pudo reiniciar la clave: '.$e->getMessage());
        }
    }

    public function render()
    {
        $columnas = $this->columnas();
        $consulta = $this->base()->select('u.idusuario as ID', 'u.usunombre as dni', 'u.usuldap as usuario')
            ->selectRaw($columnas['persona'][1].' AS persona')
            ->selectRaw($columnas['perfiles'][1].' AS perfiles');
        $filas = $this->ordenar($this->filtrar($consulta), ['p.PerApePaterno', 'p.PerApeMaterno', 'p.PerNombres'], 'u.idusuario')->paginate($this->porPagina);

        return view('livewire.seguridad.usuarios', ['filas' => $filas]);
    }
}

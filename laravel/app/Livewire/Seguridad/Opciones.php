<?php

namespace App\Livewire\Seguridad;

use App\Support\ArbolOpciones;
use App\Support\Procedimiento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Url;
use Livewire\Component;
use RuntimeException;

/**
 * Opciones del menu de cada sistema (antes OpcionVista con paListarOpcionFlexigrid). Se registran,
 * editan, eliminan y ordenan con seguridad.paInsertaDatosOpcion, paActualizaDatosOpcion,
 * paEliminaDatosOpcion y paActualizaOrdenOpcion. Se ven por sistema (una pestaña por modulo) y como el
 * menu: cada opcion principal en un grupo con sus secundarias, en el orden de App\Support\ArbolOpciones.
 */
class Opciones extends Component
{
    /** Modulo cuyas opciones se ven (pestaña); por defecto el de GEPRO */
    #[Url(as: 'm', except: '')]
    public string $filtroModulo = '';

    #[Url(as: 'q', except: '')]
    public string $buscar = '';

    public bool $abierto = false;

    #[Locked]
    public ?int $idOpcion = null;

    /** Modulo de la opcion al abrir el formulario (paActualizaDatosOpcion: @popcmoduloOrig) */
    #[Locked]
    public ?int $moduloOriginal = null;

    public array $datos = [];

    /** Elige la pestaña del sistema */
    public function verModulo(string $modulo): void
    {
        if (array_key_exists($modulo, $this->modulos())) {
            $this->filtroModulo = $modulo;
            $this->buscar = '';
        }
    }

    /** Modulo de la pestaña: el elegido si existe; si no, el de GEPRO o el primero */
    private function moduloActual(array $modulos): string
    {
        if (array_key_exists($this->filtroModulo, $modulos)) {
            return $this->filtroModulo;
        }
        $gepro = (string) DB::table('seguridad.tsmodulo as m')->join('seguridad.tssistema as s', 's.IdSistema', '=', 'm.modsistema')
            ->where('s.sisabreviatura', config('gepro.sistema'))->where('m.modestado', 1)->value('m.idmodulo');

        return array_key_exists($gepro, $modulos) ? $gepro : (string) array_key_first($modulos);
    }

    /** Modulos de los sistemas activos: idmodulo => "Sistema · Modulo" */
    public function modulos(): array
    {
        return DB::table('seguridad.tssistema as s')
            ->join('seguridad.tsmodulo as m', 'm.modsistema', '=', 's.IdSistema')
            ->where('s.sisestado', 1)->where('m.modestado', 1)
            ->orderBy('s.sisnombre')->orderBy('m.modnombre')
            ->get(['m.idmodulo', 's.sisnombre', 'm.modnombre'])
            ->mapWithKeys(fn ($f) => [(string) $f->idmodulo => trim($f->sisnombre).' · '.trim($f->modnombre)])
            ->all();
    }

    /** Opciones principales (nivel 1) activas del modulo elegido en el formulario, salvo la que se edita */
    public function principales(): array
    {
        $modulo = (int) ($this->datos['modulo'] ?? 0);
        if ($modulo <= 0) {
            return [];
        }

        return DB::table('seguridad.tsopcion')
            ->where('opcmodulo', $modulo)->where('opcestado', 1)->where('opcnivel', 1)
            ->when($this->idOpcion, fn ($q) => $q->where('idopcion', '<>', $this->idOpcion))
            ->orderBy('opcorden')->orderBy('idopcion')
            ->pluck('opcdescripcion', 'idopcion')
            ->mapWithKeys(fn ($d, $id) => [(string) $id => trim((string) $d)])
            ->all();
    }

    private function fila(int $id): ?object
    {
        return DB::table('seguridad.tsopcion as o')
            ->join('seguridad.tsmodulo as m', 'm.idmodulo', '=', 'o.opcmodulo')
            ->join('seguridad.tssistema as s', 's.IdSistema', '=', 'm.modsistema')
            ->where('o.idopcion', $id)->where('o.opcestado', 1)->where('m.modestado', 1)->where('s.sisestado', 1)
            ->first(['o.idopcion', 'o.opcdescripcion', 'o.opcmodulo', 'o.opcenlace', 'o.opcdestino', 'o.opcnivel', 'o.opcpadre', 'o.opclightbox']);
    }

    private function secundariasActivas(int $id): int
    {
        return DB::table('seguridad.tsopcion')->where('opcpadre', $id)->where('opcestado', 1)->where('opcnivel', '>', 1)->count();
    }

    public function nuevo(): void
    {
        $this->resetErrorBag();
        $this->idOpcion = null;
        $this->moduloOriginal = null;
        $this->datos = ['nivel' => '1', 'modulo' => $this->moduloActual($this->modulos()), 'padre' => '', 'nombre' => '', 'enlace' => '', 'destino' => '1', 'lightbox' => '0'];
        $this->abierto = true;
    }

    /** Nueva opcion secundaria dentro de esa opcion principal (boton del grupo) */
    public function nuevaSecundaria(int $padre): void
    {
        $fila = $this->fila($padre);
        if (! $fila || (int) $fila->opcnivel !== 1) {
            return;
        }
        $this->nuevo();
        $this->datos['modulo'] = (string) $fila->opcmodulo;
        $this->datos['nivel'] = '2';
        $this->datos['padre'] = (string) $padre;
    }

    public function editar(int $id): void
    {
        $fila = $this->fila($id);
        if (! $fila) {
            return;
        }
        $this->resetErrorBag();
        $this->idOpcion = (int) $fila->idopcion;
        $this->moduloOriginal = (int) $fila->opcmodulo;
        $this->datos = [
            'nivel' => (int) $fila->opcnivel === 1 ? '1' : '2',
            'modulo' => (string) $fila->opcmodulo,
            'padre' => (int) $fila->opcnivel === 1 ? '' : (string) (int) $fila->opcpadre,
            'nombre' => trim((string) $fila->opcdescripcion),
            //ALGUNOS ENLACES SE GUARDARON CON ENTIDADES HTML ("&amp;Opcion=110"); SE EDITAN COMO TEXTO
            'enlace' => trim(html_entity_decode((string) $fila->opcenlace, ENT_QUOTES | ENT_HTML5, 'UTF-8')),
            'destino' => (int) $fila->opcdestino === 2 ? '2' : '1',
            'lightbox' => (int) $fila->opclightbox === 1 ? '1' : '0',
        ];
        $this->abierto = true;
    }

    /** Al cambiar el sistema o el tipo, la opcion principal elegida ya no vale */
    public function updatedDatosModulo(): void
    {
        $this->datos['padre'] = '';
    }

    public function updatedDatosNivel(): void
    {
        if (($this->datos['nivel'] ?? '1') === '1') {
            $this->datos['padre'] = '';
        }
    }

    public function cerrar(): void
    {
        $this->abierto = false;
        $this->resetErrorBag();
    }

    public function guardar(): void
    {
        $this->datos = array_map(fn ($v) => is_string($v) ? trim($v) : $v, $this->datos);
        $secundaria = ($this->datos['nivel'] ?? '') === '2';
        $this->validate([
            'datos.nivel' => ['required', 'in:1,2'],
            'datos.modulo' => ['required', 'in:'.implode(',', array_keys($this->modulos()))],
            'datos.padre' => $secundaria ? ['required', 'in:'.implode(',', array_keys($this->principales()) ?: ['-'])] : [],
            'datos.nombre' => ['required', 'max:100'],
            'datos.enlace' => ['nullable', 'max:200'],
            'datos.destino' => ['required', 'in:1,2'],
            'datos.lightbox' => ['required', 'in:0,1'],
        ], [], [
            'datos.nivel' => 'tipo', 'datos.modulo' => 'sistema', 'datos.padre' => 'opción principal', 'datos.nombre' => 'nombre',
            'datos.enlace' => 'enlace', 'datos.destino' => 'abrir', 'datos.lightbox' => 'lightbox',
        ]);
        //UNA PRINCIPAL CON SECUNDARIAS NO PASA A SECUNDARIA NI A OTRO SISTEMA: SUS SECUNDARIAS QUEDARIAN SUELTAS
        if ($this->idOpcion && $this->secundariasActivas($this->idOpcion) > 0
            && ($secundaria || (int) $this->datos['modulo'] !== $this->moduloOriginal)) {
            $this->addError('datos.nivel', 'Tiene opciones secundarias: muévalas o elimínelas antes de cambiar su tipo o su sistema.');

            return;
        }

        $comunes = [
            'popcdescripcion' => $this->datos['nombre'],
            'popcmodulo' => (int) $this->datos['modulo'],
            'popcenlace' => $this->datos['enlace'],
            'popcdestino' => (int) $this->datos['destino'],
            'popcnivel' => (int) $this->datos['nivel'],
            'popcpadre' => $secundaria ? (int) $this->datos['padre'] : 0,
            'popclightbox' => (int) $this->datos['lightbox'],
        ];
        try {
            if ($this->idOpcion) {
                if (! $this->fila($this->idOpcion)) {
                    $this->cerrar();
                    $this->dispatch('aviso', tipo: 'error', mensaje: 'La opción ya no existe.');

                    return;
                }
                $r = Procedimiento::ejecutar('seguridad.paActualizaDatosOpcion', $comunes + [
                    'popcmoduloOrig' => $this->moduloOriginal, 'pidopcion' => $this->idOpcion, 'pUsuario' => (int) Auth::id(),
                ]);
            } else {
                $r = Procedimiento::ejecutar('seguridad.paInsertaDatosOpcion', $comunes + ['pUsuario' => (int) Auth::id()]);
            }
        } catch (RuntimeException $e) {
            $this->addError('general', 'No se pudo grabar: '.$e->getMessage());

            return;
        }
        if ($r['id'] === '2') {
            $this->addError('datos.nombre', 'Ya existe una opción con ese nombre en ese sistema.');

            return;
        }
        $this->dispatch('aviso', tipo: 'ok', mensaje: $this->idOpcion ? 'Opción actualizada.' : 'Opción registrada.');
        $this->cerrar();
    }

    public function eliminar(int $id): void
    {
        if (! $this->fila($id)) {
            return;
        }
        if ($this->secundariasActivas($id) > 0) {
            $this->dispatch('aviso', tipo: 'error', mensaje: 'Tiene opciones secundarias: elimínelas o muévalas primero.');

            return;
        }
        try {
            Procedimiento::ejecutar('seguridad.paEliminaDatosOpcion', ['pidopcion' => $id, 'pUsuario' => (int) Auth::id()]);
            $this->dispatch('aviso', tipo: 'ok', mensaje: 'Opción eliminada.');
        } catch (RuntimeException $e) {
            $this->dispatch('aviso', tipo: 'error', mensaje: 'No se pudo eliminar: '.$e->getMessage());
        }
    }

    /** Sube ($subir) o baja la opcion un lugar entre sus hermanas (intercambia su opcorden con la vecina) */
    public function mover(int $id, bool $subir): void
    {
        if (! $this->fila($id)) {
            return;
        }
        try {
            Procedimiento::ejecutar('seguridad.paActualizaOrdenOpcion', ['pidopcion' => $id, 'pTipoOrden' => $subir ? 1 : 2, 'pUsuario' => (int) Auth::id()]);
        } catch (RuntimeException $e) {
            $this->dispatch('aviso', tipo: 'error', mensaje: 'No se pudo cambiar el orden: '.$e->getMessage());
        }
    }

    public function render()
    {
        $modulos = $this->modulos();
        $this->filtroModulo = $this->moduloActual($modulos);

        //OPCIONES ACTIVAS POR MODULO (PARA LAS PESTAÑAS)
        $cuentas = DB::table('seguridad.tsopcion')->where('opcestado', 1)->whereIn('opcmodulo', array_keys($modulos))
            ->groupBy('opcmodulo')->selectRaw('opcmodulo, COUNT(*) AS n')->pluck('n', 'opcmodulo')->map(fn ($n) => (int) $n)->all();

        $opciones = DB::table('seguridad.tsopcion as o')
            ->where('o.opcestado', 1)->where('o.opcmodulo', (int) $this->filtroModulo)
            ->select('o.idopcion', 'o.opcmodulo', 'o.opcnivel', 'o.opcpadre', 'o.opcorden', 'o.opcdescripcion', 'o.opcenlace', 'o.opcdestino')
            //PERFILES ACTIVOS CON ACCESO A LA OPCION
            ->selectRaw('(SELECT COUNT(*) FROM seguridad.tsacceso a INNER JOIN seguridad.tsperfil pf ON pf.idperfil = a.accperfil AND pf.pefestado = 1 WHERE a.accopcion = o.idopcion AND a.accestado = 1) AS perfiles')
            ->get();
        $grupos = $this->agrupar(ArbolOpciones::ordenar($opciones));

        //BUSQUEDA: SI COINCIDE LA PRINCIPAL SE VE TODO SU GRUPO; SI NO, SOLO LAS SECUNDARIAS QUE COINCIDEN
        $texto = mb_strtolower(trim($this->buscar), 'UTF-8');
        if ($texto !== '') {
            $coincide = fn ($f) => $f && str_contains(mb_strtolower(trim((string) $f->opcdescripcion), 'UTF-8'), $texto);
            foreach ($grupos as $i => $g) {
                if (! $coincide($g['principal'])) {
                    $grupos[$i]['hijas'] = array_values(array_filter($g['hijas'], $coincide));
                    if (! $grupos[$i]['hijas']) {
                        unset($grupos[$i]);
                    }
                }
            }
            $grupos = array_values($grupos);
        }

        return view('livewire.seguridad.opciones', [
            'grupos' => $grupos,
            'total' => count($opciones),
            'modulos' => $modulos,
            'cuentas' => $cuentas,
            'principales' => $this->abierto ? $this->principales() : [],
        ]);
    }

    /**
     * Grupos del menu: [principal (o null: secundarias sin principal activa), hijas]. Recibe las filas
     * ya ordenadas (cada principal seguida de sus secundarias; las sueltas al final).
     *
     * @return list<array{principal: ?object, hijas: list<object>}>
     */
    private function agrupar(array $filas): array
    {
        $grupos = [];
        $sueltas = [];
        $actual = null;
        foreach ($filas as $f) {
            if ((int) $f->opcnivel === 1) {
                $grupos[] = ['principal' => $f, 'hijas' => []];
                $actual = array_key_last($grupos);
            } elseif ($actual !== null && (int) $f->opcpadre === (int) $grupos[$actual]['principal']->idopcion) {
                $grupos[$actual]['hijas'][] = $f;
            } else {
                $sueltas[] = $f;
            }
        }
        if ($sueltas) {
            $grupos[] = ['principal' => null, 'hijas' => $sueltas];
        }

        return $grupos;
    }

    /** Lo que abre la opcion, para mostrarlo corto: la Pagina del enlace o el enlace mismo */
    public static function destino(?string $enlace): string
    {
        $enlace = trim(html_entity_decode((string) $enlace, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        if (preg_match('/[?&]Pagina=([^&]+)/', $enlace, $m)) {
            return $m[1];
        }

        return $enlace;
    }
}

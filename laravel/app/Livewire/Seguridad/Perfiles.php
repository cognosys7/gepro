<?php

namespace App\Livewire\Seguridad;

use App\Services\Seguridad;
use App\Support\Procedimiento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Locked;
use Livewire\Component;
use RuntimeException;

/**
 * Perfiles de los sistemas activos (antes PerfilVista y AccesoVista, que listan con paListarPerfilFlexigrid).
 * En la opcion Perfil se registran, editan y eliminan con seguridad.paInsertaDatosPerfil,
 * paActualizaDatosPerfil y paEliminaDatosPerfil; en la opcion Acceso solo se abren sus accesos.
 */
class Perfiles extends Component
{
    use Grilla;

    /** 'Perfil' (mantenimiento) o 'Acceso' (solo accesos) */
    #[Locked]
    public string $pagina = 'Perfil';

    public bool $abierto = false;

    #[Locked]
    public ?int $idPerfil = null;

    public string $modulo = '';

    public string $nombre = '';

    public function mount(string $pagina = 'Perfil'): void
    {
        $this->pagina = $pagina === 'Acceso' ? 'Acceso' : 'Perfil';
    }

    public function columnas(): array
    {
        return [
            'sistema' => ['Software', 's.sisnombre', true],
            'modulo' => ['Módulo', 'm.modnombre', true],
            'perfil' => ['Perfil', 'pf.pefnombre', true],
            'usuarios' => ['Usuarios', '(SELECT COUNT(*) FROM seguridad.tsusuarioperfil up INNER JOIN seguridad.tsusuario u ON u.idusuario = up.upsusuario WHERE up.upsperfil = pf.idperfil AND up.upsestado = 1 AND u.usuestado = 1)', false],
        ];
    }

    public function mantenimiento(): bool
    {
        return $this->pagina === 'Perfil';
    }

    /** Modulos de los sistemas activos (paListaSistemasModulos): idmodulo => "Sistema · Modulo" */
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

    private function fila(int $id): ?object
    {
        return DB::table('seguridad.tsperfil as pf')
            ->join('seguridad.tsmodulo as m', 'm.idmodulo', '=', 'pf.pefmodulo')
            ->join('seguridad.tssistema as s', 's.IdSistema', '=', 'm.modsistema')
            ->where('pf.idperfil', $id)->where('pf.pefestado', 1)->where('m.modestado', 1)->where('s.sisestado', 1)
            ->first(['pf.idperfil', 'pf.pefnombre', 'pf.pefmodulo']);
    }

    public function nuevo(): void
    {
        if (! $this->mantenimiento()) {
            return;
        }
        $this->resetErrorBag();
        $this->idPerfil = null;
        $this->modulo = '';
        $this->nombre = '';
        $this->abierto = true;
    }

    public function editar(int $id): void
    {
        $fila = $this->mantenimiento() ? $this->fila($id) : null;
        if (! $fila) {
            return;
        }
        $this->resetErrorBag();
        $this->idPerfil = (int) $fila->idperfil;
        $this->modulo = (string) $fila->pefmodulo;
        $this->nombre = trim((string) $fila->pefnombre);
        $this->abierto = true;
    }

    public function cerrar(): void
    {
        $this->abierto = false;
        $this->resetErrorBag();
    }

    public function guardar(): void
    {
        if (! $this->mantenimiento()) {
            return;
        }
        $this->nombre = trim($this->nombre);
        $this->validate([
            //AL EDITAR EL MODULO NO CAMBIA (paActualizaDatosPerfil SOLO CAMBIA EL NOMBRE)
            'modulo' => $this->idPerfil ? [] : ['required', 'in:'.implode(',', array_keys($this->modulos()))],
            'nombre' => ['required', 'max:100'],
        ], [], ['modulo' => 'sistema', 'nombre' => 'perfil']);

        try {
            if ($this->idPerfil) {
                $fila = $this->fila($this->idPerfil);
                if (! $fila) {
                    $this->cerrar();
                    $this->dispatch('aviso', tipo: 'error', mensaje: 'El perfil ya no existe.');

                    return;
                }
                $r = Procedimiento::ejecutar('seguridad.paActualizaDatosPerfil', [
                    'pidperfil' => $this->idPerfil, 'pidmodulo' => (int) $fila->pefmodulo, 'ppefnombre' => $this->nombre, 'pUsuario' => (int) Auth::id(),
                ]);
            } else {
                $r = Procedimiento::ejecutar('seguridad.paInsertaDatosPerfil', [
                    'ppefnombre' => $this->nombre, 'ppefmodulo' => (int) $this->modulo, 'pUsuario' => (int) Auth::id(),
                ]);
            }
        } catch (RuntimeException $e) {
            $this->addError('general', 'No se pudo grabar: '.$e->getMessage());

            return;
        }
        if ($r['id'] === '2') {
            $this->addError('nombre', 'Ya existe un perfil con ese nombre en ese sistema.');

            return;
        }
        $this->dispatch('aviso', tipo: 'ok', mensaje: $this->idPerfil ? 'Perfil actualizado.' : 'Perfil registrado.');
        $this->cerrar();
    }

    public function eliminar(int $id): void
    {
        if (! $this->mantenimiento() || ! $this->fila($id)) {
            return;
        }
        //NO SE ELIMINA EL PERFIL CON EL QUE SE ENTRA A ESTE MODULO: EL USUARIO SE QUEDARIA FUERA
        if ($id === $this->perfilPropio()) {
            $this->dispatch('aviso', tipo: 'error', mensaje: 'No puede eliminar el perfil con el que entra al sistema de seguridad.');

            return;
        }
        try {
            Procedimiento::ejecutar('seguridad.paEliminaDatosPerfil', ['pidperfil' => $id, 'pUsuario' => (int) Auth::id()]);
            $this->dispatch('aviso', tipo: 'ok', mensaje: 'Perfil eliminado.');
        } catch (RuntimeException $e) {
            $this->dispatch('aviso', tipo: 'error', mensaje: 'No se pudo eliminar: '.$e->getMessage());
        }
    }

    /** Perfil de seguridad del usuario que ingreso (en las peticiones de Livewire no pasa el middleware) */
    private function perfilPropio(): int
    {
        return (int) (app(Seguridad::class)->perfilSeguridad((int) Auth::id())['perfil'] ?? 0);
    }

    public function render()
    {
        $columnas = $this->columnas();
        $consulta = DB::table('seguridad.tsperfil as pf')
            ->join('seguridad.tsmodulo as m', 'm.idmodulo', '=', 'pf.pefmodulo')
            ->join('seguridad.tssistema as s', 's.IdSistema', '=', 'm.modsistema')
            ->where('s.sisestado', 1)->where('m.modestado', 1)->where('pf.pefestado', 1)
            ->select('pf.idperfil as ID', 's.sisnombre as sistema', 'm.modnombre as modulo', 'pf.pefnombre as perfil')
            ->selectRaw($columnas['usuarios'][1].' AS usuarios');
        $filas = $this->ordenar($this->filtrar($consulta), ['s.sisnombre', 'm.modnombre', 'pf.pefnombre'], 'pf.idperfil')->paginate($this->porPagina);

        return view('livewire.seguridad.perfiles', [
            'filas' => $filas,
            'modulos' => $this->abierto ? $this->modulos() : [],
        ]);
    }
}

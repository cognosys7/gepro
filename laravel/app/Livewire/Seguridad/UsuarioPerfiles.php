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
 * Perfiles de un usuario (antes AddusuarioperfilVista): un perfil por sistema. Asignar reemplaza el que
 * tenga en ese sistema y quitar lo deja sin acceso; ambos con seguridad.paAgregarQuitarUsuarioPerfil.
 */
class UsuarioPerfiles extends Component
{
    #[Locked]
    public int $usuario;

    /** Perfil elegido en cada modulo: idmodulo => idperfil */
    public array $eleccion = [];

    public function mount(int $usuario): void
    {
        abort_unless(DB::table('seguridad.tsusuario')->where('idusuario', $usuario)->where('usuestado', 1)->exists(), 404);
        $this->usuario = $usuario;
        $this->eleccion = array_map(fn ($p) => (string) ($p[0] ?? ''), $this->asignados());
    }

    /** Modulos de los sistemas activos con sus perfiles activos */
    private function modulos(): array
    {
        $filas = DB::table('seguridad.tssistema as s')
            ->join('seguridad.tsmodulo as m', 'm.modsistema', '=', 's.IdSistema')
            ->leftJoin('seguridad.tsperfil as pf', function ($j) {
                $j->on('pf.pefmodulo', '=', 'm.idmodulo')->where('pf.pefestado', 1);
            })
            ->where('s.sisestado', 1)->where('m.modestado', 1)
            ->orderBy('s.sisnombre')->orderBy('m.modnombre')->orderBy('pf.pefnombre')
            ->get(['m.idmodulo', 's.sisnombre', 's.sisabreviatura', 'm.modnombre', 'pf.idperfil', 'pf.pefnombre']);
        $modulos = [];
        foreach ($filas as $f) {
            $modulos[(int) $f->idmodulo] ??= ['sistema' => trim($f->sisnombre), 'abreviatura' => trim($f->sisabreviatura), 'modulo' => trim($f->modnombre), 'perfiles' => []];
            if ($f->idperfil !== null) {
                $modulos[(int) $f->idmodulo]['perfiles'][(string) $f->idperfil] = trim($f->pefnombre);
            }
        }

        return $modulos;
    }

    /** Perfiles activos del usuario por modulo: idmodulo => [idperfil, ...] */
    private function asignados(): array
    {
        $asignados = [];
        $filas = DB::table('seguridad.tsusuarioperfil as up')
            ->join('seguridad.tsperfil as pf', 'pf.idperfil', '=', 'up.upsperfil')
            ->where('up.upsusuario', $this->usuario)->where('up.upsestado', 1)->where('pf.pefestado', 1)
            ->orderBy('up.idusuperfil')
            ->get(['pf.pefmodulo', 'pf.idperfil']);
        foreach ($filas as $f) {
            $asignados[(int) $f->pefmodulo][] = (int) $f->idperfil;
        }

        return $asignados;
    }

    /**
     * El usuario que ingreso no puede dejarse sin su perfil de administracion del sistema de seguridad
     * (se quedaria fuera de este modulo)
     */
    private function protegido(int $modulo, ?int $perfilNuevo): bool
    {
        if ($this->usuario !== (int) Auth::id()) {
            return false;
        }
        $propio = app(Seguridad::class)->perfilSeguridad($this->usuario);
        if (! $propio || $propio['modulo'] !== $modulo) {
            return false;
        }
        if ($perfilNuevo === null) {
            return true;
        }
        $nombre = strtoupper(trim((string) DB::table('seguridad.tsperfil')->where('idperfil', $perfilNuevo)->value('pefnombre')));

        return ! in_array($nombre, array_map('strtoupper', (array) config('gepro.seguridad.perfiles')), true);
    }

    public function asignar(int $modulo): void
    {
        $modulos = $this->modulos();
        $perfil = (string) ($this->eleccion[$modulo] ?? '');
        if (! isset($modulos[$modulo]['perfiles'][$perfil])) {
            $this->dispatch('aviso', tipo: 'error', mensaje: 'Elija un perfil de ese sistema.');

            return;
        }
        if (($this->asignados()[$modulo] ?? []) === [(int) $perfil]) {
            return;
        }
        if ($this->protegido($modulo, (int) $perfil)) {
            $this->dispatch('aviso', tipo: 'error', mensaje: 'No puede quitarse su propio perfil de administración de seguridad.');

            return;
        }
        try {
            Procedimiento::ejecutar('seguridad.paAgregarQuitarUsuarioPerfil', [
                'pidUsuario' => $this->usuario, 'pidPerfil' => (int) $perfil, 'pidModulo' => $modulo, 'pTipo' => 1, 'pUsuario' => (int) Auth::id(),
            ]);
            $this->dispatch('aviso', tipo: 'ok', mensaje: 'Perfil asignado: '.$modulos[$modulo]['perfiles'][$perfil].'.');
        } catch (RuntimeException $e) {
            $this->dispatch('aviso', tipo: 'error', mensaje: 'No se pudo asignar: '.$e->getMessage());
        }
    }

    public function quitar(int $modulo): void
    {
        $perfiles = $this->asignados()[$modulo] ?? [];
        if (! $perfiles) {
            return;
        }
        if ($this->protegido($modulo, null)) {
            $this->dispatch('aviso', tipo: 'error', mensaje: 'No puede quitarse su propio perfil de administración de seguridad.');

            return;
        }
        try {
            foreach ($perfiles as $perfil) {
                Procedimiento::ejecutar('seguridad.paAgregarQuitarUsuarioPerfil', [
                    'pidUsuario' => $this->usuario, 'pidPerfil' => $perfil, 'pidModulo' => $modulo, 'pTipo' => 2, 'pUsuario' => (int) Auth::id(),
                ]);
            }
            $this->eleccion[$modulo] = '';
            $this->dispatch('aviso', tipo: 'ok', mensaje: 'Perfil quitado: ya no entra a ese sistema.');
        } catch (RuntimeException $e) {
            $this->dispatch('aviso', tipo: 'error', mensaje: 'No se pudo quitar: '.$e->getMessage());
        }
    }

    public function render()
    {
        $asignados = $this->asignados();
        foreach ($asignados as $modulo => $perfiles) {
            $this->eleccion[$modulo] ??= (string) $perfiles[0];
        }

        return view('livewire.seguridad.usuario-perfiles', [
            'modulos' => $this->modulos(),
            'asignados' => $asignados,
        ]);
    }
}

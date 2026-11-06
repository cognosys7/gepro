<?php

namespace App\Livewire\Seguridad;

use App\Support\ArbolOpciones;
use App\Support\Procedimiento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Locked;
use Livewire\Component;
use RuntimeException;

/**
 * Accesos de un perfil (antes AddaccesoVista con paListarOpcionAccesoFlexigrid): las opciones del menu
 * de su modulo, con o sin acceso. Otorgar y quitar usan seguridad.paAgregarQuitarAcceso.
 */
class PerfilAccesos extends Component
{
    #[Locked]
    public int $perfil;

    #[Locked]
    public int $modulo;

    public string $buscar = '';

    public function mount(int $perfil): void
    {
        $modulo = DB::table('seguridad.tsperfil')->where('idperfil', $perfil)->where('pefestado', 1)->value('pefmodulo');
        abort_unless($modulo !== null, 404);
        $this->perfil = $perfil;
        $this->modulo = (int) $modulo;
    }

    private function opcionDelModulo(int $opcion): bool
    {
        return DB::table('seguridad.tsopcion')->where('idopcion', $opcion)->where('opcmodulo', $this->modulo)->where('opcestado', 1)->exists();
    }

    private function tieneAcceso(int $opcion): bool
    {
        return DB::table('seguridad.tsacceso')->where('accopcion', $opcion)->where('accperfil', $this->perfil)->where('accestado', 1)->exists();
    }

    /** $otorgar: true da el acceso, false lo quita. paAgregarQuitarAcceso no revisa si ya lo tiene: se revisa aqui */
    public function cambiar(int $opcion, bool $otorgar): void
    {
        if (! $this->opcionDelModulo($opcion) || $this->tieneAcceso($opcion) === $otorgar) {
            return;
        }
        try {
            Procedimiento::ejecutar('seguridad.paAgregarQuitarAcceso', [
                'pidopcion' => $opcion, 'pidperfil' => $this->perfil, 'pTipo' => $otorgar ? 1 : 2, 'pUsuario' => (int) Auth::id(),
            ]);
            $this->dispatch('aviso', tipo: 'ok', mensaje: $otorgar ? 'Acceso otorgado.' : 'Acceso quitado.');
        } catch (RuntimeException $e) {
            $this->dispatch('aviso', tipo: 'error', mensaje: 'No se pudo grabar: '.$e->getMessage());
        }
    }

    public function render()
    {
        $opciones = DB::table('seguridad.tsopcion as o')
            ->where('o.opcmodulo', $this->modulo)->where('o.opcestado', 1)
            ->select('o.idopcion', 'o.opcmodulo', 'o.opcnivel', 'o.opcpadre', 'o.opcorden', 'o.opcdescripcion', 'o.opcenlace')
            ->selectRaw('CASE WHEN EXISTS (SELECT 1 FROM seguridad.tsacceso a WHERE a.accopcion = o.idopcion AND a.accperfil = ? AND a.accestado = 1) THEN 1 ELSE 0 END AS acceso', [$this->perfil])
            ->get();
        $filas = ArbolOpciones::ordenar($opciones);

        //LA BUSQUEDA MANTIENE LA OPCION PRINCIPAL DE LAS SECUNDARIAS QUE COINCIDEN
        $texto = mb_strtolower(trim($this->buscar), 'UTF-8');
        if ($texto !== '') {
            $coinciden = array_filter($filas, fn ($f) => str_contains(mb_strtolower((string) $f->opcdescripcion, 'UTF-8'), $texto));
            $mostrar = [];
            foreach ($coinciden as $f) {
                $mostrar[(int) $f->idopcion] = true;
                $mostrar[(int) $f->opcpadre] = true;
            }
            $filas = array_values(array_filter($filas, fn ($f) => isset($mostrar[(int) $f->idopcion])));
        }

        return view('livewire.seguridad.perfil-accesos', [
            'filas' => $filas,
            'total' => count($opciones),
            'conAcceso' => $opciones->where('acceso', 1)->count(),
        ]);
    }
}

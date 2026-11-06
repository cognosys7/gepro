<?php

namespace App\Livewire\Seguridad;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

/**
 * Software (antes SistemaVista): sistemas y modulos activos, como paListarSistemasFlexigrid. En el
 * sistema actual esta pantalla ya no registra, edita ni elimina (sus botones estaban ocultos).
 */
class Sistemas extends Component
{
    use Grilla;

    public function columnas(): array
    {
        return [
            'sistema' => ['Software', 's.sisnombre', true],
            'abreviatura' => ['Abreviatura', 's.sisabreviatura', true],
            'modulo' => ['Módulo', 'm.modnombre', true],
            'url' => ['URL', 's.sisurl', false],
        ];
    }

    public function render()
    {
        $consulta = DB::table('seguridad.tssistema as s')
            ->join('seguridad.tsmodulo as m', 'm.modsistema', '=', 's.IdSistema')
            ->where('s.sisestado', 1)->where('m.modestado', 1)
            ->select('m.idmodulo as ID', 's.sisnombre as sistema', 's.sisabreviatura as abreviatura', 'm.modnombre as modulo', 's.sisurl as url');
        $filas = $this->ordenar($this->filtrar($consulta), ['s.sisnombre'], 'm.idmodulo')->paginate($this->porPagina);

        return view('livewire.seguridad.sistemas', ['filas' => $filas]);
    }
}

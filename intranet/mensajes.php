<?php
function mensajesistema($valor)
{
    $descripcion = "";
    if ($valor == 1)
    {
        $descripcion = "<div class='mensajeOK'>
                                <div id='marginImgMsj'><img src='".RECURSOSPROY."images/msjOK.png'></div>
                                <div id='marginMsjs'>Se registró satisfactoriamente la información</div>
                        </div>";
    }
    if ($valor == 2)
    {
        $descripcion = "<div class='mensajeERROR'>
                                <div id='marginImgMsj'><img src='".RECURSOSPROY."images/msjERROR.png'></div>
                                <div id='marginMsjs'>Los datos ingresados ya existen en el sistema</div>
                        </div>";
    }
    if ($valor == 3)
    {
        $descripcion = "<div class='mensajeOK'>
                                <div id='marginImgMsj'><img src='".RECURSOSPROY."images/msjOK.png'></div>
                                <div id='marginMsjs'>Se actualizó la información satisfactoriamente</div>
                        </div>";
    }
    if ($valor == 4)
    {
        $descripcion = "<div class='mensajeOK'>
                                <div id='marginImgMsj'><img src='".RECURSOSPROY."images/msjOK.png'></div>
                                <div id='marginMsjs'>Se eliminó la información satisfactoriamente</div>
                        </div>";
    }
    if ($valor == 5)
    {
        $descripcion = "<div class='mensajeERROR'>
                                <div id='marginImgMsj'><img src='".RECURSOSPROY."images/msjERROR.png'></div>
                                <div id='marginMsjs'>Se produjo un error al procesar su información</div>
                        </div>";
    }
    if ($valor == 6)
    {
        $descripcion = "<div class='mensajeERROR'>
                                <div id='marginImgMsj'><img src='".RECURSOSPROY."images/msjERROR.png'></div>
                                <div id='marginMsjs'>Los datos ingresados no existen.</div>
                        </div>";
    }
	else
	{
		$descripcion = "<div class='mensajeERROR'>
                                <div id='marginImgMsj'><img src='".RECURSOSPROY."images/msjERROR.png'></div>
                                <div id='marginMsjs'>Se produjo un error al procesar su información.</div>
                        </div>";
	}
    return $descripcion;
}
?>
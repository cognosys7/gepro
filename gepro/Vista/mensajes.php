<?php
function mensajesistema($valor,$sMensaje="")
{
    $descripcion = "";    
    if ($valor == 1)
    {
        $descripcion = "<div class='mensajeOK'>
                                <div id='marginImgMsj'><img src='".RECURSOSGEN_RECURSOS."images/msjOK.png'></div>
                                <div id='marginMsjs'>SE REGISTRÓ SATISFACTORIAMENTE LA INFORMACIÓN.</div>
                        </div>";
    }
    elseif ($valor == 2)
    {
        $descripcion = "<div class='mensajeERROR'>
                                <div id='marginImgMsj'><img src='".RECURSOSGEN_RECURSOS."images/msjERROR.png'></div>
                                <div id='marginMsjs'>LOS DATOS INGRESADOS YA EXISTEN EN EL SISTEMA.</div>
                        </div>";
    }
    elseif ($valor == 3)
    {
        $descripcion = "<div class='mensajeOK'>
                                <div id='marginImgMsj'><img src='".RECURSOSGEN_RECURSOS."images/msjOK.png'></div>
                                <div id='marginMsjs'>SE ACTUALIZÓ LA INFORMACIÓN SATISFACTORIAMENTE.</div>
                        </div>";
    }
    elseif ($valor == 4)
    {
        $descripcion = "<div class='mensajeOK'>
                                <div id='marginImgMsj'><img src='".RECURSOSGEN_RECURSOS."images/msjOK.png'></div>
                                <div id='marginMsjs'>SE ELIMINÓ LA INFORMACIÓN SATISFACTORIAMENTE.</div>
                        </div>";
    }
    elseif ($valor == 5)
    {
        $descripcion = "<div class='mensajeERROR'>
                                <div id='marginImgMsj'><img src='".RECURSOSGEN_RECURSOS."images/msjERROR.png'></div>
                                <div id='marginMsjs'>SE PRODUJO UN ERROR AL PROCESAR SU INFORMACIÓN.</div>
                        </div>";
    }
    elseif ($valor == 6)
    {
        $descripcion = "<div class='mensajeOK'>
                                <div id='marginImgMsj'><img src='".RECURSOSGEN_RECURSOS."images/msjOK.png'></div>
                                <div id='marginMsjs'>Se envió el correo de manera satisfactoria</div>
                        </div>";
    }
    elseif ($valor == 7)
    {
        $descripcion = "<div class='mensajeERROR'>
                                <div id='marginImgMsj'><img src='".RECURSOSGEN_RECURSOS."images/msjERROR.png'></div>
                                <div id='marginMsjs'>EL MONTO INGRESADO EXCEDE EL MONTO ESTABLECIDO POR EL DECRETO SUPREMO. \n$sMensaje</div>
                        </div>";
    }
    elseif ($valor == 8)
    {
        $descripcion = "<div class='mensajeERROR'>
                                <div id='marginImgMsj'><img src='".RECURSOSGEN_RECURSOS."images/msjERROR.png'></div>
                                <div id='marginMsjs'>Error<br>$sMensaje</div>
                        </div>";
    }
    elseif ($valor == 9)
    {
        $descripcion = "<div class='mensajeOK'>
                                <div id='marginImgMsj'><img src='".RECURSOSGEN_RECURSOS."images/msjOK.png'></div>
                                <div id='marginMsjs'>$sMensaje</div>
                        </div>";
    }
    elseif ($valor == 10)
    {
        $descripcion = "<div class='mensajeERROR'>
                                <div id='marginImgMsj'><img src='".RECURSOSGEN_RECURSOS."images/msjERROR.png'></div>
                                <div id='marginMsjs'>SE PRODUJO UN CORTE EN EL SISTEMA. ACTUALICE EL SISTEMA E INTÉNTELO NUEVAMENTE.</div>
                        </div>";
    }
    elseif ($valor == 11)
    {
        $descripcion = "<div class='mensajeERROR'>
                                <div id='marginImgMsj'><img src='".RECURSOSGEN_RECURSOS."images/msjERROR.png'></div>
                                <div id='marginMsjs'>EL DECRETO SUPREMO YA HA SIDO REGISTRADO PARA ESTE PROYECTO.</div>
                        </div>";
    }    
    elseif (!empty($valor))
    {        
        $descripcion = "<div class='mensajeERROR'>
                                <div id='marginImgMsj'><img src='".RECURSOSGEN_RECURSOS."images/msjERROR.png'></div>
                                <div id='marginMsjs'>SE PRODUJO UNA RESTRICCION AL INGRESAR SUS DATOS. TENGA EN CONSIDERACION EL TIPO DE INFORMACION QUE DESEA INGRESAR.</div>
                        </div>";
        //                                <div id='marginMsjs'>SE PRODUJO UN ERROR AL PROCESAR SU INFORMACIÓN, CONTACTESE CON EL ADMINISTRADOR DEL SISTEMA.</div>
    }    
    return $descripcion;
}
?>

<?php
function DiaSemana($Valor){
    switch ((int)$Valor) {
        case 1:
            $sDiaSemana = "LUNES";
            break;
        case 2:
            $sDiaSemana = "MARTES";
            break;
        case 3:
            $sDiaSemana = "MIERCOLES";
            break;
        case 4:
            $sDiaSemana = "JUEVES";
            break;
        case 5:
            $sDiaSemana = "VIERNES";
            break;
        case 6:
            $sDiaSemana = "SÁBADO";
            break;
        case 7:
            $sDiaSemana = "DOMINGO";
            break;
        default:
            $sDiaSemana = "error!";
            break;
    }
    return $sDiaSemana;
}
function Mes($Valor)
{
    if ($Valor == 0)
    {
        $Resultado = "TODOS";
    }
    if ($Valor == 1)
    {
        $Resultado = "ENERO";
    }
    if ($Valor == 2)
    {
        $Resultado = "FEBRERO";
    }
    if ($Valor == 3)
    {
        $Resultado = "MARZO";
    }
    if ($Valor == 4)
    {
        $Resultado = "ABRIL";
    }
    if ($Valor == 5)
    {
        $Resultado = "MAYO";
    }
    if ($Valor == 6)
    {
        $Resultado = "JUNIO";
    }
    if ($Valor == 7)
    {
        $Resultado = "JULIO";
    }
    if ($Valor == 8)
    {
        $Resultado = "AGOSTO";
    }
    if ($Valor == 9)
    {
        $Resultado = "SEPTIEMBRE";
    }
    if ($Valor == 10)
    {
        $Resultado = "OCTUBRE";
    }
    if ($Valor == 11)
    {
        $Resultado = "NOVIEMBRE";
    }
    if ($Valor == 12)
    {
        $Resultado = "DICIEMBRE";
    }
    return $Resultado;
}

function ColorFilaNaranja($Fila)
{
    $FilaR = $Fila%2;
    if ($FilaR == 1)
    {
        $Color = "#EEDDD0";
    }
    else
    {
        $Color = "#Ffffff";
    }
    return $Color;
}

function ColorFilaCeleste($Fila)
{
    $FilaR = $Fila%2;
    if ($FilaR == 1)
    {
        $Color = "#CCE2FB";
    }
    else
    {
        $Color = "#Ffffff";
    }
    return $Color;
}

function ColorFilaGris($Fila)
{
    $FilaR = $Fila%2;
    if ($FilaR == 1)
    {
        $Color = "#EAEAEA";
    }
    else
    {
        $Color = "#Ffffff";
    }
    return $Color;
}

function TipoVisita($Valor)
{
    if ($Valor == "S")
    {
        $mensaje = "PROGRAMADA";
    }
    if ($Valor == "N")
    {
        $mensaje = "NO PROGRAMADA";
    }
    return $mensaje;
}

function comboSistemas($nombre, $lstDatos, $valorInicial, $deshabilitado, $requerido, $estilo = '') {
?>
<select id="<?php echo $nombre; ?>" <?php if ($deshabilitado == 1){?>disabled="disabled"<?php }?> <?php if ($requerido == 1){?>class="required"<?php }?> name="<?php echo $nombre; ?>" <?php echo $estilo; ?>>
        <option value="">Seleccione una opción</option>
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if ($lstDatos[$i]->idmodulo == $valorInicial)
            {
                $lOption .= "<option value=\"" . $lstDatos[$i]->idmodulo . "\" selected=\"selected\">" . $lstDatos[$i]->sisnombre." - ".$lstDatos[$i]->modnombre . "</option>\n\r";
            }
            else
            {
                $lOption .= "<option value=\"" . $lstDatos[$i]->idmodulo . "\">" . $lstDatos[$i]->sisnombre." - ".$lstDatos[$i]->modnombre . "</option>\n\r";
            }
        }
        echo $lOption;
        ?>
    </select>
<?php
}

function comboMenus($nombre, $lstDatos, $valorInicial, $deshabilitado, $requerido, $estilo = '') {
?>
<select id="<?php echo $nombre; ?>" <?php if ($deshabilitado == 1){?>disabled="disabled"<?php }?> <?php if ($requerido == 1){?>class="required"<?php }?> name="<?php echo $nombre; ?>" <?php echo $estilo; ?>>
        <option value="">Seleccione una opción</option>
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if ($lstDatos[$i]->IdOpcion == $valorInicial)
            {
                $lOption .= "<option value=\"" . $lstDatos[$i]->IdOpcion . "\" selected=\"selected\">" . $lstDatos[$i]->OpcDescripcion . "</option>\n\r";
            }
            else
            {
                $lOption .= "<option value=\"" . $lstDatos[$i]->IdOpcion . "\">" . $lstDatos[$i]->OpcDescripcion . "</option>\n\r";
            }
        }
        echo $lOption;
        ?>
    </select>
<?php
}

function comboUOrganica($nombre, $lstDatos, $valorInicial, $deshabilitado, $requerido, $estilo = '') {
?>
<select id="<?php echo $nombre; ?>" <?php if ($deshabilitado == 1){?>disabled="disabled"<?php }?> <?php if ($requerido == 1){?>class="required"<?php }?> name="<?php echo $nombre; ?>" <?php echo $estilo; ?>>
        <option value="">Seleccione una opción</option>
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if ($lstDatos[$i]->IdUnidadOrganica == $valorInicial)
            {
                $lOption .= "<option value=\"" . $lstDatos[$i]->IdUnidadOrganica . "\" selected=\"selected\">" . $lstDatos[$i]->UorNombre. "</option>\n\r";
            }
            else
            {
                $lOption .= "<option value=\"" . $lstDatos[$i]->IdUnidadOrganica . "\">" . $lstDatos[$i]->UorNombre. "</option>\n\r";
            }
        }
        echo $lOption;
        ?>
    </select>
<?php
}

function comboTipoDocumento($nombre, $lstDatos, $valorInicial, $tipofunction, $deshabilitado, $requerido, $estilo = '') {
?>
<select id="<?php echo $nombre; ?>" <?php if ($deshabilitado == 1){?>disabled="disabled"<?php }?> <?php if ($requerido == 1){?>class="required"<?php }?> name="<?php echo $nombre; ?>" <?php echo $estilo; ?> <?php if ($tipofunction <> 0){?>onchange="TipoDocumento(<?php echo $tipofunction;?>);<?php }?>">
        <option value="">Seleccione una opción</option>
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if ($lstDatos[$i]->IdCatalogo == $valorInicial)
            {
                $lOption .= "<option value=\"" . $lstDatos[$i]->IdCatalogo . "\" selected=\"selected\">" . $lstDatos[$i]->CatDescripcion . "</option>\n\r";
            }
            else
            {
                $lOption .= "<option value=\"" . $lstDatos[$i]->IdCatalogo . "\">" . $lstDatos[$i]->CatDescripcion . "</option>\n\r";
            }
        }
        echo $lOption;
        ?>
    </select>
<?php
}
function CallCatalogo($Codigo,$Tipo)
{
    $lstLista      = array();
    $objetoDAO     = new CatalogoDAO();
    $objetoDAO->VerificaCatalogoSeleccionado($lstLista,$Codigo);
    $listaResult   = count($lstLista) > 0 ? true : false;
    if (($listaResult == true) || ($listaResult > 0)) 
    {
        if ($Tipo == 1)
        {
            $Resultado = $lstLista[0]->CatDescripcion;
        }
    }
    else
    {
        $Resultado = "";
    }
    return $Resultado;
}
?>

<?php
function ConvertirMontos($Importe)
{
    return str_replace(",", "", $Importe);
}
function FormatoMonedas($Monto)
{
    if (strlen($Monto)>0)
    {
        return number_format($Monto, 2, '.', ',');
    }
    else
    {
        return "0.00";
    }
}

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


/*GENERANDO EL COMBOBOX DE REGION O DEPARTAMENTO*/    
/*
function comboDepartamento($nombre,$lstDatos,$valorInicial,$habil,$estilo) {    
?>    
<select   data-content="Seleccione el Departamento" id="<?php echo $nombre;?>" <?php if ($habil == 0){?>disabled="disabled"<?php }?> class="required" name="<?php echo $nombre;?>" <?php echo $estilo;?> >
    <option value="">Seleccione una Opción</option>        
            <?php
            $lOption = "";
            for ($i=0;$i<count($lstDatos);$i++) {
                if (strlen($lstDatos[$i]->IdUbigeo>0))
                {
                    if ($lstDatos[$i]->IdUbigeo == $valorInicial)
                    {
                        $lOption .= "<option value=\"".$lstDatos[$i]->IdUbigeo."\" selected=\"selected\">".$lstDatos[$i]->UbiLocalidad."</option>\n\r";
                    }
                    else
                    {
                        $lOption .= "<option value=\"".$lstDatos[$i]->IdUbigeo."\">".$lstDatos[$i]->UbiLocalidad."</option>\n\r";
                    }
                }
            }
            echo $lOption;
            ?>
</select>
<?php
}       
     */
/*GENERANDO EL COMBOBOX DE PROVINCIAS*/    
/*
function comboProvincia($nombre,$lstDatos,$valorInicial,$habil,$estilo) {    
?>    
<select  data-trigger="hover" data-content="Seleccione la Provincia" id="<?php echo $nombre;?>" <?php if ($habil == 0){?>disabled="disabled"<?php }?> class="required" name="<?php echo $nombre;?>" <?php echo $estilo;?> >
    <option value="">Seleccione una Opción</option>        
            <?php
            $lOption = "";
            for ($i=0;$i<count($lstDatos);$i++) {
                if (strlen($lstDatos[$i]->IdUbigeo>0))
                {
                    if ($lstDatos[$i]->IdUbigeo == $valorInicial)
                    {
                        $lOption .= "<option value=\"".$lstDatos[$i]->IdUbigeo."\" selected=\"selected\">".$lstDatos[$i]->UbiLocalidad."</option>\n\r";
                    }
                    else
                    {
                        $lOption .= "<option value=\"".$lstDatos[$i]->IdUbigeo."\">".$lstDatos[$i]->UbiLocalidad."</option>\n\r";
                    }
                }
            }
            echo $lOption;
            ?>
</select>
<?php
}
*/
/*GENERANDO EL COMBOBOX DE DISTRITO*/    
/*
function comboDistrito($nombre,$lstDatos,$valorInicial,$habil,$estilo) {    
?>    

<select data-trigger="hover" data-content="Seleccione el Distrito" id="<?php echo $nombre;?>" <?php if ($habil == 0){?>disabled="disabled"<?php }?> class="required" name="<?php echo $nombre;?>" <?php echo $estilo;?> >
    <option value="">Seleccione una Opción</option>
            <?php
            $lOption = "";
            for ($i=0;$i<count($lstDatos);$i++) {
                if (strlen($lstDatos[$i]->IdUbigeo>0))
                {
                    if ($lstDatos[$i]->IdUbigeo == $valorInicial)
                    {
                        $lOption .= "<option value=\"".$lstDatos[$i]->IdUbigeo."\" selected=\"selected\">".$lstDatos[$i]->UbiLocalidad."</option>\n\r";
                    }
                    else
                    {
                        $lOption .= "<option value=\"".$lstDatos[$i]->IdUbigeo."\">".$lstDatos[$i]->UbiLocalidad."</option>\n\r";
                    }
                }
            }
            echo $lOption;
            ?>
</select>
<?php
}
*/
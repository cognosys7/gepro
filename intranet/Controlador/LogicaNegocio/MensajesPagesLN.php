<?php
function MensajeError($valor)
{
    $desc = "";
    if (isset($valor))
    {
        if ($valor == 1)
        {
        $desc = "Los datos ingresados son Inválidos.";
        }
        if ($valor == 2)
        {
        $desc = "Codigo CAPTCHA erróneo.";
        }
    }
    return $desc;
}
?>
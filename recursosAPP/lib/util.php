<?php
function ConvertMontos($Valor) 
{
    return str_replace(",", "", $Valor);
}

function VerificarInputs($valor)
{
    $search  = array("'", ";", "SELECT", "UPDATE", "DELETE", "=", "<", ">", "&", "$");
    $replace = array('0', '', '', '', '', '', '', '', '', '');
    $ValorF = str_ireplace($search,$replace,$valor);
    return htmlspecialchars(addslashes(trim($ValorF)));
}
?>

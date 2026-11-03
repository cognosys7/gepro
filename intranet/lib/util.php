<?php 
function CallImgsAleatorio($Codigo,$Valor)
{
    $valores    = array();
    if ($Valor == 1)
    {
        $num_max = 11;
        array_push($valores,$Codigo);
    }
    else
    {
        $num_max = 12;
    }
    $x          = 0;
    while ($x < $num_max) 
    {
        $num_aleatorio = rand(1,29);
        if (!in_array($num_aleatorio,$valores)) 
        {
            array_push($valores,$num_aleatorio);
            $x++;
        }
    }
    shuffle($valores);
    return($valores);
}
?>
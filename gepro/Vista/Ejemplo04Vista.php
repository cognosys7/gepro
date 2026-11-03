<?php
function muestraVista(){

$lCollection        = Collection::Singleton();

$lConsulta   = $lCollection->Get('lConsulta');
$lCatalogo   = $lCollection->Get('lCatalogo');
$lCatalogoDatos = $lCollection->Get('lCatalogoDatos');

//var_dump($lCatalogoDatos);
?>

<h1> Mi primer ejemplo <?php echo $lConsulta[0]?></h1>

<h2> Mi primer ejemplo <?php echo $lConsulta[1]?></h2>

<h3> Mi primer ejemplo <?php echo utf8_encode($lConsulta[2])?></h3>

<h4> Mi primer ejemplo <?php echo $lConsulta[3]?></h4>

<table border="1">
<tr>
<td>Id</td>
<td><?php echo $lCatalogo[0]->IdCatalogo ?></td>
</tr>
<tr>
<td>Descripción</td>
<td><?php echo $lCatalogo[0]->CatDescripcion ?></td>
</tr>
</table>
<br>
<form name="form">


<input type="text">

<input type="button" value="Grabar">

</form>

<?php
}
?>
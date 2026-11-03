<?php

function muestraVista() {
    $lCollection = Collection::Singleton();
    $NombreUser = $lCollection->Get('DatosPersona');
    $horaSist   = date("G");
    if (($horaSist > 0) and ($horaSist <= 12)) 
    {
        $saludo = "Buenos días";
    }
    else
    {
        if (($horaSist > 12) and ($horaSist <= 18)) 
        {
            $saludo = "Buenas tardes";
        }
        else
        {
            $saludo = "Buenas noches";
        }
    }
    ?>
<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <div class="box-content">
                <div class="dashboard">
                    <div class="dashboard_content">
                    <u><?php echo $saludo." Estimado(a) ".$NombreUser;?></u>
                    <br><br>
                    <form name="formulario" id="formulario">
                         <input type="hidden" name="Pagina" value="Principal">
                    </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php
}
?>
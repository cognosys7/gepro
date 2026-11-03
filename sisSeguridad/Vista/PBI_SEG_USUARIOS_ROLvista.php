<?php

function muestraVista() {
    $lCollection = Collection::Singleton();
    //INFORMACIÓN DE LN
    $PaginaFormulario = $lCollection->Get('PaginaFormulario');
    $PermisoOK = $lCollection->Get('PermisoOK');
    ?>

        <iframe width="800" height="600" src="https://app.powerbi.com/view?r=eyJrIjoiM2Y4MWU2OGEtY2VjMS00N2ZhLTk4NzktM2NhYTVkZDRjZjgyIiwidCI6IjhkNmE0OTg0LThlZTAtNGEzNi1iNDA1LWQ2NzhmNDdmZGE5MSIsImMiOjR9" frameborder="0" allowFullScreen="true"></iframe>
    
    <?php
}


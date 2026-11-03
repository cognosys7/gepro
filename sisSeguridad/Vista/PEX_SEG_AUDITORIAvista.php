<?php

function muestraVista() {
    $lCollection = Collection::Singleton();
    //INFORMACIÓN DE LN
    $PaginaFormulario = $lCollection->Get('PaginaFormulario');
    $PermisoOK = $lCollection->Get('PermisoOK');
    ?>

        <h5>Revise su archivo de descarga, en formato excel: SGPAM_SEG_AUDITORIA</h5>
        
        <script type="text/javascript">
            window.location='http://198.150.0.125/SGPAM_archivos/TablerosExcel/SGPAM_SEG_AUDITORIA.xlsm'
        </script>
        
        
    <?php
}


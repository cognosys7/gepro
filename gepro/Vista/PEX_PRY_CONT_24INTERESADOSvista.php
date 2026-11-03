<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : AMSAC
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PEX_PRY_CONT_24INTERESADOSvista de Business Intelligence
  //  Fecha           : miércoles, 5 de junio de 2019 0:46:48
  //  Modificado      : 28 de agosto 2019
  //***************************************************************************** */

function muestraVista() {
    $lCollection = Collection::Singleton();
    //INFORMACIÓN DE LN
    $PaginaFormulario = $lCollection->Get('PaginaFormulario');
    $PermisoOK = $lCollection->Get('PermisoOK');
    ?>

        <h5>Revise su archivo de descarga, en formato excel: SGPAM_PRY_CONT_24INTERESADOS</h5>
        
        <script type="text/javascript">
            window.location='http://sgpam.amsac.pe/SGPAM_archivos/TablerosExcel/SGPAM_PRY_CONT_24INTERESADOS.xlsm'
        </script>
        
        
    <?php
}


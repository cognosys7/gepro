<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : AMSAC
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PEX_PRY_ANEXO3vista de Business Intelligence
  //  Fecha           : miércoles, 5 de junio de 2019 0:46:48
  //  Modificado      : 28 de agosto 2019
  //***************************************************************************** */

function muestraVista() {
    $lCollection = Collection::Singleton();
    //INFORMACIÓN DE LN
    $PaginaFormulario = $lCollection->Get('PaginaFormulario');
    $PermisoOK = $lCollection->Get('PermisoOK');
    ?>

<!--    <button class="enlace" role="link" onclick="window.location='http://198.150.0.125/SGPAM_archivos/TablerosExcel/FichaTecnicaProyecto_Ingenieria_Anexo3.xlsm'">Descargar</button> -->
        
        <h5>Revise su archivo de descarga, en formato excel: FichaTecnicaProyecto_Ingenieria_Anexo3</h5>
        
        <script type="text/javascript">
            window.location='http://sgpam.amsac.pe/SGPAM_archivos/TablerosExcel/FichaTecnicaProyecto_Ingenieria_Anexo3.xlsm'
        </script> 
        
    <?php
}


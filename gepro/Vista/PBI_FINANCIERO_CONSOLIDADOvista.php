<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : AMSAC
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PBI_FINANCIERO_CONSOLIDADOvista de Business Intelligence
  //  Fecha           : miércoles, 5 de junio de 2019 0:46:48
  //  Modificado      : 28 de Julio 2019
  //***************************************************************************** */

function muestraVista() {
    $lCollection = Collection::Singleton();
    //INFORMACIÓN DE LN
    $PaginaFormulario = $lCollection->Get('PaginaFormulario');
    $PermisoOK = $lCollection->Get('PermisoOK');
    ?>

        <iframe width="1320" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiNjk1ZDg3MjQtOGVhMS00MjE5LTg4YTQtNjkzODY1ODE3MjkyIiwidCI6IjhkNmE0OTg0LThlZTAtNGEzNi1iNDA1LWQ2NzhmNDdmZGE5MSIsImMiOjR9&pageName=ReportSectiona5825f4a19be50dbeca0" frameborder="0" allowFullScreen="true"></iframe>
    
    <?php
}


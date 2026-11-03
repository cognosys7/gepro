<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : AMSAC
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PBI_FINANCIERO_DETALLADOvista de Business Intelligence
  //  Fecha           : miércoles, 5 de junio de 2019 0:46:48
  //  Modificado      : 28 de Julio 2019
  //***************************************************************************** */

function muestraVista() {
    $lCollection = Collection::Singleton();
    //INFORMACIÓN DE LN
    $PaginaFormulario = $lCollection->Get('PaginaFormulario');
    $PermisoOK = $lCollection->Get('PermisoOK');
    ?>

        <iframe width="1320" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiNDhhYjJkMmItNWYzMC00MWNhLTgwODItYzY0MzhiMTNiM2I4IiwidCI6IjhkNmE0OTg0LThlZTAtNGEzNi1iNDA1LWQ2NzhmNDdmZGE5MSIsImMiOjR9&pageName=ReportSectionaaefc3dc98a61b867ace" frameborder="0" allowFullScreen="true"></iframe>
    
    <?php
}


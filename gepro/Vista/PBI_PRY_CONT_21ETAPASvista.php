<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : AMSAC
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PBI_PRY_CONT_21ETAPASvista de Business Intelligence
  //  Fecha           : miércoles, 5 de agosto de 2019 0:46:48
  //  Modificado      : 28 de agosto 2019
  //***************************************************************************** */

function muestraVista() {
    $lCollection = Collection::Singleton();
    //INFORMACIÓN DE LN
    $PaginaFormulario = $lCollection->Get('PaginaFormulario');
    $PermisoOK = $lCollection->Get('PermisoOK');
    ?>

        <iframe width="1250" height="750" src="https://app.powerbi.com/view?r=eyJrIjoiYjhmMTc5MDYtMTJjNi00ZjdjLTk5OWMtNWI0MDU3ZmUwYjgxIiwidCI6IjhkNmE0OTg0LThlZTAtNGEzNi1iNDA1LWQ2NzhmNDdmZGE5MSIsImMiOjR9" frameborder="0" allowFullScreen="true"></iframe>
    
    <?php
}


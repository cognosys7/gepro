
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : AMSAC
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : ALERTA_CONTRATO_CARTA_FIANZA de la vista BIBD_CONT_CONCEPTO_ALERTA
  //  Fecha           : miércoles, 8 de agosto de 2019 8:21:49
  //  Modificado      : 16 de agosto 2017
  //
  //***************************************************************************** */


//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_ALERTA_CONTRATO_CARTA_FIANZA', "EXEC dbo.SP_ALERTA_CONTRATO_CARTA_FIANZA
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);
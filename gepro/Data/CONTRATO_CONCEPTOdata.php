
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : CONTRATO_CONCEPTODATA de la tabla CONTRATO_CONCEPTO
  //  Fecha           : lunes, 13 de mayo de 2019 21:09:52
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-E
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_CONTRATO_CONCEPTO', "EXEC dbo.SP_CONTRATO_CONCEPTO
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_CONTRATO_CONCEPTO', "EXEC dbo.SP_CONTRATO_CONCEPTO
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_CONTRATO_CONCEPTO', "EXEC dbo.SP_CONTRATO_CONCEPTO
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_CONTRATO_CONCEPTO', "EXEC dbo.SP_CONTRATO_CONCEPTO
     @TipoAccion= 'SelGrd'
    ,@rp = ?
    ,@sortname = ?
    ,@sortorder = ?
    ,@page = ?
    ,@filtro = ?
    ,@codigoMensaje = ?
    ,@Mensaje = ?
    ,@nTotal = ?
"
);



//MANTENIMIENTO
define('Insert_CONTRATO_CONCEPTO', "EXEC dbo.SP_CONTRATO_CONCEPTO
     @TipoAccion = 'Insert'
		,@IDE_CONTRATO = ?
		,@IDE_BANCO = ?
		,@TIP_CONCEPTO = ?
		,@TIP_DOCUMENTO = ?
		,@COD_TIPO_DOCUMENTO = ?
		,@IMG_DOCUMENTO = ?
		,@IMP_CONCEPTO = ?
		,@FEC_EMISION = ?
		,@FEC_INICIO = ?
		,@FEC_TERMINO = ?
		,@DES_OBSERVACION = ?
		,@EST_CONT_CONCEPTO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_CONTRATO_CONCEPTO', "EXEC dbo.SP_CONTRATO_CONCEPTO
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_CONTRATO = ?
		,@IDE_BANCO = ?
		,@TIP_CONCEPTO = ?
		,@TIP_DOCUMENTO = ?
		,@COD_TIPO_DOCUMENTO = ?
		,@IMG_DOCUMENTO = ?
		,@IMP_CONCEPTO = ?
		,@FEC_EMISION = ?
		,@FEC_INICIO = ?
		,@FEC_TERMINO = ?
		,@DES_OBSERVACION = ?
		,@EST_CONT_CONCEPTO = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_CONTRATO_CONCEPTO', "EXEC dbo.SP_CONTRATO_CONCEPTO
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

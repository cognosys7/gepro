
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Hector Lopez Sanchez
  //  Propósito       : PROC_POSTORESDATA de la tabla PROC_POSTORES
  //  Fecha           : jueves, 2 de noviembre de 2017 22:56:22
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_PROC_POSTORES', "EXEC dbo.SP_PROC_POSTORES
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROC_POSTORES', "EXEC dbo.SP_PROC_POSTORES
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROC_POSTORES', "EXEC dbo.SP_PROC_POSTORES
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PROC_POSTORES', "EXEC dbo.SP_PROC_POSTORES
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
define('Insert_PROC_POSTORES', "EXEC dbo.SP_PROC_POSTORES
     @TipoAccion = 'Insert'
		,@IDE_PROC_ITEM = ?
		,@RUC_POSTOR = ?
		,@DES_POSTOR = ?
		,@TIP_POSTOR = ?
		,@VAL_REFERENCIAL_ITEM = ?
		,@VAL_OFERTADO_ITEM = ?
		,@EST_POSTOR = ?
		,@FEC_REG_PROPUESTA = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROC_POSTORES', "EXEC dbo.SP_PROC_POSTORES
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_PROC_ITEM = ?
		,@RUC_POSTOR = ?
		,@DES_POSTOR = ?
		,@TIP_POSTOR = ?
		,@VAL_REFERENCIAL_ITEM = ?
		,@VAL_OFERTADO_ITEM = ?
		,@EST_POSTOR = ?
		,@FEC_REG_PROPUESTA = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_PROC_POSTORES', "EXEC dbo.SP_PROC_POSTORES
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

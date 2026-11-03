
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PLAN_TRANSFERENCIADATA de la tabla PLAN_TRANSFERENCIA
  //  Fecha           : viernes, 5 de enero de 2018 22:58:16
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_PLAN_TRANSFERENCIA', "EXEC dbo.SP_PLAN_TRANSFERENCIA
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PLAN_TRANSFERENCIA', "EXEC dbo.SP_PLAN_TRANSFERENCIA
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PLAN_TRANSFERENCIA', "EXEC dbo.SP_PLAN_TRANSFERENCIA
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PLAN_TRANSFERENCIA', "EXEC dbo.SP_PLAN_TRANSFERENCIA
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
define('Insert_PLAN_TRANSFERENCIA', "EXEC dbo.SP_PLAN_TRANSFERENCIA
     @TipoAccion = 'Insert'
		,@IDE_PLAN = ?
		,@IDE_NORMATIVA = ?
		,@IMP_TRANSFERIDO = ?
		,@DES_ALCANCE = ?
		,@EST_TRANSFERENCIA = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PLAN_TRANSFERENCIA', "EXEC dbo.SP_PLAN_TRANSFERENCIA
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_PLAN = ?
		,@IDE_NORMATIVA = ?
		,@IMP_TRANSFERIDO = ?
		,@DES_ALCANCE = ?
		,@EST_TRANSFERENCIA = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_PLAN_TRANSFERENCIA', "EXEC dbo.SP_PLAN_TRANSFERENCIA
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);


<?php

/********************************************************************************
//  ==========================================
  //  Proyecto        : MODULO DE PLANIFICACION
  //  Entidad         : AMSAC - ACTIVOS MINEROS S.A.C.
  //  Autores         : ING. EDGAR DAVID PISFIL AHUMADA
                
//  Propósito       : PLAN_GESTION_TRANSFERENCIADATA de la tabla PLAN_GESTION_TRANSFERENCIA
//  Fecha           : lunes, 09 de julio de 2018 11:06:54 a.m.
//  Desde el Modelo : PDM - AMSAC
//  Modificado      : 16 de Octubre 2017
//
//******************************************************************************/

//Seleccionar count
define('Count_PLAN_GESTION_TRANSFERENCIA',
"EXEC dbo.SP_PLAN_GESTION_TRANSFERENCIA
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PLAN_GESTION_TRANSFERENCIA',
"EXEC dbo.SP_PLAN_GESTION_TRANSFERENCIA
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"   
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PLAN_GESTION_TRANSFERENCIA',
"EXEC dbo.SP_PLAN_GESTION_TRANSFERENCIA
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PLAN_GESTION_TRANSFERENCIA',
"EXEC dbo.SP_PLAN_GESTION_TRANSFERENCIA
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
define('Insert_PLAN_GESTION_TRANSFERENCIA',
"EXEC dbo.SP_PLAN_GESTION_TRANSFERENCIA
     @TipoAccion = 'Insert'
		,@IDE_NORMATIVA = ?
		,@FEC_FORMULACION = ?
		,@COD_TRAMITE = ?
		,@IMP_TOTAL = ?
		,@DES_OBSERVACION = ?
		,@EST_SOLICITUD = ?
		,@EST_PLAN_GESTION_TRANS = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PLAN_GESTION_TRANSFERENCIA',
"EXEC dbo.SP_PLAN_GESTION_TRANSFERENCIA
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_NORMATIVA = ?
		,@FEC_FORMULACION = ?
		,@COD_TRAMITE = ?
		,@IMP_TOTAL = ?
		,@DES_OBSERVACION = ?
		,@EST_SOLICITUD = ?
		,@EST_PLAN_GESTION_TRANS = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);        

define('Delete_PLAN_GESTION_TRANSFERENCIA',
"EXEC dbo.SP_PLAN_GESTION_TRANSFERENCIA
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);
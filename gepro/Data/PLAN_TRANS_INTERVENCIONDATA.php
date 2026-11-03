
<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : MODULO DE PLANIFICACION
//  Entidad         : AUTORIDAD PARA LA RECONSTRUCCIÓN CON CAMBIOS. PRESIDENCIA DEL CONSEJO DE MINISTROS
//  Autores         : ING. EDGAR DAVID PISFIL AHUMADA              
//  Propósito       : PLAN_TRANS_INTERVENCIONDATA de la tabla PLAN_TRANS_INTERVENCION
//  Fecha           : viernes, 26 de octubre de 2018 13:10:56
//  Desde el Modelo : PDM - AMSAC
//  Modificado      : 16 de Octubre 2017
//
//******************************************************************************/

//Seleccionar count
define('Count_PLAN_TRANS_INTERVENCION',
"EXEC dbo.SP_PLAN_TRANS_INTERVENCION
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PLAN_TRANS_INTERVENCION',
"EXEC dbo.SP_PLAN_TRANS_INTERVENCION
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"   
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PLAN_TRANS_INTERVENCION',
"EXEC dbo.SP_PLAN_TRANS_INTERVENCION
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PLAN_TRANS_INTERVENCION',
"EXEC dbo.SP_PLAN_TRANS_INTERVENCION
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
define('Insert_PLAN_TRANS_INTERVENCION',
"EXEC dbo.SP_PLAN_TRANS_INTERVENCION
     @TipoAccion = 'Insert'
		,@IDE_TRANSFERENCIA = ?
		,@TIPO_TRANSFERENCIA = ?
		,@TIPO_TRANSACCION = ?
		,@AMBITO = ?
		,@PROGRAMA_PPTO = ?
		,@FUENTE_FINANC = ?
		,@GENERICA = ?
		,@COMPONENTE = ?
		,@COD_PRODUCTO_PROYECTO = ?
		,@IMP_TRANSFERENCIA = ?
		,@DES_INTERVENCION = ?
		,@DES_INTERVENCION_CORTO = ?
		,@TIP_GRUPO_INTERVENCION = ?
		,@COD_SNIP = ?
		,@COD_UNICO = ?
		,@COD_UBIGEO = ?
		,@IDE_ENTIDAD = ?
		,@TIP_TIPOLOGIA_INTERVENCION = ?
		,@IDE_INTERVENCION = ?
		,@IDE_PIP = ?
		,@TIP_PRODUCTO_PROYECTO = ?
		,@EST_TRANS_INTERVENCION = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PLAN_TRANS_INTERVENCION',
"EXEC dbo.SP_PLAN_TRANS_INTERVENCION
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_TRANSFERENCIA = ?
		,@TIPO_TRANSFERENCIA = ?
		,@TIPO_TRANSACCION = ?
		,@AMBITO = ?
		,@PROGRAMA_PPTO = ?
		,@FUENTE_FINANC = ?
		,@GENERICA = ?
		,@COMPONENTE = ?
		,@COD_PRODUCTO_PROYECTO = ?
		,@IMP_TRANSFERENCIA = ?
		,@DES_INTERVENCION = ?
		,@DES_INTERVENCION_CORTO = ?
		,@TIP_GRUPO_INTERVENCION = ?
		,@COD_SNIP = ?
		,@COD_UNICO = ?
		,@COD_UBIGEO = ?
		,@IDE_ENTIDAD = ?
		,@TIP_TIPOLOGIA_INTERVENCION = ?
		,@IDE_INTERVENCION = ?
		,@IDE_PIP = ?
		,@TIP_PRODUCTO_PROYECTO = ?
		,@EST_TRANS_INTERVENCION = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);        

define('Delete_PLAN_TRANS_INTERVENCION',
"EXEC dbo.SP_PLAN_TRANS_INTERVENCION
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION.NET
//  Empresa			  : www.cognosys.com.pe
//  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Edgar David Pisfil Ahumada                    
//  Propósito       : PLAN_GESTION_TRANS_PROYDATA de la tabla PLAN_GESTION_TRANS_PROY
//  Fecha           : lunes, 16 de julio de 2018 01:43:47 p.m.
//  Desde el Modelo : PDM - AMSAC
//  Modificado      : 16 de Octubre 2017
//
//******************************************************************************/

//Seleccionar count
define('Count_PLAN_GESTION_TRANS_PROY',
"EXEC dbo.SP_PLAN_GESTION_TRANS_PROY
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PLAN_GESTION_TRANS_PROY',
"EXEC dbo.SP_PLAN_GESTION_TRANS_PROY
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"   
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PLAN_GESTION_TRANS_PROY',
"EXEC dbo.SP_PLAN_GESTION_TRANS_PROY
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PLAN_GESTION_TRANS_PROY',
"EXEC dbo.SP_PLAN_GESTION_TRANS_PROY
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
define('Insert_PLAN_GESTION_TRANS_PROY',
"EXEC dbo.SP_PLAN_GESTION_TRANS_PROY
     @TipoAccion = 'Insert'
		,@IDE_PLAN_GESTION_TRANS = ?
		,@IDE_SOLICITUD_PROYECTO = ?
		,@DES_OBSERVACION = ?
		,@EST_PLAN_GESTION_TRANS_PROY = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PLAN_GESTION_TRANS_PROY',
"EXEC dbo.SP_PLAN_GESTION_TRANS_PROY
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_PLAN_GESTION_TRANS = ?
		,@IDE_SOLICITUD_PROYECTO = ?
		,@DES_OBSERVACION = ?
		,@EST_PLAN_GESTION_TRANS_PROY = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);        

define('Delete_PLAN_GESTION_TRANS_PROY',
"EXEC dbo.SP_PLAN_GESTION_TRANS_PROY
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);
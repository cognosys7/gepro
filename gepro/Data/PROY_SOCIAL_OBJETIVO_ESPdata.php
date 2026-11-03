<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : SISTEMA DE GESTION DE PROYECTOS
//  Empresa	    	  : ACTIVOS MINEROS S.A.C.
//  Autores         : Ing. julio César Meza Yangali                    
//  Propósito       : PROY_SOCIAL_OBJETIVO_ESPdata de la tabla PROY_SOCIAL_OBJETIVO_ESP
//  Fecha           : sábado, 3 de julio de 2021 5:49:30
//  Desde el Modelo : PDM - Modelo Físico de Datos - SGPAM
//  Modificado      : sábado, 3 de julio de 2021 5:49:30
//
//******************************************************************************/


//Seleccionar count
define('Count_PROY_SOCIAL_OBJETIVO_ESP',
"EXEC dbo.SP_PROY_SOCIAL_OBJETIVO_ESP
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROY_SOCIAL_OBJETIVO_ESP',
"EXEC dbo.SP_PROY_SOCIAL_OBJETIVO_ESP
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"   
);


//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROY_SOCIAL_OBJETIVO_ESP',
"EXEC dbo.SP_PROY_SOCIAL_OBJETIVO_ESP
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);


//Seleccionar Datos para Grilla
define('SelGrd_PROY_SOCIAL_OBJETIVO_ESP',
"EXEC dbo.SP_PROY_SOCIAL_OBJETIVO_ESP
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
define('Insert_PROY_SOCIAL_OBJETIVO_ESP',
"EXEC dbo.SP_PROY_SOCIAL_OBJETIVO_ESP
     @TipoAccion = 'Insert'
		,@IDE_PROYECTO = ?
		,@FEC_OBJETIVO = ?
		,@DES_OBJETIVO_ESPECIFICO = ?
		,@DES_META = ?
		,@DES_INDICADOR = ?
		,@DES_ACTIVIDAD = ?
		,@EST_OBJETIVO_ESP = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROY_SOCIAL_OBJETIVO_ESP',
"EXEC dbo.SP_PROY_SOCIAL_OBJETIVO_ESP
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_PROYECTO = ?
		,@FEC_OBJETIVO = ?
		,@DES_OBJETIVO_ESPECIFICO = ?
		,@DES_META = ?
		,@DES_INDICADOR = ?
		,@DES_ACTIVIDAD = ?
		,@EST_OBJETIVO_ESP = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);        


define('Delete_PROY_SOCIAL_OBJETIVO_ESP',
"EXEC dbo.SP_PROY_SOCIAL_OBJETIVO_ESP
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

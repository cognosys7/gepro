<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : SISTEMA DE GESTION DE PROYECTOS
//  Empresa	    	  : ACTIVOS MINEROS S.A.C.
//  Autores         : Ing. julio C�sar Meza Yangali                    
//  Prop�sito       : PROY_OPORTUNIDAD_RIESGOdata de la tabla PROY_OPORTUNIDAD_RIESGO
//  Fecha           : s�bado, 3 de julio de 2021 3:55:17
//  Desde el Modelo : PDM - Modelo F�sico de Datos - SGPAM
//  Modificado      : s�bado, 3 de julio de 2021 3:55:17
//
//******************************************************************************/


//Seleccionar count
define('Count_PROY_OPORTUNIDAD_RIESGO',
"EXEC dbo.SP_PROY_OPORTUNIDAD_RIESGO
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROY_OPORTUNIDAD_RIESGO',
"EXEC dbo.SP_PROY_OPORTUNIDAD_RIESGO
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"   
);


//Seleccionar Registros Por Condici�n Generada Por el Usuario
define('SelCampos_PROY_OPORTUNIDAD_RIESGO',
"EXEC dbo.SP_PROY_OPORTUNIDAD_RIESGO
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);


//Seleccionar Datos para Grilla
define('SelGrd_PROY_OPORTUNIDAD_RIESGO',
"EXEC dbo.SP_PROY_OPORTUNIDAD_RIESGO
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
define('Insert_PROY_OPORTUNIDAD_RIESGO',
"EXEC dbo.SP_PROY_OPORTUNIDAD_RIESGO
     @TipoAccion = 'Insert'
		,@IDE_PROYECTO = ?
		,@FEC_RIESGO = ?
		,@DES_RIESGO = ?
		,@NUM_PROBABILIDAD = ?
		,@NUM_IMPACTO = ?
		,@NUM_VALORACION = ?
		,@DES_ACCION = ?
		,@EST_RIESGO = ?
        ,@TIP_COMPONENTE = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROY_OPORTUNIDAD_RIESGO',
"EXEC dbo.SP_PROY_OPORTUNIDAD_RIESGO
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_PROYECTO = ?
		,@FEC_RIESGO = ?
		,@DES_RIESGO = ?
		,@NUM_PROBABILIDAD = ?
		,@NUM_IMPACTO = ?
		,@NUM_VALORACION = ?
		,@DES_ACCION = ?
		,@EST_RIESGO = ?
        ,@TIP_COMPONENTE = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);        


define('Delete_PROY_OPORTUNIDAD_RIESGO',
"EXEC dbo.SP_PROY_OPORTUNIDAD_RIESGO
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

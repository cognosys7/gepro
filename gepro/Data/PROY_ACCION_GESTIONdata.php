<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : SISTEMA DE GESTION DE PROYECTOS
//  Empresa	    	  : ACTIVOS MINEROS S.A.C.
//  Autores         : Ing. julio César Meza Yangali                    
//  Propósito       : PROY_ACCION_GESTIONdata de la tabla PROY_ACCION_GESTION
//  Fecha           : sábado, 3 de julio de 2021 0:44:54
//  Desde el Modelo : PDM - Modelo Físico de Datos - SGPAM
//  Modificado      : sábado, 3 de julio de 2021 0:44:54
//
//******************************************************************************/


//Seleccionar count
define('Count_PROY_ACCION_GESTION',
"EXEC dbo.SP_PROY_ACCION_GESTION
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROY_ACCION_GESTION',
"EXEC dbo.SP_PROY_ACCION_GESTION
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"   
);


//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROY_ACCION_GESTION',
"EXEC dbo.SP_PROY_ACCION_GESTION
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);


//Seleccionar Datos para Grilla
define('SelGrd_PROY_ACCION_GESTION',
"EXEC dbo.SP_PROY_ACCION_GESTION
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
define('Insert_PROY_ACCION_GESTION',
"EXEC dbo.SP_PROY_ACCION_GESTION
     @TipoAccion = 'Insert'
		,@IDE_PROYECTO = ?
		,@FEC_ACCION = ?
		,@TIP_COMPONENTE = ?
		,@DES_ACCION = ?
		,@EST_ACCION = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROY_ACCION_GESTION',
"EXEC dbo.SP_PROY_ACCION_GESTION
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_PROYECTO = ?
		,@FEC_ACCION = ?
		,@TIP_COMPONENTE = ?
		,@DES_ACCION = ?
		,@EST_ACCION = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);        


define('Delete_PROY_ACCION_GESTION',
"EXEC dbo.SP_PROY_ACCION_GESTION
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

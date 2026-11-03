<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : SISTEMA DE GESTION DE PROYECTOS
//  Empresa	    	  : ACTIVOS MINEROS S.A.C.
//  Autores         : Ing. julio César Meza Yangali                    
//  Propósito       : PROY_SEGUIMIENTOdata de la tabla PROY_SEGUIMIENTO
//  Fecha           : sábado, 3 de julio de 2021 19:46:22
//  Desde el Modelo : PDM - Modelo Físico de Datos - SGPAM
//  Modificado      : sábado, 3 de julio de 2021 19:46:22
//
//******************************************************************************/


//Seleccionar count
define('Count_PROY_SEGUIMIENTO',
"EXEC dbo.SP_PROY_SEGUIMIENTO
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROY_SEGUIMIENTO',
"EXEC dbo.SP_PROY_SEGUIMIENTO
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"   
);


//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROY_SEGUIMIENTO',
"EXEC dbo.SP_PROY_SEGUIMIENTO
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);


//Seleccionar Datos para Grilla
define('SelGrd_PROY_SEGUIMIENTO',
"EXEC dbo.SP_PROY_SEGUIMIENTO
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
define('Insert_PROY_SEGUIMIENTO',
"EXEC dbo.SP_PROY_SEGUIMIENTO
     @TipoAccion = 'Insert'
		,@IDE_PROYECTO = ?
		,@FEC_SEGUIMIENTO = ?
		,@DES_SEGUIMIENTO = ?
		,@EST_SEGUIMIENTO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROY_SEGUIMIENTO',
"EXEC dbo.SP_PROY_SEGUIMIENTO
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_PROYECTO = ?
		,@FEC_SEGUIMIENTO = ?
		,@DES_SEGUIMIENTO = ?
		,@EST_SEGUIMIENTO = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);        


define('Delete_PROY_SEGUIMIENTO',
"EXEC dbo.SP_PROY_SEGUIMIENTO
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

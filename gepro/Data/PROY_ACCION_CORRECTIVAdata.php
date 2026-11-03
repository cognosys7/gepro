<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : SISTEMA DE GESTION DE PROYECTOS
//  Empresa	    	  : ACTIVOS MINEROS S.A.C.
//  Autores         : Ing. julio C�sar Meza Yangali                    
//  Prop�sito       : PROY_ACCION_CORRECTIVAdata de la tabla PROY_ACCION_CORRECTIVA
//  Fecha           : s�bado, 3 de julio de 2021 2:15:11
//  Desde el Modelo : PDM - Modelo F�sico de Datos - SGPAM
//  Modificado      : s�bado, 3 de julio de 2021 2:15:11
//
//******************************************************************************/


//Seleccionar count
define('Count_PROY_ACCION_CORRECTIVA',
"EXEC dbo.SP_PROY_ACCION_CORRECTIVA
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROY_ACCION_CORRECTIVA',
"EXEC dbo.SP_PROY_ACCION_CORRECTIVA
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"   
);


//Seleccionar Registros Por Condici�n Generada Por el Usuario
define('SelCampos_PROY_ACCION_CORRECTIVA',
"EXEC dbo.SP_PROY_ACCION_CORRECTIVA
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);


//Seleccionar Datos para Grilla
define('SelGrd_PROY_ACCION_CORRECTIVA',
"EXEC dbo.SP_PROY_ACCION_CORRECTIVA
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
define('Insert_PROY_ACCION_CORRECTIVA',
"EXEC dbo.SP_PROY_ACCION_CORRECTIVA
     @TipoAccion = 'Insert'
		,@IDE_PROYECTO = ?
		,@FEC_ACCION = ?
		,@DES_DESVIACION_IDENTIFICADA = ?
		,@DES_ACCION_CORRECTIVA = ?
		,@EST_ACCION = ?
        ,@TIP_COMPONENTE = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROY_ACCION_CORRECTIVA',
"EXEC dbo.SP_PROY_ACCION_CORRECTIVA
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_PROYECTO = ?
		,@FEC_ACCION = ?
		,@DES_DESVIACION_IDENTIFICADA = ?
		,@DES_ACCION_CORRECTIVA = ?
		,@EST_ACCION = ?	
        ,@TIP_COMPONENTE = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);        


define('Delete_PROY_ACCION_CORRECTIVA',
"EXEC dbo.SP_PROY_ACCION_CORRECTIVA
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

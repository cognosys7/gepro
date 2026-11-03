<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : SISTEMA DE GESTION DE PROYECTOS
//  Empresa	    : ACTIVOS MINEROS S.A.C.
//  Autores         : Ing. julio C�sar Meza Yangali                    
//  Prop�sito       : PROY_CONT_AMPLIACIONdata de la tabla PROY_CONT_AMPLIACION
//  Fecha           : martes, 11 de mayo de 2021 18:46:02
//  Desde el Modelo : PDM - Modelo F�sico de Datos - SGPAM
//  Modificado      : martes, 11 de mayo de 2021 18:46:02
//
//******************************************************************************/


//Seleccionar count
define('Count_PROY_CONT_AMPLIACION',
"EXEC dbo.SP_PROY_CONT_AMPLIACION
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROY_CONT_AMPLIACION',
"EXEC dbo.SP_PROY_CONT_AMPLIACION
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"   
);


//Seleccionar Registros Por Condici�n Generada Por el Usuario
define('SelCampos_PROY_CONT_AMPLIACION',
"EXEC dbo.SP_PROY_CONT_AMPLIACION
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);


//Seleccionar Datos para Grilla
define('SelGrd_PROY_CONT_AMPLIACION',
"EXEC dbo.SP_PROY_CONT_AMPLIACION
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
define('Insert_PROY_CONT_AMPLIACION',
"EXEC dbo.SP_PROY_CONT_AMPLIACION
     @TipoAccion = 'Insert'
        ,@NUM_ORDEN = ?
		,@IDE_PROYECTO_ACTIVIDAD = ?
		,@TIP_AMPLIACION = ?
		,@NUM_AMPLIACION = ?
		,@FEC_INICIO_AMP = ?
		,@CAN_DIAS_CALENDARIO = ?
		,@FEC_TERMINO_AMP = ?
		,@COD_RESOLUCION = ?
		,@EST_CONT_AMPLIACION = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROY_CONT_AMPLIACION',
"EXEC dbo.SP_PROY_CONT_AMPLIACION
     @TipoAccion = 'Update'
    ,@pCodigo = ?
        ,@NUM_ORDEN = ?
		,@IDE_PROYECTO_ACTIVIDAD = ?
		,@TIP_AMPLIACION = ?
		,@NUM_AMPLIACION = ?
		,@FEC_INICIO_AMP = ?
		,@CAN_DIAS_CALENDARIO = ?
		,@FEC_TERMINO_AMP = ?
		,@COD_RESOLUCION = ?
		,@EST_CONT_AMPLIACION = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);        


define('Delete_PROY_CONT_AMPLIACION',
"EXEC dbo.SP_PROY_CONT_AMPLIACION
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_ACTIVIDADDATA de la tabla GEN_ACTIVIDAD
  //  Fecha           : viernes, 24 de noviembre de 2017 09:48:17 a.m.
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_GEN_ACTIVIDAD', "EXEC dbo.SP_GEN_ACTIVIDAD
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_GEN_ACTIVIDAD', "EXEC dbo.SP_GEN_ACTIVIDAD
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_GEN_ACTIVIDAD', "EXEC dbo.SP_GEN_ACTIVIDAD
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);


//Seleccionar Datos para Grilla
define('SelGrd_GEN_ACTIVIDAD', "EXEC dbo.SP_GEN_ACTIVIDAD
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
define('Insert_GEN_ACTIVIDAD', "EXEC dbo.SP_GEN_ACTIVIDAD
     @TipoAccion = 'Insert'
		,@IDE_INTERVENCION_COMP = ?
		,@IDE_ACTIVIDAD_SUP = ?
		,@DES_ACTIVIDAD = ?
		,@DES_ABREVIATURA = ?
		,@NUM_NIVEL = ?
		,@NUM_DIAS = ?
		,@IND_HITO = ?
		,@COD_ORDEN = ?
		,@EST_ACTIVIDAD = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_GEN_ACTIVIDAD', "EXEC dbo.SP_GEN_ACTIVIDAD
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_INTERVENCION_COMP = ?
		,@IDE_ACTIVIDAD_SUP = ?
		,@DES_ACTIVIDAD = ?
		,@DES_ABREVIATURA = ?
		,@NUM_NIVEL = ?
		,@NUM_DIAS = ?
		,@IND_HITO = ?
		,@COD_ORDEN = ?
		,@EST_ACTIVIDAD = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_GEN_ACTIVIDAD', "EXEC dbo.SP_GEN_ACTIVIDAD
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

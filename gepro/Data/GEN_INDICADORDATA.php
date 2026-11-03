<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_INDICADORDATA de la tabla GEN_INDICADOR
  //  Fecha           : miércoles, 03 de enero de 2018 04:36:59 p.m.
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_GEN_INDICADOR', "EXEC dbo.SP_GEN_INDICADOR
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_GEN_INDICADOR', "EXEC dbo.SP_GEN_INDICADOR
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_GEN_INDICADOR', "EXEC dbo.SP_GEN_INDICADOR
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_GEN_INDICADOR', "EXEC dbo.SP_GEN_INDICADOR
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
define('Insert_GEN_INDICADOR', "EXEC dbo.SP_GEN_INDICADOR
     @TipoAccion = 'Insert'
		,@IDE_INTERVENCION = ?
		,@DES_INDICADOR = ?
		,@TIP_INDICADOR = ?
		,@TIP_PRIORIDAD = ?
		,@TIP_PERIODO_PROGRAMACION = ?
		,@TIP_PERIODO_EJECUCION = ?
		,@DES_UNIDAD_MEDIDA = ?
		,@EST_INDICADOR = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_GEN_INDICADOR', "EXEC dbo.SP_GEN_INDICADOR
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_INTERVENCION = ?
		,@DES_INDICADOR = ?
		,@TIP_INDICADOR = ?
		,@TIP_PRIORIDAD = ?
		,@TIP_PERIODO_PROGRAMACION = ?
		,@TIP_PERIODO_EJECUCION = ?
		,@DES_UNIDAD_MEDIDA = ?
		,@EST_INDICADOR = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_GEN_INDICADOR', "EXEC dbo.SP_GEN_INDICADOR
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

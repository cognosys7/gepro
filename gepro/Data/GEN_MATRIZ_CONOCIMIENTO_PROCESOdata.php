<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : GEN_MATRIZ_CONOCIMIENTO_PROCESODATA de la tabla GEN_MATRIZ_CONOCIMIENTO_PROCESO
  //  Fecha           : lunes, 3 de junio de 2019 9:04:59
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-J
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_GEN_MATRIZ_CONOCIMIENTO_PROCESO', "EXEC dbo.SP_GEN_MATRIZ_CONOCIMIENTO_PROCESO
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_GEN_MATRIZ_CONOCIMIENTO_PROCESO', "EXEC dbo.SP_GEN_MATRIZ_CONOCIMIENTO_PROCESO
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_GEN_MATRIZ_CONOCIMIENTO_PROCESO', "EXEC dbo.SP_GEN_MATRIZ_CONOCIMIENTO_PROCESO
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_GEN_MATRIZ_CONOCIMIENTO_PROCESO', "EXEC dbo.SP_GEN_MATRIZ_CONOCIMIENTO_PROCESO
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


//Seleccionar Datos para Grilla Busqueda
define('SelGrd_GEN_MATRIZ_CONOCIMIENTO_PROCESO_busqueda', "EXEC dbo.SP_GEN_MATRIZ_CONOCIMIENTO_PROCESO
     @TipoAccion= 'SelGrd_busqueda'
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
define('Insert_GEN_MATRIZ_CONOCIMIENTO_PROCESO', "EXEC dbo.SP_GEN_MATRIZ_CONOCIMIENTO_PROCESO
     @TipoAccion = 'Insert'
		,@TIP_AREA_CONOCIMIENTO = ?
		,@TIP_GRUPO_PROCESO = ?
		,@DES_CRUCE_CONOC_PROC = ?
		,@DES_ABREVIATURA = ?
		,@COD_ORDEN = ?
		,@EST_CONOC_PROC = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_GEN_MATRIZ_CONOCIMIENTO_PROCESO', "EXEC dbo.SP_GEN_MATRIZ_CONOCIMIENTO_PROCESO
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@TIP_AREA_CONOCIMIENTO = ?
		,@TIP_GRUPO_PROCESO = ?
		,@DES_CRUCE_CONOC_PROC = ?
		,@DES_ABREVIATURA = ?
		,@COD_ORDEN = ?
		,@EST_CONOC_PROC = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_GEN_MATRIZ_CONOCIMIENTO_PROCESO', "EXEC dbo.SP_GEN_MATRIZ_CONOCIMIENTO_PROCESO
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

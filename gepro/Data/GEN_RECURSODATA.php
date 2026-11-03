<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_RECURSODATA de la tabla GEN_RECURSO
  //  Fecha           : martes, 16 de enero de 2018 12:58:57 p.m.
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_GEN_RECURSO', "EXEC dbo.SP_GEN_RECURSO
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_GEN_RECURSO', "EXEC dbo.SP_GEN_RECURSO
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_GEN_RECURSO', "EXEC dbo.SP_GEN_RECURSO
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_GEN_RECURSO', "EXEC dbo.SP_GEN_RECURSO
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



//Seleccionar Datos para busqueda
define('SelGrd_GEN_RECURSO_busqueda', "EXEC dbo.SP_GEN_RECURSO
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
define('Insert_GEN_RECURSO', "EXEC dbo.SP_GEN_RECURSO
     @TipoAccion = 'Insert'
		,@IDE_ENTIDAD = ?
		,@TIP_RECURSO = ?
		,@COD_RECURSO = ?
		,@DES_RECURSO = ?
		,@EST_RECURSO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_GEN_RECURSO', "EXEC dbo.SP_GEN_RECURSO
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_ENTIDAD = ?
		,@TIP_RECURSO = ?
		,@COD_RECURSO = ?
		,@DES_RECURSO = ?
		,@EST_RECURSO = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_GEN_RECURSO', "EXEC dbo.SP_GEN_RECURSO
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

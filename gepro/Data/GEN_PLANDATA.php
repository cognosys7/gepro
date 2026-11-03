<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_PLANDATA de la tabla GEN_PLAN
  //  Fecha           : miércoles, 22 de noviembre de 2017 03:15:33 p.m.
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_GEN_PLAN', "EXEC dbo.SP_GEN_PLAN
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_GEN_PLAN', "EXEC dbo.SP_GEN_PLAN
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_GEN_PLAN', "EXEC dbo.SP_GEN_PLAN
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_GEN_PLAN', "EXEC dbo.SP_GEN_PLAN
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
define('Insert_GEN_PLAN', "EXEC dbo.SP_GEN_PLAN
     @TipoAccion = 'Insert'
		,@DES_PLAN = ?
		,@TIP_CALENDARIO = ?
		,@EST_PLAN = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_GEN_PLAN', "EXEC dbo.SP_GEN_PLAN
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@DES_PLAN = ?
		,@TIP_CALENDARIO = ?
		,@EST_PLAN = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_GEN_PLAN', "EXEC dbo.SP_GEN_PLAN
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

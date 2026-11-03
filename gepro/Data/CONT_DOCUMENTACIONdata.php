<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : CONT_DOCUMENTACIONDATA de la tabla CONT_DOCUMENTACION
  //  Fecha           : lunes, 3 de junio de 2019 19:00:41
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-J
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_CONT_DOCUMENTACION', "EXEC dbo.SP_CONT_DOCUMENTACION
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_CONT_DOCUMENTACION', "EXEC dbo.SP_CONT_DOCUMENTACION
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_CONT_DOCUMENTACION', "EXEC dbo.SP_CONT_DOCUMENTACION
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_CONT_DOCUMENTACION', "EXEC dbo.SP_CONT_DOCUMENTACION
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
define('SelGrd_CONT_DOCUMENTACION_busqueda', "EXEC dbo.SP_CONT_DOCUMENTACION
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
define('Insert_CONT_DOCUMENTACION', "EXEC dbo.SP_CONT_DOCUMENTACION
     @TipoAccion = 'Insert'
		,@IDE_CONTRATO = ?
		,@IDE_CONOC_PROC = ?
		,@FEC_DOCUMENTO = ?
		,@DES_DOCUMENTO = ?
		,@EST_DOCUMENTO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_CONT_DOCUMENTACION', "EXEC dbo.SP_CONT_DOCUMENTACION
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_CONTRATO = ?
		,@IDE_CONOC_PROC = ?
		,@FEC_DOCUMENTO = ?
		,@DES_DOCUMENTO = ?
		,@EST_DOCUMENTO = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_CONT_DOCUMENTACION', "EXEC dbo.SP_CONT_DOCUMENTACION
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

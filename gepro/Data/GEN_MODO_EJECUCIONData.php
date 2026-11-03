
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_MODO_EJECUCIONDATA de la tabla GEN_MODO_EJECUCION
  //  Fecha           : miércoles, 1 de noviembre de 2017 09:11:22
  //  Desde el Modelo : PDM AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_GEN_MODO_EJECUCION', "EXEC dbo.SP_GEN_MODO_EJECUCION
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_GEN_MODO_EJECUCION', "EXEC dbo.SP_GEN_MODO_EJECUCION
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_GEN_MODO_EJECUCION', "EXEC dbo.SP_GEN_MODO_EJECUCION
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_GEN_MODO_EJECUCION', "EXEC dbo.SP_GEN_MODO_EJECUCION
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
define('Insert_GEN_MODO_EJECUCION', "EXEC dbo.SP_GEN_MODO_EJECUCION
     @TipoAccion = 'Insert'
		,@DES_MODO_EJECUCION = ?
		,@DES_ABREVIATURA = ?
		,@EST_MODO_EJECUCION = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_GEN_MODO_EJECUCION', "EXEC dbo.SP_GEN_MODO_EJECUCION
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@DES_MODO_EJECUCION = ?
		,@DES_ABREVIATURA = ?
		,@EST_MODO_EJECUCION = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_GEN_MODO_EJECUCION', "EXEC dbo.SP_GEN_MODO_EJECUCION
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

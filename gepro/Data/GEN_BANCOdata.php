
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_BANCODATA de la tabla GEN_BANCO
  //  Fecha           : miércoles, 8 de mayo de 2019 8:21:49
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-E
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_GEN_BANCO', "EXEC dbo.SP_GEN_BANCO
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_GEN_BANCO', "EXEC dbo.SP_GEN_BANCO
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_GEN_BANCO', "EXEC dbo.SP_GEN_BANCO
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_GEN_BANCO', "EXEC dbo.SP_GEN_BANCO
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
define('Insert_GEN_BANCO', "EXEC dbo.SP_GEN_BANCO
     @TipoAccion = 'Insert'
		,@COD_INTERNO = ?
		,@DES_BANCO = ?
		,@COD_RUC = ?
		,@DES_LOGO = ?
		,@DES_COMENTARIO = ?
		,@EST_BANCO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_GEN_BANCO', "EXEC dbo.SP_GEN_BANCO
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@COD_INTERNO = ?
		,@DES_BANCO = ?
		,@COD_RUC = ?
		,@DES_LOGO = ?
		,@DES_COMENTARIO = ?
		,@EST_BANCO = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_GEN_BANCO', "EXEC dbo.SP_GEN_BANCO
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

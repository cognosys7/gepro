
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_ROLESDATA de la tabla GEN_ROLES
  //  Fecha           : sábado, 11 de mayo de 2019 21:29:14
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-E
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_GEN_ROLES', "EXEC dbo.SP_GEN_ROLES
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_GEN_ROLES', "EXEC dbo.SP_GEN_ROLES
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_GEN_ROLES', "EXEC dbo.SP_GEN_ROLES
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_GEN_ROLES', "EXEC dbo.SP_GEN_ROLES
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
define('Insert_GEN_ROLES', "EXEC dbo.SP_GEN_ROLES
     @TipoAccion = 'Insert'
		,@IDE_FASE = ?
		,@DES_ROL = ?
		,@EST_ROL = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_GEN_ROLES', "EXEC dbo.SP_GEN_ROLES
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_FASE = ?
		,@DES_ROL = ?
		,@EST_ROL = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_GEN_ROLES', "EXEC dbo.SP_GEN_ROLES
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

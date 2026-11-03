
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa		: www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_PROVEEDORDATA de la tabla GEN_PROVEEDOR
  //  Fecha           : martes, 7 de mayo de 2019 14:18:07
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-D
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_GEN_PROVEEDOR', "EXEC dbo.SP_GEN_PROVEEDOR
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_GEN_PROVEEDOR', "EXEC dbo.SP_GEN_PROVEEDOR
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_GEN_PROVEEDOR', "EXEC dbo.SP_GEN_PROVEEDOR
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_GEN_PROVEEDOR', "EXEC dbo.SP_GEN_PROVEEDOR
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
define('Insert_GEN_PROVEEDOR', "EXEC dbo.SP_GEN_PROVEEDOR
     @TipoAccion = 'Insert'
		,@COD_PROVEEDOR = ?
		,@COD_RUC = ?
		,@DES_PROVEEDOR = ?
		,@DES_DIRECCION = ?
		,@DES_COMENTARIO = ?
		,@EST_PROVEEDOR = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_GEN_PROVEEDOR', "EXEC dbo.SP_GEN_PROVEEDOR
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@COD_PROVEEDOR = ?
		,@COD_RUC = ?
		,@DES_PROVEEDOR = ?
		,@DES_DIRECCION = ?
		,@DES_COMENTARIO = ?
		,@EST_PROVEEDOR = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_GEN_PROVEEDOR', "EXEC dbo.SP_GEN_PROVEEDOR
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

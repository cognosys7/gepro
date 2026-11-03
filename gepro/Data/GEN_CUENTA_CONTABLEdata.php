
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_CUENTA_CONTABLEDATA de la tabla GEN_CUENTA_CONTABLE
  //  Fecha           : sábado, 25 de mayo de 2019 23:54:48
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-I
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_GEN_CUENTA_CONTABLE', "EXEC dbo.SP_GEN_CUENTA_CONTABLE
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_GEN_CUENTA_CONTABLE', "EXEC dbo.SP_GEN_CUENTA_CONTABLE
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_GEN_CUENTA_CONTABLE', "EXEC dbo.SP_GEN_CUENTA_CONTABLE
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_GEN_CUENTA_CONTABLE', "EXEC dbo.SP_GEN_CUENTA_CONTABLE
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
define('SelGrd_GEN_CUENTA_CONTABLE_busqueda', "EXEC dbo.SP_GEN_CUENTA_CONTABLE
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
define('Insert_GEN_CUENTA_CONTABLE', "EXEC dbo.SP_GEN_CUENTA_CONTABLE
     @TipoAccion = 'Insert'
		,@COD_CUENTA_CONTABLE = ?
		,@DES_CUENTA_CONTABLE = ?
		,@EST_CUENTA_CONTABLE = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_GEN_CUENTA_CONTABLE', "EXEC dbo.SP_GEN_CUENTA_CONTABLE
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@COD_CUENTA_CONTABLE = ?
		,@DES_CUENTA_CONTABLE = ?
		,@EST_CUENTA_CONTABLE = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_GEN_CUENTA_CONTABLE', "EXEC dbo.SP_GEN_CUENTA_CONTABLE
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

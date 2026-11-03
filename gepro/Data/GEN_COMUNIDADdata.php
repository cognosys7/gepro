
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa		: www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_COMUNIDADDATA de la tabla GEN_COMUNIDAD
  //  Fecha           : sábado, 18 de mayo de 2019 23:54:06
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-G
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_GEN_COMUNIDAD', "EXEC dbo.SP_GEN_COMUNIDAD
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_GEN_COMUNIDAD', "EXEC dbo.SP_GEN_COMUNIDAD
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_GEN_COMUNIDAD', "EXEC dbo.SP_GEN_COMUNIDAD
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_GEN_COMUNIDAD', "EXEC dbo.SP_GEN_COMUNIDAD
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


//Seleccionar Datos para Grilla busqueda
define('SelGrd_GEN_COMUNIDAD_busqueda', "EXEC dbo.SP_GEN_COMUNIDAD
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
define('Insert_GEN_COMUNIDAD', "EXEC dbo.SP_GEN_COMUNIDAD
     @TipoAccion = 'Insert'
		,@COD_UBIGEO = ?
		,@DES_COMUNIDAD = ?
		,@EST_COMUNIDAD = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_GEN_COMUNIDAD', "EXEC dbo.SP_GEN_COMUNIDAD
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@COD_UBIGEO = ?
		,@DES_COMUNIDAD = ?
		,@EST_COMUNIDAD = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_GEN_COMUNIDAD', "EXEC dbo.SP_GEN_COMUNIDAD
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

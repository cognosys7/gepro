<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : GEN_ARCHIVODATA de la tabla GEN_ARCHIVO
  //  Fecha           : lunes, 3 de junio de 2019 22:00:44
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-J
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_GEN_ARCHIVO', "EXEC dbo.SP_GEN_ARCHIVO
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_GEN_ARCHIVO', "EXEC dbo.SP_GEN_ARCHIVO
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_GEN_ARCHIVO', "EXEC dbo.SP_GEN_ARCHIVO
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_GEN_ARCHIVO', "EXEC dbo.SP_GEN_ARCHIVO
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
define('SelGrd_GEN_ARCHIVO_busqueda', "EXEC dbo.SP_GEN_ARCHIVO
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
define('Insert_GEN_ARCHIVO', "EXEC dbo.SP_GEN_ARCHIVO
     @TipoAccion = 'Insert'
		,@IDE_TABLA = ?
		,@IDE_REGISTRO = ?
		,@DES_RUTA = ?
		,@DES_ARCHIVO = ?
		,@EST_ARCHIVO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_GEN_ARCHIVO', "EXEC dbo.SP_GEN_ARCHIVO
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_TABLA = ?
		,@IDE_REGISTRO = ?
		,@DES_RUTA = ?
		,@DES_ARCHIVO = ?
		,@EST_ARCHIVO = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_GEN_ARCHIVO', "EXEC dbo.SP_GEN_ARCHIVO
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

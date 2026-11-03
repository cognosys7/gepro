
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_ESTADODATA de la tabla GEN_ESTADO
  //  Fecha           : lunes, 20 de noviembre de 2017 11:22:48 a.m.
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_GEN_ESTADO', "EXEC dbo.SP_GEN_ESTADO
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_GEN_ESTADO', "EXEC dbo.SP_GEN_ESTADO
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_GEN_ESTADO', "EXEC dbo.SP_GEN_ESTADO
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_GEN_ESTADO', "EXEC dbo.SP_GEN_ESTADO
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
define('Insert_GEN_ESTADO', "EXEC dbo.SP_GEN_ESTADO
     @TipoAccion = 'Insert'
		,@DES_ESTADO = ?
		,@DES_ABREVIATURA = ?
		,@EST_ESTADO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_GEN_ESTADO', "EXEC dbo.SP_GEN_ESTADO
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@DES_ESTADO = ?
		,@DES_ABREVIATURA = ?
		,@EST_ESTADO = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_GEN_ESTADO', "EXEC dbo.SP_GEN_ESTADO
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

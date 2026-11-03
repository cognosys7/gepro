
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_ENTIDADDATA de la tabla GEN_ENTIDAD
  //  Fecha           : miércoles, 1 de noviembre de 2017 15:50:31
  //  Desde el Modelo : PDM AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_GEN_ENTIDAD', "EXEC dbo.SP_GEN_ENTIDAD
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_GEN_ENTIDAD', "EXEC dbo.SP_GEN_ENTIDAD
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_GEN_ENTIDAD', "EXEC dbo.SP_GEN_ENTIDAD
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_GEN_ENTIDAD', "EXEC dbo.SP_GEN_ENTIDAD
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
/***EDGAR***/
define('SelGrd_GEN_ENTIDAD_pAuxiliar',
"EXEC dbo.SP_GEN_TABLAS
     @TipoAccion= 'SelGrd'
    ,@rp = ?
    ,@sortname = ?
    ,@sortorder = ?
    ,@page = ?
    ,@filtro = ?
    ,@codigoMensaje = ?
    ,@Mensaje = ?
    ,@nTotal = ?
    ,@pAuxiliar='Anidado'
"
);
/***EDGAR***/


//MANTENIMIENTO
define('Insert_GEN_ENTIDAD', "EXEC dbo.SP_GEN_ENTIDAD
     @TipoAccion = 'Insert'		
		,@IDE_SECTOR = ?
		,@COD_RUC = ?
		,@DES_ENTIDAD = ?
		,@TIP_ENTIDAD = ?
		,@NUM_NIVEL = ?
		,@EST_ENTIDAD = ?
		,@SEC_EJEC = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_GEN_ENTIDAD', "EXEC dbo.SP_GEN_ENTIDAD
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_SECTOR = ?
		,@COD_RUC = ?
		,@DES_ENTIDAD = ?
		,@TIP_ENTIDAD = ?
		,@NUM_NIVEL = ?
		,@EST_ENTIDAD = ?
		,@SEC_EJEC = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_GEN_ENTIDAD', "EXEC dbo.SP_GEN_ENTIDAD
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);


<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_INTERVENCIONDATA de la tabla GEN_INTERVENCION
  //  Fecha           : viernes, 3 de mayo de 2019 18:42:57
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-C
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_GEN_INTERVENCION', "EXEC dbo.SP_GEN_INTERVENCION
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_GEN_INTERVENCION', "EXEC dbo.SP_GEN_INTERVENCION
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_GEN_INTERVENCION', "EXEC dbo.SP_GEN_INTERVENCION
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_GEN_INTERVENCION', "EXEC dbo.SP_GEN_INTERVENCION
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
define('SelGrd_GEN_INTERVENCION_pAuxiliar',
"EXEC dbo.SP_GEN_INTERVENCION
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
define('Insert_GEN_INTERVENCION', "EXEC dbo.SP_GEN_INTERVENCION
     @TipoAccion = 'Insert'
		,@IDE_SECTOR = ?
		,@DES_INTERVENCION = ?
		,@NUM_NIVEL = ?
		,@IDE_INTERVENCION_SUP = ?
		,@DES_RUBRO = ?
		,@TIP_SECTOR_PIRCC = ?
		,@EST_INTERVENCION = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_GEN_INTERVENCION', "EXEC dbo.SP_GEN_INTERVENCION
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_SECTOR = ?
		,@DES_INTERVENCION = ?
		,@NUM_NIVEL = ?
		,@IDE_INTERVENCION_SUP = ?
		,@DES_RUBRO = ?
		,@TIP_SECTOR_PIRCC = ?
		,@EST_INTERVENCION = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_GEN_INTERVENCION', "EXEC dbo.SP_GEN_INTERVENCION
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

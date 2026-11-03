<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : GEN_CONCEPTO_SOCIALDATA de la tabla GEN_CONCEPTO_SOCIAL
  //  Fecha           : domingo, 26 de mayo de 2019 20:51:18
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-G
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_GEN_CONCEPTO_SOCIAL', "EXEC dbo.SP_GEN_CONCEPTO_SOCIAL
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_GEN_CONCEPTO_SOCIAL', "EXEC dbo.SP_GEN_CONCEPTO_SOCIAL
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_GEN_CONCEPTO_SOCIAL', "EXEC dbo.SP_GEN_CONCEPTO_SOCIAL
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_GEN_CONCEPTO_SOCIAL', "EXEC dbo.SP_GEN_CONCEPTO_SOCIAL
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
define('SelGrd_GEN_CONCEPTO_SOCIAL_busqueda', "EXEC dbo.SP_GEN_CONCEPTO_SOCIAL
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


//Seleccionar Datos para Grilla Busqueda
define('SelGrd_GEN_CONCEPTO_SOCIAL_pAuxiliar', "EXEC dbo.SP_GEN_CONCEPTO_SOCIAL
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

//MANTENIMIENTO
define('Insert_GEN_CONCEPTO_SOCIAL', "EXEC dbo.SP_GEN_CONCEPTO_SOCIAL
     @TipoAccion = 'Insert'
		,@DES_CONCEPTO = ?
		,@DES_CONCEPTO_ABREVIATURA = ?
		,@TIP_UNIDAD_MEDIDA = ?
		,@NUM_NIVEL = ?
		,@EST_CONCEPTO = ?
		,@IDE_RUBRO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_GEN_CONCEPTO_SOCIAL', "EXEC dbo.SP_GEN_CONCEPTO_SOCIAL
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@DES_CONCEPTO = ?
		,@DES_CONCEPTO_ABREVIATURA = ?
		,@TIP_UNIDAD_MEDIDA = ?
		,@NUM_NIVEL = ?
		,@EST_CONCEPTO = ?
		,@IDE_RUBRO = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_GEN_CONCEPTO_SOCIAL', "EXEC dbo.SP_GEN_CONCEPTO_SOCIAL
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

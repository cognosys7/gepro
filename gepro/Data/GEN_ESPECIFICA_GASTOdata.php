
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_ESPECIFICA_GASTODATA de la tabla GEN_ESPECIFICA_GASTO
  //  Fecha           : domingo, 26 de mayo de 2019 2:36:59
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-I
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_GEN_ESPECIFICA_GASTO', "EXEC dbo.SP_GEN_ESPECIFICA_GASTO
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_GEN_ESPECIFICA_GASTO', "EXEC dbo.SP_GEN_ESPECIFICA_GASTO
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_GEN_ESPECIFICA_GASTO', "EXEC dbo.SP_GEN_ESPECIFICA_GASTO
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_GEN_ESPECIFICA_GASTO_cod', "EXEC dbo.SP_GEN_ESPECIFICA_GASTO
     @TipoAccion= 'SelCampos_cod'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_GEN_ESPECIFICA_GASTO', "EXEC dbo.SP_GEN_ESPECIFICA_GASTO
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
define('SelGrd_GEN_ESPECIFICA_GASTO_busqueda', "EXEC dbo.SP_GEN_ESPECIFICA_GASTO
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
define('Insert_GEN_ESPECIFICA_GASTO', "EXEC dbo.SP_GEN_ESPECIFICA_GASTO
     @TipoAccion = 'Insert'
		,@NUM_ANHO = ?
		,@COD_ESPECIFICA_GASTO = ?
		,@DES_ESPECIFICA_GASTO = ?
		,@COD_GENERICA = ?
		,@DES_GENERICA = ?
		,@COD_SUBGENERICA = ?
		,@DES_SUBGENERICA = ?
		,@COD_SUBGENERICA_DET = ?
		,@DES_SUBGNERICA_DET = ?
		,@COD_ESPECIFICA = ?
		,@DES_ESPECIFICA = ?
		,@COD_ESPECIFICA_DET = ?
		,@DES_ESPECIFICA_DET = ?
		,@EST_ESPECIFICA_GASTO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_GEN_ESPECIFICA_GASTO', "EXEC dbo.SP_GEN_ESPECIFICA_GASTO
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@NUM_ANHO = ?
		,@COD_ESPECIFICA_GASTO = ?
		,@DES_ESPECIFICA_GASTO = ?
		,@COD_GENERICA = ?
		,@DES_GENERICA = ?
		,@COD_SUBGENERICA = ?
		,@DES_SUBGENERICA = ?
		,@COD_SUBGENERICA_DET = ?
		,@DES_SUBGNERICA_DET = ?
		,@COD_ESPECIFICA = ?
		,@DES_ESPECIFICA = ?
		,@COD_ESPECIFICA_DET = ?
		,@DES_ESPECIFICA_DET = ?
		,@EST_ESPECIFICA_GASTO = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_GEN_ESPECIFICA_GASTO', "EXEC dbo.SP_GEN_ESPECIFICA_GASTO
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

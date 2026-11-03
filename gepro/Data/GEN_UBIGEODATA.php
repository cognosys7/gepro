<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : GEN_UBIGEODATA de la tabla GEN_UBIGEO
  //  Fecha           : jueves, 20 de junio de 2019 3:07:55
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-J4
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_GEN_UBIGEO', "EXEC dbo.SP_GEN_UBIGEO
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_GEN_UBIGEO', "EXEC dbo.SP_GEN_UBIGEO
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_GEN_UBIGEO', "EXEC dbo.SP_GEN_UBIGEO
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_GEN_UBIGEO', "EXEC dbo.SP_GEN_UBIGEO
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
define('Insert_GEN_UBIGEO', "EXEC dbo.SP_GEN_UBIGEO
     @TipoAccion = 'Insert'
		,@COD_UBIGEO = ?
                ,@COD_UBIGEO_SUP = ?
		,@DES_DEPARTAMENTO = ?
		,@DES_PROVINCIA = ?
		,@DES_DISTRITO = ?
		,@NUM_NIVEL = ?
		,@GEO_LONGITUD = ?
		,@GEO_LATITUD = ?
		,@EST_UBIGEO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_GEN_UBIGEO', "EXEC dbo.SP_GEN_UBIGEO
     @TipoAccion = 'Update'
    ,@pCodigo = ?
                ,@COD_UBIGEO = ?
		,@COD_UBIGEO_SUP = ?
		,@DES_DEPARTAMENTO = ?
		,@DES_PROVINCIA = ?
		,@DES_DISTRITO = ?
		,@NUM_NIVEL = ?
		,@GEO_LONGITUD = ?
		,@GEO_LATITUD = ?
		,@EST_UBIGEO = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_GEN_UBIGEO', "EXEC dbo.SP_GEN_UBIGEO
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

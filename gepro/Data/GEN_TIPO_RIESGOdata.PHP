
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_TIPO_RIESGODATA de la tabla GEN_TIPO_RIESGO
  //  Fecha           : sábado, 11 de mayo de 2019 17:23:34
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-E
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_GEN_TIPO_RIESGO', "EXEC dbo.SP_GEN_TIPO_RIESGO
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_GEN_TIPO_RIESGO', "EXEC dbo.SP_GEN_TIPO_RIESGO
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_GEN_TIPO_RIESGO', "EXEC dbo.SP_GEN_TIPO_RIESGO
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_GEN_TIPO_RIESGO', "EXEC dbo.SP_GEN_TIPO_RIESGO
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
define('Insert_GEN_TIPO_RIESGO', "EXEC dbo.SP_GEN_TIPO_RIESGO
     @TipoAccion = 'Insert'
		,@DES_TIPO_RIESGO = ?
		,@EST_TIPO_RIESGO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_GEN_TIPO_RIESGO', "EXEC dbo.SP_GEN_TIPO_RIESGO
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@DES_TIPO_RIESGO = ?
		,@EST_TIPO_RIESGO = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_GEN_TIPO_RIESGO', "EXEC dbo.SP_GEN_TIPO_RIESGO
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

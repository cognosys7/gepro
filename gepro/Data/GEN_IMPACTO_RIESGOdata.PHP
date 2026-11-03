
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_IMPACTO_RIESGODATA de la tabla GEN_IMPACTO_RIESGO
  //  Fecha           : sábado, 11 de mayo de 2019 19:08:15
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-E
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_GEN_IMPACTO_RIESGO', "EXEC dbo.SP_GEN_IMPACTO_RIESGO
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_GEN_IMPACTO_RIESGO', "EXEC dbo.SP_GEN_IMPACTO_RIESGO
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_GEN_IMPACTO_RIESGO', "EXEC dbo.SP_GEN_IMPACTO_RIESGO
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_GEN_IMPACTO_RIESGO', "EXEC dbo.SP_GEN_IMPACTO_RIESGO
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
define('Insert_GEN_IMPACTO_RIESGO', "EXEC dbo.SP_GEN_IMPACTO_RIESGO
     @TipoAccion = 'Insert'
		,@DES_IMPACTO = ?
		,@NUM_VALOR = ?
		,@EST_IMPACTO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_GEN_IMPACTO_RIESGO', "EXEC dbo.SP_GEN_IMPACTO_RIESGO
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@DES_IMPACTO = ?
		,@NUM_VALOR = ?
		,@EST_IMPACTO = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_GEN_IMPACTO_RIESGO', "EXEC dbo.SP_GEN_IMPACTO_RIESGO
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

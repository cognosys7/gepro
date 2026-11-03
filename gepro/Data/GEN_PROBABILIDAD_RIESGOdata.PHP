
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_PROBABILIDAD_RIESGODATA de la tabla GEN_PROBABILIDAD_RIESGO
  //  Fecha           : sábado, 11 de mayo de 2019 18:22:29
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-E
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_GEN_PROBABILIDAD_RIESGO', "EXEC dbo.SP_GEN_PROBABILIDAD_RIESGO
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_GEN_PROBABILIDAD_RIESGO', "EXEC dbo.SP_GEN_PROBABILIDAD_RIESGO
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_GEN_PROBABILIDAD_RIESGO', "EXEC dbo.SP_GEN_PROBABILIDAD_RIESGO
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_GEN_PROBABILIDAD_RIESGO', "EXEC dbo.SP_GEN_PROBABILIDAD_RIESGO
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
define('Insert_GEN_PROBABILIDAD_RIESGO', "EXEC dbo.SP_GEN_PROBABILIDAD_RIESGO
     @TipoAccion = 'Insert'
		,@DES_PROBABILIDAD = ?
		,@NUM_VALOR = ?
		,@EST_PROBABILIDAD = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_GEN_PROBABILIDAD_RIESGO', "EXEC dbo.SP_GEN_PROBABILIDAD_RIESGO
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@DES_PROBABILIDAD = ?
		,@NUM_VALOR = ?
		,@EST_PROBABILIDAD = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_GEN_PROBABILIDAD_RIESGO', "EXEC dbo.SP_GEN_PROBABILIDAD_RIESGO
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

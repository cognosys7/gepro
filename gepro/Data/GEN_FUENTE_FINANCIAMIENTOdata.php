
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_FUENTE_FINANCIAMIENTODATA de la tabla GEN_FUENTE_FINANCIAMIENTO
  //  Fecha           : sábado, 25 de mayo de 2019 23:33:01
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_GEN_FUENTE_FINANCIAMIENTO', "EXEC dbo.SP_GEN_FUENTE_FINANCIAMIENTO
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_GEN_FUENTE_FINANCIAMIENTO', "EXEC dbo.SP_GEN_FUENTE_FINANCIAMIENTO
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_GEN_FUENTE_FINANCIAMIENTO', "EXEC dbo.SP_GEN_FUENTE_FINANCIAMIENTO
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_GEN_FUENTE_FINANCIAMIENTO', "EXEC dbo.SP_GEN_FUENTE_FINANCIAMIENTO
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
define('SelGrd_GEN_FUENTE_FINANCIAMIENTO_busqueda', "EXEC dbo.SP_GEN_FUENTE_FINANCIAMIENTO
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
define('Insert_GEN_FUENTE_FINANCIAMIENTO', "EXEC dbo.SP_GEN_FUENTE_FINANCIAMIENTO
     @TipoAccion = 'Insert'
		,@COD_FTE_FTO = ?
		,@DES_FTE_FTO = ?
		,@EST_FTE_FTO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_GEN_FUENTE_FINANCIAMIENTO', "EXEC dbo.SP_GEN_FUENTE_FINANCIAMIENTO
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@COD_FTE_FTO = ?
		,@DES_FTE_FTO = ?
		,@EST_FTE_FTO = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_GEN_FUENTE_FINANCIAMIENTO', "EXEC dbo.SP_GEN_FUENTE_FINANCIAMIENTO
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

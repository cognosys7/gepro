<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROY_RIESGO_RECURSODATA de la tabla PROY_RIESGO_RECURSO
  //  Fecha           : domingo, 24 de junio de 2018 20:44:02
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_PROY_RIESGO_RECURSO', "EXEC dbo.SP_PROY_RIESGO_RECURSO
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROY_RIESGO_RECURSO', "EXEC dbo.SP_PROY_RIESGO_RECURSO
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROY_RIESGO_RECURSO', "EXEC dbo.SP_PROY_RIESGO_RECURSO
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PROY_RIESGO_RECURSO', "EXEC dbo.SP_PROY_RIESGO_RECURSO
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
define('Insert_PROY_RIESGO_RECURSO', "EXEC dbo.SP_PROY_RIESGO_RECURSO
     @TipoAccion = 'Insert'
    ,@IDE_RIESGO_PROB = ?
    ,@IDE_RECURSO = ?
    ,@EST_RECURSO_RIESGO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROY_RIESGO_RECURSO', "EXEC dbo.SP_PROY_RIESGO_RECURSO
     @TipoAccion = 'Update'
    ,@pCodigo = ?
    ,@IDE_RIESGO_PROB = ?
    ,@IDE_RECURSO = ?
    ,@EST_RECURSO_RIESGO = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_PROY_RIESGO_RECURSO', "EXEC dbo.SP_PROY_RIESGO_RECURSO
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

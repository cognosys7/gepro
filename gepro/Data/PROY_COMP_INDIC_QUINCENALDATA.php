<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Edgar David Pisfil Ahumada
  //  Propósito       : PROY_COMP_INDIC_QUINCENALDATA de la tabla PROY_COMP_INDIC_QUINCENAL
  //  Fecha           : jueves, 10 de mayo de 2018 18:44:16
  //  Desde el Modelo : PDM - AMSAC
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_PROY_COMP_INDIC_QUINCENAL', "EXEC dbo.SP_PROY_COMP_INDIC_QUINCENAL
     @TipoAccion= 'Count'
    ,@filtro = ?
    ,@IDE_PROY_COMPONENTE = ?
    ,@IDE_INDICADOR = ?
    ,@COD_ANHO = ?"
);

//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROY_COMP_INDIC_QUINCENAL', "EXEC dbo.SP_PROY_COMP_INDIC_QUINCENAL
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROY_COMP_INDIC_QUINCENAL', "EXEC dbo.SP_PROY_COMP_INDIC_QUINCENAL
    @TipoAccion= 'SelCampos'
    ,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PROY_COMP_INDIC_QUINCENAL', "EXEC dbo.SP_PROY_COMP_INDIC_QUINCENAL
     @TipoAccion= 'SelGrd'
    ,@rp = ?
    ,@sortname = ?
    ,@sortorder = ?
    ,@page = ?
    ,@filtro = ?
    ,@IDE_PROY_COMPONENTE = ?
    ,@IDE_INDICADOR=?
    ,@COD_ANHO=?
    ,@codigoMensaje = ?
    ,@Mensaje = ?
    ,@nTotal = ?
"
);

//MANTENIMIENTO
define('Insert_PROY_COMP_INDIC_QUINCENAL', "EXEC dbo.SP_PROY_COMP_INDIC_QUINCENAL
     @TipoAccion = 'Insert'
    ,@IDE_COMP_INDIC_MES = ?
    ,@IDE_COMP_ACTIVIDAD = ?
    ,@COD_QUINCENA = ?
    ,@NUM_VALOR = ?
    ,@EST_COMP_INDIC_QNA = ?    
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);

define('Update_PROY_COMP_INDIC_QUINCENAL', "EXEC dbo.SP_PROY_COMP_INDIC_QUINCENAL
     @TipoAccion = 'Update'
    ,@pCodigo = ?
    ,@IDE_COMP_INDIC_MES = ?
    ,@IDE_COMP_ACTIVIDAD = ?
    ,@COD_QUINCENA = ?
    ,@NUM_VALOR = ?	
    ,@EST_COMP_INDIC_QNA = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_PROY_COMP_INDIC_QUINCENAL', "EXEC dbo.SP_PROY_COMP_INDIC_QUINCENAL
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

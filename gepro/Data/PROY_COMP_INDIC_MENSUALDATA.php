
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Edgar David Pisfil Ahumada
  //  Propósito       : PROY_COMP_INDIC_MENSUALDATA de la tabla PROY_COMP_INDIC_MENSUAL
  //  Fecha           : lunes, 11 de diciembre de 2017 06:28:06 p.m.
  //  Desde el Modelo : PDM - AMSAC
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_PROY_COMP_INDIC_MENSUAL', "EXEC dbo.SP_PROY_COMP_INDIC_MENSUAL
     @TipoAccion= 'Count'
    ,@filtro = ?
    ,@IDE_PROY_COMPONENTE = ?
    ,@IDE_INDICADOR = ?
    ,@COD_ANHO = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROY_COMP_INDIC_MENSUAL', "EXEC dbo.SP_PROY_COMP_INDIC_MENSUAL
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROY_COMP_INDIC_MENSUAL', "EXEC dbo.SP_PROY_COMP_INDIC_MENSUAL
     @TipoAccion= 'SelCampos'
    ,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PROY_COMP_INDIC_MENSUAL', "EXEC dbo.SP_PROY_COMP_INDIC_MENSUAL
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
    ,@nTotal = ?"
);

//MANTENIMIENTO
define('Insert_PROY_COMP_INDIC_MENSUAL', "EXEC dbo.SP_PROY_COMP_INDIC_MENSUAL
     @TipoAccion = 'Insert'
    ,@IDE_COMP_INDIC_ANUAL = ?
    ,@IDE_COMP_ACTIVIDAD = ?
    ,@COD_MES = ?
    ,@NUM_VALOR = ?
    ,@EST_COMP_INDIC_MENSUAL = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROY_COMP_INDIC_MENSUAL', "EXEC dbo.SP_PROY_COMP_INDIC_MENSUAL
     @TipoAccion = 'Update'
    ,@pCodigo = ?
    ,@IDE_COMP_INDIC_ANUAL = ?
    ,@IDE_COMP_ACTIVIDAD = ?
    ,@COD_MES = ?
    ,@NUM_VALOR = ?
    ,@EST_COMP_INDIC_MENSUAL = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_PROY_COMP_INDIC_MENSUAL', "EXEC dbo.SP_PROY_COMP_INDIC_MENSUAL
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

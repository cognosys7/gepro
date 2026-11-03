<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Edgar David Pisfil Ahumada
  //  Propósito       : PROY_COMP_ACTIVIDADDATA de la tabla PROY_COMP_ACTIVIDAD
  //  Fecha           : miércoles, 01 de noviembre de 2017 11:09:53 a.m.
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_PROY_COMP_ACTIVIDAD', "EXEC dbo.SP_PROY_COMP_ACTIVIDAD
     @TipoAccion= 'Count'
    ,@filtro = ?
    ,@IDE_PROY_COMPONENTE = ?
    ,@IDE_PLAN_FORECAST = ?
    "
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROY_COMP_ACTIVIDAD', "EXEC dbo.SP_PROY_COMP_ACTIVIDAD
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROY_COMP_ACTIVIDAD', "EXEC dbo.SP_PROY_COMP_ACTIVIDAD
     @TipoAccion= 'SelCampos'
    ,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PROY_COMP_ACTIVIDAD', "EXEC dbo.SP_PROY_COMP_ACTIVIDAD
     @TipoAccion= 'SelGrd'
    ,@rp = ?
    ,@sortname = ?
    ,@sortorder = ?
    ,@page = ?
    ,@filtro = ?
    ,@IDE_PROY_COMPONENTE = ?
    ,@IDE_PLAN_FORECAST = ?
    ,@codigoMensaje = ?
    ,@Mensaje = ?
    ,@nTotal = ?
   
"
);

//MANTENIMIENTO
define('Insert_PROY_COMP_ACTIVIDAD', "EXEC dbo.SP_PROY_COMP_ACTIVIDAD
     @TipoAccion = 'Insert'
    ,@IDE_ACTIVIDAD = ?
    ,@IDE_COMPONENTE_PLAN = ?
    ,@FEC_INICIO = ?
    ,@FEC_TERMINO = ?
    ,@NUM_DIAS = ?
    ,@EST_COM_ACTIVIDAD = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);

define('Insert_PROY_COMP_ACTIVIDADES', "EXEC dbo.SP_PROY_COMP_ACTIVIDAD
     @TipoAccion = 'InsertActi',
     @IDE_PROY_COMPONENTE = ?,
     @IDE_INTERVENCION = ?,
     @IDE_COMPONENTE = ?,
     @pUsuario = ?"        
);


define('Update_PROY_COMP_ACTIVIDAD', "EXEC dbo.SP_PROY_COMP_ACTIVIDAD
     @TipoAccion = 'Update'
    ,@pCodigo = ?
    ,@IDE_ACTIVIDAD = ?
    ,@IDE_COMPONENTE_PLAN = ?
    ,@FEC_INICIO = ?
    ,@FEC_TERMINO = ?
    ,@NUM_DIAS = ?
    ,@EST_COM_ACTIVIDAD = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_PROY_COMP_ACTIVIDAD', "EXEC dbo.SP_PROY_COMP_ACTIVIDAD
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);
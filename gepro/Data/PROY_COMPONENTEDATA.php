
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                         Edgar David Pisfil Ahumada
  //  Propósito       : PROY_COMPONENTEDATA de la tabla PROY_COMPONENTE
  //  Fecha            : lunes, 20 de noviembre de 2017 10:15:37 a.m.
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_PROY_COMPONENTE', "EXEC dbo.SP_PROY_COMPONENTE
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROY_COMPONENTE', "EXEC dbo.SP_PROY_COMPONENTE
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROY_COMPONENTE', "EXEC dbo.SP_PROY_COMPONENTE
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROY_COMPONENTE2', "EXEC dbo.SP_PROY_COMPONENTE
     @TipoAccion= 'SelCampos2'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PROY_COMPONENTE', "EXEC dbo.SP_PROY_COMPONENTE
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
define('Insert_PROY_COMPONENTE', "EXEC dbo.SP_PROY_COMPONENTE
     @TipoAccion = 'Insert'
    ,@IDE_PROYECTO_ACTIVIDAD = ?
    ,@IDE_CARTERA = ?
    ,@IDE_COMPONENTE = ?
    ,@NUM_SEC_COMPONENTE = ?
    ,@IDE_MODO_EJECUCION = ?
    ,@IDE_PROC_ITEM = ?
    ,@IMP_COMPONENTE = ?
    ,@IDE_ESTADO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROY_COMPONENTE', "EXEC dbo.SP_PROY_COMPONENTE
     @TipoAccion = 'Update'
    ,@pCodigo = ?
    ,@IDE_PROYECTO_ACTIVIDAD = ?
    ,@IDE_CARTERA = ?    
    ,@IDE_MODO_EJECUCION = ?
    ,@IDE_PROC_ITEM = ?
    ,@IMP_COMPONENTE = ?
    ,@IDE_ESTADO = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_PROY_COMPONENTE', "EXEC dbo.SP_PROY_COMPONENTE
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

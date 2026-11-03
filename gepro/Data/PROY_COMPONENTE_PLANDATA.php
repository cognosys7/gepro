
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROY_COMPONENTE_PLANDATA de la tabla PROY_COMPONENTE_PLAN
  //  Fecha           : miércoles, 22 de noviembre de 2017 02:50:15 p.m.
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_PROY_COMPONENTE_PLAN', "EXEC dbo.SP_PROY_COMPONENTE_PLAN
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROY_COMPONENTE_PLAN', "EXEC dbo.SP_PROY_COMPONENTE_PLAN
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROY_COMPONENTE_PLAN', "EXEC dbo.SP_PROY_COMPONENTE_PLAN
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROY_COMPONENTE_PLAN2', "EXEC dbo.SP_PROY_COMPONENTE_PLAN
     @TipoAccion= 'SelCampos2'
	,@campos = ?
    ,@filtro = ?"
);


//Seleccionar Datos para Grilla
define('SelGrd_PROY_COMPONENTE_PLAN', "EXEC dbo.SP_PROY_COMPONENTE_PLAN
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
define('Insert_PROY_COMPONENTE_PLAN', "EXEC dbo.SP_PROY_COMPONENTE_PLAN
     @TipoAccion = 'Insert'
    ,@IDE_PROY_COMPONENTE = ?
    ,@IDE_PLAN = ?
    ,@FEC_INICIO = ?
    ,@FEC_TERMINO = ?
    ,@EST_COMPONENTE_PLAN = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROY_COMPONENTE_PLAN', "EXEC dbo.SP_PROY_COMPONENTE_PLAN
     @TipoAccion = 'Update'
    ,@pCodigo = ?
    ,@IDE_PROY_COMPONENTE = ?
    ,@IDE_PLAN = ?
    ,@FEC_INICIO = ?
    ,@FEC_TERMINO = ?
    ,@EST_COMPONENTE_PLAN = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_PROY_COMPONENTE_PLAN', "EXEC dbo.SP_PROY_COMPONENTE_PLAN
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

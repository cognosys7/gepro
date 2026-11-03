<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROY_COMP_RECURSODATA de la tabla PROY_COMP_RECURSO
  //  Fecha           : martes, 16 de enero de 2018 03:06:22 p.m.
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */
//Seleccionar count
define('Count_PROY_COMP_RECURSO', "EXEC dbo.SP_PROY_COMP_RECURSO
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROY_COMP_RECURSO', "EXEC dbo.SP_PROY_COMP_RECURSO
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROY_COMP_RECURSO', "EXEC dbo.SP_PROY_COMP_RECURSO
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PROY_COMP_RECURSO', "EXEC dbo.SP_PROY_COMP_RECURSO
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
define('Insert_PROY_COMP_RECURSO', "EXEC dbo.SP_PROY_COMP_RECURSO
     @TipoAccion = 'Insert'
		,@IDE_PROY_COMPONENTE = ?
		,@IDE_RECURSO = ?
		,@IDE_ROL = ?
		,@EST_PROY_COMP_REC = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);

define('Update_PROY_COMP_RECURSO', "EXEC dbo.SP_PROY_COMP_RECURSO
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_PROY_COMPONENTE = ?
		,@IDE_RECURSO = ?
		,@IDE_ROL = ?
		,@EST_PROY_COMP_REC = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);
define('Delete_PROY_COMP_RECURSO', "EXEC dbo.SP_PROY_COMP_RECURSO
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

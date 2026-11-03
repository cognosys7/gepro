
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Hector Lopez Sanchez
  //  Propósito       : PROC_TIPODATA de la tabla PROC_TIPO
  //  Fecha           : miércoles, 1 de noviembre de 2017 10:00:23
  //  Desde el Modelo : PDM AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_PROC_TIPO', "EXEC dbo.SP_PROC_TIPO
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROC_TIPO', "EXEC dbo.SP_PROC_TIPO
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROC_TIPO', "EXEC dbo.SP_PROC_TIPO
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PROC_TIPO', "EXEC dbo.SP_PROC_TIPO
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
define('Insert_PROC_TIPO', "EXEC dbo.SP_PROC_TIPO
     @TipoAccion = 'Insert'
		,@TIPO_PROC = ?
		,@SIGLA_PROC = ?
		,@EST_PROC_TIPO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROC_TIPO', "EXEC dbo.SP_PROC_TIPO
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@TIPO_PROC = ?
		,@SIGLA_PROC = ?
		,@EST_PROC_TIPO = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_PROC_TIPO', "EXEC dbo.SP_PROC_TIPO
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

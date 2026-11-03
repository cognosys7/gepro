
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROY_PIPDATA de la tabla PROY_PIP
  //  Fecha           : jueves, 16 de mayo de 2019 15:57:58
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-E
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_PROY_PIP', "EXEC dbo.SP_PROY_PIP
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROY_PIP', "EXEC dbo.SP_PROY_PIP
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROY_PIP', "EXEC dbo.SP_PROY_PIP
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PROY_PIP', "EXEC dbo.SP_PROY_PIP
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
define('Insert_PROY_PIP', "EXEC dbo.SP_PROY_PIP
     @TipoAccion = 'Insert'
		,@IDE_PIP = ?
		,@IDE_PROYECTO = ?
		,@COD_SNIP = ?
		,@COD_UNICO = ?
		,@COD_INFOBRAS = ?
		,@COD_INTERNO = ?
		,@EST_PROY_SNIP = ?
		,@CHK = ?
		,@EST_PROY_PIP = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROY_PIP', "EXEC dbo.SP_PROY_PIP
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_PIP = ?
		,@IDE_PROYECTO = ?
		,@COD_SNIP = ?
		,@COD_UNICO = ?
		,@COD_INFOBRAS = ?
		,@COD_INTERNO = ?
		,@EST_PROY_SNIP = ?
		,@CHK = ?
		,@EST_PROY_PIP = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_PROY_PIP', "EXEC dbo.SP_PROY_PIP
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

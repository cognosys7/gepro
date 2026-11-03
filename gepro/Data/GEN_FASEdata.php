
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_FASEDATA de la tabla GEN_FASE
  //  Fecha           : domingo, 12 de mayo de 2019 3:30:19
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-E
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_GEN_FASE', "EXEC dbo.SP_GEN_FASE
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_GEN_FASE', "EXEC dbo.SP_GEN_FASE
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_GEN_FASE', "EXEC dbo.SP_GEN_FASE
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_GEN_FASE', "EXEC dbo.SP_GEN_FASE
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
define('Insert_GEN_FASE', "EXEC dbo.SP_GEN_FASE
     @TipoAccion = 'Insert'
		,@DES_FASE = ?
		,@DES_CICLO = ?
		,@EST_FASE = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_GEN_FASE', "EXEC dbo.SP_GEN_FASE
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@DES_FASE = ?
		,@DES_CICLO = ?
		,@EST_FASE = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_GEN_FASE', "EXEC dbo.SP_GEN_FASE
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

<?php

//Seleccionar count
define('Count_GEN_ENTIDAD', "EXEC dbo.SP_GEN_ENTIDAD
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_GEN_ENTIDAD', "EXEC dbo.SP_GEN_ENTIDAD
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_GEN_ENTIDAD', "EXEC dbo.SP_GEN_ENTIDAD
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_GEN_ENTIDAD', "EXEC dbo.SP_GEN_ENTIDAD
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
define('Insert_GEN_ENTIDAD', "EXEC dbo.SP_GEN_ENTIDAD
     @TipoAccion = 'Insert'		
		,@IDE_SECTOR = ?
		,@COD_RUC = ?
		,@DES_ENTIDAD = ?
		,@TIP_ENTIDAD = ?
		,@NUM_NIVEL = ?
		,@EST_ENTIDAD = ?
		,@SEC_EJEC = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_GEN_ENTIDAD', "EXEC dbo.SP_GEN_ENTIDAD
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_SECTOR = ?
		,@COD_RUC = ?
		,@DES_ENTIDAD = ?
		,@TIP_ENTIDAD = ?
		,@NUM_NIVEL = ?
		,@EST_ENTIDAD = ?
		,@SEC_EJEC = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_GEN_ENTIDAD', "EXEC dbo.SP_GEN_ENTIDAD
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

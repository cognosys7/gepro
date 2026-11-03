<?php

//Seleccionar count
define('Count_GEN_TABLAS',
"EXEC dbo.SP_GEN_TABLAS
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_GEN_TABLAS',
"EXEC dbo.SP_GEN_TABLAS
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"   
);

//Seleccionar Registros Por Condici�n Generada Por el Usuario
define('SelCampos_GEN_TABLAS',
"EXEC dbo.SP_GEN_TABLAS
     @TipoAccion= 'SelCampos'
     ,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_GEN_TABLAS',
"EXEC dbo.SP_GEN_TABLAS
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
define('Insert_GEN_TABLAS',
"EXEC dbo.SP_GEN_TABLAS
     @TipoAccion = 'Insert'
		,@COD_TABLA = ?
		,@COD_ITEM = ?
		,@DES_ITEM = ?
		,@DES_ABREVIATURA = ?
		,@EST_ITEM = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_GEN_TABLAS',
"EXEC dbo.SP_GEN_TABLAS
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@COD_TABLA = ?
		,@COD_ITEM = ?
		,@DES_ITEM = ?
		,@DES_ABREVIATURA = ?
		,@EST_ITEM = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);        

define('Delete_GEN_TABLAS',
"EXEC dbo.SP_GEN_TABLAS
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

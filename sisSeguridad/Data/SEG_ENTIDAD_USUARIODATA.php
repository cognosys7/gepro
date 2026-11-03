<?php

//Seleccionar count
define('Count_SEG_ENTIDAD_USUARIO',
"EXEC seguridad.SP_SEG_ENTIDAD_USUARIO
     @TipoAccion= 'Count'
    ,@filtro = ?"
);

//Seleccionar un Registro Por Clave Primaria
define('SelPk_SEG_ENTIDAD_USUARIO',
"EXEC seguridad.SP_SEG_ENTIDAD_USUARIO
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"   
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_SEG_ENTIDAD_USUARIO',
"EXEC seguridad.SP_SEG_ENTIDAD_USUARIO
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_SEG_ENTIDAD_USUARIO',
"EXEC seguridad.SP_SEG_ENTIDAD_USUARIO
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
define('Insert_SEG_ENTIDAD_USUARIO',
"EXEC seguridad.SP_SEG_ENTIDAD_USUARIO
     @TipoAccion = 'Insert'
		,@IDUSUARIO = ?
		,@IDE_ENTIDAD = ?
		,@TIP_ACCESO = ?
		,@EST_ENTIDAD_USUARIO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_SEG_ENTIDAD_USUARIO',
"EXEC seguridad.SP_SEG_ENTIDAD_USUARIO
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDUSUARIO = ?
		,@IDE_ENTIDAD = ?
		,@TIP_ACCESO = ?
		,@EST_ENTIDAD_USUARIO = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);        

define('Delete_SEG_ENTIDAD_USUARIO',
"EXEC seguridad.SP_SEG_ENTIDAD_USUARIO
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);
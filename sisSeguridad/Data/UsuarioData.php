<?php

define('SELECT_USUARIO_SELECCIONADO',
        "EXEC seguridad.paVerificaDatosUsuarioxId @pidusuario = ?"
);

define('SELECT_USUARIO_IDPERSONA',
        "EXEC seguridad.paVerificaDatosUsuarioIdPersona @pidpersona = ?"
);

//MANTENIMIENTO
define('INSERTA_DATOS_USUARIO_PERSONAL',
        "EXEC seguridad.paInsertaDatosUsuarioPersonal @pIdPersona = ?, @pPerDocumento = ?, @pPerNroDocumento = ?, @pPerApePaterno = ?, @pPerApeMaterno = ?,"
        . "@pPerNombres = ?, @pusuclave = ?, @pPerSexo = ?, @pPerFecNacimiento = ?, @pusuldap = ?, @pprhunidadorganica = ?,"
        . "@pUsuario = ?, @pIdError = ?, @pMensajeError = ?"
);

define('ACTUALIZA_DATOS_USUARIO_PERSONAL',
        "EXEC seguridad.paActualizaDatosUsuarioPersonal "
        . "@pIdUsuario = ?"
        . ", @pIdPersona = ?"
        . ", @pIdPersonal = ?"
        . ", @pPerApePaterno = ?"
        . ", @pPerApeMaterno = ?"
        . ", @pPerNombres = ?"
        . ", @pPerSexo = ?"
        . ", @pPerFecNacimiento = ?"
        . ", @pusuldap = ?"
        . ", @pprhunidadorganica = ?"
        . ", @pUsuario = ?"
        . ", @pIdError = ?"
        . ", @pMensajeError = ?"
);

define('ACTUALIZA_CLAVE_USUARIO',
        "EXEC seguridad.paActualizaClaveUsuario @pidUsuario = ?, @pUsuario = ?, @pIdError = ?, @pMensajeError = ?"
);

define('ELIMINA_DATOS_USUARIO_PERSONAL',
        "EXEC seguridad.paEliminaDatosUsuarioPersonal @pidUsuario = ?, @pidPersonal = ?, @pUsuario = ?, @pIdError = ?, @pMensajeError = ?"
);

//FLEXIGRID
define('CUENTA_USUARIOS',
        "EXEC seguridad.paCuentaUsuariosFlexigrid @where = ?"
);

define('LISTA_USUARIOS',
"EXEC seguridad.paListarUsuariosFlexigrid
   @rp = ?
  ,@sortname = ?
  ,@sortorder = ?
  ,@page = ?
  ,@where = ?
  ,@codigoMensaje = ?
  ,@Mensaje = ?
  ,@nTotal = ?
"
);

define('LISTAR_USUARIOS',
"EXEC seguridad.paListarUsuarios
   @filtro = ?
  ,@Campos = ?  
"
);

?>
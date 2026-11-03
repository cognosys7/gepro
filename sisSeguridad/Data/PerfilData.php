<?php

define('VER_PERFIL_XID',
        "EXEC seguridad.paVerificaPerfilxID @pIdPerfil = ?"
    );

//MANTENIMIENTO
define('INSERTA_DATOS_PERFIL',
        "EXEC seguridad.paInsertaDatosPerfil @ppefnombre = ?, @ppefmodulo = ?, @pUsuario = ?, @pIdError = ?, @pMensajeError = ?"
);

define('ACTUALIZA_DATOS_PERFIL',
        "EXEC seguridad.paActualizaDatosPerfil @pidperfil = ?, @pidmodulo = ?, @ppefnombre = ?, @pUsuario = ?, @pIdError = ?, @pMensajeError = ?"
);

define('ELIMINA_DATOS_PERFIL',
        "EXEC seguridad.paEliminaDatosPerfil @pidperfil = ?, @pUsuario = ?, @pIdError = ?, @pMensajeError = ?"
);

//FLEXIGRID
define('CUENTA_PERFIL',
        "EXEC seguridad.paCuentaPerfilFlexigrid @where = ?"
);

define('LISTA_PERFIL',
"EXEC seguridad.paListarPerfilFlexigrid
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
?>
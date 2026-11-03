<?php

//FLEXIGRID
define('LISTA_USUARIO_PERFIL',
"EXEC seguridad.paListarUsuarioPerfilFlexigrid
   @rp = ?
  ,@sortname = ?
  ,@sortorder = ?
  ,@page = ?
  ,@where = ?
  ,@pIdUsuario = ?
  ,@codigoMensaje = ?
  ,@Mensaje = ?
  ,@nTotal = ?
"
);

define('AGREGAR_QUITAR_USUARIO_PERFIL',
        "EXEC seguridad.paAgregarQuitarUsuarioPerfil @pidUsuario = ?, @pidPerfil = ?, @pidModulo = ?, @pTipo = ?, @pUsuario = ?, @pIdError = ?, @pMensajeError = ?"
);
?>
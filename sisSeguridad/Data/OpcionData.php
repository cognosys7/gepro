<?php

define('VERIFICA_OPCION_SELECCIONADO',
        "EXEC seguridad.paVerificaDatosOpcionxID @pidopcion = ?"
);

//MANTENIMIENTO
define('INSERTA_DATOS_OPCION',
        "EXEC seguridad.paInsertaDatosOpcion @popcdescripcion = ?, @popcmodulo = ?, @popcenlace = ?, @popcdestino = ?, @popcnivel = ?, "
        . "@popcpadre = ?, @popclightbox = ?, @pUsuario = ?, @pIdError = ?, @pMensajeError = ?"
);

define('ACTUALIZA_ORDEN_OPCION',
        "EXEC seguridad.paActualizaOrdenOpcion @pidopcion = ?, @pTipoOrden = ?, @pUsuario = ?, @pIdError = ?, @pMensajeError = ?"
);

define('ACTUALIZA_DATOS_OPCION',
        "EXEC seguridad.paActualizaDatosOpcion @popcdescripcion = ?, @popcenlace = ?, @popcdestino = ?, @popcnivel = ?, "
        . "@popcpadre = ?, @popclightbox = ?, @popcmodulo = ?, @popcmoduloOrig = ?, @pidopcion = ?, @pUsuario = ?, "
        . "@pIdError = ?, @pMensajeError = ?"
);

define('ELIMINA_DATOS_OPCION',
        "EXEC seguridad.paEliminaDatosOpcion @pidopcion = ?, @pUsuario = ?, @pIdError = ?, @pMensajeError = ?"
);

//FLEXIGRID
define('CUENTA_OPCION',
        "EXEC seguridad.paCuentaOpcionFlexigrid @where = ?"
);

define('LISTA_OPCION',
"EXEC seguridad.paListarOpcionFlexigrid
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

define('LISTA_OPCION_ACCESO',
"EXEC seguridad.paListarOpcionAccesoFlexigrid
   @rp = ?
  ,@sortname = ?
  ,@sortorder = ?
  ,@page = ?
  ,@where = ?
  ,@IdPerfil = ?
  ,@codigoMensaje = ?
  ,@Mensaje = ?
  ,@nTotal = ?
"
);
?>
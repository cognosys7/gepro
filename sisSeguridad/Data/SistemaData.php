<?php

define('LISTA_SISTEMAS_MODULOS',
        "EXEC seguridad.paListaSistemasModulos"
);

define('VERIFICA_SISTEMA_SELECCIONADO',
        "EXEC seguridad.paVerificaDatosSistemaxID @pidsistema = ?"
);

//MANTENIMIENTO
define('INSERTA_DATOS_SISTEMA',
        "EXEC seguridad.paInsertaDatosSistemaModulo @psisnombre = ?, @psisurl = ?, @psisabreviatura = ?, @pmodnombre = ?, @pUsuarioReg = ?, @pIdError = ?, @pMensajeError = ?"
);

define('ACTUALIZA_DATOS_SISTEMA',
        "EXEC seguridad.paActualizaDatosSistemaModulo @pidsistema = ?, @pidmodulo = ?, @psisnombre = ?, @psisurl = ?, @psisabreviatura = ?, @pmodnombre = ?, @pUsuario = ?, @pIdError = ?, @pMensajeError = ?"
);

define('ELIMINA_DATOS_SISTEMA',
        "EXEC seguridad.paEliminaDatosSistemaModulo @pidsistema = ?, @pidmodulo = ?, @pUsuario = ?, @pIdError = ?, @pMensajeError = ?"
);

//FLEXIGRID
define('CUENTA_SISTEMA',
        "EXEC seguridad.paCuentaSistemasFlexigrid @where = ?"
);

define('LISTA_SISTEMAS',
"EXEC seguridad.paListarSistemasFlexigrid
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
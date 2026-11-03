<?php
define('VERIFICA_PERFIL_UBIGEO_SELECCIONADO',
        "EXEC convenio.paVerificaPerfilUbigeoxId @pIdPerfilUbigeo = ?"
);

define('VERIFICA_PERFIL_SELECCIONADO',
        "EXEC seguridad.paVerificaPerfilxID @pIdPerfil = ?"
);

//////MANTENIMIENTO
define('INSERTA_DATOS_PERFIL_UBIGEO',
        "EXEC convenio.paInsertaPerfilUbigeo "
        . " @pIdPerfil = ?"
        . ", @pIdubigeo = ?"
        . ", @pUsuario = ?"
        . ", @pIdError = ?"
        . ", @pMensajeError = ?"
);

define('ACTUALIZA_DATOS_PERFIL_UBIGEO',
        "EXEC convenio.paActualizaPerfilUbigeo "
        . " @pIdPerfilUbigeo = ?"
        . ", @pIdPerfil = ?"
        . ", @pIdubigeo = ?"
        . ", @pUsuario = ?"
        . ", @pIdError = ?"
        . ", @pMensajeError = ?"
);

define('ELIMINA_DATOS_PERFIL_UBIGEO',
        "EXEC convenio.paEliminaPerfilUbigeo "
        . " @pIdPerfilUbigeo = ?"
        . ", @pUsuario = ?"
        . ", @pIdError = ?"
        . ", @pMensajeError = ?"
);

////FLEXIGRID
//define('CUENTA_PERFIL',
//        "EXEC seguridad.paCuentaPerfilFlexigrid @where = ?"
//);
//
//define('LISTA_PERFIL_FLEXIGRID',
//"EXEC seguridad.paListarPerfilFlexigrid2
//   @rp = ?
//  ,@sortname = ?
//  ,@sortorder = ?
//  ,@page = ?
//  ,@where = ?
//  ,@codigoMensaje = ?
//  ,@Mensaje = ?
//  ,@nTotal = ?
//"
//);

define('CUENTA_PERFIL_UBIGEO',
        "EXEC convenio.paCuentaPerfilUbigeoFlexigrid @where = ?"
);

define('LISTA_PERFIL_UBIGEO_FLEXIGRID',
"EXEC convenio.paListarPerfilUbigeoFlexigrid
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
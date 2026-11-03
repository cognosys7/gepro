<?php
   
define('VERIFICA_FAMILIA_SELECCIONADA',
        "EXEC dbo.paVerificaFamiliaxID @pIDE_Familia = ?"
);

define('CUENTA_FAMILIAS',
        "EXEC dbo.paCuentaFamiliasFlexigrid @where = ?"
);

define('INSERTA_DATOS_FAMILIA',
        "EXEC dbo.paInsertaFamilia "
        . "  @pFamilia = ?"
        . ", @pIDE_UBIGEO = ?"
        . ", @pUsuario = ?"
        . ", @pIdError = ?"
        . ", @pMensajeError = ?"
);

define('ACTUALIZA_DATOS_FAMILIA',
        "EXEC dbo.paActualizaFamilia "
        . "  @pIDE_Familia = ?"
        . ", @pFamilia = ?"
        . ", @pIDE_UBIGEO = ?"
        . ", @pUsuario = ?"
        . ", @pIdError = ?"
        . ", @pMensajeError = ?"
);

define('ELIMINA_DATOS_FAMILIA',
        "EXEC dbo.paEliminaFamilia "
        . "  @pIDE_Familia = ?"
        . ", @pUsuario = ?"
        . ", @pIdError = ?"
        . ", @pMensajeError = ?"
);

define('LISTA_FAMILIAS_FLEXIGRID',
"EXEC dbo.paListarFamiliasFlexigrid
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
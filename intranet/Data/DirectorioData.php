<?php
//OKPA
define('VERIFICA_DIRECTORIO_SELECT',
        "EXEC Intranet.paVerificaDirectorioPersonalxId @pidpersonal = %d"
);

//OKPA
define('LISTADO_DIRECTORIO',
        "EXEC intranet.paMostrarDirectorioAnexo"
);

//OKPA
define('INSERTA_DIRECTORIO',
        "EXEC intranet.paNuevoDirectorio "
        . " @pPersonal = ?"
        . ", @pTelfDirecto = ?"
        . ", @pTelfAnexo = ?"
        . ", @pCelular = ?"
        . ", @pCorreo = ?"
        . ", @pUsuario = ?"
        . ", @pIdError = ?"
        . ", @pMensajeError = ?"
);

//OKPA
define('DIRECTORIO_UPDATE',
        "EXEC intranet.paActualizaDirectorio "
        . "@pTelfDirecto = ?"
        . ", @pTelfAnexo = ?"
        . ", @pCelular = ?"
        . ", @pCorreo = ?"
        . ", @pUsuario = ?"
        . ", @pCodigo = ?"
        . ", @pIdError = ?"
        . ", @pMensajeError = ?"
);
?>
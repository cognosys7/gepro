<?php

define('VERIFICA_DATOS_PERSONA',
        "EXEC general.paVerificaPersonaDNI
          @pPerDocumento = ?, @pPerNroDocumento = ?"
);

define('INSERTA_DATOS_PERSONA',
        "EXEC general.paInsertaDatosBasicosPersona @pPerDocumento = ?, @pPerNroDocumento = ?, @pPerApePaterno = ?, @pPerApeMaterno = ?, "
        . "@pPerNombres = ?,@pUsuarioReg = ?, @pIdPersona = ?, @pIdError = ?,@pMensajeError = ?"
);

define('INSERTA_DATOS_PERSONA_RENIEC',
        "EXEC general.paInsertaDatosReniecPersona @pPerDocumento = ?, @pPerNroDocumento = ?, @pPerApePaterno = ?, @pPerApeMaterno = ?, "
        . "@pPerNombres = ?,@pUsuarioReg = ?, @pPerFecNacimiento = ?, @pPerSexo = ?, @pIdPersona = ?, @pIdError = ?,@pMensajeError = ?"
);

?>
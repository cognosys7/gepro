<?php
//OKPA
define('SELECT_USUARIO_LOGIN',
        "EXEC seguridad.paVerificaUsuarioLoguin @pusunombre = '%s', @pusuclave = '%s'"
);

//OKPA
define('RECUPERA_USUARIO_LOGIN',
        "EXEC seguridad.paRecuperaUsuarioLoguin @pPerNroDocumento = '%s'"
);

//OKPA
define('RECUPERA_USUARIO_LDAP',
        "EXEC seguridad.paRecuperaUsuarioLDAP @pPerUsuario = '%s'"
);

//OKPA
define('RECUPERA_USUARIO_LOGIN2',
        "EXEC seguridad.paRecuperaUsuarioLoguin2 @pidusuario = %d, @pusudatorecupera = %d"
);

//OKPA
// define('SELECT_PERSONAL_SELECT',
//         "EXEC general.paVerificaPersonalxId @pprhpersona = %d"
// );

//OKPA
define('SELECT_USUARIO_SELEC',
        "EXEC seguridad.paVerificaUsuarioPersonalxId @pidusuario = %d"
);

//OKPA
// define('SELECT_CUMPLE_USUARIOS2',
//         "EXEC general.paListaCumpleUsuarios2 @pScript = ?"
// );
  
//OKPA
// define('SELECT_CUMPLE_USUARIOS',
//         "EXEC general.paListaCumpleUsuarios @pScript1 = ?, @pScript2 = ?"
// );

//OKPA
define('USUARIO_CLAVE_UPDATE',
        "EXEC seguridad.ActualizaClave "
        . " @pClave = ?"
        . ", @pUsuario = ?"
        . ", @pCodigo = ?"
        . ", @pIdError = ?"
        . ", @pMensajeError = ?"
);

//OKPA
define('USUARIO_CLAVE_UPDATE2',
        "EXEC seguridad.ActualizaClave2 "
        . " @pClave = ?"
        . ", @pCodigo = ?"
        . ", @pIdError = ?"
        . ", @pMensajeError = ?"
);

//OKPA
define('USUARIO_CLAVE_UPDATE3',
        "EXEC seguridad.ActualizaClave3 "
        . " @pClave = ?"
        . ", @pUsuRecupera = ?"
        . ", @pUsuario = ?"
        . ", @pCodigo = ?"
        . ", @pIdError = ?"
        . ", @pMensajeError = ?"
);
?>
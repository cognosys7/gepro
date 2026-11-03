<?php    
    define('VERIFICA_SISTEMA_XNOM',
        "EXEC seguridad.paVerificaDatosSistemaxNom @psisabreviatura = ?"
    );
    
    define('SELECT_USUARIO_SELEC',
        "EXEC seguridad.paVerificaDatosUsuarioxId @pidusuario = ?"
    );
    
    define('VERIFICA_USUARIO_PERFIL',
        "EXEC seguridad.paVerificaDatosUsuarioPerfil @pupsusuario = ?, @pmodsistema = ?"
    );
    
    define('VERIFICA_PERFIL_XID',
        "EXEC seguridad.paVerificaPerfilxID @pIdPerfil = ?"
    );
    
    define('LISTA_MENUS',
        "EXEC seguridad.paListaOpcionesMenu @pScript = ?"
    );
    
    define('VERIFICA_ACCESO_OPCION_PERFIL',
        "EXEC seguridad.paVerificaAccesoxOpcionPerfil @pIdOpcion = ?, @pIdPerfil = ?"
    );
?>

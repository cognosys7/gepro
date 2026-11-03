<?php

define('AGREGAR_QUITAR_ACCESO',
        "EXEC seguridad.paAgregarQuitarAcceso @pidopcion = ?, @pidperfil = ?, @pTipo = ?, @pUsuario = ?, @pIdError = ?, @pMensajeError = ?"
);
?>
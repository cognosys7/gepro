<?php

namespace App\Auth;

use Illuminate\Auth\GenericUser;

/**
 * Usuario de GEPRO (seguridad.tsusuario + general.tgpersona + general.trpersonal).
 * Atributos: id, usunombre, usuldap, nombre, idpersona, idpersonal, unidad, idunidad, idjefe.
 * No guarda la clave: solo se usa al validar el ingreso (LegadoUserProvider).
 */
class UsuarioGepro extends GenericUser
{
    public function getRememberTokenName()
    {
        return '';
    }

    /** "MEZA YANGALI JULIO CESAR" -> "Meza Yangali Julio Cesar" */
    public function nombreVisible(): string
    {
        return mb_convert_case(trim((string) ($this->attributes['nombre'] ?? '')), MB_CASE_TITLE, 'UTF-8');
    }
}

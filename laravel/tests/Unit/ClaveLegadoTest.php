<?php

namespace Tests\Unit;

use App\Auth\LegadoUserProvider;
use PHPUnit\Framework\TestCase;

/**
 * La clave se calcula igual que en el login del sistema actual (PrincipalLN.php).
 */
class ClaveLegadoTest extends TestCase
{
    public function test_ingreso_con_usunombre(): void
    {
        $esperado = md5('JPEREZ'.'Secreta1'.'Cognosys@SAC');
        $this->assertSame($esperado, LegadoUserProvider::claveLegado('jperez', 'Secreta1', 'JPEREZ', 'JUAN.PEREZ'));
    }

    public function test_ingreso_con_usuldap_usa_usunombre(): void
    {
        $esperado = md5('JPEREZ'.'Secreta1'.'Cognosys@SAC');
        $this->assertSame($esperado, LegadoUserProvider::claveLegado('juan.perez', 'Secreta1', 'JPEREZ', 'JUAN.PEREZ'));
    }

    public function test_usuario_que_no_coincide(): void
    {
        $this->assertNull(LegadoUserProvider::claveLegado('otro', 'x', 'JPEREZ', 'JUAN.PEREZ'));
    }

    public function test_misma_limpieza_que_el_sistema_actual(): void
    {
        //Reemplazar(): ' -> 0, quita ; y %; luego addslashes y htmlspecialchars
        $this->assertSame('a0b&amp;c', LegadoUserProvider::limpiar(" a'b;&c% "));
        $this->assertSame(md5('JPEREZ'.'a0b&amp;c'.'Cognosys@SAC'), LegadoUserProvider::claveLegado('JPEREZ', "a'b;&c%", 'JPEREZ', ''));
    }
}

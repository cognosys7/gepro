<?php

namespace Tests\Feature;

use App\Auth\LegadoUserProvider;
use App\Livewire\Seguridad\Opciones;
use App\Livewire\Seguridad\PerfilAccesos;
use App\Livewire\Seguridad\Perfiles;
use App\Livewire\Seguridad\Sistemas;
use App\Livewire\Seguridad\UsuarioPerfiles;
use App\Livewire\Seguridad\Usuarios;
use App\Services\Seguridad;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\UsuariosDePrueba;

/**
 * Sistema de seguridad (antes sisSeguridad), contra BDGEPRO. Lo que graba se revierte.
 */
class SeguridadTest extends TestCase
{
    use DatabaseTransactions;
    use UsuariosDePrueba;

    protected $connectionsToTransact = ['sqlsrv'];

    private function admin(): object
    {
        $u = $this->usuarioSeguridad();
        if (! $u) {
            $this->markTestSkipped('Ningun usuario tiene perfil de administracion en el sistema de seguridad.');
        }

        return $u;
    }

    private function cuenta(string $sp, string $filtro = ' '): int
    {
        return (int) array_values((array) DB::selectOne('SET NOCOUNT ON; EXEC seguridad.'.$sp.' @where = ?', [$filtro]))[0];
    }

    public function test_entra_solo_con_perfil_de_seguridad(): void
    {
        $admin = $this->admin();
        foreach (config('gepro.seguridad.paginas') as $pagina) {
            $perfil = app(Seguridad::class)->perfilSeguridad((int) $admin->id);
            $esperado = app(Seguridad::class)->opcionDePagina($perfil['perfil'], $perfil['modulo'], $pagina) ? 200 : 403;
            $this->actingAs($admin)->get(route('seguridad.pagina', ['pagina' => $pagina]))->assertStatus($esperado);
        }
        $this->actingAs($admin)->get(route('seguridad.inicio'))->assertRedirect();
        $this->actingAs($admin)->get('/seguridad/PROYECTO')->assertNotFound();

        //PERFIL DE GEPRO (AUNQUE SE LLAME ADMINISTRADOR) SIN PERFIL EN SEGURIDAD: NO ENTRA
        $soloGepro = $this->usuarioSeguridad(false);
        if ($soloGepro) {
            $this->actingAs($soloGepro)->get(route('seguridad.pagina', ['pagina' => 'Usuarios']))->assertForbidden();
            $this->actingAs($soloGepro)->get(route('seguridad.inicio'))->assertForbidden();
        }
    }

    public function test_menu_de_seguridad_y_enlace_desde_gepro(): void
    {
        $admin = $this->admin();
        $s = app(Seguridad::class);
        $perfil = $s->perfilSeguridad((int) $admin->id);
        $urls = collect($s->menu($perfil['perfil'], $perfil['modulo'], true))->flatMap(fn ($o) => array_merge([$o['url']], array_column($o['hijos'], 'url')))->filter()->implode(' ');
        $this->assertStringContainsString(route('seguridad.pagina', ['pagina' => 'Usuarios']), $urls);

        //LA OPCION "SEGURIDAD DEL SISTEMA" DEL MENU DE GEPRO ABRE EL MODULO DE LARAVEL
        $opcion = DB::table('seguridad.tsopcion')->where('opcestado', 1)->where('opcenlace', 'like', '%SisSeguridad/%')
            ->first(['IdOpcion', 'OpcNivel', 'OpcPadre', 'OpcEnlace', 'OpcTipoEnlace']);
        if ($opcion) {
            $this->assertSame(route('seguridad.inicio'), $s->url($opcion));
        }
    }

    public function test_mismos_totales_que_el_sistema_actual(): void
    {
        $this->actingAs($this->admin());
        Livewire::test(Perfiles::class, ['pagina' => 'Perfil'])->assertViewHas('filas', fn ($f) => $f->total() === $this->cuenta('paCuentaPerfilFlexigrid'));
        Livewire::test(Opciones::class)->assertViewHas('filas', fn ($f) => $f->total() === $this->cuenta('paCuentaOpcionFlexigrid'));
        Livewire::test(Sistemas::class)->assertViewHas('filas', fn ($f) => $f->total() === $this->cuenta('paCuentaSistemasFlexigrid'));
        Livewire::test(Usuarios::class)->assertViewHas('filas', fn ($f) => $f->total() === $this->cuenta('paCuentaUsuariosFlexigrid'));
    }

    public function test_busqueda_con_parametros(): void
    {
        $this->actingAs($this->admin());
        Livewire::test(Usuarios::class)->set('buscar', "' OR 1=1 --")->assertViewHas('filas', fn ($f) => $f->total() === 0);
        Livewire::test(Perfiles::class)->set('buscar', 'ADMINISTRADOR')->assertViewHas('filas', fn ($f) => $f->total() > 0)
            ->set('orden', 'perfil; DROP TABLE x')->assertViewHas('filas', fn ($f) => $f->total() > 0);
    }

    public function test_perfil_registrar_editar_y_eliminar(): void
    {
        $this->actingAs($this->admin());
        $modulo = (string) DB::table('seguridad.tsmodulo')->where('modestado', 1)->where('modsistema', app(Seguridad::class)->sistema())->value('idmodulo');

        Livewire::test(Perfiles::class)->call('nuevo')->set('modulo', $modulo)->set('nombre', 'PERFIL LARAVEL PRUEBA')->call('guardar')->assertHasNoErrors();
        $id = (int) DB::table('seguridad.tsperfil')->where('pefestado', 1)->where('pefnombre', 'PERFIL LARAVEL PRUEBA')->value('idperfil');
        $this->assertGreaterThan(0, $id);

        //MISMO NOMBRE EN EL MISMO SISTEMA (@pIdError = 2)
        Livewire::test(Perfiles::class)->call('nuevo')->set('modulo', $modulo)->set('nombre', 'PERFIL LARAVEL PRUEBA')->call('guardar')->assertHasErrors('nombre');

        Livewire::test(Perfiles::class)->call('editar', $id)->assertSet('modulo', $modulo)->set('nombre', 'PERFIL LARAVEL EDITADO')->call('guardar')->assertHasNoErrors();
        $this->assertSame('PERFIL LARAVEL EDITADO', trim(DB::table('seguridad.tsperfil')->where('idperfil', $id)->value('pefnombre')));

        //EN LA OPCION ACCESO NO SE EDITA
        Livewire::test(Perfiles::class, ['pagina' => 'Acceso'])->call('editar', $id)->assertSet('abierto', false);

        Livewire::test(Perfiles::class)->call('eliminar', $id);
        $this->assertSame(0, (int) DB::table('seguridad.tsperfil')->where('idperfil', $id)->value('pefestado'));
    }

    public function test_no_elimina_su_propio_perfil_de_seguridad(): void
    {
        $admin = $this->admin();
        $this->actingAs($admin);
        $perfil = app(Seguridad::class)->perfilSeguridad((int) $admin->id)['perfil'];
        Livewire::test(Perfiles::class)->call('eliminar', $perfil);
        $this->assertSame(1, (int) DB::table('seguridad.tsperfil')->where('idperfil', $perfil)->value('pefestado'));
    }

    public function test_opciones_y_accesos(): void
    {
        $this->actingAs($this->admin());
        $modulo = (string) DB::table('seguridad.tsmodulo')->where('modestado', 1)->where('modsistema', app(Seguridad::class)->sistema())->value('idmodulo');

        Livewire::test(Opciones::class)->call('nuevo')->set('datos.modulo', $modulo)->set('datos.nombre', 'GRUPO LARAVEL')->call('guardar')->assertHasNoErrors();
        $grupo = (int) DB::table('seguridad.tsopcion')->where('opcestado', 1)->where('opcmodulo', $modulo)->where('opcdescripcion', 'GRUPO LARAVEL')->value('idopcion');
        $this->assertGreaterThan(0, $grupo);

        //SECUNDARIA SIN PRINCIPAL: ERROR; CON PRINCIPAL: SE REGISTRA DEBAJO
        Livewire::test(Opciones::class)->call('nuevo')->set('datos.modulo', $modulo)->set('datos.nivel', '2')->set('datos.nombre', 'OPCION LARAVEL A')->call('guardar')->assertHasErrors('datos.padre');
        foreach (['A', 'B'] as $letra) {
            Livewire::test(Opciones::class)->call('nuevo')->set('datos.modulo', $modulo)->set('datos.nivel', '2')->set('datos.padre', (string) $grupo)
                ->set('datos.nombre', 'OPCION LARAVEL '.$letra)->set('datos.enlace', 'Antirefresh.php?Pagina=PRUEBA_'.$letra)->call('guardar')->assertHasNoErrors();
        }
        $a = DB::table('seguridad.tsopcion')->where('opcestado', 1)->where('opcdescripcion', 'OPCION LARAVEL A')->first();
        $b = DB::table('seguridad.tsopcion')->where('opcestado', 1)->where('opcdescripcion', 'OPCION LARAVEL B')->first();
        $this->assertSame([$grupo, $grupo, 2], [(int) $a->opcpadre, (int) $b->opcpadre, (int) $b->opcnivel]);
        $this->assertLessThan((int) $b->opcorden, (int) $a->opcorden);

        //EN LA LISTA VAN DEBAJO DE SU PRINCIPAL; BAJAR A LA PRIMERA LA PONE DESPUES DE LA SEGUNDA
        $orden = fn () => collect(Livewire::test(Opciones::class)->set('filtroModulo', $modulo)->set('porPagina', 100)->set('buscar', 'LARAVEL')->viewData('filas')->items())->pluck('idopcion')->map(fn ($i) => (int) $i)->all();
        $this->assertSame([$grupo, (int) $a->idopcion, (int) $b->idopcion], $orden());
        Livewire::test(Opciones::class)->call('mover', (int) $a->idopcion, false);
        $this->assertSame([$grupo, (int) $b->idopcion, (int) $a->idopcion], $orden());

        //UNA PRINCIPAL CON SECUNDARIAS NO SE ELIMINA NI PASA A SECUNDARIA
        Livewire::test(Opciones::class)->call('eliminar', $grupo);
        $this->assertSame(1, (int) DB::table('seguridad.tsopcion')->where('idopcion', $grupo)->value('opcestado'));

        //ACCESOS DEL PERFIL: OTORGAR (UNA SOLA VEZ) Y QUITAR
        $perfil = (int) DB::table('seguridad.tsperfil')->where('pefestado', 1)->where('pefmodulo', $modulo)->value('idperfil');
        $accesos = fn () => DB::table('seguridad.tsacceso')->where('accperfil', $perfil)->where('accopcion', $a->idopcion)->where('accestado', 1)->count();
        $pantalla = Livewire::test(PerfilAccesos::class, ['perfil' => $perfil]);
        $pantalla->call('cambiar', (int) $a->idopcion, true)->call('cambiar', (int) $a->idopcion, true);
        $this->assertSame(1, $accesos());
        $pantalla->assertViewHas('filas', fn ($f) => collect($f)->firstWhere('idopcion', $a->idopcion)?->acceso == 1);
        $pantalla->call('cambiar', (int) $a->idopcion, false);
        $this->assertSame(0, $accesos());

        //OPCION DE OTRO MODULO: NO SE TOCA DESDE ESTE PERFIL
        $otra = (int) DB::table('seguridad.tsopcion')->where('opcestado', 1)->where('opcmodulo', '<>', $modulo)->value('idopcion');
        $pantalla->call('cambiar', $otra, true);
        $this->assertSame(0, DB::table('seguridad.tsacceso')->where('accperfil', $perfil)->where('accopcion', $otra)->where('accestado', 1)->count());

        foreach ([$a, $b] as $o) {
            Livewire::test(Opciones::class)->call('eliminar', (int) $o->idopcion);
        }
        Livewire::test(Opciones::class)->call('eliminar', $grupo);
        $this->assertSame(0, (int) DB::table('seguridad.tsopcion')->where('idopcion', $grupo)->value('opcestado'));
    }

    /** DNI que no esta en las personas, los usuarios ni RENIEC */
    private function dniLibre(): string
    {
        for ($n = 1; $n < 100; $n++) {
            $dni = str_pad((string) $n, 8, '0', STR_PAD_LEFT);
            if (! DB::table('general.tgpersona')->where('PerNroDocumento', $dni)->exists()
                && ! DB::table('seguridad.tsusuario')->where('usunombre', $dni)->exists()
                && ! DB::connection('reniec')->table('dbo.DataReniec')->where('Dni', $dni)->exists()) {
                return $dni;
            }
        }
        $this->markTestSkipped('No hay un DNI libre para la prueba.');
    }

    public function test_usuario_registrar_clave_editar_perfiles_y_eliminar(): void
    {
        $admin = $this->admin();
        $this->actingAs($admin);
        $dni = $this->dniLibre();

        //DNI DE UN USUARIO QUE YA EXISTE
        Livewire::test(Usuarios::class)->call('nuevo')->set('datos.dni', trim((string) $admin->usunombre))->call('verificar')->assertHasErrors('datos.dni')->assertSet('paso', 'dni');

        Livewire::test(Usuarios::class)->call('nuevo')->set('datos.dni', $dni)->call('verificar')->assertHasNoErrors()->assertSet('paso', 'datos')->assertSet('origen', '')
            ->set('datos.paterno', 'prueba')->set('datos.materno', 'laravel')->set('datos.nombres', 'usuario')
            ->set('datos.nacimiento', '1990-05-17')->set('datos.sexo', '0')->set('datos.usuario', 'prueba.laravel')
            ->call('guardar')->assertHasNoErrors();
        $u = DB::table('seguridad.tsusuario as u')->join('general.tgpersona as p', 'p.IdPersona', '=', 'u.usupersona')
            ->where('u.usuestado', 1)->where('u.usunombre', $dni)->first(['u.idusuario', 'u.usuldap', 'u.usuclave', 'p.PerApePaterno', 'p.PerSexo', 'p.PerFecNacimiento']);
        $this->assertNotNull($u);
        $this->assertSame(['PRUEBA.LARAVEL', 'PRUEBA', 0, '1990-05-17'], [trim($u->usuldap), trim($u->PerApePaterno), (int) $u->PerSexo, substr((string) $u->PerFecNacimiento, 0, 10)]);

        //INGRESA CON SU DNI COMO CLAVE, CON EL DNI O CON SU NOMBRE DE USUARIO
        $proveedor = new LegadoUserProvider();
        foreach ([$dni, 'prueba.laravel'] as $nombre) {
            $usuario = $proveedor->retrieveByCredentials(['usuario' => $nombre]);
            $this->assertNotNull($usuario, $nombre);
            $this->assertTrue($proveedor->validateCredentials($usuario, ['usuario' => $nombre, 'clave' => $dni]), $nombre);
        }

        //OTRO USUARIO NO PUEDE TOMAR ESE NOMBRE
        Livewire::test(Usuarios::class)->call('editar', (int) $admin->id)->set('datos.usuario', 'PRUEBA.LARAVEL')->call('guardar')->assertHasErrors('datos.usuario');

        //EDITAR
        Livewire::test(Usuarios::class)->call('editar', (int) $u->idusuario)->assertSet('datos.dni', $dni)->assertSet('datos.nacimiento', '1990-05-17')
            ->set('datos.nombres', 'usuario editado')->call('guardar')->assertHasNoErrors();
        $this->assertSame('USUARIO EDITADO', trim(DB::table('general.tgpersona as p')->join('seguridad.tsusuario as u', 'u.usupersona', '=', 'p.IdPersona')->where('u.idusuario', $u->idusuario)->value('p.PerNombres')));

        //REINICIAR CLAVE: VUELVE A SER EL DNI
        DB::table('seguridad.tsusuario')->where('idusuario', $u->idusuario)->update(['usuclave' => 'x']);
        Livewire::test(Usuarios::class)->call('reiniciarClave', (int) $u->idusuario);
        $this->assertSame(strtolower(trim($u->usuclave)), strtolower(trim(DB::table('seguridad.tsusuario')->where('idusuario', $u->idusuario)->value('usuclave'))));

        //PERFILES: UNO POR SISTEMA (ASIGNAR OTRO REEMPLAZA AL ANTERIOR)
        $modulo = (int) DB::table('seguridad.tsmodulo')->where('modestado', 1)->where('modsistema', app(Seguridad::class)->sistema())->value('idmodulo');
        [$p1, $p2] = DB::table('seguridad.tsperfil')->where('pefestado', 1)->where('pefmodulo', $modulo)->orderBy('idperfil')->limit(2)->pluck('idperfil')->map(fn ($i) => (int) $i)->all();
        $activos = fn () => DB::table('seguridad.tsusuarioperfil')->where('upsusuario', $u->idusuario)->where('upsestado', 1)->pluck('upsperfil')->map(fn ($i) => (int) $i)->all();
        Livewire::test(UsuarioPerfiles::class, ['usuario' => (int) $u->idusuario])->set('eleccion.'.$modulo, (string) $p1)->call('asignar', $modulo);
        $this->assertSame([$p1], $activos());
        $this->assertNotNull(app(Seguridad::class)->perfil((int) $u->idusuario));
        Livewire::test(UsuarioPerfiles::class, ['usuario' => (int) $u->idusuario])->assertSet('eleccion.'.$modulo, (string) $p1)->set('eleccion.'.$modulo, (string) $p2)->call('asignar', $modulo);
        $this->assertSame([$p2], $activos());
        Livewire::test(UsuarioPerfiles::class, ['usuario' => (int) $u->idusuario])->call('quitar', $modulo);
        $this->assertSame([], $activos());

        //ELIMINAR (NO EL PROPIO)
        Livewire::test(Usuarios::class)->call('eliminar', (int) $admin->id);
        $this->assertSame(1, (int) DB::table('seguridad.tsusuario')->where('idusuario', $admin->id)->value('usuestado'));
        Livewire::test(Usuarios::class)->call('eliminar', (int) $u->idusuario);
        $this->assertSame(0, (int) DB::table('seguridad.tsusuario')->where('idusuario', $u->idusuario)->value('usuestado'));
    }

    public function test_no_se_quita_su_propio_perfil_de_seguridad(): void
    {
        $admin = $this->admin();
        $this->actingAs($admin);
        $propio = app(Seguridad::class)->perfilSeguridad((int) $admin->id);
        Livewire::test(UsuarioPerfiles::class, ['usuario' => (int) $admin->id])->call('quitar', $propio['modulo']);
        $this->assertNotNull(app(Seguridad::class)->perfilSeguridad((int) $admin->id));
    }

    public function test_dni_en_reniec_trae_sus_datos(): void
    {
        $this->actingAs($this->admin());
        $dni = null;
        foreach (DB::connection('reniec')->table('dbo.DataReniec')->orderBy('Dni')->limit(200)->pluck('Dni') as $candidato) {
            if (! DB::table('general.tgpersona')->where('PerNroDocumento', trim($candidato))->exists()
                && ! DB::table('seguridad.tsusuario')->where('usunombre', trim($candidato))->exists()) {
                $dni = trim($candidato);
                break;
            }
        }
        if (! $dni) {
            $this->markTestSkipped('BDRENIEC no tiene un DNI que no este en las personas.');
        }
        $f = DB::connection('reniec')->table('dbo.DataReniec')->where('Dni', $dni)->first();
        Livewire::test(Usuarios::class)->call('nuevo')->set('datos.dni', trim($dni))->call('verificar')
            ->assertSet('origen', 'reniec')->assertSet('datos.paterno', trim($f->ApellidoPaterno));
    }

    public function test_ventanas_de_accesos_y_perfiles(): void
    {
        $admin = $this->admin();
        $perfil = app(Seguridad::class)->perfilSeguridad((int) $admin->id);
        $this->actingAs($admin)->get(route('seguridad.accesos', ['perfil' => $perfil['perfil']]))->assertOk()->assertSee('Accesos del perfil');
        $this->actingAs($admin)->get(route('seguridad.usuario-perfiles', ['usuario' => $admin->id]))->assertOk()->assertSee('Perfiles del usuario');
        $this->actingAs($admin)->get(route('seguridad.accesos', ['perfil' => 999999]))->assertNotFound();
    }
}

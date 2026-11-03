# GEPRO – Gestión de Proyectos (Oficina de Proyectos - PMO)

Sistema PHP (sin framework) de COGNOSYS, de la misma familia que CUBMIN (`C:\www\cubmin`). Destino: Municipalidad de Chancay (hasta 20 usuarios). Base de datos SQL Server `BDGEPRO` (y `BDRENIEC`).

## Origen

- Copia de `C:\xampp\htdocs\gepro` (PHP 7.4, sin git) tomada el 2026-11-02. El original queda intacto como referencia.
- **No se consideran** `essalud/` (base `BDGEPRO_ESSALUD`) ni `C:\xampp\htdocs\ge3p`.
- `SGPAM_archivos/` (409 MB, archivos subidos por usuarios) y `recursosAPP/ArchivosIntranet/` quedan fuera de git.
- `recursosAPP` traía un `.git` de PRONIED (`10.40.7.16`, rama `desarrollo`); se quitó en esta copia.
- Las claves de SQL Server, RENIEC, correo y WhatsApp se dejaron vacías en el primer commit. Se cargarán desde fuera del sitio, como en CUBMIN (`config/cargar_config.php`).

## Estructura

| Carpeta | Qué es |
|---|---|
| `gepro/` | Aplicación principal (MVC casero): 149 LN, 136 vistas |
| `intranet/` | Login y portal |
| `sisSeguridad/` | Seguridad y usuarios |
| `recursosAPP/` | Librerías compartidas (`lib/DAO.php`, `lib/SQLServer.php`, `lib/Flexigrid.php`...) |
| `dm_gepro/` | API JSON con Slim 2 (data mart) |
| `laravel/` | GEPRO en Laravel 13 + Livewire 4 (migración por módulos; ver abajo) |

El funcionamiento de las páginas (Antirefresh, mainpage, LN/Vista, `Accion` vs `ActionForm`) es igual que en CUBMIN; ver `C:\www\cubmin\CLAUDE.md`.

- Las constantes de `gepro/Data/*DATA.php` guardan el `EXEC` de cada SP. `SelGrd_*` es el nombre del método del DAO y de la constante; el SP es `SP_<TABLA>` con `@TipoAccion='SelGrd'`.

## Diagnóstico (2026-11-02)

**Código compartido:** `recursosAPP/lib` (122 de 124), `intranet` (82 de 87) y `sisSeguridad` (83 de 90) son idénticos a los de CUBMIN antes de su migración. Los cambios de CUBMIN (PR #1 y la rama `seguridad-wt03-wt10`) se pueden portar casi directo.

**PHP 8 en `gepro/`:** sin `mysql_*`, `each()`, `create_function` ni offsets con llaves. Pendiente: PHPExcel en 6 archivos (pasar a PhpSpreadsheet, como en CUBMIN), PHPMailer 5.2.11 en 10 (pasar a 6.x), `utf8_encode`/`money_format` en 4, `split` en 1.

**Base `BDGEPRO`** (~2,1 GB; archivo `PLANTILLA`): 260 tablas, 346 SP, 126 vistas, 18 funciones, sin triggers.
- 156 SP usan SQL dinámico (`EXEC(@sql)`/`sp_executesql`): revisar inyección y, más adelante, el paso a PostgreSQL.
- Los `Data` referencian 194 SP; 13 no existen en la base (varios son de `BDRENIEC`) y 161 SP de la base no se llaman desde `Data`.
- Esquemas: `dbo`, `general`, `osce` (1,4 millones de filas), `seguridad`, `siaf`, `generador`, `UE`, `vivienda`, `papeleta`, `convenio`, `intranet`.
- Trae datos de otros clientes (PRONIED, AMSAC): 504 usuarios y 17 tablas con DNI, correo, teléfono o dirección. Para Chancay hace falta una base limpia.
- Las claves de usuario usan `md5` (`intranet/.../ClaveLN.php`, `PrincipalLN.php`, `RecuperaclaveLN.php`).

**Menú (sistema 30, `/gepro`):** 60 páginas activas de 136 vistas. Cuatro opciones del menú no tienen vista (`GEN_INTERVENCION`, `GEN_INTERVENCION_COMP`, `GEN_MODO_EJECUCION`, `X`); las tres primeras ya están en Laravel como catálogos. Hay 4 vistas `migrar_*` (hacen `TRUNCATE`) que no están en el menú, igual que `RPT_INTERVENCIONES`; son las únicas que usan PHPExcel. Nunca abrirlas en pruebas automáticas.
- 12 vistas `PEX_*` descargan Excel desde `http://sgpam.amsac.pe/SGPAM_archivos/...` (dominio de AMSAC): cambiar para Chancay.

## Plan (cada etapa en su rama y PR)

1. Diagnóstico (este archivo).
2. PHP 8.5 sobre SQL Server, sitio en Apache85 en el puerto 8086, portando lo de CUBMIN.
3. Seguridad: credenciales fuera del sitio, cuenta propia de BD (no `sa`), CSRF, saneo de grillas, `open_basedir`. El login local se queda: `password_hash` en lugar de `md5`, recuperación con token de un solo uso y captcha validado en el servidor.
4. Base limpia para Chancay y paso a PostgreSQL (SP a PL/pgSQL), luego nube y Docker. **En pausa:** ahora se trabaja el paso a Laravel sobre SQL Server.

## Laravel (`laravel/`)

Decidido el 2026-11-02: pasar GEPRO a Laravel **por módulos**, con pantallas en **Blade + Livewire** sobre **SQL Server**. El paso a PostgreSQL queda en pausa (2026-11-03): no se prepara nada para PostgreSQL por ahora, y se pueden usar las funciones y vistas de SQL Server (por ejemplo `FN_PROYECTO`). Laravel convive con el sistema actual sobre la misma BDGEPRO hasta migrar el último módulo.

- **Credenciales:** `config/database.php` lee `C:\gepro_config\config.php` (variable `GEPRO_CONFIG` del `.env`), igual que el sistema actual. La instancia tiene nombre (`HOST\SQLSERVER2022`), por eso `DB_PORT` va vacío.
- **Usuarios:** `App\Auth\LegadoUserProvider` lee `seguridad.tsusuario` con la misma regla de clave del login actual: `md5(USUNOMBRE + clave + 'Cognosys@SAC')`, con `Reemplazar`/`addslashes`/`htmlspecialchars`; también se ingresa con `usuldap`. Las claves siguen en md5 mientras convivan los dos sistemas.
- **Perfil y menú:** `App\Services\Seguridad` consulta las mismas tablas que `paVerificaDatosUsuarioPerfil`, `paListaOpcionesMenu` y `paVerificaAccesoxOpcionPerfil`, pero con parámetros. El middleware `gepro` exige un perfil activo en GEPRO.
- **Convivencia:** las opciones del menú que no están en `config('gepro.paginas_migradas')` abren el sistema actual (`GEPRO_LEGADO_URL`). `App\Support\PuenteSesionLegado` abre o lee la sesión nativa del sistema actual (cookie `GEPROSESSID` en `C:\php85\tmp`), así que no se vuelve a pedir la clave. Al migrar una página, se agrega a `paginas_migradas`.
- **Módulos migrados:** Proyectos (`/proyectos?opcion=N`, las 11 opciones del menú con `Pagina=PROYECTO`) y sus Contratos (`/proyectos/{id}/contratos?opcion=N&tipo=0..5`, antes `PROYECTO_ACTIVIDAD`; se abre en la modal con la plantilla `layouts/embebido`). En `SP_PROYECTO_ACTIVIDAD`, `IMP_TRANSFERIDO` lleva el `IDE_CONTRATO` elegido: el SP crea o actualiza con él el enlace en `PROY_CONTRATO`. Patrón: un controlador valida el acceso con `Seguridad::opcionDePagina()` y marca `Op`/`Oc` en la sesión del sistema actual (`PuenteSesionLegado::marcarOpcion`). La grilla es un componente Livewire con consulta parametrizada y orden antes de paginar, que reemplaza a `SelGrd`; las columnas por opción salen de `*_BotonVer` en el `lni`, donde `'false'` significa visible. Las acciones abren las pantallas del sistema actual en la modal de Laravel (`data-modal-url`, `&vmSinCabecera=1`); al cerrarse avisan con `postMessage('gepro:cerrar')` (`recursosAPP/recursos/js/ventana-modal.js`).
- **Catálogos:** los mantenimientos (30: los 27 de Configuración Proyecto y Mantenimiento, incluidos los jerárquicos Tablas maestras, Entregables y Concepto de gestión social; UBIGEO con clave de texto; Invierte.pe solo editable en denominación y estado; y Fases y componentes, Modalidad de ejecución e Hitos, que no tenían vista) se declaran en `laravel/config/catalogos.php` y usan una sola grilla y un solo formulario (`CatalogoTabla`, `CatalogoFormulario`, ruta `/catalogos/{Pagina}`). Graban con su `SP_<TABLA>`, respetan Nuevo/Editar/Eliminar y los campos de solo lectura del sistema actual. Para sumar otro catálogo basta con declararlo ahí; la prueba `CatalogosTest` compara su total con el `Count` del SP. `SP_GEN_BANCO` 'Count' tiene un error (filtra `IDE_BANCO <> '2'`). `SP_GEN_UBIGEO` 'Update' calcula `COD_UBIGEO_SUP` quitando dos dígitos: editar una región (o el código `00`) falla por la clave foránea, también en el sistema actual. Si un SP falla, su `CATCH` hace `ROLLBACK` y deshace también la transacción de la prueba.
- **Pantallas que dependen de otro registro** (también en `config/catalogos.php`, con `'de'`): Contrato → Etapas (`PROY_COMPONENTE`, eliminado = 9) → Control anual (`PROY_CONT_ETAPA_CONTROL`) → Control mensual (`PROY_CONT_COMP_CONTROL_DET`), y Etapas → Recursos. Ruta `/catalogos/{Pagina}?de=<id>` con la plantilla embebida (se abren en la modal); acceso validado con `'acceso' => 'PROYECTO'`. Los SP hacen el trabajo de fondo (el del mensual suma en el anual). El cálculo del mensual está en `App\Calculos\ControlMensual` (misma fórmula que `calcularPrioridad()`); los meses importados desde Excel traen importes ajustados.
- **Pantallas del contrato y del proyecto** (con `'de'`): Detalle del contrato (`CONTRATO`, enlazado por `PROY_CONTRATO` con `'enlace'`; no se registra aquí), Riesgos (`PROY_RIESGO_PROBLEMA`), Interesados (`CONT_INTERESADOS`) y Documentos (`CONT_DOCUMENTACION`) del `PROYECTO_ACTIVIDAD`, y Lecciones aprendidas (`PROY_LECCION_APRENDIDA`) del `PROYECTO`. En Interesados y Documentos, `IDE_CONTRATO` guarda el `IDE_PROYECTO_ACTIVIDAD`. La prioridad del riesgo la calcula `App\Calculos\PrioridadRiesgo` (regla actual de `calcularPrioridad()`; los riesgos de 2019 se grabaron con la regla anterior). Siguen en el sistema actual: Carta fianza (`CONTRATO_CONCEPTO`), Gastos (`BIDM_GASTO_CONSOLIDA`), Archivo (`GEN_ARCHIVO`) y Recursos del riesgo (`PROY_RIESGO_RECURSO`).
- **Actos preparatorios** (`PROCESO`, con `'de'`: Ítems `PROC_ITEM` y Cronograma `PROC_CRONOGRAMA`): la clave es el código de la convocatoria del SEACE, que escribe el usuario (`'codigo'` en la definición: el `Insert` la recibe en `@pCodigo`; al editar no se cambia). Al registrar un ítem, `SP_PROC_ITEM` crea su proyecto con `SP_PROYECTO_ACTIVIDAD`. Los postores del ítem siguen en el sistema actual (`PROC_POSTORES`). `SP_PROC_ITEM` y `SP_PROC_CRONOGRAMA` 'Count' no filtran los eliminados.
- **Tableros de Power BI:** las opciones `PBI_*` del menú abren `/tableros/{Pagina}`, con el reporte en un marco. Las URL están en `laravel/config/tableros.php` (las mismas que publicaba AMSAC; cada cliente pone las suyas en `GEPRO_PBI_<PAGINA>` del `.env`).
- **Perfil "CONSULTA TOTAL":** no registra, edita ni elimina en ningún módulo (`Seguridad::puedeGrabar()`), como `UsuarioEvento` del sistema actual.
- **Sin tablas propias en BDGEPRO:** sesiones y caché en archivos; no hay migraciones. **No ejecutar `php artisan migrate` contra BDGEPRO.**
- **Ejecutar en desarrollo:** el `php.ini` global tiene el `open_basedir` de CUBMIN, así que se pasa `-d open_basedir=`. Servidor: desde `laravel/public`, `C:\php85\php.exe -d open_basedir= -S localhost:8087 ..\vendor\laravel\framework\src\Illuminate\Foundation\resources\server.php`. Pruebas: `C:\php85\php.exe -d open_basedir= vendor\phpunit\phpunit\phpunit` (solo leen BDGEPRO; el puente se apaga con `GEPRO_PUENTE=false`).
- **Composer:** `C:\php85\php.exe -d open_basedir= C:\ProgramData\ComposerSetup\bin\composer.phar ...` (con `--no-scripts` y luego `artisan package:discover`).

## Cuidado

- El código es en español; mantener comentarios en español y el estilo existente.

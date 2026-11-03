/*****************************************************
Ventanas modales con grilla (paginas que se abren con colorbox: archivos adjuntos,
detalle semanal...). Estilos en recursosAPP/recursos/css/ventana-modal.css

VentanaColumnasAdaptables('#flex1', pesos, fijos, maximo): ajusta las columnas visibles de la
grilla al ancho de la ventana. Las columnas de "fijos" (botones) tienen ancho fijo en px
y las de "pesos" se reparten el resto en proporcion. Se recalcula al cargar los datos
(llamar desde onSuccess), al volver a la pestaña y al cambiar el tamaño de la ventana.
Las columnas sin abbr (botones) se identifican por su posicion en colModel.
"maximo" (opcional, px): tope de las columnas proporcionales en ventanas muy anchas; el
espacio que sobra queda libre a la derecha en vez de estirar las columnas.
*****************************************************/

function VentanaAjustarColumnas(selector, pesos, fijos, maximo)
{
    var tabla = $(selector)[0];
    if (!tabla || !tabla.p) return;
    var g = $(tabla).closest('.flexigrid');
    if (!g.length || !g.is(':visible')) return;

    var modelo = tabla.p.colModel;
    var nombre = function (th) { var c = modelo[th.index()]; return c ? c.name : ''; };
    var ths = g.find('.hDiv th').filter(function () {
        var n = nombre($(this));
        return $(this).css('display') !== 'none' && (fijos[n] || pesos[n]);
    });

    var total = 0, ocupado = 0;
    ths.each(function () {
        var n = nombre($(this));
        if (fijos[n]) ocupado += fijos[n]; else total += pesos[n];
    });
    var disponible = g.find('.bDiv').width() - 20; //20: BARRA DE DESPLAZAMIENTO
    //VENTANA ANGOSTA: LOS ANCHOS FIJOS SE REDUCEN (HASTA LA MITAD) PARA DEJAR AL RESTO
    //AL MENOS EL 40% DEL ANCHO (MINIMO 150px)
    var minimoResto = Math.max(150, Math.floor(disponible * 0.4));
    var factor = 1;
    if (ocupado && disponible - ocupado < minimoResto) factor = Math.max(0.5, (disponible - minimoResto) / ocupado);
    var ancho = disponible - ocupado * factor;
    if (!total || ancho < 100) return;

    ths.each(function () {
        var th = $(this), div = th.children('div'), n = nombre(th);
        var exterior = fijos[n] ? Math.floor(fijos[n] * factor) : Math.floor(ancho * pesos[n] / total);
        if (maximo && !fijos[n]) exterior = Math.min(exterior, maximo);
        var interior = Math.max(40, exterior - (th.outerWidth() - div.width()));
        var idx = th.index();
        div.width(interior);
        g.find('.bDiv tr').each(function () { $(this).children('td').eq(idx).children('div').width(interior); });
    });
    if (tabla.grid && tabla.grid.rePosDrag) tabla.grid.rePosDrag();
}

/*
 * TECLA ESC EN LAS VENTANAS CON CABECERA (.vm-cabecera). La pagina corre dentro de un iframe, asi
 * que el escKey de colorbox (que escucha en la pagina de atras) no la recibe.
 * - En la pestaña del listado: cierra la ventana (boton × de la cabecera).
 * - En la pestaña de edicion: vuelve al listado si la pagina define window.VentanaCancelar
 *   (su funcion de Cancelar), pidiendo confirmacion si se modifico algun campo; si no la define,
 *   no hace nada.
 * - Si dentro de la pagina hay otra ventana colorbox abierta, la cierra colorbox y aqui no se hace nada.
 */
$(document).on('keydown', function (e) {
    if (e.key !== 'Escape' && e.keyCode !== 27) return;
    var cerrar = $('.vm-cabecera .vm-cerrar').first();
    if (!cerrar.length || $('#colorbox').is(':visible')) return;

    var activa = 0;
    try { activa = $('#tabs').tabs('option', 'active') || 0; } catch (err) { }
    if (activa > 0) {
        if (typeof window.VentanaCancelar === 'function') {
            e.preventDefault();
            var modificado = false;
            $('#formulario').find('input[type=text], textarea').each(function () {
                if (this.value !== this.defaultValue) modificado = true;
            });
            if (!modificado || confirm('¿Descartar los cambios no guardados?')) window.VentanaCancelar();
        }
        return;
    }
    e.preventDefault();
    cerrar.trigger('click');
});

/*
 * BOTONES "CARGAR", "IMPORTAR" Y "VER DETALLE" DE LAS GRILLAS: LOS SP LOS ENVIAN COMO <input type=button>
 * CON UN ICONO DE FONDO: id=album_16 (CARGAR ARCHIVO), id=upload16 (IMPORTAR) E id=componente_24 (DETALLE,
 * P. EJ. DETALLE SEMANAL). SE CAMBIAN POR BOTONES CON ICONO Y TEXTO QUE EJECUTAN LA MISMA ACCION (SE COPIA
 * SU onclick). ESTILOS: .gr-accion EN css/pagina.css.
 * LLAMAR DESDE EL onSuccess DE LA GRILLA: GrillaEstilizarAcciones('#flex1')
 */
function GrillaEstilizarAcciones(selector)
{
    var acciones = {
        album_16: { clase: 'gr-cargar', icono: 'icon-paper-clip', texto: 'Cargar' },
        upload16: { clase: 'gr-importar', icono: 'icon-cloud-upload', texto: 'Importar' },
        componente_24: { clase: 'gr-detalle', icono: 'icon-calendar', texto: 'Ver detalle' }
    };
    $(selector).find('input[type=button]').each(function () {
        //"VER ARCHIVO" DE LOS ARCHIVOS ADJUNTOS (GEN_ARCHIVO) USA EL MISMO id=album_16: SE DISTINGUE POR SU onclick
        var a = /abrirArchivo\(/.test($(this).attr('onclick') || '')
            ? { clase: 'gr-descargar', icono: 'icon-download-alt', texto: 'Descargar' }
            : acciones[this.id];
        if (!a) return;
        var boton = $('<button type="button" class="gr-accion">').addClass(a.clase)
            .attr('title', $(this).attr('title'))
            .attr('onclick', $(this).attr('onclick'))
            .html('<i class="' + a.icono + '"></i> ' + a.texto);
        $(this).replaceWith(boton);
    });
    //"REPORTE X DIA" (cubdia.SP_PLAN_MENSUAL_RPT): <span class=btn_reporte_dia onclick=abrirPlanMesDiaRpt(...)>
    $(selector).find('span.btn_reporte_dia').each(function () {
        var boton = $('<button type="button" class="gr-accion gr-detalle">')
            .attr('title', 'Ver el reporte por día')
            .attr('onclick', $(this).attr('onclick'))
            .html('<i class="icon-calendar"></i> Ver días');
        $(this).replaceWith(boton);
    });
}

/*
 * VERSION DEL BUDGET EN LAS GRILLAS: "BUDGET ANUAL" (AZUL) O "FORECAST" (AMBAR). LA CELDA DE LA COLUMNA
 * "columna" SE MUESTRA COMO ETIQUETA DE COLOR Y LA CELDA DE "columnaFranja" LLEVA UNA FRANJA DEL MISMO COLOR.
 * ESTILOS: .gr-version Y .gr-fila-* EN css/pagina.css. EJEMPLO: GrillaMarcarVersion('#flex1', 'UNIDAD', 'TIPOPLAN')
 */
function GrillaMarcarVersion(selector, columna, columnaFranja)
{
    $(selector).find('tr').each(function () {
        var div = $(this).children('td[abbr="' + columna + '"]').children('div');
        var version = $.trim(div.text());
        if (version === '' || div.find('.gr-version').length) return;
        var texto = version.toUpperCase();
        var tipo = texto.indexOf('FORECAST') >= 0 ? 'forecast' : (texto.indexOf('BUDGET') >= 0 ? 'budget' : 'otra');
        div.html($('<span class="gr-version">').addClass('gr-' + tipo).text(version));
        $(this).addClass('gr-fila-' + tipo).children('td[abbr="' + columnaFranja + '"]').addClass('gr-franja');
    });
}

/*
 * TIPO DE PLAN EN LAS GRILLAS: SI EL TEXTO DE LA COLUMNA "columna" HABLA DE PRODUCCION O DE AVANCES
 * ("PROGRAMA MENSUAL DE PRODUCCION", "BUDGET DE AVANCES"...) SE ANTEPONE UNA ETIQUETA CON ICONO.
 * OTROS PLANES (OPEX, EQUIPOS...) QUEDAN IGUAL. ESTILOS: .gr-tipoplan EN css/pagina.css.
 */
function GrillaMarcarTipoPlan(selector, columna)
{
    $(selector).find('tr').each(function () {
        var div = $(this).children('td[abbr="' + columna + '"]').children('div');
        if (div.find('.gr-tipoplan').length) return;
        var texto = $.trim(div.text()).toUpperCase();
        var tipo = /PRODUCCI[OÓ]N/.test(texto) ? 'produccion' : (/AVANCE/.test(texto) ? 'avances' : '');
        if (tipo === '') return;
        div.prepend($('<span class="gr-tipoplan">').addClass('gr-' + tipo)
            .html(tipo === 'produccion' ? '<i class="icon-cogs"></i> Producción' : '<i class="icon-arrow-right"></i> Avances'), ' ');
    });
}

/*
 * FILTRO CON BOTONES EN LA BARRA DE LA GRILLA (P. EJ. UNIDAD: TODAS / KOLPA / CHONTA).
 * ENVIA EL VALOR ELEGIDO COMO PARAMETRO POST "parametro" EN CADA CARGA DE LA GRILLA; EL LN DEBE
 * VALIDARLO (LISTA DE VALORES PERMITIDOS) Y AGREGARLO AL FILTRO. opciones: [{valor: '', texto: 'Todas'}, ...]
 * LLAMAR UNA VEZ, DESPUES DE CREAR LA GRILLA. ESTILOS: .gr-filtro EN css/pagina.css.
 */
function GrillaFiltroBotones(selector, parametro, titulo, opciones)
{
    //FLEXIGRID ARMA LA GRILLA EN document.ready: SE ESPERA A ESE MOMENTO (SU HANDLER SE REGISTRO ANTES)
    $(function () { GrillaFiltroBotonesCrear(selector, parametro, titulo, opciones); });
}

function GrillaFiltroBotonesCrear(selector, parametro, titulo, opciones)
{
    var tabla = $(selector)[0];
    var barra = $(selector).closest('.flexigrid').find('div.tDiv2');
    if (!tabla || !tabla.p || !barra.length || barra.find('.gr-filtro[data-parametro="' + parametro + '"]').length) return;

    //LA CLASE fbutton HACE QUE LA BARRA SE TRATE COMO BARRA CON BOTONES (pagina.css)
    var caja = $('<div class="fbutton gr-filtro">').attr('data-parametro', parametro)
        .append($('<span class="gr-filtro-titulo">').text(titulo));
    $.each(opciones, function (i, o) {
        $('<button type="button">').text(o.texto).attr('data-valor', o.valor)
            .toggleClass('gr-activo', i === 0).appendTo(caja);
    });
    caja.on('click', 'button', function () {
        var valor = $(this).attr('data-valor');
        caja.find('button').removeClass('gr-activo');
        $(this).addClass('gr-activo');
        //SE CONSERVAN LOS DEMAS PARAMETROS Y SE REEMPLAZA SOLO ESTE
        var params = $.grep(tabla.p.params || [], function (x) { return x.name !== parametro; });
        params.push({ name: parametro, value: valor });
        $(selector).flexOptions({ params: params, newp: 1 }).flexReload();
    });
    barra.append(caja);
}

function VentanaColumnasAdaptables(selector, pesos, fijos, maximo)
{
    var ajustar = function () { VentanaAjustarColumnas(selector, pesos, fijos, maximo); };
    var timer;
    $(window).on('resize', function () { clearTimeout(timer); timer = setTimeout(ajustar, 150); });
    $(function () { $('#tabs').on('tabsactivate', ajustar); });
    return ajustar;
}

/*
 * CABECERA AUTOMATICA DE LAS VENTANAS EMERGENTES (GEPRO). Vista.php marca con class="vm-emergente"
 * el <body> de las paginas que se abren con colorbox (AccionLocal=2, Accion=muestraVista).
 * - Titulo: la primera pestaña, sin "Listado de" ("Listado de Seguimiento del Proyecto" -> "Seguimiento del Proyecto").
 * - Subtitulo: el titulo de la grilla (datos del registro padre); la barra de titulo de la grilla se oculta.
 * - Boton ×: cerrarPopup() de la pagina o, si no la tiene, cierra el colorbox de la ventana de atras.
 * - Esc: lo atiende el manejador de arriba (en la pestaña de edicion vuelve al listado con Cancelar()).
 * No se agrega si la pagina ya trae su propia .vm-cabecera (GEN_ARCHIVO) o si no esta dentro de un iframe.
 */
function VentanaIconoTitulo(titulo)
{
    var t = titulo.toLowerCase();
    var lstIconos = [
        [/archivo|documento/, 'icon-paper-clip'],
        [/ubigeo|ubicaci/, 'icon-map-marker'],
        [/interesado|comunidad|social|beneficio|queja/, 'icon-group'],
        [/riesgo|problema|correctiva/, 'icon-warning-sign'],
        [/seguimiento|indicador|control/, 'icon-eye-open'],
        [/contrato|concepto|ampliaci/, 'icon-file-text'],
        [/costo|gasto|presupuesto|financ/, 'icon-money'],
        [/recurso|proveedor|postor/, 'icon-briefcase'],
        [/cronograma|actividad|plan/, 'icon-calendar'],
        [/gr[aá]fico/, 'icon-bar-chart']
    ];
    for (var i = 0; i < lstIconos.length; i++) {
        if (lstIconos[i][0].test(t)) return lstIconos[i][1];
    }
    return 'icon-list-alt';
}

function VentanaCerrar()
{
    if (typeof window.cerrarPopup === 'function') { window.cerrarPopup(); return; }
    try { parent.$.colorbox.close(); } catch (e) { VentanaAvisarCierre(); }
}

//ABIERTA DESDE GEPRO EN LARAVEL (OTRA PAGINA, SIN colorbox Y EN DESARROLLO OTRO PUERTO): parent.$ NO
//EXISTE O NO SE PUEDE LEER. SE AVISA CON postMessage Y LARAVEL CIERRA SU VENTANA MODAL
function VentanaAvisarCierre()
{
    try { parent.postMessage('gepro:cerrar', '*'); } catch (e) { }
}

//cerrarPopup() DE CADA PAGINA (parent.$.colorbox.close()) TAMBIEN SE USA EN LOS BOTONES "Salir":
//SI FALLA, SE AVISA A LARAVEL
function VentanaEnvolverCerrarPopup()
{
    var original = window.cerrarPopup;
    window.cerrarPopup = function () {
        try {
            if (typeof original === 'function') original(); else parent.$.colorbox.close();
        } catch (e) {
            VentanaAvisarCierre();
        }
    };
}

function VentanaCabeceraAutomatica()
{
    var body = $('body');
    if (!body.hasClass('vm-emergente') || window.parent === window) return;
    VentanaEnvolverCerrarPopup();
    if ($('.vm-cabecera').length) return;

    var titulo = $.trim($('#tabs > ul > li:first a').text()).replace(/\s+/g, ' ');
    titulo = titulo.replace(/^listado\s+(de\s+las|de\s+los|de\s+la|del|de)\s+/i, '');
    if (titulo === '') titulo = $.trim($('legend:first').text());
    if (titulo === '') titulo = document.title;
    titulo = titulo.charAt(0).toUpperCase() + titulo.slice(1);

    var cabecera = $('<div class="vm-cabecera">')
        .append($('<span class="vm-icono">').append($('<i>').addClass(VentanaIconoTitulo(titulo))))
        .append($('<div class="vm-titulos">').append($('<h3>').text(titulo)).append('<small></small>'))
        .append($('<button type="button" class="vm-cerrar" title="Cerrar (Esc)">&times;</button>').on('click', VentanaCerrar));
    body.prepend(cabecera);
    //ABIERTA DESDE LARAVEL (&vmSinCabecera=1): LARAVEL YA MUESTRA SU CABECERA; ESTA QUEDA OCULTA PERO
    //SIGUE ATENDIENDO LA TECLA ESC
    if (/[?&]vmSinCabecera=1(&|$)/.test(location.search)) body.addClass('vm-sin-cabecera');
    $('#tabs').first().closest('.row-fluid').addClass('vm-ventana');

    //ESC EN LA PESTAÑA DE EDICION: VUELVE AL LISTADO CON EL Cancelar() DE LA PAGINA
    if (typeof window.VentanaCancelar !== 'function' && typeof window.Cancelar === 'function') {
        window.VentanaCancelar = function () { window.Cancelar(); };
    }
    VentanaSubtituloGrilla();
}

//LA GRILLA SE ARMA EN document.ready DE CADA PAGINA: SE REINTENTA HASTA QUE EXISTA SU TITULO
function VentanaSubtituloGrilla(intento)
{
    intento = intento || 0;
    var titulo = $('.flexigrid:first .mDiv .ftitle');
    var texto = $.trim(titulo.text()).replace(/\s+/g, ' ');
    if (texto !== '') {
        $('.vm-cabecera .vm-titulos small').text(texto).attr('title', texto);
        titulo.closest('.mDiv').hide();
        return;
    }
    if (intento < 10) setTimeout(function () { VentanaSubtituloGrilla(intento + 1); }, 200);
}

$(function () { setTimeout(VentanaCabeceraAutomatica, 0); });

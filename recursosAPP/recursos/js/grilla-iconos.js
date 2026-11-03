/*****************************************************
Iconos de las grillas (GEPRO). Estilos .gr-ico en recursosAPP/recursos/css/pagina.css

Los SP arman los botones de cada fila como <button>/<input type=button> con un id que
botones.css convierte en una imagen (editar16, eliminar16, ficha23, compartir28...).
Aqui se cambian por botones con un icono de Font Awesome y un color por tipo de accion,
conservando el onclick y el title. Se aplica a todas las grillas, cada vez que cargan filas.

Colores: gr-azul (ver/abrir), gr-verde (agregar/asignar/montos), gr-ambar (editar/observar),
gr-rojo (eliminar/riesgo), gr-violeta (personas/social), gr-teal (archivos/documentos).
Para agregar un boton nuevo de un SP basta con sumar su id a GrillaIconos.
*****************************************************/

var GrillaIconos = {
    editar16:      ['icon-pencil', 'gr-ambar'],
    detalle16:     ['icon-edit', 'gr-ambar'],
    eliminar16:    ['icon-trash', 'gr-rojo'],
    view16:        ['icon-eye-open', 'gr-azul'],
    check16:       ['icon-ok', 'gr-verde'],
    check_21:      ['icon-check', 'gr-verde'],
    add16:         ['icon-plus', 'gr-verde'],
    supervisor_21: ['icon-user', 'gr-verde'],
    album_16:      ['icon-paper-clip', 'gr-teal'],
    document16:    ['icon-folder-open', 'gr-teal'],
    pdf22:         ['icon-file-text', 'gr-teal'],
    images24:      ['icon-picture', 'gr-teal'],
    upload16:      ['icon-upload-alt', 'gr-verde'],
    trabajador32:  ['icon-user', 'gr-violeta'],
    personas32:    ['icon-group', 'gr-violeta'],
    compartir28:   ['icon-group', 'gr-violeta'],
    Like28:        ['icon-thumbs-up', 'gr-verde'],
    LikeNo28:      ['icon-thumbs-down', 'gr-rojo'],
    ficha23:       ['icon-file-text', 'gr-azul'],
    ficha24:       ['icon-list-alt', 'gr-azul'],
    proyecto_21:   ['icon-folder-open', 'gr-azul'],
    componente_24: ['icon-th-large', 'gr-azul'],
    alcance_24:    ['icon-calendar', 'gr-azul'],
    fecha_24:      ['icon-calendar', 'gr-azul'],
    indicador_24:  ['icon-bar-chart', 'gr-azul'],
    indicador_25:  ['icon-dashboard', 'gr-azul'],
    seguimiento38: ['icon-tasks', 'gr-azul'],
    recurso24:     ['icon-briefcase', 'gr-azul'],
    RCC_21:        ['icon-sitemap', 'gr-azul'],
    osce28:        ['icon-external-link', 'gr-azul'],
    carrito28:     ['icon-shopping-cart', 'gr-azul'],
    comunicacion1: ['icon-comments', 'gr-azul'],
    ubigeo_24:     ['icon-map-marker', 'gr-azul'],
    soles_21:      ['icon-money', 'gr-verde'],
    money16:       ['icon-money', 'gr-verde'],
    inviertePE:    ['icon-money', 'gr-verde'],
    evaluacion:    ['icon-thumbs-up', 'gr-verde'],
    clasif16:      ['icon-lightbulb', 'gr-ambar'],
    ojo21:         ['icon-exclamation-sign', 'gr-ambar'],
    riesgoazul_24: ['icon-time', 'gr-ambar'],
    semaforo40:    ['icon-warning-sign', 'gr-rojo']
};

//BOTONES CON LETRA (CONTRATOS DEL PROYECTO: E, O, S, P, ...): ICONO SEGUN LA LETRA
var GrillaIconosLetra = {
    'E':   ['icon-book', 'gr-azul'],
    'O':   ['icon-building', 'gr-ambar'],
    'S':   ['icon-eye-open', 'gr-teal'],
    'P':   ['icon-leaf', 'gr-verde'],
    '...': ['icon-ellipsis-horizontal', 'gr-gris']
};

function GrillaIconoDe(boton)
{
    var id = boton.id;
    var texto = $.trim(boton.tagName === 'INPUT' ? '' : $(boton).text());
    var onclick = boton.getAttribute('onclick') || '';
    var titulo = boton.getAttribute('title') || '';
    if (texto !== '' && GrillaIconosLetra[texto]) return GrillaIconosLetra[texto];
    //"VER ARCHIVO" DE LOS ADJUNTOS USA album_16: ES UNA DESCARGA
    if (/abrirArchivo\(/.test(onclick)) return ['icon-download-alt', 'gr-teal'];
    if (id === 'proyecto_21' && /ubigeo/i.test(titulo)) return ['icon-map-marker', 'gr-azul'];
    return GrillaIconos[id] || null;
}

function GrillaIconosAplicar(raiz)
{
    $(raiz).find('button[id], input[type=button][id]').each(function () {
        var icono = GrillaIconoDe(this);
        if (!icono) return;
        var nuevo = $('<button type="button" class="gr-ico">').addClass(icono[1])
            .attr('title', this.getAttribute('title') || '')
            .attr('onclick', this.getAttribute('onclick'))
            .append($('<i>').addClass(icono[0]));
        if (this.disabled) nuevo.prop('disabled', true);
        $(this).replaceWith(nuevo);
    });
}

//CADA VEZ QUE UNA GRILLA CARGA FILAS (FLEXIGRID REEMPLAZA EL tbody DE .bDiv)
$(function () {
    GrillaIconosAplicar($('.flexigrid .bDiv'));
    if (!window.MutationObserver) return;
    new MutationObserver(function (cambios) {
        for (var i = 0; i < cambios.length; i++) {
            var destino = cambios[i].target;
            if (destino.nodeType === 1 && $(destino).closest('.flexigrid .bDiv').length) {
                GrillaIconosAplicar(destino);
            }
        }
    }).observe(document.body, { childList: true, subtree: true });
});

/*****************************************************
Formularios por secciones (GEPRO). Estilos en recursosAPP/recursos/css/formulario.css

Los formularios de mantenimiento (form.fm-form, pestaña "Detalle") llegan por AJAX con los
campos uno debajo de otro, separados por <legend></legend> y con tablas que solo sirven de
titulo ("I. DATOS DEL INTERESADO..."). FormularioSecciones() los ordena en tarjetas:
- Cada tabla con campos pasa a ser una seccion con el titulo de su <strong> (y el resto del
  texto de esa celda como ayuda).
- Los campos sueltos se agrupan en secciones; un <legend> vacio empieza una nueva.
- Cada campo ocupa una columna; los textos largos dos (fm-ancho) o todo el ancho (fm-completo).
Los campos se mueven con sus eventos (no se copian): ids, validaciones, calendarios y combos
siguen funcionando. Los formularios que ya traen .fm-seccion (PROYECTO) no se tocan.
Se aplica solo al cargar la pagina y cada vez que se inserta un formulario (MutationObserver).
*****************************************************/

function FormularioIconoSeccion(titulo)
{
    if (typeof VentanaIconoTitulo === 'function') return VentanaIconoTitulo(titulo);
    return 'icon-list-alt';
}

//ANCHO DEL CAMPO SEGUN SU CONTENIDO
function FormularioAnchoCampo(grupo)
{
    var $g = $(grupo);
    if ($g.is('.fm-ancho, .fm-completo')) return;
    if ($g.find('table').length) { $g.addClass('fm-completo'); return; }
    var area = $g.find('textarea').first();
    if (area.length) {
        var filas = parseInt(area.attr('rows'), 10) || 2;
        var largo = parseInt(area.attr('maxlength'), 10) || 0;
        $g.addClass(filas >= 4 || largo >= 2000 ? 'fm-completo' : 'fm-ancho');
        return;
    }
    //VARIOS CONTROLES VISIBLES EN EL MISMO CAMPO (P. EJ. DOS COMBOS O CAMPO + BOTONES)
    if ($g.find('select, input[type=text], input:not([type])').length > 1) $g.addClass('fm-ancho');
}

function FormularioNuevaSeccion(titulo, ayuda)
{
    var seccion = $('<div class="fm-seccion fm-auto">');
    if (titulo) {
        var cab = $('<div class="fm-seccion-titulo">')
            .append($('<i>').addClass(FormularioIconoSeccion(titulo)), ' ', document.createTextNode(titulo));
        if (ayuda) cab.append($('<small>').text(ayuda));
        seccion.append(cab);
    }
    seccion.append('<div class="fm-campos">');
    return seccion;
}

//TITULO DE UNA TABLA DE MAQUETACION: EL PRIMER <strong> (O LA PRIMERA CELDA) Y EL RESTO COMO AYUDA
function FormularioTituloTabla(tabla)
{
    var fuerte = $(tabla).find('strong').filter(function () { return !$(this).closest('.control-group').length; }).first();
    if (!fuerte.length) return null;
    var celda = fuerte.closest('td');
    var titulo = $.trim(fuerte.text()).replace(/\s+/g, ' ');
    var ayuda = $.trim(celda.text()).replace(/\s+/g, ' ').replace(titulo, '');
    ayuda = $.trim(ayuda).replace(/^\(\s*|\s*\)$/g, '');
    //"I. DATOS DEL INTERESADO" -> "I. Datos del interesado"
    titulo = titulo.toLowerCase().replace(/^([ivx]+\.)/i, function (m) { return m.toUpperCase(); })
        .replace(/(^|\.\s+)([a-záéíóúñ])/g, function (m, a, b) { return a + b.toUpperCase(); });
    return { titulo: titulo, ayuda: ayuda, fila: fuerte.closest('tr') };
}

function FormularioSecciones(form)
{
    var $f = $(form);
    if ($f.data('fmSecciones') || $f.find('.fm-seccion').length) return;
    $f.data('fmSecciones', true);

    var primerLegend = $f.children('legend').first();
    var actual = null;
    var cerrar = function () { actual = null; };
    var asegurar = function () {
        if (!actual) { actual = FormularioNuevaSeccion('', ''); }
        return actual;
    };

    $f.children().each(function () {
        var el = this, $el = $(el);

        if ($el.is('legend')) {
            if (el === primerLegend[0]) return;
            var texto = $.trim($el.text());
            cerrar();
            if (texto !== '' && !$el.is('[style*="display:none"], [style*="display: none"]')) {
                actual = FormularioNuevaSeccion(texto, '');
                $el.replaceWith(actual);
            } else {
                $el.addClass('fm-separador');
            }
            return;
        }

        //TITULO SUELTO (<h4>/<h5>) O LINEA (<hr>): EMPIEZA OTRA SECCION
        if ($el.is('h3, h4, h5, h6') && !$el.find('input, select, textarea').length) {
            cerrar();
            var sub = $.trim($el.text()).replace(/\s+/g, ' ').replace(/:$/, '');
            if (sub !== '') {
                actual = FormularioNuevaSeccion(sub, '');
                $el.replaceWith(actual);
            }
            return;
        }
        if ($el.is('hr')) {
            cerrar();
            $el.addClass('fm-separador');
            return;
        }

        if ($el.is('.control-group')) {
            var sec = asegurar();
            if (!sec.parent().length) $el.before(sec);
            FormularioAnchoCampo(el);
            sec.children('.fm-campos').append(el);
            return;
        }

        if ($el.is('table') && $el.find('.control-group').length) {
            cerrar();
            var t = FormularioTituloTabla(el) || { titulo: '', ayuda: '', fila: $() };
            var sec2 = FormularioNuevaSeccion(t.titulo, t.ayuda);
            if ($el.is('[style*="display:none"], [style*="display: none"]')) sec2.css('display', 'none');
            $el.before(sec2);
            var campos = sec2.children('.fm-campos');
            $el.find('.control-group').filter(function () {
                return !$(this).parent().closest('.control-group').length;
            }).each(function () {
                FormularioAnchoCampo(this);
                campos.append(this);
            });
            t.fila.remove();
            //SI LA TABLA TENIA OTRO CONTENIDO (NOTAS, BOTONES), SE CONSERVA DENTRO DE LA SECCION
            var resto = $el.find('input, select, textarea, button, img, a').length || $.trim($el.text()) !== '';
            if (resto) {
                campos.append($('<div class="fm-completo fm-extra">').append($el));
            } else {
                $el.remove();
            }
            return;
        }

        if ($el.is('.form-actions, script, input[type=hidden], br')) return;
        //CUALQUIER OTRO BLOQUE (TABLA DE TITULO, SECCION QUE SE MUESTRA U OCULTA) CORTA LA SECCION ACTUAL
        if ($el.is('div') && $el.children('.control-group').length) {
            $el.addClass('fm-bloque');
            $el.children('.control-group').each(function () { FormularioAnchoCampo(this); });
        }
        cerrar();
    });

    //CON VARIAS SECCIONES, LA PRIMERA SIN TITULO SE LLAMA "DATOS GENERALES"
    var secciones = $f.children('.fm-seccion');
    var primera = secciones.first();
    if (secciones.length > 1 && !primera.children('.fm-seccion-titulo').length) {
        primera.prepend($('<div class="fm-seccion-titulo">').append('<i class="icon-folder-open"></i> Datos generales'));
    }
}

function FormularioSeccionesEn(raiz)
{
    $(raiz).find('form.fm-form').addBack('form.fm-form').each(function () { FormularioSecciones(this); });
}

$(function () {
    FormularioSeccionesEn(document);
    if (!window.MutationObserver) return;
    new MutationObserver(function (cambios) {
        for (var i = 0; i < cambios.length; i++) {
            for (var j = 0; j < cambios[i].addedNodes.length; j++) {
                var n = cambios[i].addedNodes[j];
                if (n.nodeType === 1 && (n.matches('form.fm-form') || n.querySelector('form.fm-form'))) FormularioSeccionesEn(n);
            }
        }
    }).observe(document.body, { childList: true, subtree: true });
});

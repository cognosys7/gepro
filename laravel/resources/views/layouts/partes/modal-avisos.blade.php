{{-- Ventana modal (iframe) y avisos flotantes: los usan layouts/app y layouts/embebido --}}
{{-- VENTANA MODAL PARA LAS PANTALLAS DEL SISTEMA ACTUAL (botones con data-modal-url) --}}
<dialog class="gp-modal" id="gp-modal" aria-labelledby="gp-modal-titulo">
    <div class="gp-modal-cabecera">
        <span class="gp-modal-icono"><i class="fa-solid fa-window-restore"></i></span>
        <div class="gp-modal-titulos">
            <h2 id="gp-modal-titulo"></h2>
            <small id="gp-modal-subtitulo"></small>
        </div>
        <button type="button" class="gp-modal-cerrar" id="gp-modal-cerrar" title="Cerrar (Esc)">&times;</button>
    </div>
    <iframe id="gp-modal-marco" title="Ventana del sistema"></iframe>
</dialog>

<div class="gp-avisos" id="gp-avisos" aria-live="polite"></div>

<script>
    //VENTANA MODAL: ABRE EN UN IFRAME LAS PANTALLAS DEL SISTEMA ACTUAL. ESTAS SE CIERRAN CON SU PROPIO
    //BOTON ENVIANDO postMessage('gepro:cerrar') (recursosAPP/recursos/js/ventana-modal.js)
    (function () {
        var modal = document.getElementById('gp-modal');
        var marco = document.getElementById('gp-modal-marco');
        var cerrar = function () {
            if (modal.open) modal.close();
        };
        modal.addEventListener('close', function () {
            marco.src = 'about:blank';
            if (window.Livewire) Livewire.dispatch('gepro-modal-cerrada');
        });
        document.getElementById('gp-modal-cerrar').addEventListener('click', cerrar);
        document.addEventListener('click', function (e) {
            var boton = e.target.closest('[data-modal-url]');
            if (!boton) return;
            document.getElementById('gp-modal-titulo').textContent = boton.dataset.modalTitulo || '';
            document.getElementById('gp-modal-subtitulo').textContent = boton.dataset.modalSubtitulo || '';
            marco.src = boton.dataset.modalUrl;
            modal.showModal();
        });
        window.addEventListener('message', function (e) {
            if (e.data === 'gepro:cerrar' && e.source === marco.contentWindow) cerrar();
        });
    })();

    //AVISOS FLOTANTES: LOS COMPONENTES LIVEWIRE HACEN $this->dispatch('aviso', tipo: 'ok'|'error', mensaje: '...')
    window.addEventListener('aviso', function (e) {
        var d = e.detail || {};
        var aviso = document.createElement('div');
        aviso.className = 'gp-aviso gp-aviso-' + (d.tipo === 'error' ? 'error' : 'ok');
        var icono = document.createElement('i');
        icono.className = 'fa-solid ' + (d.tipo === 'error' ? 'fa-circle-exclamation' : 'fa-circle-check');
        aviso.appendChild(icono);
        aviso.appendChild(document.createTextNode(' ' + (d.mensaje || '')));
        document.getElementById('gp-avisos').appendChild(aviso);
        setTimeout(function () { aviso.classList.add('gp-aviso-sale'); }, 3500);
        setTimeout(function () { aviso.remove(); }, 4000);
    });
</script>

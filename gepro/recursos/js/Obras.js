function AsignarInformacion(Codigo)
{
    var f           = document.formularioGrid;
    var Pagina      = f.Pagina.value;
    f.Codigo.value  = Codigo;
    AjaxGeneraForm(Pagina,'GeneraForm','formularioGrid','FormularioDiv');
}
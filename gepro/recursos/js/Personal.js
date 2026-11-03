function ReturnPrincipal()
{
    $("#tabs").tabs({disabled: [1]});
    $("#tabs").tabs({active: 0});
    $("#FormularioDiv").empty();
    LimpiarGrid();
}

function NuevaAsignacion(Pagina)
{
    $("#tabs").tabs({disabled: [0]});
    $("#tabs").tabs({active: [1]});
    $("#FormularioDiv").empty();
    AjaxGeneraForm(Pagina,'GeneraGrid','formularioGrid','FormularioDiv');
}

function AsignarPersonal(Valor,Valor2)
{
    var f                   = document.formulario;
    var Pagina              = f.Pagina.value;
    f.ActionForm.value      = "AsignarPersonal";
    f.Codigo.value          = Valor;
    f.CodigoUO.value        = Valor2;
    AjaxProcesaDatos(Pagina,'formulario','flex1');
    $("#FormularioDiv").empty();
    Regresar(1);
}

function EliminarPersonal(Valor)
{
    var f                   = document.formularioGrid;
    var Pagina              = f.Pagina.value;
    if(confirm('¿Desea eliminar este registro?'))
    {
        f.ActionForm.value  = "EliminaPersonal";
        f.Codigo.value      = Valor;
        AjaxProcesaDatos(Pagina,'formularioGrid','flex1');
        ReturnPrincipal();
        
    }
    else
    {
        return;
    }
}
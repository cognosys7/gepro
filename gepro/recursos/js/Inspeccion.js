function ReturnPrincipal()
{
    $("#tabs").tabs({disabled: [1]});
    $("#tabs").tabs({active: 0});
    $("#FormularioDiv").empty();
    LimpiarGrid();
}

function ValidClasificacion(Valor)
{
    if (document.getElementById("Opt"+Valor).checked === true)
    {
        $("#ClasifUusuarios"+Valor).show();
        document.getElementById("Usuarios"+Valor).disabled = false;
    }
    else
    {
        $("#ClasifUusuarios"+Valor).hide();
        document.getElementById("Usuarios"+Valor).disabled = true;
    }
}

function ClasificarOcurrencia(Valor)
{
    var f                   = document.formularioGrid;
    var Pagina              = f.Pagina.value;
    f.ActionForm.value      = "VerOcurrencia";
    f.Codigo.value          = Valor;
    $("#tabs").tabs({disabled: [0]});
    $("#tabs").tabs({active: [1]});
    $("#FormularioDiv").empty();
    AjaxGeneraForm(Pagina,'GeneraForm','formularioGrid','FormularioDiv');
}

function ProcesarClasificacion(Pagina)
{
    AjaxProcesaDatos(Pagina,'formulario','flex1');
    $('#flex1').flexReload();
    ReturnPrincipal();
}

function AddProyecto()
{
    $.colorbox({width:"95%", height:"95%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=Proyectoslst&Accion=muestraVista&AccionLocal=2"});
    $('#cboxClose').remove();
}

function CancelarClasificacion(Valor1,Valor2)
{
    var f       = document.formulario;
    var Pagina  = f.Pagina.value;
    if(confirm('¿Desea eliminar este registro?'))
    {
        f.ActionForm.value  = "EliminaClasificacionInspeccion";
        var Valor = f.Codigo.value;
        f.COcurrenciaClasInspeccion.value = Valor1;
        f.CClasificacion.value = Valor2;
        AjaxProcesaDatos(Pagina,'formulario','flex1');
        f.COcurrenciaClasInspeccion.value = "";
        f.CClasificacion.value = "";
        ClasificarOcurrencia(Valor);
    }
    else
    {
        return;
    }
}
function ReturnPrincipal()
{
    $("#tabs").tabs({disabled: [1,2,3]});
    $("#tabs").tabs({active: 0});
    $("#FormularioDiv").empty();
    LimpiarGridForm1();
}

function ReturnNivel2()
{
    $("#tabs").tabs({disabled: [0,2,3]});
    $("#tabs").tabs({active: 1});
    $("#Formulario2Div").empty();
    LimpiarGridForm2();
}

function ReturnNivel3()
{
    $("#tabs").tabs({disabled: [0,1,3]});
    $("#tabs").tabs({active: 2});
    $("#Formulario3Div").empty();
    LimpiarGridForm3();
}
   
function LimpiarGridForm1()
{
    var f                   = document.formularioGrid;
    f.COcurrencia.value     = "";
    f.ActionForm.value      = "";
}

function LimpiarGridForm2()
{
    var f                               = document.formularioClasifc;
    f.CClasificacion.value              = "";
    f.ActionForm.value                  = "";
}

function LimpiarGridForm3()
{
    var f                               = document.formularioObs;
    f.Codigo.value                      = "";
    f.ActionForm.value                  = "";
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

function VerClasificaciones(Valor)
{
    var f                   = document.formularioGrid;
    var Pagina              = f.Pagina.value;
    f.ActionForm.value      = "VerOcurrencia";
    f.COcurrencia.value     = Valor;
    $("#tabs").tabs({disabled: [0,2,3]});
    $("#tabs").tabs({active: [1]});
    $("#FormularioDiv").empty();
    AjaxGeneraForm(Pagina,'GeneraGridClasificacion','formularioGrid','FormularioDiv');
}

function VerObservaciones(Valor)
{
    var f                             = document.formularioClasifc;
    var Pagina                        = f.Pagina.value;
    f.ActionForm.value                = "VerOcurrenciaInspeccionActa";
    //f.COcurrenciaClasificacionInspeccion.value = Valor;
    f.CClasificacion.value = Valor;
    $("#tabs").tabs({disabled: [0,1,3]});
    $("#tabs").tabs({active: [2]});
    $("#Formulario2Div").empty();
    AjaxGeneraForm(Pagina,'GeneraGridObservaciones','formularioClasifc','Formulario2Div');
}

function AsignarObservacion(Valor)
{
    var f                   = document.formularioObs;
    var Pagina              = f.Pagina.value;
    f.ActionForm.value      = "VerOcurrenciaInspeccionActaObs";
    f.Codigo.value          = Valor;
    $("#tabs").tabs({disabled: [0,1,2]});
    $("#tabs").tabs({active: [3]});
    $("#Formulario3Div").empty();
    AjaxGeneraForm(Pagina,'GeneraForm','formularioObs','Formulario3Div');
}

function ProcesarAsignacion(Pagina)
{
    var f                   = document.formulario;
    f.ActionForm.value      = "AsignaOcurrencia";
    AjaxProcesaDatos(Pagina,'formulario','flex3');
    $('#flex3').flexReload();
    ReturnNivel3();
}

function CancelarAsignacion()
{
    var f       = document.formulario;
    var Pagina  = f.Pagina.value;
    if(confirm('¿Desea eliminar este registro?'))
    {
        var Valor = f.Codigo.value;
        f.ActionForm.value  = "EliminaClasificacionAsignacion";
        AjaxProcesaDatos(Pagina,'formulario','flex3');
        $('#flex3').flexReload();
        AsignarObservacion(Valor);
    }
    else
    {
        return;
    }
}
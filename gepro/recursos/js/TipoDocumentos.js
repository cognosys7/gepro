function ReturnPrincipal()
{
    $("#tabs").tabs({disabled: [1,2,3]});
    $("#tabs").tabs({active: 0});
    LimpiarGrid();
    $("#FormularioDiv").empty();
    $("#FormularioDiv2").empty();
    $("#FormularioDiv3").empty();
}

function CancelarEtapas()
{
    $("#tabs").tabs({disabled: [0,1,3]});
    $("#tabs").tabs({active: [2]});
    LimpiarForm2();
    $("#FormularioDiv3").empty();
}

function LimpiarForm()
{
    var f                   = document.formularioGrid;
    f.Codigo.value          = "";
    f.ActionForm.value      = "";
}

function NuevoDocumento(Pagina)
{
    $("#tabs").tabs({disabled: [0]});
    $("#tabs").tabs({active: [1]});
    LimpiarGrid();
    $("#FormularioDiv").empty();
    AjaxGeneraForm(Pagina,'GeneraForm','formularioGrid','FormularioDiv');
}

function ValidarMontoDerecho()
{
    var f = document.formulario;
    if (f.CkMontoDerecho.checked == true)
    {
        $("#MontoDerecho").show();
        $("#ValorGratuito").hide();
        f.MontoDerecho.focus();
        f.MontoDerecho.disabled=false;
    }
    else
    {
        $("#MontoDerecho").hide();
        $("#ValorGratuito").show();
        f.MontoDerecho.disabled=true;
    }
}

function RegistrarProceso(Pagina)
{
    AjaxProcesaDatos(Pagina,'formulario','flex1');
    ReturnPrincipal();
    $('#flex1').flexReload();
}

function NuevoCronograma(Pagina)
{
    $("#tabs").tabs({disabled: [0,1,2]});
    $("#tabs").tabs({active: [3]});
    LimpiarGrid();
    $("#FormularioDiv").empty();
    AjaxGeneraForm(Pagina,'GeneraFormEtapas','formularioCronograma','FormularioDiv3');
}

function VerCronograma(Valor)
{
    var f                   = document.formularioGrid;
    var Pagina              = f.Pagina.value;
    f.ActionForm.value      = "";
    f.Codigo.value          = Valor;
    $("#tabs").tabs({disabled: [0,1,3]});
    $("#tabs").tabs({active: [2]});
    $("#FormularioDiv2").empty();
    AjaxGeneraForm(Pagina,'GeneraCronograma','formularioGrid','FormularioDiv2');
}

function EditarProceso(Valor)
{
    var f                   = document.formularioGrid;
    var Pagina              = f.Pagina.value;
    f.ActionForm.value      = "ModificarRegistro";
    f.Codigo.value          = Valor;
    $("#tabs").tabs({disabled: [0,2,3]});
    $("#tabs").tabs({active: 1}); 
    AjaxGeneraForm(Pagina,'GeneraForm','formularioGrid','FormularioDiv');
}

function EditarEtapaProceso(Valor)
{
    var f                   = document.formularioCronograma;
    var Pagina              = f.Pagina.value;
    f.ActionForm.value      = "ModificarRegistroEtapa";
    f.CEtapa.value          = Valor;
    $("#tabs").tabs({disabled: [0,1,2]});
    $("#tabs").tabs({active: 3}); 
    AjaxGeneraForm(Pagina,'GeneraFormEtapas','formularioCronograma','FormularioDiv3');
}

function PublicarProceso(Valor)
{
    var f                   = document.formularioGrid;
    var Pagina              = f.Pagina.value;
    f.ActionForm.value      = "PublicarProceso";
    f.Codigo.value          = Valor;
    AjaxProcesaDatos(Pagina,'formularioGrid','flex1');
    ReturnPrincipal();
}

function DesPublicarProceso(Valor)
{
    var f                   = document.formularioGrid;
    var Pagina              = f.Pagina.value;
    f.ActionForm.value      = "";
    f.Codigo.value          = Valor;
    $("#tabs").tabs({disabled: [0,2,3]});
    $("#tabs").tabs({active: 1}); 
    AjaxGeneraForm(Pagina,'GeneraFormDespublik','formularioGrid','FormularioDiv');
}

function EliminarProceso(Valor)
{
    var f                   = document.formularioGrid;
    var Pagina              = f.Pagina.value;
    if(confirm('¿Desea eliminar este registro?'))
    {
        f.ActionForm.value  = "EliminaProceso";
        f.Codigo.value      = Valor;
        AjaxProcesaDatos(Pagina,'formularioGrid','flex1');
        ReturnPrincipal();
        
    }
    else
    {
        return;
    }
}

function EliminarEtapaProceso(Valor)
{
    var f                   = document.formularioCronograma;
    var Pagina              = f.Pagina.value;
    if(confirm('¿Desea eliminar este registro?'))
    {
        f.ActionForm.value  = "EliminaProcesoEtapa";
        f.CEtapa.value      = Valor;
        AjaxProcesaDatos(Pagina,'formularioCronograma','flex2');
        CancelarEtapas();
    }
    else
    {
        return;
    }
}

function FilesProceso(Codigo)
{
    $.colorbox({width:"95%", height:"95%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=Archivoslst&Accion=muestraVista&AccionLocal=2&CProcesoEtapa="+Codigo});
    $('#cboxClose').remove();
}

function VerCircular(Codigo)
{
    $.colorbox({width:"95%", height:"95%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=Circularlst&Accion=muestraVista&AccionLocal=2&CProceso="+Codigo});
    $('#cboxClose').remove();
}
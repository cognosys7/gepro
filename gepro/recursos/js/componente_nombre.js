/********************************************************************************
//  ==========================================
//  Proyecto        : MODULO DE PLANIFICACION
//  Entidad         : AUTORIDAD PARA LA RECONSTRUCCIÓN CON CAMBIOS. PRESIDENCIA DEL CONSEJO DE MINISTROS
//  Autores         : ING. EDGAR DAVID PISFIL AHUMADA             
//  Propósito       : JS de la tabla componente_nombre
//  Fecha           : miércoles, 1 de noviembre de 2017 10:45:50
//  Desde el Modelo : PDM AMSAC
//  Modificado      : 16 de Octubre 2017
//
//******************************************************************************
/*******************************************************************
 *          Activa la Pestaña de Acceso al Formulario     
/*******************************************************************/

function EditarInformacion(Valor)
{
    var f                   = document.formularioGrid;
    var Pagina              = f.Pagina.value;
    f.ActionForm.value      = "ModificarRegistro";
    f.SeleccionarID.value          = Valor;
    $("#tabs").tabs({disabled: [0]});
    $("#tabs").tabs({active: 1}); 
    AjaxGeneraForm(Pagina);
}

//FUNCTION PARA GENERAR EL FORMULARIO
function AjaxGeneraForm(pagina)
{   //alert("./mainpage.php?Pagina="+pagina+"&Accion=GeneraForm&AccionLocal=1");
    $.ajax({
        type: "POST",
        url: "./mainpage.php?Pagina="+pagina+"&Accion=GeneraForm&AccionLocal=1", 
        //MANDO LOS VALORES POST DEL FORMULARIO GRID
        data: $("#formularioGrid").serialize(),
        beforeSend: function (XMLHttpRequest) {
        },
        success: function(msg)
        {
            //REEMPLAZO EL DIV INDICADO
           $("#FormularioDiv").html(msg);
        }
        
    });
}
/*******************************************************************
 *                  FUNCTIONES PARA REGISTRAR DATOS 
*******************************************************************/
//FUNCTION PARA REGISTRAR DATOS
function AjaxRegistraDatos(pagina)
{
    $.ajax({
        type: "POST",
        url: "./mainpage.php?Pagina="+pagina+"&Accion=ProcesaMensaje&AccionLocal=1",
        //MANDO LOS VALORES POST DEL FORMULARIO GRID
        data: $("#formulario").serialize(),
        beforeSend: function (XMLHttpRequest) {
        },
        success: function(msg)
        {
           CleanMensaje();
           $("#Mensajes").html(msg);
           Cancelar();
           $('#flex1').flexReload();
        }
    });
}

function CleanMensaje()
{
    $("#Mensajes").show();
    $("#Mensajes").delay(8000).hide(600);
}

//LIMPIA Y ACTUALIZA LA GRILLA
function LimpiarForm()
{
    var f                   = document.formularioGrid;
    f.SeleccionarID.value          = "";
    f.ActionForm.value      = "";
}


function Cancelar()
{
    $("#tabs").tabs({disabled: [1]});
    $("#tabs").tabs({active: 0});
    LimpiarForm();
    $("#FormularioDiv").empty();
}


/*******************************************************************
 *                  FUNCTION PARA CREAR REGISTROS 
*******************************************************************/
function Nuevo(Pagina)
{
    $("#tabs").tabs({disabled: [0]});
    $("#tabs").tabs({active: 1});
    LimpiarForm();
    $("#FormularioDiv").empty();
    AjaxGeneraForm(Pagina);
}


/*******************************************************************
 *                  FUNCTION PARA ELIMINAR DATOS 
*******************************************************************/
function EliminarInformacion(Valor)
{
    var f                   = document.formularioGrid;
    var Pagina              = f.Pagina.value;
    if(confirm('¿Desea eliminar este registro?'))
    {
        f.ActionForm.value = "EliminaRegistro";
        f.SeleccionarID.value = Valor;
        $.ajax({
        type: "POST",
        url: "./mainpage.php?Pagina="+Pagina+"&Accion=ProcesaMensaje&AccionLocal=1",
        data: $("#formularioGrid").serialize(),
        beforeSend: function (XMLHttpRequest) {
        },
        success: function(msg)
        {
           CleanMensaje();
           $("#Mensajes").html(msg);
           Cancelar();
           $('#flex1').flexReload();
        }
    });
    }
    else
    {
        return;
    }
}



/*
 * 
 * 

function NuevoFormulario(Pagina)
{
    $("#tabs").tabs({disabled: [0]});
    $("#tabs").tabs({active: [1]});
    $("#FormularioDiv").empty();
    AjaxGeneraFormAjax(Pagina,'GeneraForm','formularioGrid','FormularioDiv');
}

function NuevoFormularioPermisos(Pagina)
{
    $("#tabs").tabs({disabled: [0]});
    $("#tabs").tabs({active: [1]});
    $("#FormularioDiv").empty();
    AjaxGeneraFormAjax(Pagina,'GeneraFormPermisos','formularioGrid','FormularioDiv');
}
*/

/***********************************************************************************
* (OPCIONAL)SECCION DE FUNCIONES AJAX PARA EL CARGADO DE LOS COMBOS QUE REQUIEREN PARAMETROS     
***********************************************************************************/

/*

function AjaxProvinciaList(pagina){
    document.getElementById('Provincia').options.length = null;
    //document.getElementById('Provincia').disabled = true;
    document.getElementById('Distrito').options.length = null;
    //document.getElementById('Distrito').disabled = true;

    var itemSelected = document.getElementById('Departamento').selectedIndex;
    var id = document.getElementById('Departamento').options[itemSelected].value;
    $.ajax({
        type: "POST",
        url: "./mainpage.php?Pagina="+pagina+"&AccionLocal=1&Accion=LoadProvinciaAjax&Id="+id,
        beforeSend: function (XMLHttpRequest) {
        // AjaxLoading("#dvCreateFolderContent");
        },
        success: function(msg){
            $("#divProvincia").html(msg);
        }
    });
}

function AjaxDistritoList(pagina){
    document.getElementById('Distrito').options.length = null;
    //document.getElementById('Distrito').disabled = true;    
    var itemSelected = document.getElementById('Provincia').selectedIndex; 
    var id = document.getElementById('Provincia').options[itemSelected].value;
    $.ajax({
        type: "POST",
        url: "./mainpage.php?Pagina="+pagina+"&AccionLocal=1&Accion=LoadDistritoAjax&Id="+id,
        beforeSend: function (XMLHttpRequest) {
        // AjaxLoading("#dvCreateFolderContent");
        },
        success: function(msg){
            $("#divDistrito").html(msg);
        }
    });
}
*/


function AsignarComponente_nombre(Codigo)
{    
    var f           = document.formularioGrid;
    var Pagina      = f.Pagina.value;
    f.PIDE.value  = Codigo;
//    alert (Pagina+'-'+f.PIDE.value);
    AjaxGeneraForm(Pagina,'GeneraForm','formularioGrid','FormularioDiv');
}

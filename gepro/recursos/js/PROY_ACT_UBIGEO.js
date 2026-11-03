/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION.NET
//  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
//                    Edgar David Pisfil Ahumada                    
//  Propósito       : JS de la tabla PROY_ACT_UBIGEO
//  Fecha           : lunes, 20 de noviembre de 2017 04:02:18 p.m.
//  Desde el Modelo : PDM - AMSAC
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
{
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

function Cancelar()
{
    $("#tabs").tabs({disabled: [1]});
    $("#tabs").tabs({active: 0});
    LimpiarForm();
    $("#FormularioDiv").empty();
}

//LIMPIA Y ACTUALIZA LA GRILLA
function LimpiarForm()
{
    var f                   = document.formularioGrid;
    f.SeleccionarID.value          = "";
    f.ActionForm.value      = "";
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

  
function AjaxProvinciaList(pagina){
    document.getElementById('PROVINCIA').options.length = null;
    //document.getElementById('Provincia').disabled = true;
    document.getElementById('DISTRITO').options.length = null;
    //document.getElementById('Distrito').disabled = true;

    var itemSelected = document.getElementById('REGION').selectedIndex;
    var id = document.getElementById('REGION').options[itemSelected].value;
    $.ajax({
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
    document.getElementById('DISTRITO').options.length = null;
    //document.getElementById('Distrito').disabled = true;    
    var itemSelected = document.getElementById('PROVINCIA').selectedIndex; 
    var id = document.getElementById('PROVINCIA').options[itemSelected].value;
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

function UBIGEO()
{    
    var itemSelected = document.getElementById('DISTRITO').selectedIndex; 
    var COD_UBIGEO = document.getElementById('DISTRITO').options[itemSelected].value;    
    $("#COD_UBIGEO").val(COD_UBIGEO);    
}

function addUBIGEO(Boton)
{   
    document.formulario.varBotonInvocador.value = Boton ;
    
    OcultaBOx();
    $.colorbox({width:"99%", height:"99%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=GEN_UBIGEO&Accion=muestraVista&AccionLocal=2&Pedido=Busqueda"});
    $('#cboxClose').remove();
}

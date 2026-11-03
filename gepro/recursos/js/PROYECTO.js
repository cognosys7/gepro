/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION.NET
//  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
//                    Edgar David Pisfil Ahumada                    
//  Propósito       : JS de la tabla PROYECTO
//  Fecha           : domingo, 5 de mayo de 2019 9:28:21
//  Desde el Modelo : PDM - AMSAC - AJUSTADO-D
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



/***********************************************************************************
* (OPCIONAL)FUNCIONES DE VENTANAS ANIDADAS     
***********************************************************************************/

function AbrirProyectoActividad (PIDE,Opcion,filtro)
{
    OcultaBOx();
    $.colorbox({width:"99%", height:"99%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=PROYECTO_ACTIVIDAD&Opcion="+Opcion+"&Accion=muestraVista&AccionLocal=2&PIDE="+PIDE+"&Pfiltro="+filtro });
    $('#cboxClose').remove();
}

function AbrirProyectoPIP (PIDE)
{
    OcultaBOx();
    $.colorbox({width:"99%", height:"99%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=PROY_PIP&Accion=muestraVista&AccionLocal=2&PIDE="+PIDE });
    $('#cboxClose').remove();
}

function LINK_PROY_ACT_UBIGEO(PIDE_PROYECTO_ACTIVIDAD)
{
    OcultaBOx();
    $.colorbox({width: "99%", height: "99%", iframe: true, escKey: true, overlayClose: false, href: "mainpage.php?Pagina=PROY_ACT_UBIGEO&Accion=muestraVista&AccionLocal=2&PIDE_PROYECTO_ACTIVIDAD=" + PIDE_PROYECTO_ACTIVIDAD});
    $('#cboxClose').remove();
}

function AbrirGestionBeneficiarios (PIDE)
{
    OcultaBOx();
    $.colorbox({width:"99%", height:"99%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=PROY_GESTION_SOCIAL&Accion=muestraVista&AccionLocal=2&PIDE="+PIDE });
    $('#cboxClose').remove();
}

function AbrirLeccionAprendida (PIDE)
{
    OcultaBOx();
    $.colorbox({width:"99%", height:"99%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=PROY_LECCION_APRENDIDA&Accion=muestraVista&AccionLocal=2&PIDE="+PIDE });
    $('#cboxClose').remove();
}

function abrirComunicacion (PIDE)
{
    OcultaBOx();
    $.colorbox({width:"99%", height:"99%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=PROY_COMUNICACION&Accion=muestraVista&AccionLocal=2&PIDE="+PIDE });
    $('#cboxClose').remove();
}

function AbrirSIGAM(PIDE)
{
//    alert("hopla");
    window.open("http://198.150.0.125/sigam/planes/" + PIDE + ".php", "Archivo Digital", "width=1000, height=800");
}

function abrirFichaTecnica(PIDE)
{
//    alert("hopla");
    window.open("https://app.powerbi.com/view?r=eyJrIjoiZDk2MzU1Y2QtNjAxNi00NGFhLWE5MWMtMTViNDUzMTBiNzc0IiwidCI6IjhkNmE0OTg0LThlZTAtNGEzNi1iNDA1LWQ2NzhmNDdmZGE5MSIsImMiOjR9&pageName=ReportSection1f49f22bde5b59240410" + PIDE + ".php", "Archivo Digital", "width='99%', height='99%'");
}


function abrirETLInteresados (PIDE)
{
    OcultaBOx(); 
    $.colorbox({width: "100%", height: "100%", iframe: true, escKey: true, overlayClose: false, href: "mainpage.php?Pagina=migrar_CONT_INTERESADOS&Accion=muestraVista&AccionLocal=2&PIDE=" + PIDE +"&Tabla=migrar_CONT_INTERESADOS" });
    $('#cboxClose').remove();
}
/////////////////////////////////////////////////////


function AbrirObjEsp (PIDE)
{
    OcultaBOx();
    $.colorbox({width:"100%", height:"100%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=PROY_SOCIAL_OBJETIVO_ESP&Accion=muestraVista&AccionLocal=2&PIDE="+PIDE });
    $('#cboxClose').remove();
}

function AbrirAccGes (PIDE)
{
    OcultaBOx();
    $.colorbox({width:"100%", height:"100%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=PROY_ACCION_GESTION&Accion=muestraVista&AccionLocal=2&PIDE="+PIDE });
    $('#cboxClose').remove();
}

function AbrirAccCor (PIDE)
{
    OcultaBOx();
    $.colorbox({width:"100%", height:"100%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=PROY_ACCION_CORRECTIVA&Accion=muestraVista&AccionLocal=2&PIDE="+PIDE });
    $('#cboxClose').remove();
}

function AbrirOpoMej (PIDE)
{
    OcultaBOx();
    $.colorbox({width:"100%", height:"100%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=PROY_OPORTUNIDAD_RIESGO&Accion=muestraVista&AccionLocal=2&PIDE="+PIDE });
    $('#cboxClose').remove();
}

function AbrirCosCom (PIDE)
{
    OcultaBOx();
    $.colorbox({width:"100%", height:"100%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=PROY_COSTO_COMPONENTE&Accion=muestraVista&AccionLocal=2&PIDE="+PIDE });
    $('#cboxClose').remove();
}

function AbrirSegPry (PIDE)
{
    OcultaBOx();
    $.colorbox({width:"100%", height:"100%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=PROY_SEGUIMIENTO&Accion=muestraVista&AccionLocal=2&PIDE="+PIDE });
    $('#cboxClose').remove();
}
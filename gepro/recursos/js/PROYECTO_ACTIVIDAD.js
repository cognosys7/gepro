/********************************************************************************
 //  ==========================================
 //  Proyecto        : GESTION.NET
 //  Autores         : Julio C�sar Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
 //                    Edgar David Pisfil Ahumada                    
 //  Prop�sito       : JS de la tabla PROYECTO_ACTIVIDAD
 //  Fecha           : jueves, 2 de noviembre de 2017 18:03:21
 //  Desde el Modelo : PDM - AMSAC
 //  Modificado      : 16 de Octubre 2017
 //
 //******************************************************************************/


function LINK_PROY_COMPONENTE(PIDE_PROYECTO_ACTIVIDAD, PIDE_INTERVENCION)
{
    OcultaBOx();
    $.colorbox({width: "99%", height: "99%", iframe: true, escKey: true, overlayClose: false, href: "mainpage.php?Pagina=PROY_COMPONENTE&Accion=muestraVista&AccionLocal=2&PIDE_PROYECTO_ACTIVIDAD=" + PIDE_PROYECTO_ACTIVIDAD+"&PIDE_INTERVENCION="+PIDE_INTERVENCION});
    $('#cboxClose').remove();
}

function LINK_PROY_RIESGO_PROBLEMA(PIDE_PROYECTO_ACTIVIDAD,PIDE_PROYECTO)
{
    OcultaBOx();
    $.colorbox({width: "99%", height: "99%", iframe: true, escKey: true, overlayClose: false, href: "mainpage.php?Pagina=PROY_RIESGO_PROBLEMA&Accion=muestraVista&AccionLocal=2&PIDE_PROYECTO_ACTIVIDAD=" + PIDE_PROYECTO_ACTIVIDAD + "&PIDE_PROYECTO=" + PIDE_PROYECTO});
    $('#cboxClose').remove();

}

function LINK_PROY_SEGUIMIENTO(PIDE_PROYECTO_ACTIVIDAD)
{
    OcultaBOx();
    $.colorbox({width: "100%", height: "100%", iframe: true, escKey: true, overlayClose: false, href: "mainpage.php?Pagina=PROY_SEGUIMIENTO_GR&Accion=muestraVista&AccionLocal=2&PIDE_PROYECTO_ACTIVIDAD=" + PIDE_PROYECTO_ACTIVIDAD});
    $('#cboxClose').remove();
}


function LINK_PROY_ACT_UBIGEO(PIDE_PROYECTO_ACTIVIDAD)
{
    OcultaBOx();
    $.colorbox({width: "99%", height: "99%", iframe: true, escKey: true, overlayClose: false, href: "mainpage.php?Pagina=PROY_ACT_UBIGEO&Accion=muestraVista&AccionLocal=2&PIDE_PROYECTO_ACTIVIDAD=" + PIDE_PROYECTO_ACTIVIDAD});
    $('#cboxClose').remove();
}
function LINK_PROY_FOTOS(PIDE_PROYECTO_ACTIVIDAD)
{
    OcultaBOx();
    $.colorbox({width: "780px", height: "575px", iframe: true, escKey: true, overlayClose: false, href: "mainpage.php?Pagina=PROY_COMP_SEGUIMIENTO_CARRUSEL&Accion=muestraVista&AccionLocal=2&PIDE_PROYECTO_ACTIVIDAD=" + PIDE_PROYECTO_ACTIVIDAD});
    $('#cboxClose').remove();
}


function AbrirProcesoAdquisicion (PIDE)
{
    OcultaBOx();
    $.colorbox({width:"99%", height:"99%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=PROCESO&Opcion=1&Accion=muestraVista&AccionLocal=2&PIDE="+PIDE });
    $('#cboxClose').remove();
}

function LINK_Migrar(PIDE)
{
    OcultaBOx(); 
    $.colorbox({width: "100%", height: "100%", iframe: true, escKey: true, overlayClose: false, href: "mainpage.php?Pagina=migrar_CONT_ETAPA_CONTROL&Accion=muestraVista&AccionLocal=2&PIDE=" + PIDE +"&Tabla=migrar_CONT_ETAPA_CONTROL" });
    $('#cboxClose').remove();
}

// ---AÑADIDO EL 11/05/2021 POR JULIO MEZA
function LINK_PROY_CONT_AMPLIACION(PIDE_PROYECTO_ACTIVIDAD,PIDE_PROYECTO)
{
    OcultaBOx();
    $.colorbox({width: "99%", height: "99%", iframe: true, escKey: true, overlayClose: false, href: "mainpage.php?Pagina=PROY_CONT_AMPLIACION&Accion=muestraVista&AccionLocal=2&PIDE=" + PIDE_PROYECTO_ACTIVIDAD + "&PIDE_PROYECTO=" + PIDE_PROYECTO});
    $('#cboxClose').remove();

} 

/*
function LINK_PROY_INDICADOR(PIDE_PROYECTO_ACTIVIDAD)
{
    OcultaBOx();
    $.colorbox({width: "90%", height: "90%", iframe: true, escKey: false, overlayClose: false, href: "mainpage.php?Pagina=PROY_INDICADOR&Accion=muestraVista&AccionLocal=2&PIDE_PROYECTO_ACTIVIDAD=" + PIDE_PROYECTO_ACTIVIDAD});
    $('#cboxClose').remove();
}   
*/

function LINK_RPT_INTERVENCIONES()
{
    OcultaBOx();
    $.colorbox({width: "50%", height: "50%", iframe: true, escKey: true, overlayClose: false, href: "mainpage.php?Pagina=RPT_INTERVENCIONES&Accion=muestraVista&AccionLocal=2"});
    $('#cboxClose').remove();
}


/*******************************************************************
 *          Activa la Pesta�a de Acceso al Formulario     
 /*******************************************************************/

function EditarInformacion(Valor)
{
    var f = document.formularioGrid;
    var Pagina = f.Pagina.value;
    f.ActionForm.value = "ModificarRegistro";
    f.SeleccionarID.value = Valor;
    $("#tabs").tabs({disabled: [0]});
    $("#tabs").tabs({active: 1});
    AjaxGeneraForm(Pagina);
}

//FUNCTION PARA GENERAR EL FORMULARIO
function AjaxGeneraForm(pagina)
{
    $.ajax({
        type: "POST",
        url: "./mainpage.php?Pagina=" + pagina + "&Accion=GeneraForm&AccionLocal=1",
        //MANDO LOS VALORES POST DEL FORMULARIO GRID
        data: $("#formularioGrid").serialize(),
        beforeSend: function (XMLHttpRequest) {
        },
        success: function (msg)
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
        url: "./mainpage.php?Pagina=" + pagina + "&Accion=ProcesaMensaje&AccionLocal=1",
        //MANDO LOS VALORES POST DEL FORMULARIO GRID
        data: $("#formulario").serialize(),
        beforeSend: function (XMLHttpRequest) {
        },
        success: function (msg)
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
    var f = document.formularioGrid;
    f.SeleccionarID.value = "";
    f.ActionForm.value = "";
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
    var f = document.formularioGrid;
    var Pagina = f.Pagina.value;
    if (confirm('�Desea eliminar este registro?'))
    {
        f.ActionForm.value = "EliminaRegistro";
        f.SeleccionarID.value = Valor;
        $.ajax({
            type: "POST",
            url: "./mainpage.php?Pagina=" + Pagina + "&Accion=ProcesaMensaje&AccionLocal=1",
            data: $("#formularioGrid").serialize(),
            beforeSend: function (XMLHttpRequest) {
            },
            success: function (msg)
            {
                CleanMensaje();
                $("#Mensajes").html(msg);
                Cancelar();
                $('#flex1').flexReload();
            }
        });
    } else
    {
        return;
    }
}






function AbrirContrato (PIDE, PIDE2)
{
    OcultaBOx();
    $.colorbox({width:"98%", height:"98%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=CONTRATO&Accion=muestraVista&AccionLocal=2&PIDE="+PIDE+"&PIDE2="+PIDE2 });
//    $.colorbox({width:"98%", height:"98%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=CONTRATO&Accion=GeneraForm&AccionLocal=1&PIDE="+PIDE+"&PIDE2="+PIDE2+"&SeleccionarID=1" });
    $('#cboxClose').remove();
}

function addContrato (PIDE)
{   
    //    SE IDENTIFICA EL BOTON UTILIZADO
    document.formulario.varBotonInvocador.value = PIDE ;
    
    OcultaBOx();
    $.colorbox({width:"98%", height:"98%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=CONTRATO&Accion=muestraVista&AccionLocal=2&Pedido=Busqueda"});
    $('#cboxClose').remove();
}



function AddObras()
{   
    OcultaBOx();
    $.colorbox({width:"79%", height:"90%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=GEN_UBIGEO&Accion=muestraVista&AccionLocal=2"});
    $('#cboxClose').remove();
}


function addPROCESO (PIDE)
{   
    //    SE IDENTIFICA EL BOTON UTILIZADO
    document.formulario.varBotonInvocador.value = PIDE ;
    
    OcultaBOx();
    $.colorbox({width:"98%", height:"98%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=PROCESO&Accion=muestraVista&AccionLocal=2&Pedido=Busqueda"});
    $('#cboxClose').remove();
}

////////////////////////////////////////

function AbrirInteresados (PIDE,PIDE_PROYECTO,PINTERVENCION)
{
    OcultaBOx();
    $.colorbox({width:"98%", height:"98%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=CONT_INTERESADOS&Accion=muestraVista&AccionLocal=2&PIDE="+PIDE+"&PIDE_PROYECTO="+PIDE_PROYECTO+"&PINTERVENCION="+PINTERVENCION });
//    $.colorbox({width:"98%", height:"98%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=CONTRATO&Accion=GeneraForm&AccionLocal=1&PIDE="+PIDE+"&PIDE2="+PIDE2+"&SeleccionarID=1" });
    $('#cboxClose').remove();
}




function asignarPROCESO(Codigo)
{
    var f = document.formularioGrid;
    var Pagina = f.Pagina.value;
    f.PIDEbuscado.value = Codigo;
//    alert (Pagina+'-'+f.PIDEbuscado.value);
    AjaxGeneraForm(Pagina, 'GeneraForm', 'formularioGrid', 'FormularioDiv');
}




function abrirDocumento (PIDE,PIDE2)
{
    OcultaBOx();
    $.colorbox({width:"99%", height:"99%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=CONT_DOCUMENTACION&Opcion=1&Accion=muestraVista&AccionLocal=2&PIDE="+PIDE + "&PIDE2=" + PIDE2 });
    $('#cboxClose').remove();
}

function abrirProyectoGastoDirecto(PIDE_PROYECTO_ACTIVIDAD, PIDE_INTERVENCION)
{
    OcultaBOx();
    $.colorbox({width: "99%", height: "99%", iframe: true, escKey: true, overlayClose: false, href: "mainpage.php?Pagina=PROY_CONTRATO_GASTO_DIR&Accion=muestraVista&AccionLocal=2&PIDE=" + PIDE_PROYECTO_ACTIVIDAD+"&PIDE_INTERVENCION="+PIDE_INTERVENCION});
    $('#cboxClose').remove();
}

function abrirEntregable(PIDE, PIDE_PROYECTO)
{
    OcultaBOx();
    $.colorbox({width: "99%", height: "99%", iframe: true, escKey: true, overlayClose: false, href: "mainpage.php?Pagina=CONT_CALIDAD&Accion=muestraVista&AccionLocal=2&PIDE=" + PIDE+"&PIDE_PROYECTO="+PIDE_PROYECTO});
    $('#cboxClose').remove();
}

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION.NET
//  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
//                    Edgar David Pisfil Ahumada                    
//  Propósito       : JS de la tabla PROY_COMP_INDIC_ANUAL
//  Fecha           : sábado, 6 de enero de 2018 22:17:28
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
function EliminarInformacion(IDE_PROY_COMPONENTE,IDE_INDICADOR,COD_ANHO)
{
    var f = document.formularioGrid;
    var Pagina = f.Pagina.value;
    if (confirm('¿Desea eliminar este registro?'))
    {
        f.ActionForm.value = "EliminaRegistro";
        f.IDE_PROY_COMPONENTE.value = IDE_PROY_COMPONENTE;
        f.IDE_INDICADOR.value = IDE_INDICADOR;
        f.COD_ANHO.value = COD_ANHO;
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


function LINK_PROY_COMP_INDIC_MENSUAL(PIDE_PROY_COMPONENTE, PIDE_INDICADOR, PIDE_COD_ANHO)
{
    OcultaBOx(); 
    $.colorbox({width: "100%", height: "100%", iframe: true, escKey: false, overlayClose: false, href: "mainpage.php?Pagina=PROY_COMP_INDIC_MENSUAL&Accion=muestraVista&AccionLocal=2\n\&PIDE_PROY_COMPONENTE=" + PIDE_PROY_COMPONENTE+"&PIDE_INDICADOR=" + PIDE_INDICADOR + "&PIDE_COD_ANHO=" + PIDE_COD_ANHO});
    $('#cboxClose').remove();
}


function LINK_PROY_COMP_INDIC_QUINCENAL(PIDE_PROY_COMPONENTE, PIDE_INDICADOR, PIDE_COD_ANHO)
{
    OcultaBOx(); 
    //$.colorbox({width: "100%", height: "100%", iframe: true, escKey: true, overlayClose: false, href: "mainpage.php?Pagina=PROY_COMP_INDIC_QUINCENAL&Accion=muestraVista&AccionLocal=2&PIDE_PROY_COMPONENTE=1670&PIDE_INDICADOR=7&PIDE_COD_ANHO=2018"});
    $.colorbox({width: "100%", height: "100%", iframe: true, escKey: false, overlayClose: false, href: "mainpage.php?Pagina=PROY_COMP_INDIC_QUINCENAL&Accion=muestraVista&AccionLocal=2\n\&PIDE_PROY_COMPONENTE=" + PIDE_PROY_COMPONENTE+"&PIDE_INDICADOR=" + PIDE_INDICADOR + "&PIDE_COD_ANHO=" + PIDE_COD_ANHO});
    $('#cboxClose').remove();
}



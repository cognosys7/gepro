/********************************************************************************
//  ==========================================
//  Proyecto        : SISTEMA DE GESTION DE PROYECTOS
//  Empresa	    : ACTIVOS MINEROS S.A.C.
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
//                    Ing. Edgar David Pisfil Ahumada                   
//  Propósito       : JS de elección de archivo para migrar a la tabla PROY_CONT_ETAPA_CONTROL y PROY_CONT_COMP_CONTROL_DET
//  Fecha           : martes, 25 de mayo de 2021 14:05:38
//  Desde el Modelo : PDM - Modelo Físico de Datos - SGPAM
//  Modificado      : martes, 25 de mayo de 2021 14:05:38
//******************************************************************************/


/*******************************************************************
 *          Activa la Pestaña de Acceso al Formulario     
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
    var f = document.formularioGrid;
    f.SeleccionarID.value = "";
    f.ActionForm.value = "";
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
    if (confirm('¿Desea eliminar este registro?'))
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



function abrirGEN_ARCHIVO(PIDE,Tabla)
{
    OcultaBOx();
    $.colorbox({width: "100%", height: "100%", iframe: true, escKey: false, overlayClose: false, href: "mainpage.php?Pagina=GEN_ARCHIVO&Accion=muestraVista&AccionLocal=2&PIDE=" + PIDE+"&Tabla=" + Tabla});
    $('#cboxClose').remove();
}


/********************************************************************************
 //  ==========================================
 //  Proyecto        : GESTION.NET
 //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
 //                    Edgar David Pisfil Ahumada                    
 //  Propósito       : JS de la tabla PROCESO
 //  Fecha           : miércoles, 1 de noviembre de 2017 11:29:06
 //  Desde el Modelo : PDM AMSAC
 //  Modificado      : 16 de Octubre 2017
 //
 //******************************************************************************
 /*******************************************************************
 *          Activa la Pestaña de Acceso al Formulario     
 /*******************************************************************/

function VerCronograma(Proceso)
{
    OcultaBOx();
    $.colorbox({width:"100%", height:"100%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=PROC_CRONOGRAMA&Accion=muestraVista&AccionLocal=2&Proceso="+Proceso});
    $('#cboxClose').remove();
}

function VerProcesoItems(Proceso)
{
    OcultaBOx();
    $.colorbox({width:"100%", height:"100%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=PROC_ITEM&Accion=muestraVista&AccionLocal=2&Proceso="+Proceso});
    $('#cboxClose').remove();
}
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
function Cancelar()
{
    $("#tabs").tabs({disabled: [1]});
    $("#tabs").tabs({active: 0});
    LimpiarForm();
    $("#FormularioDiv").empty();
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







function asignarPROCESO(Codigo)
{
    var f = document.formularioGrid;
    var Pagina = f.Pagina.value;
    f.PIDEbuscado.value = Codigo;
//    alert (Pagina+'-'+f.PIDEbuscado.value);
    AjaxGeneraForm(Pagina, 'GeneraForm', 'formularioGrid', 'FormularioDiv');
}



function abrirSEACE(Archivo)
{
//    alert(''+ Archivo);
    window.open('http://prodapp2.seace.gob.pe/seacebus-uiwd-pub/fichaSeleccion/fichaSeleccion.xhtml?idSistema=3&ongei=1&idConvocatoria='+Archivo, "OSCE - SEACE", "width=1400, height=800");
}


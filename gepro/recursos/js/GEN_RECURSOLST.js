/********************************************************************************
 //  ==========================================
 //  Proyecto        : GESTION.NET
 //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
 //                    Edgar David Pisfil Ahumada                    
 //  Propósito       : JS de la tabla GEN_RECURSO
 //  Fecha           : martes, 16 de enero de 2018 12:58:57 p.m.
 //  Desde el Modelo : PDM - AMSAC
 //  Modificado      : 16 de Octubre 2017
 //
 //******************************************************************************
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

function AsignarRecurso(Codigo)
{    
    var f           = document.formularioGrid;
    var Pagina      = f.Pagina.value;
    f.PIDE_RECURSO.value  = Codigo;
    AjaxGeneraForm(Pagina,'GeneraForm','formularioGrid','FormularioDiv');
}


/*******************************************************************
 *                  FUNCTIONES PARA REGISTRAR DATOS 
 *******************************************************************/


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




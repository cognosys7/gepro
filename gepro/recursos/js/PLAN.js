/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION.NET
//  Autores         : Julio C�sar Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
//                    Edgar David Pisfil Ahumada                    
//  Prop�sito       : JS de la tabla PLAN
//  Fecha           : viernes, 5 de enero de 2018 15:07:34
//  Desde el Modelo : PDM - AMSAC
//  Modificado      : 16 de Octubre 2017
//
//******************************************************************************
/*******************************************************************
 *          Activa la Pesta�a de Acceso al Formulario     
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
    if(confirm('�Desea eliminar este registro?'))
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



	
		function LINK_PLAN_TRANSFERENCIA (PIDE_PLAN)
		{
			OcultaBOx();
			$.colorbox({width:"98%", height:"98%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=PLAN_TRANSFERENCIA&Accion=muestraVista&AccionLocal=2&PIDE_PLAN="+PIDE_PLAN});
			$('#cboxClose').remove();
		}
	
		function LINK_PLAN_PROYECTO (PIDE_PLAN)
		{
			OcultaBOx();
			$.colorbox({width:"85%", height:"75%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=PLAN_PROYECTO&Accion=muestraVista&AccionLocal=2&PIDE_PLAN="+PIDE_PLAN});
			$('#cboxClose').remove();
		}



/***********************************************************************************
* (OPCIONAL)SECCION DE FUNCIONES AJAX PARA EL CARGADO DE LOS COMBOS QUE REQUIEREN PARAMETROS     
***********************************************************************************/

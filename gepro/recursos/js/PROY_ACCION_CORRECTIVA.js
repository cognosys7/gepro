/********************************************************************************
//  ==========================================
//  Proyecto        : SISTEMA DE GESTION DE PROYECTOS
//  Empresa	    	  : ACTIVOS MINEROS S.A.C.
//  Autores         : Ing. julio César Meza Yangali                     
//  Propósito       : JS de la tabla PROY_ACCION_CORRECTIVA
//  Fecha           : sábado, 3 de julio de 2021 2:15:12
//  Desde el Modelo : PDM - Modelo Físico de Datos - SGPAM
//  Modificado      : sábado, 3 de julio de 2021 2:15:12
//
//******************************************************************************/


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

//function asignarPROY_ACCION_CORRECTIVA(Codigo)
//{    
//    var f           = document.formularioGrid;
//    var Pagina      = f.Pagina.value;
//    f.PIDEbuscado.value  = Codigo;
////    alert (Pagina+'-'+f.PIDEbuscado.value);
//    AjaxGeneraForm(Pagina,'GeneraForm','formularioGrid','FormularioDiv');
//}


//function abrirHija_ (PIDE)
//{
//       OcultaBOx();
//        $.colorbox({width:"99%", height:"99%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=GEN_TABLAS&Accion=muestraVista&AccionLocal=2&PIDE="+PIDE });
//       $('#cboxClose').remove();
//}



//function addPadre (Boton)
//{   
//    document.formulario.varBotonInvocador.value = Boton ;
//    
//    OcultaBOx();
//    $.colorbox({width:"99%", height:"99%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=GEN_COMUNIDAD&Accion=muestraVista&AccionLocal=2&Pedido=Busqueda"});
//    $('#cboxClose').remove();
//}



//function abrirRecursiva ( PIDE , Recursiva_Nivel_Actual )
//{
//        OcultaBOx();
//        $.colorbox({width:"98%", height:"98%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=PROY_ACCION_CORRECTIVA&Accion=muestraVista&AccionLocal=2&PIDE="+PIDE+"&Recursiva_Nivel_Actual="+Recursiva_Nivel_Actual  });
//        $('#cboxClose').remove();
//}






//function abrirGEN_ARCHIVO(PIDE , Tabla , Registro , TipoArchivo)
//{
//    OcultaBOx();
//    $.colorbox({width: "99%", height: "99%", iframe: true, escKey: false, overlayClose: false, href: "mainpage.php?Pagina=GEN_ARCHIVO&Accion=muestraVista&AccionLocal=2&PIDE="+PIDE + "&Tabla="+Tabla + "&Registro="+Registro + "&TipoArchivo="+TipoArchivo});
//    $('#cboxClose').remove();
//}

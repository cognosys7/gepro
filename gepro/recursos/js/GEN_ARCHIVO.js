/********************************************************************************
 //  ==========================================
 //  Proyecto        : GESTION.NET
 //  Empresa         : www.cognosys.com.pe
 //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com - 
 //                    Ing. Edgar David Pisfil Ahumada                  
 //  Propósito       : JS de la tabla GEN_ARCHIVO
 //  Fecha           : lunes, 3 de junio de 2019 22:00:44
 //  Desde el Modelo : PDM - AMSAC - AJUSTADO-J
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
/*******************************************************************
 *                  FUNCTIONES PARA REGISTRAR DATOS 
 *******************************************************************/
//FUNCTION PARA REGISTRAR DATOS
//function AjaxRegistraDatos(pagina)
//{
//    $.ajax({
//        type: "POST",
//        url: "./mainpage.php?Pagina=" + pagina + "&Accion=ProcesaMensaje&AccionLocal=1",
//        //MANDO LOS VALORES POST DEL FORMULARIO GRID
//        data: $("#formulario").serialize(),
//        beforeSend: function (XMLHttpRequest) {
//        },
//        success: function (msg)
//        {
//            CleanMensaje();
//            $("#Mensajes").html(msg);
//            Cancelar();
//            $('#flex1').flexReload();
//        }
//    });
//}
function AjaxRegistraDatos(pagina)
{
    var f                   = document.formulario;
    ActionForm              = (f.ActionForm.value === null) ? 0 : f.ActionForm.value;
    SeleccionarID           = (f.SeleccionarID.value === null) ? 0 : f.SeleccionarID.value;      
    
    IDE_TABLA       = (f.IDE_TABLA.value === null) ? 0 : f.IDE_TABLA.value;    
    IDE_REGISTRO    = (f.IDE_REGISTRO.value === null) ? 0 : f.IDE_REGISTRO.value;
    DES_RUTA        = (f.DES_RUTA.value === null) ? 0 : f.DES_RUTA.value;    
    DES_ARCHIVO     = (f.DES_ARCHIVO.value === null) ? 0 : f.DES_ARCHIVO.value;   
    EST_ARCHIVO     = (f.EST_ARCHIVO.value === null) ? 0 : f.EST_ARCHIVO.value;  
    
    //CREAR UNA VARIABLE PARA EL PASAR LOS DATOS
    var formData    = new FormData();
    var docFile     = document.getElementById('archivo');
    var file        = docFile.files[0];
    if (typeof file === "undefined") {        
        formData.append('archivo', null);
    } 
    else {        
        formData.append('archivo', file);
    }    
    formData.append('ActionForm', ActionForm);
    formData.append('SeleccionarID', SeleccionarID);
          
    formData.append('IDE_TABLA', IDE_TABLA);
    formData.append('IDE_REGISTRO', IDE_REGISTRO);
    formData.append('DES_RUTA', DES_RUTA);
    formData.append('DES_ARCHIVO', DES_ARCHIVO);
    formData.append('EST_ARCHIVO', EST_ARCHIVO);
    
    
    $.ajax({
        url: "./mainpage.php?Pagina=" + pagina + "&Accion=ProcesaMensaje&AccionLocal=1",
        type: "POST",
        contentType: false,
        data: formData,
        processData: false,
        cache: false,        
        //MANDO LOS VALORES POST DEL FORMULARIO GRID        
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

//DESCARGA EL ARCHIVO SIN ABRIR OTRA VENTANA: DescargarArchivo.php VALIDA LA SESION Y LA RUTA Y LO
//ENVIA CON SU NOMBRE ORIGINAL. SE USA UN IFRAME OCULTO; SI HAY UN ERROR, LA PAGINA DE DESCARGA LO AVISA
function abrirArchivo(Ruta,Archivo)
{
    //t: PARA QUE EL MISMO ARCHIVO SE PUEDA DESCARGAR DOS VECES SEGUIDAS (EL IFRAME NO RECARGA LA MISMA URL)
    var url = 'DescargarArchivo.php?ruta=' + encodeURIComponent(Ruta) + '&archivo=' + encodeURIComponent(Archivo) + '&t=' + new Date().getTime();
    var marco = document.getElementById('marcoDescarga');
    if (!marco) {
        marco = document.createElement('iframe');
        marco.id = 'marcoDescarga';
        marco.style.display = 'none';
        document.body.appendChild(marco);
    }
    marco.src = url;
}


function asignarGEN_ARCHIVO(Codigo)
{
    var f = document.formularioGrid;
    var Pagina = f.Pagina.value;
    f.PIDEbuscado.value = Codigo;
//    alert (Pagina+'-'+f.PIDEbuscado.value);
    AjaxGeneraForm(Pagina, 'GeneraForm', 'formularioGrid', 'FormularioDiv');
}


function abrirHija_(PIDE)
{
    OcultaBOx();
    $.colorbox({width: "99%", height: "99%", iframe: true, escKey: false, overlayClose: false, href: "mainpage.php?Pagina=GEN_TABLAS&Accion=muestraVista&AccionLocal=2&PIDE=" + PIDE});
    $('#cboxClose').remove();
}


function addPadre(Boton)
{
    document.formulario.varBotonInvocador.value = Boton;

    OcultaBOx();
    $.colorbox({width: "99%", height: "99%", iframe: true, escKey: false, overlayClose: false, href: "mainpage.php?Pagina=GEN_COMUNIDAD&Accion=muestraVista&AccionLocal=2&Pedido=Busqueda"});
    $('#cboxClose').remove();
}
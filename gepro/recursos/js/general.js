function AbrirSNIP(CodigoSNIP)
{
     window.open("http://ofi2.mef.gob.pe/bp/ConsultarPIP/frmConsultarPIP.asp?txtCodigo="+CodigoSNIP+"&accion=consultar");
}
function replaceCaracter(text,busca,reemplaza)
{
  while (text.toString().indexOf(busca) != -1)
  {
      text = text.toString().replace(busca,reemplaza);
  }
  return text;
}
        
//LLAMADO A LISGTHBOX 
function AddControversia()
{
    $.colorbox({width:"65%", height:"75%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=Addcontroversia&Accion=muestraVista&AccionLocal=2"});
    $('#cboxClose').remove();
}

function AddCatalogo(Valor)
{
    $.colorbox({width:"65%", height:"75%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=Catalogolst&Accion=muestraVista&AccionLocal=2&Tipo="+Valor});
    $('#cboxClose').remove();
}

function AddExpedienteTecnicoSituacion(Valor)
{
    $.colorbox({width:"65%", height:"75%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=Addexpedientetecnicotituacion&Accion=muestraVista&AccionLocal=2&CodigoComponente="+Valor});
    $('#cboxClose').remove();
}

//LLAMADO A LAS FUNCIONES BÁSICAS
function Nuevo(Pagina)
{
    $("#tabs").tabs({disabled: [0]});
    $("#tabs").tabs({active: 1});
    LimpiarForm();
    $("#FormularioDiv").empty();
    AjaxGeneraForm(Pagina);
}

//ESTA FUNCION SE UTILIZA CUANDO DESDE UN TAB 2 LLAMO AL TAB 3 (METAS)
function Nuevo2(Pagina)
{
    $("#tabs").tabs({disabled: [0,1]});
    $("#tabs").tabs({active: 2});
    LimpiarForm();
    $("#FormularioDiv2").empty();
    AjaxGeneraForm2(Pagina);
}

//ESTA FUNCION SE UTILIZA CUANDO DESDE UN TAB 1 LLAMO AL TAB 3 (DOCUMENTOS, ALBUM, LIBRETA, DIRECTORIO)
function Nuevo3(Pagina)
{
    $("#tabs").tabs({disabled: [0,1]});
    $("#tabs").tabs({active: 2});
    $("#FormularioDiv").empty();
    $("#FormularioDiv2").empty();
    AjaxGeneraForm3(Pagina);
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

//ESTA FUNCION SE UTILIZA CUANDO DESDE UN FORM UBICADO EN EL TAB 3, REGRESA AL TAB 2
function Cancelar2()
{
    $("#tabs").tabs({disabled: [0,2]});
    $("#tabs").tabs({active: 1});
    LimpiarForm();
    $("#FormularioDiv2").empty();
}

function Cancelar3()
{
    $("#tabs").tabs({disabled: [0,2,3]});
    $("#tabs").tabs({active: 1});
    LimpiarForm();
    $("#FormularioDiv2").empty();
}

function CancelarFinal()
{
    $("#tabs").tabs({disabled: [1,2]});
    $("#tabs").tabs({active: 0});
    $("#FormularioDiv").empty();
}

function CancelarForm()
{
    $("#tabs").tabs({disabled: [1,2]});
    $("#tabs").tabs({active: 0});
    LimpiarFormCarpeta();
    $("#FormularioDiv").empty();
    $("#FormularioDiv2").empty();
}

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

//SE GRABA INFORMACIÓN Y DEL FORM3 PASA AL FORM2
function AjaxRegistraDatos2(pagina)
{
    $.ajax({
        type: "POST",
        url: "./mainpage.php?Pagina="+pagina+"&Accion=ProcesaMensaje&AccionLocal=1",
        //MANDO LOS VALORES POST DEL FORMULARIO GRID
        data: $("#formulario2").serialize(),
        beforeSend: function (XMLHttpRequest) {
        },
        success: function(msg)
        {
           CleanMensaje();
           $("#Mensajes").html(msg);
           Cancelar2();
           $('#flex2').flexReload();
        }
    });
}

//SE GRABA INFORMACIÓN Y DEL FORM3 PASA AL FORM1
function AjaxRegistraDatos3(pagina)
{
    var f = document.formulario2;
    $.ajax({
        type: "POST",
        url: "./mainpage.php?Pagina="+pagina+"&Accion=ProcesaMensaje&AccionLocal=1",
        //MANDO LOS VALORES POST DEL FORMULARIO GRID
        data: $("#formulario2").serialize(),
        beforeSend: function (XMLHttpRequest) {
        },
        success: function(msg)
        {
           CleanMensaje();
           $("#Mensajes").html(msg);
           if (f.CodigoPadre.value != '')
           {
                Cancelar2();
                $('#flex2').flexReload();
           }
           else
           {
               CancelarForm();
                $('#flex1').flexReload();
           }
        }
    });
}

function AjaxRegistraDatosTabs(pagina)
{
    var f   = document.formulario;
    var Val = f.CTipo.value;
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
           if (Val === 1)
           {
                Cancelar();
                $('#flex1').flexReload();
           }
        }
    });
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

function AjaxGeneraFormAjax(pagina,accion,formulario,div)
{   
    $.ajax({
        type: "POST",
        url: "./mainpage.php?Pagina="+pagina+"&Accion="+accion+"&AccionLocal=1",
        //MANDO LOS VALORES POST DEL FORMULARIO GRID
        data: $("#"+formulario).serialize(),
        beforeSend: function (XMLHttpRequest) {
        },
        success: function(msg)
        {
            //REEMPLAZO EL DIV INDICADO
           $("#"+div).html(msg);
        }
    });
}

//FUNCION UTILIZADA PARA LLAMAR A UN FORMULARIO EN EL TAB3 DESDE UN TAB2
function AjaxGeneraForm2(pagina)
{
    $.ajax({
        type: "POST",
        url: "./mainpage.php?Pagina="+pagina+"&Accion=GeneraForm&AccionLocal=1",
        //MANDO LOS VALORES POST DEL FORMULARIO GRID
        data: $("#formulario").serialize(),
        beforeSend: function (XMLHttpRequest) {
        },
        success: function(msg)
        {
            //REEMPLAZO EL DIV INDICADO
           $("#FormularioDiv2").html(msg);
        }
        
    });
}

//FUNCION UTILIZADA PARA LLAMAR A UN FORMULARIO EN EL TAB3 DESDE UN TAB1
function AjaxGeneraForm3(pagina)
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
           $("#FormularioDiv2").html(msg);
        }
        
    });
}

//FUNCION UTILIZADA PARA LLAMAR A UN FORMULARIO EN EL TAB4 DESDE UN TAB1
function AjaxGeneraForm4(pagina)
{
    $.ajax({
        type: "POST",
        url: "./mainpage.php?Pagina="+pagina+"&Accion=GeneraRegistroInformacion&AccionLocal=1",
        //MANDO LOS VALORES POST DEL FORMULARIO GRID
        data: $("#formularioGrid").serialize(),
        beforeSend: function (XMLHttpRequest) {
        },
        success: function(msg)
        {
            //REEMPLAZO EL DIV INDICADO
           $("#FormularioDiv3").html(msg);
        }
        
    });
}

//FUNCTION PARA GENERAR EL GRID
function AjaxGeneraGrid(pagina)
{
    $.ajax({
        type: "POST",
        url: "./mainpage.php?Pagina="+pagina+"&Accion=GeneraGrid&AccionLocal=1",
        //MANDO LOS VALORES POST DEL FORMULARIO GRID
        data: $("#formularioGrid").serialize(),
        beforeSend: function (XMLHttpRequest) {
        },
        success: function(msg)
        {
            //REEMPLAZO EL DIV INDICADO
           $("#FormularioDiv").html(msg);
           $("#FormularioDiv2").empty();
        }
        
    });
}

function AjaxProcesaDatos2(Pagina,Formulario)
{
    $.ajax({
        type: "POST",
        url: "./mainpage.php?Pagina="+Pagina+"&Accion=ProcesaMensaje&AccionLocal=1",
        //MANDO LOS VALORES POST DEL FORMULARIO GRID
        data: $("#"+Formulario).serialize(),
        beforeSend: function (XMLHttpRequest) {
        },
        success: function(msg)
        {
           CleanMensaje();
           $("#Mensajes").html(msg);
        }
    });
}

function EditarInformacion(Valor)
{
    var f                   = document.formularioGrid;
    var Pagina              = f.Pagina.value;
    f.ActionForm.value      = "ModificarRegistro";
    f.Codigo.value          = Valor;
    $("#tabs").tabs({disabled: [0]});
    $("#tabs").tabs({active: 1}); 
    AjaxGeneraForm(Pagina);
}

function EditarInformacion2(Valor)
{
    var f                   = document.formulario;
    var Pagina              = f.Pagina.value;
    f.ActionForm.value      = "ModificarRegistro";
    f.Codigo.value          = Valor;
    $("#tabs").tabs({disabled: [0,1]});
    $("#tabs").tabs({active: 2}); 
    AjaxGeneraForm2(Pagina);
}

function EditarInformacion3(Valor)
{
    var f                   = document.formularioGrid;
    var Pagina              = f.Pagina.value;
    f.ActionForm.value      = "ModificarRegistro";
    f.Codigo.value          = Valor;
    $("#tabs").tabs({disabled: [0,1]});
    $("#tabs").tabs({active: 2}); 
    AjaxGeneraForm3(Pagina);
}

function EliminarInformacion(Valor)
{
    var f                   = document.formularioGrid;
    var Pagina              = f.Pagina.value;
    if(confirm('¿Desea eliminar este registro?'))
    {
        f.ActionForm.value = "EliminaRegistro";
        f.Codigo.value = Valor;
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

function EliminarInformacion2(Valor)
{
    var f                   = document.formulario;
    var Pagina              = f.Pagina.value;
    if(confirm('¿Desea eliminar este registro?'))
    {
        f.ActionForm.value = "EliminaRegistro";
        f.Codigo.value = Valor;
        $.ajax({
        type: "POST",
        url: "./mainpage.php?Pagina="+Pagina+"&Accion=ProcesaMensaje&AccionLocal=1",
        data: $("#formulario").serialize(),
        beforeSend: function (XMLHttpRequest) {
        },
        success: function(msg)
        {
           CleanMensaje();
           $("#Mensajes").html(msg);
           Cancelar2();
           $('#flex2').flexReload();
        }
    });
    }
    else
    {
        return;
    }
}

function Verhistorial(Valor)
{
    $.colorbox({width: "95%", height: "95%", iframe: true, escKey: false, overlayClose: false, href: "mainpage.php?Pagina=Vermovimiento&Accion=muestraVista&AccionLocal=2&CProy=" + Valor});
    $('#cboxClose').remove();
}

function GetColumnSize2(percent)
{ 
    var div_ancho   = document.getElementById("datos2").offsetWidth;
    return (parseInt((div_ancho * percent)/100)-20);
}

function MostrarLibreta(Proyecto,IdLibretaPadre)
{
    $.colorbox({width:"95%", height:"95%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=Libretageneral&Accion=muestraVista&AccionLocal=2&CProyecto="+Proyecto+"&IdLibretaGeneralPadre="+IdLibretaPadre});    
    $('#cboxClose').remove();
}

function MostrarDocumento(Proyecto,IdDocumentoPadre)
{
    $.colorbox({width:"95%", height:"95%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=Documentogeneral&Accion=muestraVista&AccionLocal=2&CProyecto="+Proyecto+"&IdDocumentoGeneralPadre="+IdDocumentoPadre});    
    $('#cboxClose').remove();
}

function MostrarAlbum(Proyecto,IdAlbumPadre)
{
    $.colorbox({width:"95%", height:"95%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=Albumgeneral&Accion=muestraVista&AccionLocal=2&CProyecto="+Proyecto+"&IdAlbumGeneralPadre="+IdAlbumPadre});    
    $('#cboxClose').remove();
}

function MostrarDirectorio(Proyecto,IdDirectorioPadre)
{
    $.colorbox({width:"95%", height:"95%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=Directoriogeneral&Accion=muestraVista&AccionLocal=2&CProyecto="+Proyecto+"&IdDirectorioPadre="+IdDirectorioPadre});    
    $('#cboxClose').remove();
}

function AjaxRefreshDatosProyectos(pagina)
{
    $.ajax({
        type: "POST",
        url: "./mainpage.php?Pagina="+pagina+"&Accion=AjaxRefreshDatosProyectos&AccionLocal=1",
        //MANDO LOS VALORES POST DEL FORMULARIO GRID
        data: $("#formularioGrid").serialize(),
        beforeSend: function (XMLHttpRequest) {
        },
        success: function(msg)
        {
            //REEMPLAZO EL DIV INDICADO
           $("#DatosProyecto").html(msg);
        }
    });
}

function ProcesoSeleccion(Valor1,Valor2,Valor3)
{
    $.colorbox({width:"95%", height:"95%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=Addprocesoseleccion&Accion=muestraVista&AccionLocal=2&CProy="+Valor1+'&CTipo='+Valor2+'&CSComp='+Valor3});
    $('#cboxClose').remove();
}

function Contratocomponente(Valor,Valor2)
{
    $.colorbox({width: "95%", height: "95%", iframe: true, escKey: false, overlayClose: false, href: "mainpage.php?Pagina=Addcontratocomponente&Accion=muestraVista&AccionLocal=2&CProy=" + Valor + "&CTipo="+Valor2});
    $('#cboxClose').remove();
}

function FechasRestar(inicio, final)
{
    var aFecha1 = inicio.split('/');
    var aFecha2 = final.split('/');
    var fFecha1 = Date.UTC(aFecha1[2], aFecha1[1] - 1, aFecha1[0]);
    var fFecha2 = Date.UTC(aFecha2[2], aFecha2[1] - 1, aFecha2[0]);
    var dif = fFecha2 - fFecha1;
    var dias = Math.floor(dif / (1000 * 60 * 60 * 24));
    return dias + 1;
}

function AjaxProcesaDatos(Pagina,Formulario,Grid,NumAccion)
{
    $.ajax({
        type: "POST",
        url: "./mainpagegeneral.php?Pagina="+Pagina+"&Accion=ProcesaMensaje&AccionLocal="+NumAccion,
        //MANDO LOS VALORES POST DEL FORMULARIO GRID
        data: $("#"+Formulario).serialize(),
        beforeSend: function (XMLHttpRequest) {
        },
        success: function(msg)
        {
           CleanMensaje();
           $("#Mensajes").html(msg);
           $("#"+Grid).flexReload();
        }
    });
}

function AjaxGeneraFormulario(pagina,accion,formulario,div)
{   
    $.ajax({
        type: "POST",
        url: "./mainpage.php?Pagina="+pagina+"&Accion="+accion+"&AccionLocal=1",
        //MANDO LOS VALORES POST DEL FORMULARIO GRID
        data: $("#"+formulario).serialize(),
        beforeSend: function (XMLHttpRequest) {
        },
        success: function(msg)
        {
            //REEMPLAZO EL DIV INDICADO
           $("#"+div).html(msg);
        }
    });
}

function AjaxRecargaProyectoMain(Pagina,Formulario,Tab)
{
    $.ajax({
        type: "POST",
        url: "./mainpagegeneral.php?Pagina="+Pagina+"&Accion=ProyectoDatosMain&AccionLocal=100&CTabMain="+Tab,
        //MANDO LOS VALORES POST DEL FORMULARIO GRID
        data: $("#"+Formulario).serialize(),
        beforeSend: function (XMLHttpRequest) {
        },
        success: function(msg)
        {
           $("#DatosProyectoMain").html(msg);
        }
    });
}
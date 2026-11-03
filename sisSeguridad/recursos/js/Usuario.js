function TipoDocumento(valor)
{
    var f  = document.formulario;
    /////PROVIENE DEL FORMULARIO DE RECEPCION DEL TAB 1 o DE REGISTRO DE TRABAJADOR EN BUSQUEDA
    if (valor == 1)
    {
        f.DniBusqueda.disabled = false;
        f.DniBusqueda.value = "";
        f.DniBusqueda.focus();
        var valorDocumento  = $("#TipDocumBusqueda option:selected").html();
        if ((valorDocumento == "") || (valorDocumento == 0))
        {
            f.DniBusqueda.disabled = true;
        }
        if (valorDocumento == "DOCUMENTO  NACIONAL DE IDENTIDAD")
        {
            f.DniBusqueda.maxLength = 8;
        }
        if (valorDocumento == "CARNET DE EXTRANJERIA")
        {
            f.DniBusqueda.maxLength = 12;
        }
        if (valorDocumento == "PASAPORTE")
        {
            f.DniBusqueda.maxLength = 12;
        }
    }
}
function TipoBusqueda()
{
    var f = document.formulario;
    if (f.TipBusk.value == 0)
    {
        $("#BuskDNI").hide();
    }
    if (f.TipBusk.value == 1)
    {
        $("#BuskDNI").hide();
        $("#BuskDNI").toggle(200);
        f.DniBusqueda.focus();
    }
}

function buscarVisitanteUp(valor1,valor2,e)
{
    var valorDocumento  = $("#TipDocumBusqueda option:selected").html();
    if (valorDocumento == 'DOCUMENTO  NACIONAL DE IDENTIDAD') 
    {
        $('#DniBusqueda').attr("maxlength", "8");
        $('#DniBusqueda').attr("minlength", "8");
        $('#DniBusqueda').attr("required", "required");
    };
    
    if ((valorDocumento == 'CARNET DE EXTRANJERIA') || (valorDocumento == 'PASAPORTE'))
    {        
        $('#DniBusqueda').attr("maxlength", "12");
        $('#DniBusqueda').attr("minlength", "12");
        $('#DniBusqueda').attr("required", "required");
    };
    
    if (valorDocumento == 'DOCUMENTO  NACIONAL DE IDENTIDAD') 
    {
         if ($('#DniBusqueda').val().length<8)
         {
             alert('El DNI no tiene 8 digitos');
             return false;
         }
    }
    if ((valorDocumento == 'CARNET DE EXTRANJERIA') || (valorDocumento == 'PASAPORTE'))
    {
         if ($('#DniBusqueda').val().length<12)
         {
             alert('El documento no tiene 12 digitos');
             return false;
         }
    }
    var f  = document.formulario;
    if (valor1 == 1)
    {
        if (valor2 == 1)
        {
            if (f.TipDocumBusqueda.value == 0)
            {
                alert("Seleccione el tipo de Documento"); 
                return;
            }
            if ((f.DniBusqueda.value == "") || (f.DniBusqueda.value == 0))
            {
                alert("Ingrese el número de documento"); 
                f.DniBusqueda.focus(); 
                return;
            }
        }
        f.ActionForm.value = "BuscarVisitaForm";
        //f.submit();
    }
}

function buscarVisitanteEnter(e)
{
    var valorDocumento  = $("#TipDocumBusqueda option:selected").html();
    if (valorDocumento == 'DOCUMENTO  NACIONAL DE IDENTIDAD') 
    {
        $('#DniBusqueda').attr("maxlength", "8");
        $('#DniBusqueda').attr("minlength", "8");
        $('#DniBusqueda').attr("required", "required");
        var key = nav4 ? e.which : e.keyCode;
        if ( (key <= 13 || (key >= 48 && key <= 57) || key == 46)==false){
            return (key <= 13 || (key >= 48 && key <= 57) || key == 46);
        };
    };
    
    if ((valorDocumento == 'CARNET DE EXTRANJERIA') || (valorDocumento == 'PASAPORTE'))
    {        
        $('#DniBusqueda').attr("maxlength", "12");
        $('#DniBusqueda').attr("minlength", "12");
        $('#DniBusqueda').attr("required", "required");
    };
    
    var f  = document.formulario;
    
    if (key == 13)
    {
        if (f.TipDocumBusqueda.value == 0)
        {
            alert("Seleccione el tipo de Documento"); 
            return;
        }
        if ((f.DniBusqueda.value == "") || (f.DniBusqueda.value == 0))
        {
            alert("Ingrese el número de documento"); 
            f.DniBusqueda.focus(); 
            return;
        }
        f.ActionForm.value = "BuscarVisitaForm";
        //f.submit();
    }
}

//FUNCION PARA VALIDAR LOS DATOS DE LOS VISITANTES
function buscarVisitante(valor1,valor2)
{
    var valorDocumento  = $("#TipDocumBusqueda option:selected").html();
    var f  = document.formulario;
    var ext;
    if (valor1 == 1)
    {
        if (valor2 == 1)
        {
            if (valorDocumento == 'DOCUMENTO  NACIONAL DE IDENTIDAD')
            {
                ext = 8;
            }
            if ((valorDocumento == 'CARNET DE EXTRANJERIA') || (valorDocumento == 'PASAPORTE'))
            {
                ext = 12;
            }
            ext = parseInt(ext);
            if (f.TipDocumBusqueda.value == 0)
            {
                alert("Seleccione el tipo de Documento"); 
                return;
            }
            if ((f.DniBusqueda.value == "") || (f.DniBusqueda.value == 0))
            {
                alert("Ingrese el número de documento"); 
                f.DniBusqueda.focus(); 
                return;
            }
            if (f.DniBusqueda.value.length < ext)
            {
                alert("Ingrese adecuadamente el número de documento"); 
                f.DniBusqueda.focus(); 
                return;
            }
        }
        f.ActionForm.value = "BuscarVisitaForm";
        f.submit();
    }
}

function CancelarRecepcion()
{
   $("#FormBusqueda2").hide();
   $("#FormBusqueda").toggle(200);
   $("#DniBusqueda" ).focus();
}

function EditarUsuario(Codigo)
{
    var f = document.formularioGrid;
    f.ActionForm.value = "ModificaUsuario";
    f.Codigo.value = Codigo;
    f.submit();
}

function ReiniciaClave(Codigo)
{
    var f = document.formularioGrid;
    if(confirm('¿Desea reiniciar la clave para este Usuario?'))
    { 
        f.ActionForm.value = "ReiniciaClave";
        f.Codigo.value = Codigo;
        f.submit();
    }
    else 
    { 
        return;
    }
}

function EliminarUsuario(Codigo,CodigoPR)
{
    var f = document.formularioGrid;
    if(confirm('¿Desea eliminar este registro?'))
    { 
        f.ActionForm.value = "EliminaUsuario";
        f.Codigo.value = Codigo;
        f.CodigoT.value = CodigoPR;
        f.submit();
    }
    else 
    { 
        return;
    }
}

function AgregarPerfil(Codigo)
{
    $.colorbox({width:"100%", height:"100%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=Addusuarioperfil&Accion=muestraVista&AccionLocal=1&Codigo="+Codigo});
    $('#cboxClose').remove();
}

function AgregarUE(PIDE_USUARIO)
{
   //OcultaBOx();
   $.colorbox({width: "100%", height: "100%", iframe: true, escKey: false, overlayClose: false, href: "mainpage.php?Pagina=SEG_ENTIDAD_USUARIO&Accion=muestraVista&AccionLocal=2&PIDE_USUARIO=" + PIDE_USUARIO});
   $('#cboxClose').remove();    
}


function AsignarPerfil(Modulo)
{
    var f = document.formularioGrid;
    f.ActionForm.value = "AsignaPerfil";
    f.CodigoM.value = Modulo;
    f.submit();
}

function AsignarUsuarioPerfil(Perfil)
{
    var f = document.formularioGrid2;
    f.ActionForm.value = "AsignaUsuarioPerfil";
    f.CodigoP.value = Perfil;
    f.submit();
}

function EliminarUsuarioPerfil(Perfil)
{
    var f = document.formularioGrid2;
    if(confirm('¿Desea eliminar este registro?'))
    { 
        f.ActionForm.value = "EliminaUsuarioPerfil";
        f.CodigoP.value = Perfil;
        f.submit();
    }
    else 
    { 
        return;
    }
}
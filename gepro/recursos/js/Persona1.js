function cancelarBusqueda()
{
    $("#FormBusqueda").show(200);
    $("#FormularioDiv").empty();
    $("#DniBusqueda").focus();
}

function TipoBusqueda()
{
    var f = document.formulario;
    if (f.TipBusk.value === "0")
    {
        $("#BuskDNI").hide();
        $("#BuskDATOSPERSONA").hide();
        f.DniBusqueda.disabled = true;
        f.ApellidoPaterno.disabled = true;
        f.ApellidoMaterno.disabled = true;
        f.Nombres.disabled = true;
        f.BuscarPersona.disabled = true;
        f.BuscarDNI.disabled = true;
    }
    else
    {
        if (f.TipBusk.value === "1")
        {
            $("#BuskDATOSPERSONA").hide();
            $("#BuskDNI").show(200);
            f.DniBusqueda.disabled = false;
            f.ApellidoPaterno.disabled = true;
            f.ApellidoMaterno.disabled = true;
            f.Nombres.disabled = true;
            f.BuscarPersona.disabled = true;
            f.BuscarDNI.disabled = false;
            f.DniBusqueda.focus();
        }
        else
        {
            if (f.TipBusk.value === "2")
            {
                $("#BuskDNI").hide();
                $("#BuskDATOSPERSONA").show(200);
                f.DniBusqueda.disabled = true;
                f.ApellidoPaterno.disabled = false;
                f.ApellidoMaterno.disabled = false;
                f.Nombres.disabled = false;
                f.BuscarPersona.disabled = false;
                f.BuscarDNI.disabled = true;
                f.ApellidoPaterno.focus();
            }
        }
    }
}

//ESTABLECE LOS VALORES PARA EL DOCUMENTO DE IDENTIDAD//
function TipoDocumento(valor)
{
    var f  = document.formulario;
    /////PROVIENE DEL FORMULARIO DE RECEPCION DEL TAB 1 o DE REGISTRO DE TRABAJADOR EN BUSQUEDA
    if (valor === 1)
    {
        f.DniBusqueda.disabled = false;
        f.DniBusqueda.value = "";
        f.DniBusqueda.focus();
        var valorDocumento  = $("#TipDocumBusqueda option:selected").html();
        if ((valorDocumento === "") || (valorDocumento === 0))
        {
            f.DniBusqueda.disabled = true;
        }
        if (valorDocumento === "DOCUMENTO  NACIONAL DE IDENTIDAD")
        {
            f.DniBusqueda.maxLength = 8;
        }
        if (valorDocumento === "CARNET DE EXTRANJERIA")
        {
            f.DniBusqueda.maxLength = 12;
        }
        if (valorDocumento === "PASAPORTE")
        {
            f.DniBusqueda.maxLength = 12;
        }
    }
    if (valor === 2)
    {
        f.DniReg.disabled = false;
        f.DniReg.value = "";
        f.DniReg.focus();
        var valorDocumento  = $("#TipDocumReg option:selected").html();
        if (f.TipDocumReg.value === "")
        {
            f.DniReg.disabled = true;
        }
        if ((valorDocumento === "") || (valorDocumento === 0))
        {
            f.DniReg.disabled = true;
        }
        if (valorDocumento === "DOCUMENTO  NACIONAL DE IDENTIDAD")
        {
            f.DniReg.maxLength = 8;
        }
        if (valorDocumento === "CARNET DE EXTRANJERIA")
        {
            f.DniReg.maxLength = 12;
        }
        if (valorDocumento === "PASAPORTE")
        {
            f.DniReg.maxLength = 12;
        }
    }
}

function buscarVisitanteUp(Tipo)
{
    if (Tipo === 1)
    {
        var valorDocumento  = $("#TipDocumBusqueda option:selected").html();
        if (valorDocumento === 'DOCUMENTO  NACIONAL DE IDENTIDAD') 
        {
            $('#DniBusqueda').attr("maxlength", "8");
            $('#DniBusqueda').attr("minlength", "8");
            $('#DniBusqueda').attr("required", "required");
        };

        if ((valorDocumento === 'CARNET DE EXTRANJERIA') || (valorDocumento === 'PASAPORTE'))
        {        
            $('#DniBusqueda').attr("maxlength", "12");
            $('#DniBusqueda').attr("minlength", "12");
            $('#DniBusqueda').attr("required", "required");
        };

        if (valorDocumento === 'DOCUMENTO  NACIONAL DE IDENTIDAD') 
        {
             if ($('#DniBusqueda').val().length<8)
             {
                 alert('El DNI no tiene 8 digitos');
                 return false;
             }
        }
        if ((valorDocumento === 'CARNET DE EXTRANJERIA') || (valorDocumento === 'PASAPORTE'))
        {
             if ($('#DniBusqueda').val().length<12)
             {
                 alert('El documento no tiene 12 digitos');
                 return false;
             }
        }
        var f  = document.formulario;
        if (f.TipDocumBusqueda.value === 0)
        {
            alert("Seleccione el tipo de Documento"); 
            return;
        }
        if ((f.DniBusqueda.value === "") || (f.DniBusqueda.value === 0))
        {
            alert("Ingrese el número de documento"); 
            f.DniBusqueda.focus(); 
            return;
        }
        f.ActionForm.value = "BuscarVisitaForm";
    }
    if (Tipo === 2)
    {
        var valorDocumento  = $("#TipDocumReg option:selected").html();
        if (valorDocumento === 'DOCUMENTO  NACIONAL DE IDENTIDAD') 
        {
            $('#DniReg').attr("maxlength", "8");
            $('#DniReg').attr("minlength", "8");
            $('#DniReg').attr("required", "required");
        };

        if ((valorDocumento === 'CARNET DE EXTRANJERIA') || (valorDocumento === 'PASAPORTE'))
        {        
            $('#DniReg').attr("maxlength", "12");
            $('#DniReg').attr("minlength", "12");
            $('#DniReg').attr("required", "required");
        };

        if (valorDocumento === 'DOCUMENTO  NACIONAL DE IDENTIDAD') 
        {
             if ($('#DniReg').val().length<8)
             {
                 alert('El DNI no tiene 8 digitos');
                 return false;
             }
        }
        if ((valorDocumento === 'CARNET DE EXTRANJERIA') || (valorDocumento === 'PASAPORTE'))
        {
             if ($('#DniReg').val().length<12)
             {
                 alert('El documento no tiene 12 digitos');
                 return false;
             }
        }
        var f  = document.formulario;
        if (f.TipDocumReg.value === 0)
        {
            alert("Seleccione el tipo de Documento"); 
            return;
        }
        if ((f.DniReg.value === "") || (f.DniReg.value === 0))
        {
            alert("Ingrese el número de documento"); 
            f.DniReg.focus(); 
            return;
        }
    }
}

function buscarVisitanteEnter(e,Tipo)
{
    var key = nav4 ? e.which : e.keyCode;
    if (Tipo === 1)
    {
        var valorDocumento  = $("#TipDocumBusqueda option:selected").html();
        if (valorDocumento === 'DOCUMENTO  NACIONAL DE IDENTIDAD') 
        {
            $('#DniBusqueda').attr("maxlength", "8");
            $('#DniBusqueda').attr("minlength", "8");
            $('#DniBusqueda').attr("required", "required");
            if ( (key <= 13 || (key >= 48 && key <= 57) || key === 46)===false){
                return (key <= 13 || (key >= 48 && key <= 57) || key === 46);
            };
        };

        if ((valorDocumento === 'CARNET DE EXTRANJERIA') || (valorDocumento === 'PASAPORTE'))
        {        
            $('#DniBusqueda').attr("maxlength", "12");
            $('#DniBusqueda').attr("minlength", "12");
            $('#DniBusqueda').attr("required", "required");

            if ((key <= 13 || (key >=48 && key <=57) || key === 46 || key === 27 || (key > 64 && key < 91) || (key > 96 && key < 123)) === false)
            {
                return (key <= 13 || (key >=48 && key <=57) || key === 46 || key === 27 || (key > 64 && key < 91) || (key > 96 && key < 123));
            }
        };

        var f  = document.formulario;
        if (key === 13)
        {
            if (f.TipDocumBusqueda.value === 0)
            {
                alert("Seleccione el tipo de Documento"); 
                return;
            }
            if ((f.DniBusqueda.value === "") || (f.DniBusqueda.value === 0))
            {
                alert("Ingrese el número de documento"); 
                f.DniBusqueda.focus(); 
                return;
            }
            f.ActionForm.value = "BuscarVisitaForm";
        }
    }
    if (Tipo === 2)
    {
        var valorDocumento  = $("#TipDocumReg option:selected").html();
        if (valorDocumento === 'DOCUMENTO  NACIONAL DE IDENTIDAD') 
        {
            $('#DniReg').attr("maxlength", "8");
            $('#DniReg').attr("minlength", "8");
            $('#DniReg').attr("required", "required");
            if ( (key <= 13 || (key >= 48 && key <= 57) || key === 46)===false){
                return (key <= 13 || (key >= 48 && key <= 57) || key === 46);
            };
        };

        if ((valorDocumento === 'CARNET DE EXTRANJERIA') || (valorDocumento === 'PASAPORTE'))
        {        
            $('#DniReg').attr("maxlength", "12");
            $('#DniReg').attr("minlength", "12");
            $('#DniReg').attr("required", "required");

            if ((key <= 13 || (key >=48 && key <=57) || key === 46 || key === 27 || (key > 64 && key < 91) || (key > 96 && key < 123)) === false)
            {
                return (key <= 13 || (key >=48 && key <=57) || key === 46 || key === 27 || (key > 64 && key < 91) || (key > 96 && key < 123));
            }
        };
    }
}

////FUNCION PARA VALIDAR LOS DATOS DE LOS VISITANTES
function buscarVisitante()
{
    var valorDocumento  = $("#TipDocumBusqueda option:selected").html();
    var f  = document.formulario;
    var ext;
    if (valorDocumento === 'DOCUMENTO  NACIONAL DE IDENTIDAD')
    {
        ext = 8;
    }
    if ((valorDocumento === 'CARNET DE EXTRANJERIA') || (valorDocumento === 'PASAPORTE'))
    {
        ext = 12;
    }
    ext = parseInt(ext);
    if (f.TipDocumBusqueda.value === 0)
    {
        alert("Seleccione el tipo de Documento"); 
        return;
    }
    if ((f.DniBusqueda.value === "") || (f.DniBusqueda.value === 0))
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

function ProcesarBusqueda()
{
    var f                   = document.formulario;
    var Pagina              = f.Pagina.value;
    f.ActionForm.value      = "ProcesarBusqueda";
    AjaxGeneraForm(Pagina,'GeneraForm','formulario','FormularioDiv');
}

function AsignarPersona(Codigo)
{
    var f                   = document.formulario;
    var Pagina              = f.Pagina.value;
    f.Codigo.value          = Codigo;
    f.ActionForm.value      = "AsignarPersona";
    AjaxGeneraForm(Pagina,'AsignaForm','formulario','FormularioDiv');
    f.Codigo.value          = "";
}

function AsignarPersonaReniec(Codigo)
{
    var f                   = document.formulario;
    var Pagina              = f.Pagina.value;
    f.CDi.value             = Codigo;
    f.ActionForm.value      = "AsignarPersonaReniec";
    AjaxGeneraForm(Pagina,'AsignaForm','formulario','FormularioDiv');
    f.CDi.value             = "";
}

function RegistrarPersona()
{
    var f                   = document.formulario;
    var Pagina              = f.Pagina.value;
    f.ActionForm.value      = "RegistraPersona";
    AjaxGeneraForm(Pagina,'AsignaForm','formulario','FormularioDiv');
    //ReturnPrincipal();
}

function NoFounds()
{
    var f                   = document.formulario;
    var Pagina              = f.Pagina.value;
    f.ActionForm.value      = "ProcesarNoEncontrado";
    AjaxGeneraForm(Pagina,'GeneraForm','formulario','FormularioDiv');
}
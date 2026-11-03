function salir()
{
var f = document.formulario;
f.action = "mainpage.php";
f.Pagina.value = "";
f.submit();
}

function CerrarBoton(tipoForm)
{
    if (tipoForm == 1)
    {
        var f  = document.formulario;
    }
    f.BtnConfirmar.disabled = true;
}

//ESTABLECE LOS VALORES PARA EL DOCUMENTO DE IDENTIDAD//
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
function AgregarPersona(Codigo,Persona)
{
    var f          = parent.document.formulario;
    var count      = parent.$('#CountVisitantes').val();
    var rVisitante = parent.$('#CodigoVisitante1').val();
    if ((count == 1) && (rVisitante == ""))
    {
        var contador = parseInt(count) + 1;
        f.CountVisitantes.value  = contador;  
        f.RegVisitante1.value    = Persona;    
        f.CodigoVisitante1.value = Codigo;
    }
    else
    {
        var contador = parseInt(count) + 1;
        parent.$('#GrupoVisitantes').append('<div id="Grupo'+contador+'"><input value="'+Persona+'" onKeyUp="this.value = this.value.toUpperCase();" readonly="" type="text" name="RegVisitante'+contador+'" id="RegVisitante'+contador+'" class="input-xlarge alphanumeric required show-popover" data-trigger="hover" data-content="Ingrese los datos del Visitante"/><input type="hidden" name="CodigoVisitante'+contador+'" class="required" title=" " id="CodigoVisitante'+contador+'" value="'+Codigo+'">&nbsp;<input name="Submit2" type="button" value="" id="eliminar16" title="Eliminar Información" onclick="DeltxtVisitantes('+contador+')"/></div>');
        parent.$('#CountVisitantes').val(parseInt(count) + 1);
    }
    cerrarPopup();
}
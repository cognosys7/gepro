function AddAcceso(Opcion,Perfil)
{
    var f = document.formularioGrid;
    f.ActionForm.value = "AgregarAcceso";
    f.IO.value = Opcion;
    f.IP.value = Perfil;
    f.submit();
}

function QuitarAcceso(Opcion,Perfil)
{
    var f = document.formularioGrid;
    if(confirm('¿Desea eliminar este registro?'))
    { 
        f.ActionForm.value = "QuitarAcceso";
        f.IO.value = Opcion;
        f.IP.value = Perfil;
        f.submit();
    }
    else 
    { 
        return;
    }
}

function AgregarAcceso(Opcion,Modulo)
{
    $.colorbox({width:"99%", height:"99%", iframe:true, escKey: false,overlayClose: false, href:"mainpage.php?Pagina=AddAcceso&Accion=muestraVista&AccionLocal=1&IP="+Opcion+"&IM="+Modulo});
    $('#cboxClose').remove();
}
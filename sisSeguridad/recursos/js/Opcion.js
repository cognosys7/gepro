function EditarOpcion(Codigo)
{
    var f = document.formularioGrid;
    f.ActionForm.value = "ModificaOpcion";
    f.Codigo.value = Codigo;
    f.submit();
}

function EliminarOpcion(Codigo)
{
    var f = document.formularioGrid;
    if(confirm('¿Desea eliminar este registro?'))
    { 
        f.ActionForm.value = "EliminaOpcion";
        f.Codigo.value = Codigo;
        f.submit();
    }
    else 
    { 
        return;
    }
}

function cambiaEstado(Tipo)
{
    var f = document.formulario;
    if (Tipo == 1)
    {
        f.cboOpcionPadre.disabled = true;
    }
    else
    {
        f.cboOpcionPadre.disabled = false;
    }
}

function SubirBajar(Codigo,Valor)
{
    var f = document.formularioGrid;
    f.ActionForm.value = "SubirBajar";
    f.Codigo.value = Codigo;
    f.TipoSubBaj.value = Valor;
    f.submit();
}
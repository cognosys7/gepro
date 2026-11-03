function EditarPerfil(Codigo)
{
    var f = document.formularioGrid;
    f.ActionForm.value = "ModificaPerfil";
    f.Codigo.value = Codigo;
    f.submit();
}

function EliminarPerfil(Codigo)
{
    var f = document.formularioGrid;
    if(confirm('¿Desea eliminar este registro?'))
    { 
        f.ActionForm.value = "EliminaPerfil";
        f.Codigo.value = Codigo;
        f.submit();
    }
    else 
    { 
        return;
    }
    
}
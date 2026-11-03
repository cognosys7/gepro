function EditarSistema(CodigoS,CodigoM)
{
    var f = document.formularioGrid;
    f.ActionForm.value = "ModificaSistema";
    f.CodigoS.value = CodigoS;
    f.CodigoM.value = CodigoM;
    f.submit();
}

function EliminarSistema(CodigoS,CodigoM)
{
    var f = document.formularioGrid;
    if(confirm('¿Desea eliminar este registro?'))
    { 
        f.ActionForm.value = "EliminaSistema";
        f.CodigoS.value = CodigoS;
        f.CodigoM.value = CodigoM;
        f.submit();
    }
    else 
    { 
        return;
    }
    
}
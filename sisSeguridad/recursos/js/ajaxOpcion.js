function AjaxOpcionList(pagina)
{ 
    var resultado  = "";
    var tipoOpcion = document.getElementsByName("tipoOpcion");
    document.getElementById('cboOpcionPadre').options.length = null;
    
    var itemSelected = document.getElementById('cboModulo').selectedIndex; 
    var id = document.getElementById('cboModulo').options[itemSelected].value;
    for(var i=0;i<tipoOpcion.length;i++)
    {
        if(tipoOpcion[i].checked)
        {
            resultado = tipoOpcion[i].value;
        }
    }
    $.ajax({
        type: "GET",
        url: "./mainpage.php?Pagina="+pagina+"&AccionLocal=1&Accion=LoadOpcionesMainAjax&Id="+id+"&TipOpc="+resultado,
        beforeSend: function (XMLHttpRequest) {
        // AjaxLoading("#dvCreateFolderContent");
        },
        success: function(msg)
        {
            $("#divOpcionPrincipal").html(msg);
        }
    });
}
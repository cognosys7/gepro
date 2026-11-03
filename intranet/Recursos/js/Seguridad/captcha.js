function randomnum()
{
    var number1   = 3;
    var number2   = 10;
    var randomnum = (parseInt(number2) - parseInt(number1)) + 1;
    var rand1     = Math.floor(Math.random() * randomnum) + parseInt(number1);
    var rand2     = Math.floor(Math.random() * randomnum) + parseInt(number1);
    var total     = rand1 * rand2;
    $(".rand1").html(rand1);
    $(".rand2").html(rand2);
    $('#pCaptcha').val(total);
}

$(document).ready(function() 
{
    $(".re").click(function() 
    {
        randomnum();
    });
    $("#submit").click(function() 
    {
        var total = parseInt($('.rand1').html()) * parseInt($('.rand2').html());
        var total1 = $('#LoginForm_total').val();
        var Usuario = $('#LoginForm_username').val();
        var Clave   = $('#LoginForm_password').val();
        if (Usuario == "")
        {
            alert("Ingrese su Usuario de acceso");
            $('#LoginForm_username').focus(); return false;
        }
        if (Clave == "")
        {
            alert("Ingrese su Clave de acceso");
            $('#LoginForm_password').focus(); return false;
        }
        if (total != total1)
        {
            alert("Ingrese una respuesta a la Pregunta secreta");
            $('#LoginForm_total').val("");
            $('#LoginForm_total').focus();
            randomnum();
            return false;
        }
        $("#ActionForm").val("Verificar");
    });
    $("#submit2").click(function() 
    {
        var total = parseInt($('.rand1').html()) * parseInt($('.rand2').html());
        var total1 = $('#LoginForm_total').val();
        var DNI    = $('#LoginForm_DNI').val();
        if (DNI == "")
        {
            alert("Ingrese su número de DNI");
            $('#LoginForm_DNI').focus(); return false;
        }
        if (total != total1)
        {
            alert("Ingrese una respuesta a la Pregunta secreta");
            $('#LoginForm_total').val("");
            $('#LoginForm_total').focus();
            randomnum();
            return false;
        }
        $("#ActionForm").val("Recuperar");
    });
    $("#submitCancelar").click(function() 
    {
        $("#ActionForm").val("CancelarRecuperacion");
    });
    $("#submitSiguiente").click(function() 
    {
        var total = parseInt($('.rand1').html()) * parseInt($('.rand2').html());
        var total1 = $('#LoginForm_total').val();
        var DNI    = $('#LoginForm_DNI').val();
        var a = 0, rdbtn=document.getElementsByName("valsec");
//        alert(total+" - "+total1)
        for(i=0;i<rdbtn.length;i++) 
        {
            if(rdbtn.item(i).checked == false) 
            {
                a++;
            }
        }
        if(a == rdbtn.length) 
        {
            alert("Porfavor, seleccione su imagen de Seguridad"); return false;
        }
        if (DNI == "")
        {
            alert("Ingrese su número de DNI");
            $('#LoginForm_DNI').focus(); return false;
        }
        if (total != total1)
        {
            alert("Ingrese una respuesta a la Pregunta secreta");
            $('#LoginForm_total').val("");
            $('#LoginForm_total').focus();
            randomnum();
            return false;
        }
        $("#ActionForm").val("InciarRecuperacion");
    });
    randomnum();
});
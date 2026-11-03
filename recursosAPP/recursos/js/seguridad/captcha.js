function randomnum()
{
    var number1   = 5;
    var number2   = 10;
    var randomnum = (parseInt(number2) - parseInt(number1)) + 1;
    var rand1     = Math.floor(Math.random() * randomnum) + parseInt(number1);
    var rand2     = Math.floor(Math.random() * randomnum) + parseInt(number1);
    var total     = rand1 + rand2;
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
    randomnum();
});
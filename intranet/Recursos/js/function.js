//////////DESHABILITO TECLAS FUNCIONALES DEL TECLADO//////////
//117->f6
//116->f5
//122->f11 
document.onkeydown = function(e)
{
    if(e)
    document.onkeypress = function()
    {
        return true;
    }
    var evt = e?e:event;
    /////////////////////////F5 Y F11/////////////////////////////
    if((evt.keyCode==86 && evt.ctrlKey) || evt.keyCode==37 || evt.keyCode==38 || evt.keyCode==39 || evt.keyCode==40 || evt.keyCode==112 || evt.keyCode==118 || evt.keyCode==116 || evt.keyCode==117 || evt.keyCode==122)
    {
        if(e)
        document.onkeypress = function()
        {
            return false;
        }
        else
        {
            evt.keyCode = 0;
            evt.returnValue = false;
        }
    }
} 

/////////DESHABILITO LICK DERECHO DEL MOUSE/////////////
document.oncontextmenu = function() 
{
    return false
}
//Begin
function disableselect(e)
{
    return false
}
function reEnable()
{
    return true
}

document.onselectstart=new Function ("return false")
if (window.sidebar)
{
    document.onmousedown=disableselect
    document.onclick=reEnable
}

document.onselectstart=function()
{
    return false
};

//Firefox cambia
if (window.sidebar)
{
    document.onmousedown=function(e){
        var obj=e.target;
        if ((obj.tagName=="INPUT")||(obj.tagName=="TEXTAREA"))
        {
            return true;
        }
        else if (obj.tagName=="BUTTON")
        {
            return true;
        }
        return true;
    }
}

function conMayusculas(field) {
    field.value = field.value.toUpperCase()
}

$(document).ready(function(){
    $(document).keydown(function(event) {
        if (event.ctrlKey==true && (event.which == '118' || event.which == '86')) {
            //alert('thou. shalt. not. PASTE!');
            event.preventDefault();
         }
    });
});
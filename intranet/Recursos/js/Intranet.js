function verCumples()
{
    var h = screen.height-400;
    var w = screen.width-560;
    window.open("Antirefresh.php?Pagina=Cumples&Accion=muestraVista&AccionLocal=1", 'winCumples','resizable=yes,scrollbars=yes,toolbar=yes,menubar=yes,location=yes, width='+w+',height='+h);
}
function verDirectorio()
{
    var h = screen.height-400;
    var w = screen.width-560;
    window.open("Antirefresh.php?Pagina=Directorio&Accion=muestraVista&AccionLocal=1", 'winDirectorios','resizable=yes,scrollbars=yes,toolbar=yes,menubar=yes,location=yes, width='+w+',height='+h);
}
function verDirectorioEmergencias()
{
    var h = screen.height-400;
    var w = screen.width-560;
    window.open("Antirefresh.php?Pagina=Directorioemergencia&Accion=muestraVista&AccionLocal=1", 'winEmergencias','resizable=yes,scrollbars=yes,toolbar=yes,menubar=yes,location=yes, width='+w+',height='+h);
}
function verFormatos()
{
    var h = screen.height-400;
    var w = screen.width-560;
    window.open("Antirefresh.php?Pagina=Formatos&Accion=muestraVista&AccionLocal=1", 'winFormatos','resizable=yes,scrollbars=yes,toolbar=yes,menubar=yes,location=yes, width='+w+',height='+h);
}
function verFormatosConvenios()
{
    var h = screen.height-400;
    var w = screen.width-560;
    window.open("Antirefresh.php?Pagina=Formatosconvenios&Accion=muestraVista&AccionLocal=1", 'winFormatosConvenios',  'resizable=yes,scrollbars=yes,toolbar=yes,menubar=yes,location=yes, width='+w+',height='+h);
}
function verFechasPago()
{
    var h = screen.height-400;
    var w = screen.width-560;
    window.open("http://www.bn.com.pe/cronograma-pagos.html", 'winPagos',  'resizable=yes,scrollbars=yes,toolbar=yes,menubar=yes,location=yes, width='+w+',height='+h);
}
function verFeriados()
{
    var h = screen.height-400;
    var w = screen.width-560;
    window.open("Antirefresh.php?Pagina=Feriados&Accion=muestraVista&AccionLocal=1", 'winFeriados',  'resizable=yes,scrollbars=yes,toolbar=yes,menubar=yes,location=yes, width='+w+',height='+h);
}
function verUIT()
{
    var h = screen.height-400;
    var w = screen.width-560;
    window.open("http://www.sunat.gob.pe/indicestasas/uit.html", 'winUIT',  'resizable=yes,scrollbars=yes,toolbar=yes,menubar=yes,location=yes, width='+w+',height='+h);
}
function openNoticias(Valor)
{
    var h = screen.height-400;
    var w = screen.width-560;
    window.open("Antirefresh.php?Pagina=Noticia&Accion=muestraVista&AccionLocal=1&CNoticia="+Valor, 'winNoticias',  'resizable=yes,scrollbars=yes,toolbar=yes,menubar=yes,location=yes, width='+w+',height='+h);
}
function openConfig(Pagina)
{
    var h = screen.height-400;
    var w = screen.width-560;
    window.open("Antirefresh.php?Pagina="+Pagina, 'winConfig',  'resizable=yes,scrollbars=yes,toolbar=yes,menubar=yes,location=yes, width='+w+',height='+h);
}
function openSistemas(Pagina)
{
    var h = screen.height-400;
    var w = screen.width-560;
    window.open(Pagina, 'winSistema'+Pagina,  'resizable=yes,scrollbars=yes,toolbar=yes,menubar=yes,location=yes, width='+w+',height='+h);
}

function contador_regresivo(d, h, m, s)
{
    var f = document.formulario;
    var interval = setInterval(function(){
    if(s > 0) { s--; }
    else
    {
        if (m > 0)
        {
            m--;
            s = 59;
        }
        else
        {
            if (h > 0)
            {
                h--;
                m = 59;
                s = 59;
            }
            else
            {
                if (d > 0)
                {
                    d--;
                    h = 24;
                    m = 59;
                    s = 59;
                }
                else
                {
                    clearInterval(interval);
                }
            }
        }
    }
    $('#Timer').html("Sesión expira en: "+h+" h " + m+" m "+s+" s");
    },1000);
}
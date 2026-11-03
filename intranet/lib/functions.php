<?php 
function VerificaSessionUsuario($Tipo) 
{
    $usuariosession     = isset($_SESSION['usuarioIntranet']) ? $_SESSION['usuarioIntranet'] : '';
    $PerfilIntranet     = isset($_SESSION['PerfilIntranet']) ? $_SESSION['PerfilIntranet'] : "";
    if ($Tipo == 1)
    {
        if ($usuariosession == "") {
            header("Location: ".INTRANET."/");
            exit;
        }
        else
        {
            if ($PerfilIntranet == 0)
            {
                header("Location:Perfil.php");
            }
        }
    }
    else
    {
        if ($usuariosession == "") {
            header("Location: ".INTRANET."/");
            exit;
        }
    }
}

function diaSemana($ano,$mes,$dia)
{
    // 0->domingo | 6->sabado
    $diaActual= date("w",mktime(0, 0, 0, $mes, $dia, $ano));
    return $diaActual;
}

function ColorFila($Fila)
{
    $FilaR = $Fila%2;
    if ($FilaR == 1)
    {
        $Color = "#EEDDD0";
    }
    else
    {
        $Color = "#Ffffff";
    }
    return $Color;
}

function ColorFilaCeleste($Fila)
{
    $FilaR = $Fila%2;
    if ($FilaR == 1)
    {
        $Color = "#DAF3F9";
    }
    else
    {
        $Color = "#Ffffff";
    }
    return $Color;
}

function ColorFilaNaranja($Fila)
{
    $FilaR = $Fila%2;
    if ($FilaR == 1)
    {
        $Color = "#F9EDDA";
    }
    else
    {
        $Color = "#Ffffff";
    }
    return $Color;
}

function ColorFilaGris($Fila)
{
    $FilaR = $Fila%2;
    if ($FilaR == 1)
    {
        $Color = "#DDDDDD";
    }
    else
    {
        $Color = "#Ffffff";
    }
    return $Color;
}

function CallDia($Valor)
{
    if ($Valor == 1)
    {
        $Resultado =  "Lun";
    }
    if ($Valor == 2)
    {
        $Resultado =  "Mar";
    }
    if ($Valor == 3)
    {
        $Resultado =  "Mie";
    }
    if ($Valor == 4)
    {
        $Resultado =  "Jue";
    }
    if ($Valor == 5)
    {
        $Resultado =  "Vie";
    }
    if ($Valor == 6)
    {
        $Resultado =  "Sab";
    }
    if ($Valor == 0)
    {
        $Resultado =  "Dom";
    }
    return $Resultado;
}

function SeparaCadena($Valor) 
{
    $ValorR         = explode(" ",$Valor);
    return $ValorR[0];
}

function sumaNdias($fechaValor,$Dias)
{
    //dd/mm/YYYY
    $fechaValorR  = explode("-",$fechaValor); 
    $FechaValorX = date_create($fechaValorR[2]."-".$fechaValorR[1]."-".$fechaValorR[0]);
    $Fecha = date_add($FechaValorX, date_interval_create_from_date_string($Dias.' days'));
    return date_format($Fecha,'Y-m-d'); 
}

function Obtienefecha($fecha,$Tipo) 
{
    $fechaR         = explode("-",$fecha);
    $day            = $fechaR[2];
    $mes            = $fechaR[1];
    $year           = $fechaR[0];
    if ($Tipo == 1)
    {
        $final      = $day;
    }
    if ($Tipo == 2)
    {
        $final      = $mes;
    }
    if ($Tipo == 3)
    {
        $final      = $day."-".$mes."-".$year;
    }
    if ($Tipo == 4)
    {
        $final      = $day."/".$mes;
    }
    if ($Tipo == 5)
    {
        $final      = $year;
    }
    return $final;
}

function Mes($Valor,$Tipo)
{
    if ($Valor == 1)
    {
        $Resultado =  "ENERO";
        $Resultado2 = "ENE";
    }
    if ($Valor == 2)
    {
        $Resultado = "FEBRERO";
        $Resultado2 = "FEB";
    }
    if ($Valor == 3)
    {
        $Resultado = "MARZO";
        $Resultado2 = "MAR";
    }
    if ($Valor == 4)
    {
        $Resultado = "ABRIL";
        $Resultado2 = "ABR";
    }
    if ($Valor == 5)
    {
        $Resultado = "MAYO";
        $Resultado2 = "MAY";
    }
    if ($Valor == 6)
    {
        $Resultado = "JUNIO";
        $Resultado2 = "JUN";
    }
    if ($Valor == 7)
    {
        $Resultado = "JULIO";
        $Resultado2 = "JUL";
    }
    if ($Valor == 8)
    {
        $Resultado = "AGOSTO";
        $Resultado2 = "AGO";
    }
    if ($Valor == 9)
    {
        $Resultado = "SEPTIEMBRE";
        $Resultado2 = "SEP";
    }
    if ($Valor == 10)
    {
        $Resultado = "OCTUBRE";
        $Resultado2 = "OCT";
    }
    if ($Valor == 11)
    {
        $Resultado = "NOVIEMBRE";
        $Resultado2 = "NOV";
    }
    if ($Valor == 12)
    {
        $Resultado = "DICIEMBRE";
        $Resultado2 = "DIC";
    }
    if ($Valor == 13)
    {
        $Resultado =  "ENERO";
        $Resultado2 = "ENE";
    }
    if ($Tipo == 1)
    {
        return $Resultado;
    }
    if ($Tipo == 2)
    {
        return $Resultado2;
    }
}

function BuscarCadena($Valor1,$Valor2,$Tipo)
{
    $Permiso = 0;
    if ($Tipo == 1)
    {
        if ($Valor1 == "DIRECCION EJECUTIVA")
        {
            if ($Valor2 == "DIRECTOR EJECUTIVO")
            {
                $Permiso = 1;
            }
            if ($Valor2 == "ASESORES DE DIRECCIÓN EJECUTIVA")
            {
                $Permiso = 1;
            }
            if ($Valor2 == "ESPECIALISTA EN CONTROL PREVIO")
            {
                $Permiso = 1;
            }
            if ($Valor2 == "ASESOR")
            {
                $Permiso = 1;
            }
            if ($Valor2 == "SECRETARIA")
            {
                $Permiso = 1;
            }
            if ($Valor2 == "TECNICO ADMINISTRATIVO")
            {
                $Permiso = 1;
            }
        }
        if ($Valor1 == "OFICINA DE ASESORIA JURIDICA")
        {
            if ($Valor2 == "COORDINADOR DEL EQUIPO DE CONCILIACION Y ARBITRAJE DE OAJ")
            {
                $Permiso = 1;
            }
            if ($Valor2 == "SECRETARIA EJECUTIVA")
            {
                $Permiso = 1;
            }
        }
        if ($Valor1 == "OFICINA DE COMUNICACIONES")
        {
            if ($Valor2 == "JEFE DE LA OFICINA DE COMUNICACIONES")
            {
                $Permiso = 1;
            }
        }
        if ($Valor1 == "OFICINA DE PLANEAMIENTO Y PRESUPUESTO")
        {
            if ($Valor2 == "COORDINADOR DE PLANEAMIENTO PARA LA OFICINA DE PLANEAMIENTO ESTRATEGICO Y PRESUPUESTO")
            {
                $Permiso = 1;
            }
            if ($Valor2 == "ASISTENTE ADMINISTRATIVO")
            {
                $Permiso = 1;
            }
        }
        if ($Valor1 == "OFICINA DE TECNOLOGIAS DE INFORMACION")
        {
            if ($Valor2 == "COORDINADOR DE LA OFICINA DE TECNOLOGIAS DE INFORMACION")
            {
                $Permiso = 1;
            }
            if ($Valor2 == "SECRETARIA")
            {
                $Permiso = 1;
            }
        }
        if ($Valor1 == "UNIDAD DE RECURSOS HUMANOS")
        {
            if ($Valor2 == "COORDINADOR DE LA UNIDAD DE RECURSOS HUMANOS")
            {
                $Permiso = 1;
            }
            if ($Valor2 == "SECRETARIA PARA LA UNIDAD DE RECURSOS HUMANOS")
            {
                $Permiso = 1;
            }
        }
        if ($Valor1 == "UNIDAD DE FINANZAS")
        {
            if ($Valor2 == "SECRETARIA")
            {
                $Permiso = 1;
            }
        }
        if ($Valor1 == "UNIDAD DE FINANZAS")
        {
            if ($Valor2 == "SECRETARIA")
            {
                $Permiso = 1;
            }
        }
        if ($Valor1 == "OFICINA GERENCIAL DE ADMINISTRACION")
        {
            if ($Valor2 == "ASISTENTE ADMINISTRATIVO")
            {
                $Permiso = 1;
            }
        }
        if ($Valor1 == "UNIDAD DE TRAMITE DOCUMENTARIO")
        {
            if ($Valor2 == "AUXILIAR ADMINISTRATIVO")
            {
                $Permiso = 1;
            }
        }
        if ($Valor1 == "UNIDAD DE ABASTECIMIENTO")
        {
            if ($Valor2 == "PROFESIONAL")
            {
                $Permiso = 1;
            }
            if ($Valor2 == "APOYO ADMINISTRATIVO")
            {
                $Permiso = 1;
            }
        }
    }
    else
    {
        $Permiso = 1;
    }
    return $Permiso;
}

function pluginsBasic()
{
?>
    <head>
        <title>Actualización de Información</title>
        <meta charset="utf-8">
        <link rel="shortcut icon" href="../minedu.ico" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <script language="JavaScript" type="text/javascript" src="../recursos/js/jquery.js"></script>

        <!--ESTILOS POR DEFAULT-->
        <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSPROY;?>stylesheets/base.css">
        <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSPROY;?>stylesheets/skeleton.css">
        <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSPROY;?>stylesheets/layout.css">
        <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSPROY;?>stylesheets/style.css">
        <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSPROY;?>stylesheets/color.css" title="styles7" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS;?>js/colorbox/colorbox.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSPROY;?>css/estilosLoguin.css"  media="screen" />
        <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSPROY;?>framework/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSPROY;?>framework/bootstrap/bootstrap-responsive.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSPROY;?>framework/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSPROY;?>framework/flaty_rojo.css">
        <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSPROY;?>framework/flaty-responsive.css">
        <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSPROY;?>/css/estilos.css" />

        <link rel="shortcut icon" href="../minedu.ico" />
        <script language="JavaScript" type="text/javascript" src="../recursos/js/function.js"></script>
    </head>  
<?php
}

function pluginsWeb()
{
?>
    <head>
    <meta charset="utf-8">
    <title><?php echo PRONIED;?></title>
        <link rel="stylesheet" href="<?php echo RECURSOSPROY;?>/css/estilos.css" type="text/css"/>
        <link rel="stylesheet" href="<?php echo RECURSOSPROY;?>/css/menu.css" type="text/css" media="screen">
        <link rel="stylesheet" href="<?php echo RECURSOSPROY;?>/css/jcarousel.responsive.css" type="text/css">
        <link rel="stylesheet" href="<?php echo RECURSOSPROY;?>/css/jcarousel.basic.css" type="text/css">
        <link rel="stylesheet" href="<?php echo RECURSOSGEN_RECURSOS?>/js/colorbox/colorbox.css" type="text/css"  />
        <link rel="shortcut icon" href="../minedu.ico" />
        <script src="<?php echo RECURSOSPROY;?>/js/jquery.js" type="text/javascript"></script>
        <script src="<?php echo RECURSOSPROY;?>/js/menu.js" type="text/javascript" ></script>
        <script src="<?php echo RECURSOSPROY;?>/js/Carrousel/jquery.jcarousel.min.js" type="text/javascript"></script>
        <script src="<?php echo RECURSOSPROY;?>/js/Carrousel/jcarousel.responsive.js" type="text/javascript"></script>
        <script src="<?php echo RECURSOSPROY;?>/js/Carrousel/jcarousel.basic.js" type="text/javascript"></script>
        <script src="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/jquery.colorbox-min1.js" language="JavaScript" type="text/javascript"></script>
        <script src="<?php echo RECURSOSGEN_RECURSOS ?>/js/validacion/reglas.js" language="JavaScript" type="text/javascript"></script>
        <script src="<?php echo RECURSOSPROY;?>/js/Intranet.js" language="JavaScript" type="text/javascript"></script>
        <?php 
        $horaIngreso                = isset($_SESSION['horaIngreso']) ? $_SESSION['horaIngreso'] : "";
        $minutoIngreso              = isset($_SESSION['minutoIngreso']) ? $_SESSION['minutoIngreso'] : "";
        $horarioIngreso             = isset($_SESSION['horarioIngreso']) ? $_SESSION['horarioIngreso'] : "";
        if ($horarioIngreso == "PM")
        {
            if ($horaIngreso == 12)
            {
                $horaIngreso = 0;
            }
            else
            {
                $horaIngreso = $horaIngreso + 12;
            }
        }
        function SumaHoras($hora,$minuto)
        {
            $segundos_horaInicial   =   strtotime($hora);
            $segundos_minutoAnadir  =   $minuto*60;
            $nuevaHora              =   date("H:i",$segundos_horaInicial+$segundos_minutoAnadir);
            return $nuevaHora;
        }
        function RestarHoras($horaini,$horafin)
        {
                $horai  = substr($horaini,0,2);
                $mini   = substr($horaini,3,2);
                $segi   = "00";
                $horaf  = substr($horafin,0,2);
                $minf   = substr($horafin,3,2);
                $segf   = substr($horafin,6,2);

                $ini    = ((($horai*60)*60)+($mini*60)+$segi);
                $fin    = ((($horaf*60)*60)+($minf*60)+$segf);
                $dif    = $ini-$fin;
                $difh   = floor($dif/3600);
                $difm   = floor(($dif-($difh*3600))/60);
                $difs   = $dif-($difm*60)-($difh*3600);
                return date("H:i:s",mktime($difh,$difm,$difs));

        }
        $HoraFinSesion = SumaHoras($horaIngreso.":".$minutoIngreso,180);
        //echo $HoraFinSesion;exit;
        $DatosTimer    = RestarHoras($HoraFinSesion,date("H:i:s"));
        $HTimer        = substr($DatosTimer,0,2);
        $MTimer        = substr($DatosTimer,3,2);
        $STimer        = substr($DatosTimer,6,2);
        ?>
        <script type="text/javascript">
            $(function()
            {
                $('.jcarouselAvisos').jcarouselAutoscroll({
                    interval: 4000
                });
                $('.jcarouselInteres').jcarouselAutoscroll({
                    interval: 5000
                });
            });
            contador_regresivo(0, <?php echo $HTimer;?>, <?php echo $MTimer;?>, <?php echo $STimer;?>);
    </script>
    </head>   
<?php
}

function headerWeb()
{
    $personaNombre      = isset($_SESSION['personaNombre']) ? $_SESSION['personaNombre'] : '';
?>
	<!--
    <div id="LogoSuperior">
        <div id="LogoSuperiorImg">
            <div id="LogoSuperiorImg2">
                <img src="<?php echo RECURSOSPROY;?>/images/IntranetLogo1.png">
            </div>
        </div>
    </div>
	-->
    <div id="LogoHeader">
        <div id="LogoHeaderImg" style="width:40%; align-content: center; ">
            <div id="LogoHeaderImgIzq">
                <a href="javascript:openSistemas('http://198.150.0.125/ge3p/Vista/mainpage.php');"><img style="margin: -10;" src="<?php echo RECURSOSPROY;?>/images/logox.png" width="60" title="www.rcc.gob.pe"></a>
            </div>
            <div id="LogoHeaderCentro">
                GE3P MVCS
                <!--"Año del Buen Servicio al Ciudadano"-->
                <br>
                RUC: 20504743307 
                <!--| UIT = S/. 4,050.00-->
            </div>
            <div id="LogoHeaderImgDer" style="width: 50%">
                <table class="LogoDerecha" style="width: 100%">
                    <tr>
                        <td rowspan="2"><img src="<?php echo RECURSOSPROY;?>/images/user.png"></td>
                        <td class="TextUsuario" style="width:80% "><?php echo $personaNombre;?></td>
                        <td class="TextUsuario" rowspan="2"><a href="Logout.php"><img src="<?php echo RECURSOSPROY;?>/images/Salir.png"></a>
                        </td>
                    </tr>
                    <tr>
                        <td class="TextPerfil" style="margin:0 auto;">
                            
                            <!--<a href="javascript:openConfig('Perfil');" class="textEnlaceNaranja">MI PERFIL</a> |--> 
                            <a href="javascript:openConfig('Clave');" class="textEnlaceCeleste">CAMBIAR CLAVE</a>
                            <div id="Timer" class="TitulTimer"></div>
                        </td>
                        
                    </tr>
                </table>
            </div>
        </div>
        
        
        <script type="text/javascript">
        function abrirVentana(url) {
            window.open(url, "nuevo", "directories=no, location=no, menubar=no, scrollbars=yes, statusbar=no, tittlebar=no, width=1024%, height=768% , top=0 , left=0 ");
        }
        
        window.location="http://198.150.0.125/ge3p/Vista/mainpage.php";
        
//        abrirVentana("http://198.150.0.125/ge3p/Vista/mainpage.php") ;
//        window.close();
        </script>
    </div>
<?php
}

function headerWebOtros()
{
    $personaNombre      = isset($_SESSION['personaNombre']) ? $_SESSION['personaNombre'] : '';
?>
    <div id="LogoHeaderOtros">
        <table style="width: 100%">
            <tr>
                <td style="padding: 10px; width: 32%;">
                    <a href="javascript:openSistemas('http://www.pronied.gob.pe');">
                        <img style="width: 300px;" src="<?php echo RECURSOSPROY;?>/images/logo-minedu.png" title="www.pronied.gob.pe">
                    </a>
                </td>
                <td style="width: 30%; text-align: center">
                "Año del Buen Servicio al Ciudadano"
                <br>
                RUC: 20511209227 | UIT = S/. 4,050.00
                </td>
                <td style="width: 32%;">
                    <table class="LogoDerecha">
                    <tr>
                        <td style="text-align: right;" rowspan="2"><img src="<?php echo RECURSOSPROY;?>/images/user.png"></td>
                        <td class="TextUsuario"><?php echo $personaNombre;?></td>
                        <td style="text-align: left;" class="TextUsuario" rowspan="2"><a href="Logout.php"><img src="<?php echo RECURSOSPROY;?>/images/Salir_orange.png"></a>
                        </td>
                    </tr>
                    <tr>
                        <td class="TextPerfil" style="margin:0 auto;">
                            
                            <a href="javascript:openConfig('Clave');" class="textEnlaceAmarillo">CAMBIAR CLAVE</a>
                            <div id="Timer" class="TitulTimer"></div>
                        </td>
                        
                    </tr>
                </table>
                </td>
            </tr>
        </table>
    </div>
<?php
}

function menuWeb()
{
    $lCollection = Collection::Singleton();
    $lstSistemas    = $lCollection->Get('lstSistemas');
?>
    <script type="text/javascript">
    
    </script>
<!--    <div id="Menu">
        <nav id="MenuDatos">
            <ul class="menu">
                <li><a href="mainpage.php">INICIO</a></li>
                <li class="LineaMenu" style="vertical-align: middle"><img src="<?php echo RECURSOSPROY;?>/images/line.png"></li>
                <li><a  href="#">DIRECTORIOS</a>
                    <ul class="sub-menu">
                        <li><a href="javascript:verDirectorio();">Institucional</a></li>
                        <li><a href="javascript:verDirectorioEmergencias();">De emergencias</a></li>
                    </ul>
                </li>
                <li class="LineaMenu" style="vertical-align: middle"><img src="<?php echo RECURSOSPROY;?>/images/line.png"></li>
                <li><a href="javascript:verFormatos();">FORMATOS</a></li>
                <li class="LineaMenu" style="vertical-align: middle"><img src="<?php echo RECURSOSPROY;?>/images/line.png"></li>
                <li><a  href="#">APLICATIVOS</a>
                    <ul class="sub-menu">
                        <li>
                            <a href="javascript:openSistemas('https://correo.pcm.gob.pe/owa/auth/logon.aspx?replaceCurrent=1&url=https%3a%2f%2fcorreo.pcm.gob.pe%2fowa%2f')">
                            Correo Electrónico</a>
                        </li>
                        <?php 
                        $listaSistemas  = count($lstSistemas) > 0 ? true : false;
                        if (($listaSistemas == true) || ($listaSistemas > 0))
                        {
                            foreach ($lstSistemas as $ObjSistemas) 
                            {
                                $sisnombre = $ObjSistemas->sisabreviatura;
                                $sisurl    = $ObjSistemas->sisurl;
                        ?>
                        <li><a href="javascript:openSistemas('<?php echo $sisurl;?>')"><?php echo $sisnombre;?></a></li>
                        <?php
                            }
                        }
                        ?>
                    </ul>
                </li>
                <li class="LineaMenu" style="vertical-align: middle"><img src="<?php echo RECURSOSPROY;?>/images/line.png"></li>
                <li><a  href="javascript:verFormatosConvenios();">SISTEMA DE GESTIÓN DE CALIDAD</a></li>
                <li class="LineaMenu" style="vertical-align: middle"><img src="<?php echo RECURSOSPROY;?>/images/line.png"></li>
                <li><a  href="#">INSTRUCTIVOS</a>
                    <ul class="sub-menu">
                        <li><a href="javascript:openSistemas('files/INS01-carpetascompartidas.pdf')">Carpeta compartida</a></li>
                        <li><a href="javascript:openSistemas('files/INS02-configuracionescaneoenred.pdf')">Escaneo en red</a></li>
                        <li><a href="javascript:openSistemas('files/INS03-seguridadenimpresoras.pdf')">Uso de impresoras</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>-->
<?php
}

function contentWeb()
{
    ?>
<style>
.second-row {position: relative; top: 0px; left: 0; right: 0; bottom: 0; background-color: red }
.second-row iframe {display: block; width: 100%; height: 100%; border: none;}
</style>
<!--<div id="ContenidoF" class="second-row">

    <iframe src="https://app.powerbi.com/view?r=eyJrIjoiMGY2YThlZjctMmEyMy00Nzc3LWFmZWItMTkyNzhjOWY1YmQwIiwidCI6IjkwNTdiNGRiLWNiNDctNDc0NC05YzBkLTQxMTVhMzBiMDRiYiIsImMiOjR9" 
            >
    </iframe>        

    </div>    -->
    <?php
}

function contentWeb_Old()
{
    $lCollection = Collection::Singleton();
    $lstCumples1                = $lCollection->Get('lstCumples1');
    $lstEnlaces                 = $lCollection->Get('lstEnlaces');
    $lstNoticias                = $lCollection->Get('lstNoticias');
    $lstComunicados             = $lCollection->Get('lstComunicados');
    $lstComunicadosPrincipal    = $lCollection->Get('lstComunicadosPrincipal');
?>
    <script type="text/javascript">
    $.getJSON('Dolar.php', function (data) 
    {
        
        if (data.success === true)
        {
            var valores = data.data.pop();
            $('#dolar').append('<table style="width:100%; margin-left: 25%">');
            $('#dolar').append('<tr><td style="width: 45%"><b>Compra: </b></td><td style="width: 55%"> ' + valores.compra+'</td>');
            $('#dolar').append('<tr><td style="width: 45%"><b>Venta: </b></td><td style="width: 55%"> ' + valores.venta+'</td></tr>');
            $('#dolar').append('</table>');
        }
        else
        {
            $('#dolar').append('<p>No existe información para la fecha elegida');
        }
    });

    $.getJSON('Clima.php', function (data) 
    {
        if (data.success === true)
        {
            $('#clima').append(' '+data.CLIMA);
        }
        else
        {
            $('#clima').append('<p>No existe información para la fecha elegida');
        }
    });
    
    </script>
    <div id="ContenidoF">
        <br>
        <div id="marcoTransparente">
            <div id="leftcontent">
                <div class="oneColumns240 TitulColumns">
                    Noticias
                </div>
                <div class="oneColumns240 ContentColumns">
                    <table class="textContenido" style="width: 96%; margin-left: 2%; margin-right: 2%;">
                        <?php 
                        $iNoti      = 0;
                        $CountNOTI  = 0;
                        $listaNoticias  = count($lstNoticias) > 0 ? true : false;
                        if (($listaNoticias == true) || ($listaNoticias > 0))
                        {
                            foreach ($lstNoticias as $ObjNoticias) 
                            {
                                $CountNOTI++;
                            }
                        }
                        if (($listaNoticias == true) || ($listaNoticias > 0))
                        {
                            foreach ($lstNoticias as $ObjNoticias) 
                            {
                                $iNoti++;
                                $CNoticia          = $ObjNoticias->IdNoticia;
                                $TituloNoticia     = $ObjNoticias->Titulo;
                        ?>
                        <tr>
                            <td><a class="textEnlace" href="javascript:openNoticias(<?php echo $CNoticia;?>)"><?php echo $TituloNoticia;?></a></td>
                        </tr>
                        <?php
                                if ($iNoti <> $CountNOTI)
                                {
                        ?>
                        <tr>
                            <td style="text-align: center;"><hr class="Lineas"></td>
                        </tr>
                        <?php 
                                }
                            }
                        }
                        ?>
                    </table>
                </div>
                <div class="oneColumns240 TitulColumns">
                    Comunicados
                </div>
                <div class="oneColumns240 ContentColumns">
                    <table class="textContenido" style="width: 96%; margin-left: 2%; margin-right: 2%;">
                        
                        <?php 
                        $iCom      = 0;
                        $CountCom  = 0;
                        $listaComunicados  = count($lstComunicados) > 0 ? true : false;
                        if (($listaComunicados == true) || ($listaComunicados > 0))
                        {
                            foreach ($lstComunicados as $ObjComunicados) 
                            {
                                $CountCom++;
                            }
                        }
                        if (($listaComunicados == true) || ($listaComunicados > 0))
                        {
                            foreach ($lstComunicados as $ObjComunicados) 
                            {
                                $iCom++;
                                $DescripcionCom     = $ObjComunicados->Titulo;
                                $MostrarPrincipalCom= $ObjComunicados->MostrarPrincipal;
                                $TipoPublicacion    = $ObjComunicados->TipoPublicacion;
                                $ImagenComunicado   = $ObjComunicados->ImagenComunicado;
                                $EnlaceComunicado   = $ObjComunicados->EnlaceComunicado;
                                if ($MostrarPrincipalCom == 0)
                                {
                                    
                        ?>
                        <tr>
                            <td><a class="textEnlace" href="javascript:openSistemas('<?php if ($TipoPublicacion == 1){ echo INTRAAPP_FILES."/".$ImagenComunicado;}else{echo $EnlaceComunicado;}?>')"><?php echo $DescripcionCom;?></a></td>
                        </tr>
                        <?php 
                                    if ($iCom <> $CountCom)
                                    {
                        ?>
                        <tr>
                            <td style="text-align: center;"><hr class="Lineas"></td>
                        </tr>
                        <?php
                                    }
                                }
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>
            <div id="centercontent">
                <div class="oneColumns500" style="text-align: center; margin: auto;">                    
                    <div class="jcarousel-wrapper-Basic">
                        <div class="jcarouselAvisos">
                            <?php 
                            $listaComunicadosP  = count($lstComunicadosPrincipal) > 0 ? true : false;
                            ?>
                            <ul>
                                <?php 
                                
                                if (($listaComunicadosP == true) || ($listaComunicadosP > 0))
                                {
                                    foreach ($lstComunicadosPrincipal as $ObjComunicadosP) 
                                    {
                                        $DescripcionComP      = $ObjComunicadosP->Titulo;
                                        $MostrarPrincipalComP = $ObjComunicadosP->MostrarPrincipal;
                                        $ImagenComP           = $ObjComunicadosP->ImagenComunicado;
                                        $EnlaceP              = $ObjComunicadosP->RutaArchivo;
                                        if ($MostrarPrincipalComP == 1)
                                        {
                                        ?>
                                        <li><a href="javascript:openSistemas('<?php echo INTRAAPP_FILES."/".$EnlaceP;?>');"><img src="<?php echo INTRAAPP_FILES;?>/<?php echo $ImagenComP;?>" alt="<?php echo $DescripcionComP;?>"></a></li>
                                        <?php
                                        }
                                    }
                                }
                                else
                                {
                                    echo "54657";
                                }
                                ?>
                            </ul>
                        </div>
                        <a href="#" class="jcarouselAvisos-control-prev">&lsaquo;</a>
                        <a href="#" class="jcarouselAvisos-control-next">&rsaquo;</a>
                    </div>
                </div>
            </div>
            <div id="rightcontent" style="text-align: right">
                <div class="oneColumns240 TitulCalendar">
                    <span style="font-size: xx-large; font-weight: bold;"><?php echo date("d");?></span><br><?php echo Mes(date("m"),2);?>
                </div>
                <div class="oneColumns240" id="CalendarioContenido" style="right: 0px;">
                    <table style="width: 100%">
                        <tr>
                            <?php /*?>
                            <td>
                                <div class="oneColumns60 TitulCalendar">
                                    <span style="font-size: xx-large; font-weight: bold;"><?php echo date("d");?></span><br><?php echo Mes(date("m"),2);?>
                                </div>
                            </td>
                            <?php
                             */
                            ?>
                            <td >
                                <div id="clima" style="margin-top:-10px;">
                                    <table style="width:100%; margin-left: 0%" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td id="ClimaImg"></td>
                                            <td id="ClimaVal" style="font-size: 13px;"></td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <br>
                <div class="oneColumns240 TitulColumns">
                    Cumpleaños
                </div>
                <div class="oneColumns240 ContentColumns">
                    <?php 
                    $listaCumples1  = count($lstCumples1) > 0 ? true : false;
                    if (($listaCumples1 == true) || ($listaCumples1 > 0))
                    {
                    ?>
                    <table class="textContenido" style="width: 96%; margin-left: 2%; margin-right: 2%;">
                        <?php
                        $i = 0;
                        foreach ($lstCumples1 as $objCumples1) 
                        {
                            $i++;
                            $PerApePaterno     = $objCumples1->PerApePaterno;
                            $PerApeMaterno     = $objCumples1->PerApeMaterno;
                            $PerNombres        = $objCumples1->PerNombres;
                            $PerFecNacimiento  = $objCumples1->FecNacimiento;
                            $Persona           = $PerNombres." ".$PerApePaterno." ".$PerApeMaterno;
                        ?>
                        <tr>
                            <td><span class="DatosCalendar"><?php echo $PerFecNacimiento;?></span><span class="NombresCalendar"><?php echo ucwords(strtolower($Persona));?></span></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;"></td>
                        </tr>
                        <?php 
                        }
                        ?>
                        <tr>
                            <td><br><a style="color: #676767;" href="javascript:verCumples();">Ver todos los cumpleaños.</a></td>
                        </tr>
                    </table>
                    <?php 
                    }
                    ?>
                </div>
            </div>
            <div id="centerlogos3">
                <table style="width: 100%;text-align: center;">
                    <tr>
<!--                        <td style="text-align: center; width: 18%" class="BorderImg">
                            <a href="javascript:verUIT();"><img src="<?php echo RECURSOSPROY;?>/images/icons/logo_uit.png"></a>
                        </td>-->
                        <td style="width: 5%;"></td>
                        <td style="text-align: center; width: 25%" class="BorderImg">
                            <a href="javascript:verFeriados();"><img src="<?php echo RECURSOSPROY;?>/images/icons/icono-feriados.png"></a>
                        </td>
                        <td style="width: 5%;"></td>
                        <td style="text-align: center; width: 25%" class="BorderImg">
                            <div>
                                <a href="javascript:openSistemas('http://www.sbs.gob.pe/app/stats/tc-cv.asp')"><img src="../Recursos/images/icons/icono-tipodecambio.png"></a>
                                <!--<span style="font-size: 11px; color: #C64C26;font-weight: bold;">TIPO DE CAMBIO</span><br>-->
<!--                                <div id="dolar" style="font-size: 11px; margin-left: 20%;">
                                </div>-->
                            </div>
                        </td>
                        <td style="width: 5%;"></td>
                        <td style="text-align: center; width: 25%" class="BorderImg">
                            <a href="javascript:verFechasPago();"><img src="<?php echo RECURSOSPROY;?>/images/icons/logobn.png"></a>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="centerlogosInteres">
                <div class="jcarousel-wrapper-Interes">
                    <div class="jcarouselInteres">
                        <ul>
                            <?php 
                            $listaEnlaces  = count($lstEnlaces) > 0 ? true : false;
                            if (($listaEnlaces == true) || ($listaEnlaces > 0))
                            {
                                foreach ($lstEnlaces as $ObjEnlaces) 
                                {
                                    $DescEnlace     = $ObjEnlaces->Descripcion;
                                    $RutaEnlace     = $ObjEnlaces->RutaArchivo;
                                    $Enlace         = $ObjEnlaces->Enlace;
                            ?>
                            <li><a href="javascript:openSistemas('<?php echo $Enlace;?>')"><img src="<?php echo INTRAAPP_FILES;?>/<?php echo $RutaEnlace;?>" alt="<?php echo $DescEnlace;?>"></a></li>
                            <?php 
                                }
                            }
                            ?>
                        </ul>
                    </div>
                    <a href="#" class="jcarouselInteres-control-prev">&lsaquo;</a>
                    <a href="#" class="jcarouselInteres-control-next">&rsaquo;</a>
                    <!--<p class="jcarouselInteres-pagination"></p>-->
                </div>
                </div>
        </div>
    </div>
<?php
}

function pieWeb()
{
?>

<?php
}
?>

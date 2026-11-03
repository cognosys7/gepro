<?php

function muestraVista() {
    $lCollection = Collection::Singleton();
    //INFORMACIÓN DE LN
    $lKPI01 = $lCollection->Get('lKPI01');
    $lKPI02 = $lCollection->Get('lKPI02');
    
    $PaginaFormulario = $lCollection->Get('PaginaFormulario');
    $PermisoOK        = $lCollection->Get('PermisoOK');
    ?>
    <!--ESTILOS PARA UTILIZAR-->
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS?>/js/flexigrid/flexigrid_searchbar_on_top.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS?>/js/flexigrid/miflexigridgris.css"  />
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS?>/css/botones.css"  />
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/flexigrid/flexigrid.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY?>/js/Perfil.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY?>/js/general.js"></script>

    <div id="Mensajes"></div>
    <div class="row-fluid">
       <div class="span12">
           <div class="box">
               <?php 
               if ($PermisoOK <> 0)
               {
                    $CodigoPerfil   = $lCollection->Get('CPerfil');
                    $NombrePerfilR  = $lCollection->Get('NombrePerfilR');
                    //var_dump($NombrePerfilR, $CodigoPerfil);
                    //NOMBRE DEL USUARIO PARA EL SALUDO ("MEZA YANGALI JULIO" -> "Meza Yangali Julio")
                    $NombreUsuario = trim((string)$lCollection->Get('DatosPersona'));
                    if (function_exists('mb_convert_case'))
                    {
                        $NombreUsuario = mb_convert_case($NombreUsuario, MB_CASE_TITLE, 'UTF-8');
                    }
               ?>
               <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS?>/css/portada.css"  />
               <div class="box-content">
                    <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post">
                        <div id="contenedor" >
                            <!--PORTADA DE INICIO (estilos en recursosAPP/recursos/css/portada.css)-->
                            <div class="gp-portada">
                                <div class="gp-hero">
                                    <div class="gp-hero-texto">
                                        <p class="gp-saludo">Bienvenido<?php if ($NombreUsuario !== '') { ?>, <?php echo htmlspecialchars($NombreUsuario, ENT_QUOTES, 'UTF-8'); } ?></p>
                                        <img class="gp-logo" src="<?php echo RECURSOSGEN_RECURSOS ?>/images/gepro_logo.png" alt="GEPRO">
                                        <h2 class="gp-titulo">Sistema Integral para Oficina de Proyectos (PMO)</h2>
                                        <p class="gp-descripcion">Planifique, ejecute y controle su portafolio de proyectos: contratos, componentes, riesgos, interesados y presupuesto en un solo lugar, con tableros para la toma de decisiones.</p>
                                        <ul class="gp-modulos">
                                            <li><i class="icon-cogs"></i>Configuración del proyecto</li>
                                            <li><i class="icon-briefcase"></i>Gestión del proyecto</li>
                                            <li><i class="icon-money"></i>Presupuesto</li>
                                            <li><i class="icon-bar-chart"></i>Tableros BI</li>
                                            <li><i class="icon-wrench"></i>Mantenimiento</li>
                                            <li><i class="icon-shield"></i>Seguridad</li>
                                        </ul>
                                    </div>
                                    <!--ANILLO CON LAS CINCO FASES (PETROLEO Y VERDE DEL LOGO)-->
                                    <div class="gp-hero-grafico" aria-hidden="true">
                                        <svg viewBox="0 0 300 300">
                                            <circle cx="150" cy="150" r="128" fill="#ffffff" fill-opacity=".85"/>
                                            <g fill="none" stroke-width="22" transform="rotate(-90 150 150)">
                                                <circle cx="150" cy="150" r="110" stroke="#007F8F" stroke-dasharray="132 559.15" stroke-dashoffset="0"/>
                                                <circle cx="150" cy="150" r="110" stroke="#2A97A4" stroke-dasharray="132 559.15" stroke-dashoffset="-138.23"/>
                                                <circle cx="150" cy="150" r="110" stroke="#56B0BA" stroke-dasharray="132 559.15" stroke-dashoffset="-276.46"/>
                                                <circle cx="150" cy="150" r="110" stroke="#3E9E3E" stroke-dasharray="132 559.15" stroke-dashoffset="-414.69"/>
                                                <circle cx="150" cy="150" r="110" stroke="#007D00" stroke-dasharray="132 559.15" stroke-dashoffset="-552.92"/>
                                            </g>
                                            <text x="150" y="146" text-anchor="middle" font-family="Segoe UI, Arial" font-size="40" font-weight="700" fill="#007F8F">PMO</text>
                                            <text x="150" y="172" text-anchor="middle" font-family="Segoe UI, Arial" font-size="12" fill="#5a6b78">Portafolio · Programas</text>
                                            <text x="150" y="188" text-anchor="middle" font-family="Segoe UI, Arial" font-size="12" fill="#5a6b78">Proyectos</text>
                                        </svg>
                                    </div>
                                </div>

                                <div class="gp-ciclo">
                                    <h3>Ciclo de vida del proyecto</h3>
                                    <ul class="gp-fases">
                                        <li><span class="gp-icono"><i class="icon-flag"></i></span><strong>Inicio</strong><span class="gp-detalle">Registro del proyecto, portafolio, programa e interesados.</span></li>
                                        <li><span class="gp-icono"><i class="icon-calendar"></i></span><strong>Planificación</strong><span class="gp-detalle">Componentes, actividades, cronograma, costos y riesgos.</span></li>
                                        <li><span class="gp-icono"><i class="icon-cogs"></i></span><strong>Ejecución</strong><span class="gp-detalle">Contratos, procesos de selección y gestión social.</span></li>
                                        <li><span class="gp-icono"><i class="icon-eye-open"></i></span><strong>Seguimiento y control</strong><span class="gp-detalle">Avance, indicadores, acciones correctivas y tableros.</span></li>
                                        <li><span class="gp-icono"><i class="icon-ok"></i></span><strong>Cierre</strong><span class="gp-detalle">Entregables, lecciones aprendidas y documentación final.</span></li>
                                    </ul>
                                </div>

                                <div class="gp-pie">
                                    <span>GEPRO · Gestión de Proyectos</span>
                                    <span class="gp-autor">Desarrollado por <img src="<?php echo RECURSOSGEN_RECURSOS ?>/images/cognosys_logo.png" alt="COGNOSYS - The Next Level"></span>
                                </div>
                            </div>
                        </div>
                    </form>
               </div>
               <?php 
               }
               else
               {
                   echo "<br><br><center>UD. NO TIENE ACCESO A ESTE MÓDULO</center><br>";
               }
               ?>
           </div>
       </div>
    </div>
    <br>
<!--A-->
    <style>
        .color1 {color: '#0C7894';}
        .color2 {color: '#999';}
        .color2 {color: '#aaa';}
    </style>    
    <!--Javascript-->
    <script src="<?php echo RECURSOSGEN_RECURSOS ?>/js/highcharts/highcharts.js"></script>
    <script src="<?php echo RECURSOSGEN_RECURSOS ?>/js/highcharts/highcharts-more.js"></script>
    <script src="<?php echo RECURSOSGEN_RECURSOS ?>/js/highcharts/solid-gauge.js"></script>
    <script src="<?php echo RECURSOSGEN_RECURSOS ?>/js/highcharts/data.js"></script>
    <script src="<?php echo RECURSOSGEN_RECURSOS ?>/js/highcharts/highcharts-3d.js"></script>
    <script src="<?php echo RECURSOSGEN_RECURSOS ?>/js/highcharts/exporting.js"></script>
    
<!--    <div class="row-fluid">      
        <div class="span3">
            <div class="box">
                <div class="box-content box-yellow color1" style="min-height: 300px">
                    <ul class="tiles">
                        <li class="blue">
                                <a href="#">
                                    <span class="count">
                                        <i class="icon-bell"></i>
                                        <?php echo 89; //$lKPI01[0]->KPI01 ?>
                                    </span>
                                    <span class="name">Mobiliario</span>
                                </a>
                            </li>
                        <li class="red">
                                <a href="#">
                                    <span class="count">
                                        <i class="icon-eye-open"></i>
                                        <?php echo 38; //$lKPI01[0]->KPI03 ?>
                                    </span>
                                    <span class="name">Equipamiento</span>
                                </a>
                            </li>
                        <li class="orange">
                                <a href="#">
                                    <span class="count">
                                        <i class="icon-ok-circle"></i>
                                        <?php echo 54; //$lKPI01[0]->KPI02 ?>
                                    </span>
                                    <span class="name">Prefabricados</span>
                                </a>
                            </li>
                        <li class="lime">
                                <a href="#">
                                    <span class="count">
                                        <i class="icon-thumbs-down"></i>
                                        <?php echo 12; //$lKPI01[0]->KPI04 ?>
                                    </span>
                                    <span class="name">Bienes y Servicios</span>
                                </a>
                            </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="span3">
            <div class="box">
                <div class="box-content">
                    <div id="container1" style="min-width: 310px; min-height: 300px; margin: 0 auto"></div>
                </div>
            </div>
        </div>
        <div class="span2">
            <div class="box">
                <div class="box-content" style="min-height: 300px">
                    <h4>Meta Física</h4>
                    <span class="label label-info">Mobiliario</span>
                    <span class="label label-success">Equipamiento</span>
                    <span class="label label-success">Prefabricados</span>
                    <span class="label label-info">Otros</span>
                    <table class="table table-hover table-nomargin table-colored-header">
                        <head>
                            <tr>
                                <th>Indicador</th>
                                <th>(Unidades)</th>
                            </tr>
                        </head>
                        <tbody>
                            <tr>
                                <td>Promedio</td>
                                <td><?php echo $lKPI02[0]->PROMEDIO ?></td>
                            </tr>
                            <tr>
                                <td>Maxímo</td>
                                <td><span class="label label-important"><?php echo $lKPI02[0]->MAXIMO ?></span></td>
                            </tr>
                            <tr>
                                <td>Mínimo</td>
                                <td><?php echo $lKPI02[0]->MINIMO ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="span4">
            <div class="box">
                <div class="box-content">
                    <div id="container2" style="min-width: 310px; min-height: 300px; margin: 0 auto"></div>
                </div>
            </div>
        </div>
        
    </div>-->
    
    
    <script type="text/javascript">

        $(function () {
            var chart;
            /*
             *Gráfico 01::
             *Tipo :Columnas[Column]
             *
             */
            var url1 = "mainpage.php?Pagina=Json&AccionLocal=2&Accion=LoadJson1";
            $.getJSON(url1, function (json1) {
                chart = new Highcharts.Chart({
                    chart: {
                        renderTo: 'container1',
                        type: 'pie',
                        options3d: {
                            enabled: true,
                            alpha: 45
                        }
                    }
                    , plotOptions: {
                        pie: {
                            innerSize: 40,
                            depth: 45,
                            dataLabels: {
                                enabled: false
                            },
                            showInLegend: true
                        }
                    }
                    , title: {
                        text: 'Tipos de observaciones',
                        x: 0//-20 //center
                    },
                    subtitle: {
                       text: '',
                        x: 0//-20
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    }
//                  ,legend: {
//                      layout: 'horizontal',
//                      align: 'botton',
//                      verticalAlign: 'top',
//                      x: 50,
//                      y: 50,
//                      borderWidth: 0
//                  }
                    , series: json1
                });
    //            });
            });

            /*
            *Gráfico 02::
            *Tipo :Bar 
            *
            */
            var url1 = "mainpage.php?Pagina=Json&AccionLocal=2&Accion=LoadJson2";
            $.getJSON(url1, function (json2) {
                chart = new Highcharts.Chart({
                    chart: {
                        renderTo: 'container2',
                        type: 'bar',
                        marginRight: 130,
                        marginBottom: 50
                    },
                    title: {
                        text: 'Ocurrencias/Región',
                        x: 0//-20 //center
                    },
                    subtitle: {
                        text: '5 regiones  con más ocurrencias',
                        x: 0//-20
                    },
                    xAxis: {
                        type: 'category'
                    },
                    yAxis: {
                        title: {
                            text: 'Ocurrencias'
                        },
                        plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#808080'
                            }]
                    },
                    tooltip: {
                        formatter: function () {
                            return '<b>' + this.series.name + '</b><br/>' +
                                    this.key + ': ' + this.y;
                        }
                    },
                    legend: {
                        layout: 'botton',
                        align: 'center',
                        verticalAlign: 'top',
                        x: -10,
                        y: 50,
                        borderWidth: 0
                    }
                    , series: json2
                });
            });
            
            /*
             *Gráfico 03::
             *Tipo :Columnas[Column]
             *
             */
            var url1 = "mainpage.php?Pagina=Json&AccionLocal=2&Accion=LoadJson3";
            $.getJSON(url1, function (json3) {
                chart = new Highcharts.Chart({
                    chart: {
                        renderTo: 'container3',
                        type: 'column',
                        marginRight: 50,
                        marginBottom: 90
                    },
                    title: {
                        text: 'Situación/Ocurrencias',
                        x: 0//-20 //center
                    },
                    subtitle: {
                        text: 'Ocurrencias por situación',
                        x: 0//-20
                    },
                    xAxis: {
                        type: 'category'
                    },
                    yAxis: {
                        title: {
                            text: '# ocurrencias'
                        },
                        plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#808080'
                           }]
                    },
                    tooltip: {
                        formatter: function () {
                            return '<b>' + this.series.name + '</b><br/>' +
                                    this.key + ': ' + this.y;
                        }
                    },
                    legend: {
                        layout: 'botton',
                        align: 'center',
                        verticalAlign: 'top',
                        x: -10,
                        y: 50,
                        borderWidth: 0
                    }
                    , plotOptions: {
                        column: {
                            stacking: 'normal',
                            dataLabels: {
                                enabled: true,
                                color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                                style: {
                                    textShadow: '0 0 3px black'
                                }
                            }
                        }
                    }
                    , series: json3
                });
            });


            /**
             * 
             * Gráfico 04
             */
            var url1 = "mainpage.php?Pagina=Json&AccionLocal=2&Accion=LoadJson4";
            $.getJSON(url1, function (json4) {
                chart = new Highcharts.Chart({
                    chart: {
                        renderTo: 'container4',
                        type: 'line',
                        marginRight: 10,
                        marginBottom: 20
                    },
                    title: {
                        text: 'Evolución de las ocurrencias',
                        x: 0//-20 //center
                    },
                    subtitle: {
                        text: 'por semana',
                        x: 0//-20
                    },
                    xAxis: {
                        type: 'category'
                    },
                    yAxis: {
                        title: {
                            text: 'Ocurrencia'
                        },
                        plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                    },
                    tooltip: {
                        formatter: function () {
                            return '<b>' + this.series.name + '</b><br/>' +
                                this.key + ': ' + this.y;
                        }
                    },
                    legend: {
                        layout: 'botton',
                        align: 'center',
                        verticalAlign: 'top',
                        x: -10,
                        y: 50,
                        borderWidth: 1
                    }
                    , plotOptions: {
                        column: {
                            stacking: 'normal',
                            dataLabels: {
                                enabled: true,
                                color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                                style: {
                                    textShadow: '0 0 3px black'
                                }
                            }
                        }
                    }
                    , series: json4
                });
                //chart.setOptions(Highcharts.theme);
            });
        });
                            
        /**
         * 
         * @param {type} Valor
         * @returns {undefined}
         */
        function VerGrafico01(Valor)
        {
            $.colorbox({width: "85%", height: "75%", iframe: true, escKey: false, overlayClose: false, href: "mainpage.php?Pagina=VerGrafico01&Accion=muestraVista&AccionLocal=1&&ACC=GRAF01&&Codigo=" + Valor});
            $('#cboxClose').remove();
        }
            
        /**
         * 
         * @param {type} Valor
         * @returns {undefined}
         */
        function VerGrafico02(Valor)
        {
            $.colorbox({width: "85%", height: "75%", iframe: true, escKey: false, overlayClose: false, href: "mainpage.php?Pagina=VerGrafico02&Accion=muestraVista&AccionLocal=1&&ACC=GRAF02&&Codigo=" + Valor});
            $('#cboxClose').remove();
        }
            
        function VerDetalle01()
        {
            $.colorbox({width: "60%", height: "75%", iframe: true, escKey: false, overlayClose: false, href: "mainpage.php?Pagina=VerDetalle01&Accion=muestraVista&AccionLocal=1&&ACC=DET01"});
            $('#cboxClose').remove();
        }
            
        function VerDetalle02()
        {
            $.colorbox({width: "85%", height: "75%", iframe: true, escKey: false, overlayClose: false, href: "mainpage.php?Pagina=VerDetalle02&Accion=muestraVista&AccionLocal=1&&ACC=DET02"});
            $('#cboxClose').remove();
        }
            
        function VerDetalle03()
        {
            $.colorbox({width: "85%", height: "75%", iframe: true, escKey: false, overlayClose: false, href: "mainpage.php?Pagina=VerDetalle03&Accion=muestraVista&AccionLocal=1&&ACC=DET03"});
            $('#cboxClose').remove();
        }
    </script>    
    <?php
    }
?>
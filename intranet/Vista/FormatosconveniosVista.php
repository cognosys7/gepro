<?php
function muestraVista() {
    require_once("mensajes.php");
    $lCollection = Collection::Singleton();
    ?>
    <!DOCTYPE html>
    <html> 
        <head>
            <meta charset="utf-8">
            <title><?php echo PRONIED; ?></title>
            <meta name="description" content="">
            <meta name="viewport" content="width=device-width">
            <link type="text/css" rel="stylesheet" href="<?php echo RECURSOSPROY; ?>css/estilosbox.css"/>
            <link type="text/css" rel="stylesheet" href="<?php echo RECURSOSPROY; ?>css/tinitable.css" />
            <link type="text/css" rel="stylesheet" href="<?php echo RECURSOSGEN_RECURSOS?>/css/botones.css"  />
            <script>
                function pulsar(e) {
                    tecla = (document.all) ? e.keyCode : e.which;
                    return (tecla != 13);
                }
                function cerrarPopup()
                {
                    parent.$.colorbox.close();
                }
                function openPDF(Pagina)
                {
                    window.open('document.php?Pagina='+Pagina,'_blank');
                }
            </script>
        </head>
        <body id="bg">
            <br>
            
            <!--
            <div id="wrap">
                <div id="content">
                    <form class="formulario" id="formulario" name="formulario">
                        <fieldset>
                            <legend><b> SISTEMA DE GESTIÓN DE CALIDAD</b></legend>
                            A continuación se lista la documentación vigente del sistema.
                            <hr style="border: 1; height: 1; border-color: #3B3A33;"/>
                        </fieldset>
                        <br>
                        <hr style="border: 0; height: 0; box-shadow: 0 0 10px 1px dimgray;">
                        <br>
                        <table border="0" id="table" class="tinytable">
                            <thead>
                                <tr>
                                    <th width="5%"><h3>N&ordm;</h3></th>
                                    <th style="text-align: left;" width="75%"><h3>&nbsp;&nbsp;Contexto de la Organización</h3></th>
                                    <th style="text-align: center;" class="nosort" width="20%"><h3>Descargar</h3></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-21 Registro de Partes Interesadas</td>
                                    <td style="text-align: center;">
                                        <a href="formatosConvenios/4/PRONIED-UGSC-PR-04_Macro_Procesos_de_la_UGSC_Rev_1.pdf" target="_blank"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                        <a href="javascript:openPDF('4/PRONIED-UGSC-FRM-21_Registro_de_Partes_Interesadas')">
                                            <img src="../recursos/images/office/pdf.png" title="Descargar"/>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                                $i = 2;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-27 Matriz FODA Rev 2</td>
                                    <td style="text-align: center;">
                                        <a href="javascript:openPDF('4/PRONIED-UGSC-FRM-27_Matriz_FODA_Rev_2')">
                                            <img src="../recursos/images/office/pdf.png" title="Descargar"/>
                                        </a>
                                        <a href="javascript:openPDF('4/PRONIED-UGSC-FRM-27_Matriz_FODA_Rev_2_2')">
                                            <img src="../recursos/images/office/pdf.png" title="Descargar"/>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                                $i = 3;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-44 Matriz de detalle del mapa de procesos Rev 1</td>
                                    <td style="text-align: center;">
                                        
                                        <a href="javascript:openPDF('4/PRONIED-UGSC-FRM-44_Matriz_de_detalle_del_mapa_de_procesos_Rev_1')">
                                            <img src="../recursos/images/office/pdf.png" title="Descargar"/>
                                        </a>
                                        <a href="javascript:openPDF('4/PRONIED-UGSC-FRM-44_Matriz_de_detalle_del_mapa_de_procesos_Rev_1_2')">
                                            <img src="../recursos/images/office/pdf.png" title="Descargar"/>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                                $i = 4;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-PR-04 Macro Procesos de la UGSC</td>
                                    <td style="text-align: center;">
                                        
                                        <a href="javascript:openPDF('4/PRONIED-UGSC-PR-04_Macro_Procesos_de_la_UGSC')">
                                            <img src="../recursos/images/office/pdf.png" title="Descargar"/>
                                        </a>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                        <br>
                        <table border="0" id="table" class="tinytable">
                            <thead>
                                <tr>
                                    <th width="5%"><h3>N&ordm;</h3></th>
                                    <th style="text-align: left;" width="75%"><h3>&nbsp;&nbsp;Liderazgo</h3></th>
                                    <th style="text-align: center;" class="nosort" width="20%"><h3>Descargar</h3></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-PLT-01 Política de Calidad Rev 1</td>
                                    <td style="text-align: center;">
                                        <a href="javascript:openPDF('5/PRONIED-UGSC-PLT-01_Politica_de_Calidad_Rev_1')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <table border="0" id="table" class="tinytable">
                            <thead>
                                <tr>
                                    <th width="5%"><h3>N&ordm;</h3></th>
                                    <th style="text-align: left;" width="75%"><h3>&nbsp;&nbsp;Planificación</h3></th>
                                    <th style="text-align: center;" class="nosort" width="20%"><h3>Descargar</h3></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-22 Objetivos de la Calidad</td>
                                    <td style="text-align: center;">
                                        
                                        <a href="javascript:openPDF('6/PRONIED-UGSC-FRM-22_Objetivos_de_la_Calidad')">
                                            <img src="../recursos/images/office/pdf.png" title="Descargar"/>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                                $i = 2;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-PR-18 Identificación y Evaluación de Riesgos</td>
                                    <td style="text-align: center;">
                                        
                                        <a href="javascript:openPDF('6/PRONIED-UGSC-PR-18_Identificacion_y_Evaluacion_de_Riesgos')">
                                            <img src="../recursos/images/office/pdf.png" title="Descargar"/>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                                $i = 3;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-26 Plan de Gestión de Riesgos Rev 2 (Con Datos)</td>
                                    <td style="text-align: center;">
                                        
                                        <a href="javascript:openPDF('6/PRONIED-UGSC-FRM-26_Plan_de_Gestion_de_Riesgos_Rev_2')">
                                            <img src="../recursos/images/office/pdf.png" title="Descargar"/>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <table border="0" id="table" class="tinytable">
                            <thead>
                                <tr>
                                    <th width="5%"><h3>N&ordm;</h3></th>
                                    <th style="text-align: left;" width="75%"><h3>&nbsp;&nbsp;Soporte</h3></th>
                                    <th style="text-align: center;" class="nosort" width="20%"><h3>Descargar</h3></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-01 Distribución de Documentos Internos</td>
                                    <td style="text-align: center;">
                                        <a href="formatosConvenios/7/PRONIED-UGSC-FRM-01_Distribucion_de_Documentos_Internos.docx" target="_blank"><img src="../recursos/images/office/word.png" title="Descargar"/></a>
                                        <a href="javascript:openPDF('7/PRONIED-UGSC-FRM-01_Distribucion_de_Documentos_Internos')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 2;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-02 Control de cambios</td>
                                    <td style="text-align: center;">
                                        <a href="formatosConvenios/7/PRONIED-UGSC-FRM-02_Control_de_cambios.docx" target="_blank"><img src="../recursos/images/office/word.png" title="Descargar"/></a>
                                        <a href="javascript:openPDF('7/PRONIED-UGSC-FRM-02_Control_de_cambios')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 3;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-03 Lista Maestra de Documentos Internos</td>
                                    <td style="text-align: center;">
                                        <a href="formatosConvenios/7/PRONIED-UGSC-FRM-03_Lista_Maestra_de_Documentos_Internos.xlxs" target="_blank"><img src="../recursos/images/office/xls.png" title="Descargar"/></a>
                                        <a href="javascript:openPDF('7/PRONIED-UGSC-FRM-03_Lista_Maestra_de_Documentos_Internos')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 4;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-04 Lista Maestra de Documentos Externos</td>
                                    <td style="text-align: center;">
                                        <a href="formatosConvenios/7/PRONIED-UGSC-FRM-04_Lista_Maestra_de_Documentos_Externos.xlsx" target="_blank"><img src="../recursos/images/office/xls.png" title="Descargar"/></a>
                                        <a href="javascript:openPDF('7/PRONIED-UGSC-FRM-04_Lista_Maestra_de_Documentos_Externos')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 5;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-05 Lista Maestra de Registros</td>
                                    <td style="text-align: center;">
                                        <a href="formatosConvenios/7/PRONIED-UGSC-FRM-05_Lista_Maestra_de_Registros.xlsx" target="_blank"><img src="../recursos/images/office/xls.png" title="Descargar"/></a>
                                        <a href="javascript:openPDF('7/PRONIED-UGSC-FRM-05_Lista_Maestra_de_Registros')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 6;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-06 Distribución de Documentos Externos</td>
                                    <td style="text-align: center;">
                                        <a href="formatosConvenios/7/PRONIED-UGSC-FRM-06_Distribucion_de_Documentos_Externos.docx" target="_blank"><img src="../recursos/images/office/word.png" title="Descargar"/></a>
                                        <a href="javascript:openPDF('7/PRONIED-UGSC-FRM-06_Distribucion_de_Documentos_Externos')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 7;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-10 Registro de asistencia</td>
                                    <td style="text-align: center;">
                                        <a href="formatosConvenios/7/PRONIED-UGSC-FRM-10_Registro_de_asistencia.xlsx" target="_blank"><img src="../recursos/images/office/xls.png" title="Descargar"/></a>
                                        <a href="javascript:openPDF('7/PRONIED-UGSC-FRM-10_Registro_de_asistencia')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 8;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-12 PDA Empleado</td>
                                    <td style="text-align: center;">
                                        <a href="formatosConvenios/7/PRONIED-UGSC-FRM-12_PDA_Empleado.xlsx" target="_blank"><img src="../recursos/images/office/xls.png" title="Descargar"/></a>
                                        <a href="javascript:openPDF('7/PRONIED-UGSC-FRM-12_PDA_Empleado')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 9;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-13 PDA Evaluador</td>
                                    <td style="text-align: center;">
                                        <a href="formatosConvenios/7/PRONIED-UGSC-FRM-13_PDA_Evaluador.xlsx" target="_blank"><img src="../recursos/images/office/xls.png" title="Descargar"/></a>
                                        <a href="javascript:openPDF('7/PRONIED-UGSC-FRM-13_PDA_Evaluador')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 10;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-14 Organigrama Matricial</td>
                                    <td style="text-align: center;">
                                        <a href="formatosConvenios/7/PRONIED-UGSC-FRM-14_Organigrama_Matricial.xlsx" target="_blank"><img src="../recursos/images/office/xls.png" title="Descargar"/></a>
                                        <a href="javascript:openPDF('7/PRONIED-UGSC-FRM-14_Organigrama_Matricial')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 11;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-23 Entrega de documentos al archivo</td>
                                    <td style="text-align: center;">
                                        <a href="formatosConvenios/7/PRONIED-UGSC-FRM-23_Entrega_de_documentos_al_archivo.docx" target="_blank"><img src="../recursos/images/office/word.png" title="Descargar"/></a>
                                        <a href="javascript:openPDF('7/PRONIED-UGSC-FRM-23_Entrega_de_documentos_al_archivo')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 12;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-24 Solicitud de préstamo de documentos</td>
                                    <td style="text-align: center;">
                                        <a href="formatosConvenios/7/PRONIED-UGSC-FRM-24_Solicitud_de_prestamo_de_documentos.docx" target="_blank"><img src="../recursos/images/office/word.png" title="Descargar"/></a>
                                        <a href="javascript:openPDF('7/PRONIED-UGSC-FRM-24_Solicitud_de_prestamo_de_documentos')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 13;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-28 Plan de Capacitaciones</td>
                                    <td style="text-align: center;">
                                        <a href="formatosConvenios/7/PRONIED-UGSC-FRM-28_Plan_de_Capacitaciones.xlsx" target="_blank"><img src="../recursos/images/office/xls.png" title="Descargar"/></a>
                                        <a href="javascript:openPDF('7/PRONIED-UGSC-FRM-28_Plan_de_Capacitaciones')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                        <a href="javascript:openPDF('7/PRONIED-UGSC-FRM-28_Plan_de_Capacitaciones2')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 14;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-40 Glosario de Términos</td>
                                    <td style="text-align: center;">
                                        <a href="javascript:openPDF('7/PRONIED-UGSC-FRM-40_Glosario_de_Terminos')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 15;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-IT-01 Organización del Archivo de Gestión de la UGSC</td>
                                    <td style="text-align: center;">
                                        <a href="javascript:openPDF('7/PRONIED-UGSC-IT-01_Organizacion_del_Archivo_de_Gestion_de_la_UGSC')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 16;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-MN-02 Manual de Perfiles y Puestos</td>
                                    <td style="text-align: center;">
                                        <a href="javascript:openPDF('7/PRONIED-UGSC-MN-02_Manual_de_Perfiles_y_Puestos')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 17;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-MN-03 Manual Evaluación del Desempeño</td>
                                    <td style="text-align: center;">
                                        <a href="javascript:openPDF('7/PRONIED-UGSC-MN-03_Manual_Evaluacion_del_Desempenio')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 18;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-PR-01 Elaboracion y Control de Documentos</td>
                                    <td style="text-align: center;">
                                        <a href="javascript:openPDF('7/PRONIED-UGSC-PR-01_Elaboracion_y_Control_de_Documentos')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 19;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-PR-02 Elaboracion de Formatos y Control de Registros</td>
                                    <td style="text-align: center;">
                                        <a href="javascript:openPDF('7/PRONIED-UGSC-PR-02_Elaboracion_de_Formatos_y_Control_de_Registros')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <table border="0" id="table" class="tinytable">
                            <thead>
                                <tr>
                                    <th width="5%"><h3>N&ordm;</h3></th>
                                    <th style="text-align: left;" width="75%"><h3>&nbsp;&nbsp;Operación</h3></th>
                                    <th style="text-align: center;" class="nosort" width="20%"><h3>Descargar</h3></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-11 Lista requisitos legales</td>
                                    <td style="text-align: center;">
                                        <a href="formatosConvenios/8/PRONIED-UGSC-FRM-11_Lista_requisitos_legales.xlsx" target="_blank"><img src="../recursos/images/office/xls.png" title="Descargar"/></a>
                                        <a href="javascript:openPDF('8/PRONIED-UGSC-FRM-15_Programa_de_auditorias_Rev_1')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 2;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-25 Control de documentos del proyecto</td>
                                    <td style="text-align: center;">
                                        <a href="formatosConvenios/8/PRONIED-UGSC-FRM-25_Control_de_documentos_del_proyecto.xlsx" target="_blank"><img src="../recursos/images/office/xls.png" title="Descargar"/></a>
                                        <a href="javascript:openPDF('8/PRONIED-UGSC-FRM-25_Control_de_documentos_del_proyecto')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 3;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-29 Información y Reporte del Avance del Proyecto</td>
                                    <td style="text-align: center;">
                                        <a href="formatosConvenios/8/PRONIED-UGSC-FRM-29_Informacion_y_Reporte_del_Avance_del_Proyecto.xlsx" target="_blank"><img src="../recursos/images/office/xls.png" title="Descargar"/></a>
                                        <a href="javascript:openPDF('8/PRONIED-UGSC-FRM-29_Informacion_y_Reporte_del_Avance_del_Proyecto')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 4;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-31 Informe de inspección técnica a obra</td>
                                    <td style="text-align: center;">
                                        <a href="formatosConvenios/8/PRONIED-UGSC-FRM-31_Informe_de_inspeccion_tecnica_a_obra.docx" target="_blank"><img src="../recursos/images/office/word.png" title="Descargar"/></a>
                                        <a href="javascript:openPDF('8/PRONIED-UGSC-FRM-31_Informe_de_inspeccion_tecnica_a_obra')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 5;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-32 Ruta mensual de Seguimiento</td>
                                    <td style="text-align: center;">
                                        <a href="formatosConvenios/8/PRONIED-UGSC-FRM-32_Ruta_mensual_de_Seguimiento.xlsx" target="_blank"><img src="../recursos/images/office/xls.png" title="Descargar"/></a>
                                        <a href="javascript:openPDF('8/PRONIED-UGSC-FRM-32_Ruta_mensual_de_Seguimiento')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 6;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-33 Metas, metrados y costos del proyecto</td>
                                    <td style="text-align: center;">
                                        <a href="formatosConvenios/8/PRONIED-UGSC-FRM-33_Metas_metrados_y_costos_del proyecto.xlsx" target="_blank"><img src="../recursos/images/office/xls.png" title="Descargar"/></a>
                                        <a href="javascript:openPDF('8/PRONIED-UGSC-FRM-33_Metas_metrados_y_costos_del proyecto')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 7;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-34 Notificación</td>
                                    <td style="text-align: center;">
                                        <a href="formatosConvenios/8/PRONIED-UGSC-FRM-34_Notificacion.docx" target="_blank"><img src="../recursos/images/office/word.png" title="Descargar"/></a>
                                        <a href="javascript:openPDF('8/PRONIED-UGSC-FRM-34_Notificacion')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 8;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-35 Ficha Técnica del Proyecto</td>
                                    <td style="text-align: center;">
                                        <a href="formatosConvenios/8/PRONIED-UGSC-FRM-35_Ficha_Tecnica_del_Proyecto.docx" target="_blank"><img src="../recursos/images/office/word.png" title="Descargar"/></a>
                                        <a href="javascript:openPDF('8/PRONIED-UGSC-FRM-35_Ficha_Tecnica_del_Proyecto')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 9;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-36 Registro de cambio y-o quejas</td>
                                    <td style="text-align: center;">
                                        <a href="formatosConvenios/8/PRONIED-UGSC-FRM-36_Registro_de_cambio_y-o_quejas.xls" target="_blank"><img src="../recursos/images/office/xls.png" title="Descargar"/></a>
                                        <a href="javascript:openPDF('8/PRONIED-UGSC-FRM-36_Registro_de_cambio_y-o_quejas')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 10;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-38 Identificación de Convenios Condicionados</td>
                                    <td style="text-align: center;">
                                        <a href="formatosConvenios/8/PRONIED-UGSC-FRM-38_Identificacion_de_Convenios_Condicionados.xlsx" target="_blank"><img src="../recursos/images/office/xls.png" title="Descargar"/></a>
                                        <a href="javascript:openPDF('8/PRONIED-UGSC-FRM-38_Identificacion_de_Convenios_Condicionados')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 11;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-39 Catálogo del producto</td>
                                    <td style="text-align: center;">
                                        <a href="javascript:openPDF('8/PRONIED-UGSC-FRM-39_Catalogo_del_producto2')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 12;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-41 Lecciones Aprendidas</td>
                                    <td style="text-align: center;">
                                        <a href="formatosConvenios/8/PRONIED-UGSC-FRM-41_Lecciones_Aprendidas.xls" target="_blank"><img src="../recursos/images/office/xls.png" title="Descargar"/></a>
                                        <a href="javascript:openPDF('8/PRONIED-UGSC-FRM-41_Lecciones_Aprendidas')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 13;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-45 Matriz de evaluación de proveedores Rev 1</td>
                                    <td style="text-align: center;">
                                        <a href="javascript:openPDF('8/PRONIED-UGSC-FRM-45_Matriz_de_evaluacion_de_proveedores_Rev_1')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                        <a href="javascript:openPDF('8/PRONIED-UGSC-FRM-45_Matriz_de_evaluacion_de_proveedores_Rev_1_2')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 14;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-IT-02 Liberación del Producto</td>
                                    <td style="text-align: center;">
                                        <a href="javascript:openPDF('8/PRONIED-UGSC-IT-02_Liberacion_del_Producto')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 15;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-MN-01 Manual del Sistema de Gestión de la Calidad</td>
                                    <td style="text-align: center;">
                                        <a href="javascript:openPDF('8/PRONIED-UGSC-MN-01_Manual_del_Sistema_de_Gestión_de_la_Calidad')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 16;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-MN-04 Manual del Corte de Información</td>
                                    <td style="text-align: center;">
                                        <a href="javascript:openPDF('8/PRONIED-UGSC-MN-04_Manual_del_Corte_de_Informacion')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 17;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-MN-05 Manual de Usuario-Llenado de Base de Datos</td>
                                    <td style="text-align: center;">
                                        <a href="javascript:openPDF('8/PRONIED-UGSC-MN-05_Manual_de_Usuario-Llenado_de_Base_de_Datos')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 18;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-PR-07 Contrataciones de Bienes y Servicios de la UGSC</td>
                                    <td style="text-align: center;">
                                        <a href="javascript:openPDF('8/PRONIED-UGSC-PR-07_Contrataciones_de_Bienes_y_Servicios_de_la_UGSC')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 19;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-PR-08 Identificación de Proyectos</td>
                                    <td style="text-align: center;">
                                        <a href="javascript:openPDF('8/PRONIED-UGSC-PR-08_Identificacion_de_Proyectos')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 20;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-PR-09 Planificación de las Operaciones</td>
                                    <td style="text-align: center;">
                                        <a href="javascript:openPDF('8/PRONIED-UGSC-PR-09_Planificacion_de_las_Operaciones')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 21;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-PR-10 Seguimiento y Monitoreo a la Incorporación de Recursos Transferidos a las Unidades Ejecutoras</td>
                                    <td style="text-align: center;">
                                        <a href="javascript:openPDF('8/PRONIED-UGSC-PR-10_Seguimiento_y_Monitoreo_a_la_Incorporacion_de_Recursos_Transferidos_a_las_Unidades_Ejecutoras')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 22;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-PR-11 Seguimiento y Monitoreo a la Selección, Elaboración y Aprobación del Expediente Técnico</td>
                                    <td style="text-align: center;">
                                        <a href="javascript:openPDF('8/PRONIED-UGSC-PR-11_Seguimiento_y_Monitoreo_a_la_Seleccion_Elaboracion_y_Aprobacion_del_Expediente_Tecnico')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 23;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-PR-12 Seguimiento y Monitoreo al Proceso de Selección de Ejecutores de Obra</td>
                                    <td style="text-align: center;">
                                        <a href="javascript:openPDF('8/PRONIED-UGSC-PR-12_Seguimiento_y_Monitoreo_al_Proceso_de_Selección_de_Ejecutores_de_Obra')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 24;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-PR-13 Seguimiento y Monitoreo a la Ejecución de Obra</td>
                                    <td style="text-align: center;">
                                        <a href="javascript:openPDF('8/PRONIED-UGSC-PR-13_Seguimiento_y_Monitoreo_a_la_Ejecucion_de_Obra')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 25;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-PR-14 Emisión de Reportes</td>
                                    <td style="text-align: center;">
                                        <a href="javascript:openPDF('8/PRONIED-UGSC-PR-14_Emision_de_Reportes')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 26;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-PR-15 Control de Calidad de la Base de Datos de Transferencias</td>
                                    <td style="text-align: center;">
                                        <a href="javascript:openPDF('8/PRONIED-UGSC-PR-15_Control_de_la_Calidad_de_la_Base_de_Datos_de_Transferencias')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 27;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-PR-16 Comunicaciones</td>
                                    <td style="text-align: center;">
                                        <a href="javascript:openPDF('8/PRONIED-UGSC-PR-16_Comunicaciones')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 28;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-PR-17 Producto No Conforme</td>
                                    <td style="text-align: center;">
                                        <a href="javascript:openPDF('8/PRONIED-UGSC-PR-17_Producto_No_Conforme')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <table border="0" id="table" class="tinytable">
                            <thead>
                                <tr>
                                    <th width="5%"><h3>N&ordm;</h3></th>
                                    <th style="text-align: left;" width="75%"><h3>&nbsp;&nbsp;Evaluación de Desempeño</h3></th>
                                    <th style="text-align: center;" class="nosort" width="20%"><h3>Descargar</h3></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-15 Programa de Auditorias</td>
                                    <td style="text-align: center;">
                                        <a href="formatosConvenios/9/PRONIED-UGSC-FRM-15_Programa_de_Auditorias.xlsx" target="_blank"><img src="../recursos/images/office/xls.png" title="Descargar"/></a>
                                        <a href="javascript:openPDF('9/PRONIED-UGSC-FRM-15_Programa_de_Auditorias')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                        <a href="javascript:openPDF('9/PRONIED-UGSC-FRM-15_Programa_de_Auditorias2')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 2;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-16 Plan de Auditorías</td>
                                    <td style="text-align: center;">
                                        <a href="formatosConvenios/9/PRONIED-UGSC-FRM-16_Plan_de_Auditorias.docx" target="_blank"><img src="../recursos/images/office/word.png" title="Descargar"/></a>
                                        <a href="javascript:openPDF('9/PRONIED-UGSC-FRM-16_Plan_de_Auditorias')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                        <a href="javascript:openPDF('9/PRONIED-UGSC-FRM-16_Plan_de_Auditorias2')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 3;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-17 Control de Auditorías</td>
                                    <td style="text-align: center;">
                                       <a href="formatosConvenios/9/PRONIED-UGSC-FRM-17_Control_de_Auditorias.xlsx" target="_blank"><img src="../recursos/images/office/word.png" title="Descargar"/></a>
                                       <a href="javascript:openPDF('9/PRONIED-UGSC-FRM-17_Control_de_Auditorias')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                       <a href="javascript:openPDF('9/PRONIED-UGSC-FRM-17_Control_de_Auditorias2')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 4;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-18 Informe de Auditorías</td>
                                    <td style="text-align: center;">
                                       <a href="formatosConvenios/9/PRONIED-UGSC-FRM-18_Informe_de_Auditorias.docx" target="_blank"><img src="../recursos/images/office/word.png" title="Descargar"/></a>
                                       <a href="javascript:openPDF('9/PRONIED-UGSC-FRM-18_Informe_de_Auditorias')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                       <a href="javascript:openPDF('9/PRONIED-UGSC-FRM-18_Informe_de_Auditorias2')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    
                                    </td>
                                </tr>
                                <?php
                                $i = 5;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-19 Minuta de Revisión por la Dirección</td>
                                    <td style="text-align: center;">
                                       <a href="formatosConvenios/9/PRONIED-UGSC-FRM-19_Minuta_de_Revision_por_la_Direccion.docx" target="_blank"><img src="../recursos/images/office/word.png" title="Descargar"/></a>
                                       <a href="javascript:openPDF('9/PRONIED-UGSC-FRM-19_Minuta_de_Revision_por_la_Direccion')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                       <a href="javascript:openPDF('9/PRONIED-UGSC-FRM-19_Minuta_de_Revision_por_la_Direccion2')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                       </td>
                                </tr>
                                <?php
                                $i = 6;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-20 Encuesta Medición de Satisfacción del Cliente</td>
                                    <td style="text-align: center;">
                                       <a href="formatosConvenios/9/PRONIED-UGSC-FRM-20_Encuesta_Medicion_de_Satisfaccion_del_Cliente.docx" target="_blank"><img src="../recursos/images/office/word.png" title="Descargar"/></a>
                                       <a href="javascript:openPDF('9/PRONIED-UGSC-FRM-20_Encuesta_Medicion_de_Satisfaccion_del_Cliente')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 7;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-PR-05 Auditorías Internas</td>
                                    <td style="text-align: center;">
                                       <a href="javascript:openPDF('9/PRONIED-UGSC-PR-05_Auditorias_Internas')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 8;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-PR-06 Revisión por la Dirección</td>
                                    <td style="text-align: center;">
                                       <a href="javascript:openPDF('9/PRONIED-UGSC-PR-06_Revision_por_la_Direccion')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 9;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-15 Programa de auditoría (Para el año 2016)</td>
                                    <td style="text-align: center;">
                                       <a href="javascript:openPDF('9/PRONIED-UGSC-FRM-15_Programa_de_auditoria_Para_el_anio_2016)')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 10;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-42 Evaluación desempeño - profesionales de campo Rev 1</td>
                                    <td style="text-align: center;">
                                        <a href="formatosConvenios/9/PRONIED-UGSC-FRM-42_Evaluacion_desempenio-profesionales_de_campo_Rev_1.xlsm" target="_blank"><img src="../recursos/images/office/xls.png" title="Descargar"/></a>
                                        <a href="javascript:openPDF('9/PRONIED-UGSC-FRM-42_Evaluacion_desempenio-profesionales_de_campo_Rev_1')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 11;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-46 Programa de revisión por la dirección Rev 1</td>
                                    <td style="text-align: center;">
                                       <a href="javascript:openPDF('9/PRONIED-UGSC-FRM-46_Programa_de_revision_por_la_dirección_Rev_1')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                       <a href="javascript:openPDF('9/PRONIED-UGSC-FRM-46_Programa_de_revision_por_la_dirección_Rev_1_2')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <table border="0" id="table" class="tinytable">
                            <thead>
                                <tr>
                                    <th width="5%"><h3>N&ordm;</h3></th>
                                    <th style="text-align: left;" width="75%"><h3>&nbsp;&nbsp;Mejora</h3></th>
                                    <th style="text-align: center;" class="nosort" width="20%"><h3>Descargar</h3></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-07 Solicitud de Acciones Correctivas</td>
                                    <td style="text-align: center;">
                                        <a href="formatosConvenios/10/PRONIED-UGSC-FRM-07_Solicitud_de_Acciones_Correctivas.xlsx" target="_blank"><img src="../recursos/images/office/xls.png" title="Descargar"/></a>
                                        <a href="javascript:openPDF('10/PRONIED-UGSC-FRM-07_Solicitud_de_Acciones_Correctivas')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 2;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-08 Control de levantamiento de Observaciones y Sugerencias</td>
                                    <td style="text-align: center;">
                                        <a href="formatosConvenios/10/PRONIED-UGSC-FRM-08_Control_de_levantamiento_de_Observaciones_y_Sugerencias.xlsx" target="_blank"><img src="../recursos/images/office/xls.png" title="Descargar"/></a>
                                        <a href="javascript:openPDF('10/PRONIED-UGSC-FRM-08_Control_de_levantamiento_de_Observaciones_y_Sugerencias"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 3;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-FRM-09 Control de Solicitudes de Acciones Correctivas</td>
                                    <td style="text-align: center;">
                                        <a href="formatosConvenios/10/PRONIED-UGSC-FRM-09_Control_de_Solicitudes_de_Acciones_Correctivas.xlsx" target="_blank"><img src="../recursos/images/office/xls.png" title="Descargar"/></a>
                                        <a href="javascript:openPDF('10/PRONIED-UGSC-FRM-09_Control_de_Solicitudes_de_Acciones_Correctivas')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 4;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>PRONIED-UGSC-PR-03 No Conformidades y Acciones Correctivas</td>
                                    <td style="text-align: center;">
                                        <a href="javascript:openPDF('10/PRONIED-UGSC-PR-03_No_Conformidades_y_Acciones_correctivas')"><img src="../recursos/images/office/pdf.png" title="Descargar"/></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
            -->
            
            PÁGINA EN CONSTRUCCIÓN
        </body>
    </html>
    <?php
}
?>
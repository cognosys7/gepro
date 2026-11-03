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
            </script>
        </head>
        <body id="bg">
            <br>
            <!--
            <div id="wrap">
                <div id="content">
                    <form class="formulario" id="formulario" name="formulario">
                        <fieldset>
                            <legend><b> FORMATOS A DESCARGAR</b></legend>
                            A continuación se listarán un listado de formatos disponibles para su descarga.
                            <hr style="border: 1; height: 1; border-color: #3B3A33;"/>
                        </fieldset>
                        <br>
                        <hr style="border: 0; height: 0; box-shadow: 0 0 10px 1px dimgray;">
                        <br>
                        <table border="0" id="table" class="tinytable">
                            <thead>
                                <tr>
                                    <th width="5%"><h3>N&ordm;</h3></th>
                                    <th style="text-align: left;" width="75%"><h3>&nbsp;&nbsp;Nombre del Formato</h3></th>
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
                                    <td>Formato de registro de usuarios.</td>
                                    <td style="text-align: center;">
                                        <a href="formatos/ficha_registro_usuarios.xlsx" target="_blank"><img src="../recursos/images/office/xls.png"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 2;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>Formato de bienes (Patrimonio) - (Cargo en uso de bienes muebles, papeleta de devolución de bienes patrimoniales, autorización de salida y retorno de bienes patrimoniales, autorización de ingreso y retiro de bienes de terceros, autorización de movimiento de bienes de alto tránsito).</td>
                                    <td style="text-align: center;">
                                        <a href="formatos/Formato_de_cargo_en_uso.xls" target="_blank"><img src="../recursos/images/office/xls.png"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 3;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>Formato de solicitud de acceso al servicio de internet institucional.</td>
                                    <td style="text-align: center;">
                                        <a href="formatos/s01_v5.xls" target="_blank"><img src="../recursos/images/office/xls.png"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 4;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>Formato de solicitud de servicio de correo y acceso a la red.</td>
                                    <td style="text-align: center;">
                                        <a href="formatos/s02_v_Final.xls" target="_blank"><img src="../recursos/images/office/xls.png"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 5;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>Formato de solicitud del servicio de telefonía móvil.</td>
                                    <td style="text-align: center;">
                                        <a href="formatos/s06_v3.xls" target="_blank"><img src="../recursos/images/office/xls.png"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 6;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>Formato de solicitud del servicio de acceso a los sistemas de información.</td>
                                    <td style="text-align: center;">
                                        <a href="formatos/s09_v2.xls" target="_blank"><img src="../recursos/images/office/xls.png"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 7;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>Formato de respaldo PRONIED</td>
                                    <td style="text-align: center;">
                                        <a href="formatos/Formato_de_Respaldo_PRONIED.xlsx" target="_blank"><img src="../recursos/images/office/xls.png"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 8;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>Formato de respaldo restauración</td>
                                    <td style="text-align: center;">
                                        <a href="formatos/Formato_de_Respaldo_Restauracion.xlsx" target="_blank"><img src="../recursos/images/office/xls.png"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 9;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>Checklist - Equipos de Cómputo</td>
                                    <td style="text-align: center;">
                                        <a href="formatos/CHECKLIST_FORMATO_PRONIED.xlsx" target="_blank"><img src="../recursos/images/office/xls.png"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 10;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>Lista de chequeo de cambio de equipo</td>
                                    <td style="text-align: center;">
                                        <a href="formatos/Lista_de_Chequeo_de_Cambio_de_Equipo.xlsx" target="_blank"><img src="../recursos/images/office/xls.png"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 11;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>Lista de chequeo de entrega de equipo</td>
                                    <td style="text-align: center;">
                                        <a href="formatos/Lista_de_Chequeo_de_Entrega_de_Equipo.xlsx" target="_blank"><img src="../recursos/images/office/xls.png"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 12;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>Lista de chequeo de recojo de equipo</td>
                                    <td style="text-align: center;">
                                        <a href="formatos/Lista_de_Chequeo_de_Recojo_del_Equipo.xlsx" target="_blank"><img src="../recursos/images/office/xls.png"/></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <legend><b> ENCABEZADOS DE DOCUMENTOS POR OFICINA</b></legend>
                        <table border="0" id="table" class="tinytable">
                            <thead>
                                <tr>
                                    <th width="5%"><h3>N&ordm;</h3></th>
                                    <th style="text-align: left;" width="75%"><h3>&nbsp;&nbsp;Nombre de la Imagen</h3></th>
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
                                    <td>Logo Pronied</td>
                                    <td style="text-align: center;">
                                        <a href="formatos/Logo_Pronied.jpg" target="_blank"><img src="../recursos/images/office/pictures.png"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 2;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>Logo Oficina de Asesoría Jurídica</td>
                                    <td style="text-align: center;">
                                        <a href="formatos/Oficina_de_Asesoria.jpg" target="_blank"><img src="../recursos/images/office/pictures.png"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 3;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>Logo Oficina de Planeamiento Estratégico y Presupuesto</td>
                                    <td style="text-align: center;">
                                        <a href="formatos/Oficina_Planeamiento_Estrategico_Presupuesto.jpg" target="_blank"><img src="../recursos/images/office/pictures.png"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 4;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>Logo Oficina General de Administración</td>
                                    <td style="text-align: center;">
                                        <a href="formatos/Oficina_General_Administracion.jpg" target="_blank"><img src="../recursos/images/office/pictures.png"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 5;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>Logo Unidad Gerencial de Estudios y Obras</td>
                                    <td style="text-align: center;">
                                        <a href="formatos/Unidad_Gerencial_Estudios_Obras.jpg" target="_blank"><img src="../recursos/images/office/pictures.png"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 6;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>Logo Unidad Gerencial de Mantenimiento</td>
                                    <td style="text-align: center;">
                                        <a href="formatos/Unidad_Gerencial_Mantenimiento.jpg" target="_blank"><img src="../recursos/images/office/pictures.png"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 7;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>Logo Unidad Gerencial de Mobiliario y Equipamiento</td>
                                    <td style="text-align: center;">
                                        <a href="formatos/Unidad_Gerencial_Mobiliario_Equipamiento.jpg" target="_blank"><img src="../recursos/images/office/pictures.png"/></a>
                                    </td>
                                </tr>
                                <?php
                                $i = 8;
                                $ColorX = ColorFilaNaranja($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #E3C99F; color: #704A0E;"><?php echo $i; ?>-</td>
                                    <td>Logo Unidad Gerencial de Supervision de Convenios</td>
                                    <td style="text-align: center;">
                                        <a href="formatos/Unidad_Gerencial_Supervision_Convenios.jpg" target="_blank"><img src="../recursos/images/office/pictures.png"/></a>
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
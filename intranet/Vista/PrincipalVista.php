<?php
function muestraVista() {
    $lCollection = Collection::Singleton();
    $Process        = $lCollection->Get('Process');
    $Mensaje        = $lCollection->Get('Mensaje');
    $CUsu           = $lCollection->Get('CodigoUsuario');
    if ($Process == 1)
    {
        $DNIUser    = $lCollection->Get('DNIUser');
        $ImgDato    = $lCollection->Get('ImgDato'); 
    }
    else
    {
        $DNIUser    = "";
        $ImgDato    = "";
    }
    ?>
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY?>/js/Seguridad/Seguridad.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY?>/js/validacion/reglas.js"></script>
    <!--FONDO DE FORM FORM DEL LOGIN-->
    <form id="login-form" action="index.php" method="post" style="border:0px; background-color: rgba(255, 255, 255, 0.75); margin-top: 12vh;">
        <input type="hidden" name="Pagina" value="Principal">
        <input type="hidden" name="ActionForm" id="ActionForm" value="Verificar">
        <input type="hidden" name="pCaptcha" id="pCaptcha" value="" />
        <input type="hidden" name="cUs" id="cUs" value="<?php echo $CUsu;?>" />
        <table style="width:100%; font-size: 11px; margin-top: 0px; "border="0">
            <tr>
                <td colspan="3">
                    <center><img width="50%" src="../Recursos/images/gepro.png"></center>
                </td>
            </tr>
            <tr>
                <td style="width: 5%"></td-->
                <td style="width: 90%">
                    
                    
                     <!--si es entrada normal: TITULO , $Process = 1-->
                    <div id="TitulForm1" <?php if ($Process == 1){?>style="display: none"<?php }?>>
                        <center><h3><!--span style="color: #E59549;">Bienvenido</span> <br--><span style="color:#107AE7; font-weight:bold; font-size:22; ">SISTEMA PARA OFICINA DE GESTIÓN DE PROYECTOS</span></h3></center>
                    </div>


                    <!--si es entrada para resetear: TITULO , $Process = 0-->
                    <div id="TitulForm2" <?php if ($Process == 0){?>style="display: none"<?php }?>>
                    <center><h3><span style="color:#A6131B;">Recuperar Contraseña</span></h3></center>
                    </div>
                    <?php if (strlen($Mensaje)>0) { ?><span class="error"><?php echo MensajeError($Mensaje); }?></span>
            
                    
                    
                    
                    <!--si es entrada normal: USUARIO - CLAVE , $Process = 1-->
                    <div id="LoginFormV" <?php if ($Process == 1){?>style="display: none"<?php }?>>
                    <div class="control-group">
                        <div class="controls">
                            <h5 style="display: inline-block; font-size:13; font-weight: bold; color:black; ">Usuario</h5> 
                            <br>
                            <img src="../Recursos/images/users/1479346788_icons_user.png"> <input type="text" style="width: 90%;" maxlength="40" autocomplete="off" name="usuario" id="LoginForm_username" placeholder="Ingrese su Usuario" class="input-block-level" />
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <h5 style="display: inline-block; font-size:13; font-weight: bold; color:black; ">Contraseña</h5>
                            <br>
                            <img src="../Recursos/images/users/1479346793_key.png"> <input type="password" style="width: 90%" minlength="5" autocomplete="off" name="clave" id="LoginForm_password" placeholder="Ingrese su Contraseña" class="input-block-level" />
                        </div>
                    </div>
                    </div>
                    
                    
                    <!--si es entrada para resetear: IMAGENES DE RESPUESTA DE CLAVE , $Process = 0-->
                    <div id="ResetFormV" <?php if ($Process == 0){?>style="display: none"<?php }?>>
                        <div class="control-group">
                            <div class="controls">
                                <h5 style="display: inline-block; font-size:13; font-weight: bold; color:black; ">Usuario</h5> 
                                <br>
                                <input <?php if ($Process == 1){?>readonly=""<?php }?> type="text" value="<?php echo $DNIUser;?>" autocomplete="off" onkeypress="return acceptNum(event);" name="dni" maxlength="8" id="LoginForm_DNI" placeholder="Ingrese su Usuario" class="input-block-level" />
                            </div>
                        </div>
                        <?php 
                        if (strlen($DNIUser)>0)
                        {
                        ?>
                        <div class="control-group">
                            <div class="controls">
                                <h5 style="display: inline-block; font-size:13; font-weight: bold; color:black; ">
                                Seleccione su imagen de seguridad
                                </h5>
                                <?php 
                                $lstValores = CallImgsAleatorio($ImgDato,1);
                                ?>
                                <table style="width: 100%">
                                    <tr>
                                        <td style="text-align: center;"><img src="../recursos/images/icons_security/icon<?php echo $lstValores[0]?>.png"></td>
                                        <td style="text-align: center;"><img src="../recursos/images/icons_security/icon<?php echo $lstValores[1]?>.png"></td>
                                        <td style="text-align: center;"><img src="../recursos/images/icons_security/icon<?php echo $lstValores[2]?>.png"></td>
                                        <td style="text-align: center;"><img src="../recursos/images/icons_security/icon<?php echo $lstValores[3]?>.png"></td>
                                        <td style="text-align: center;"><img src="../recursos/images/icons_security/icon<?php echo $lstValores[4]?>.png"></td>
                                        <td style="text-align: center;"><img src="../recursos/images/icons_security/icon<?php echo $lstValores[5]?>.png"></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;"><input type="radio" name="valsec" value="<?php echo $lstValores[0]?>"></td>
                                        <td style="text-align: center;"><input type="radio" name="valsec" value="<?php echo $lstValores[1]?>"></td>
                                        <td style="text-align: center;"><input type="radio" name="valsec" value="<?php echo $lstValores[2]?>"></td>
                                        <td style="text-align: center;"><input type="radio" name="valsec" value="<?php echo $lstValores[3]?>"></td>
                                        <td style="text-align: center;"><input type="radio" name="valsec" value="<?php echo $lstValores[4]?>"></td>
                                        <td style="text-align: center;"><input type="radio" name="valsec" value="<?php echo $lstValores[5]?>"></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;"><img src="../recursos/images/icons_security/icon<?php echo $lstValores[6]?>.png"></td>
                                        <td style="text-align: center;"><img src="../recursos/images/icons_security/icon<?php echo $lstValores[7]?>.png"></td>
                                        <td style="text-align: center;"><img src="../recursos/images/icons_security/icon<?php echo $lstValores[8]?>.png"></td>
                                        <td style="text-align: center;"><img src="../recursos/images/icons_security/icon<?php echo $lstValores[9]?>.png"></td>
                                        <td style="text-align: center;"><img src="../recursos/images/icons_security/icon<?php echo $lstValores[10]?>.png"></td>
                                        <td style="text-align: center;"><img src="../recursos/images/icons_security/icon<?php echo $lstValores[11]?>.png"></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;"><input type="radio" name="valsec" value="<?php echo $lstValores[6]?>"></td>
                                        <td style="text-align: center;"><input type="radio" name="valsec" value="<?php echo $lstValores[7]?>"></td>
                                        <td style="text-align: center;"><input type="radio" name="valsec" value="<?php echo $lstValores[8]?>"></td>
                                        <td style="text-align: center;"><input type="radio" name="valsec" value="<?php echo $lstValores[9]?>"></td>
                                        <td style="text-align: center;"><input type="radio" name="valsec" value="<?php echo $lstValores[10]?>"></td>
                                        <td style="text-align: center;"><input type="radio" name="valsec" value="<?php echo $lstValores[11]?>"></td>
                                    </tr>
                                    
                                </table>
                            </div>
                        </div>
                        <?php 
                        }
                        ?>
                    </div>
                    
                    
                    <!--codigo catchan-->
                    <div class="control-group">
                        <div class="controls" style="display: inline-block; font-size:13; font-weight: bold; color:black; ">
                            Ingrese el resultado:<br>
                            <div class="re">Pregunta:</div>
                            <!--<div style="text-align:center;">-->
<!--                                <div style="float: left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                <div style="float: left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                <div style="float: left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                <div style="float: left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                <div style="float: left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>-->
                                <div class="rand1"></div>
                                <div class="plus">x</div>
                                <div class="rand2"></div>
                            <!--</div>-->
                        </div>
                    </div>
                                        
                    <!--respuesta de catchan-->
                    <div class="control-group">
                        <div class="controls">
                            <h5 style="display: inline-block; font-size:13; font-weight: bold; color:black; ">Resultado</h5> 
                            <br>
                            <img src="../Recursos/images/users/1479347078_equal.png"> 
                            <input type="text" style="width: 90%" autocomplete="off" name="total" id="LoginForm_total" maxlength="3" onkeypress="return acceptNumLog(event);" placeholder="Ingrese su Respuesta" class="input-block-level" />
                        </div>
                    </div>
                    
                    
                    
                    <!--si es entrada normal: BOTON INGRESAR, $Process = 1-->
                    <div id="LoginButton" <?php if ($Process == 1){?>style="display: none"<?php }?>>
                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" id="submit" class="btn btn-primary input-block-level" style="background:#107AE7">Ingresar</button>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <h5 style="font-size:14; font-weight: bold; align:center; ">
                                <center><a href="javascript:ClaveReset()"><b>¿Olvidó su Contraseña?</b></a></center>
                            </h5>
                        </div>
                    </div>
                    </div>
                    
                    
                    <!--si la entrada es para cambiar clave, despues de elegir imagen de reseteo-->
                    <?php 
                    if ($Process == 1)
                    {
                    ?>
                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" id="submitSiguiente" class="btn btn-primary input-block-level" style="background:#107AE7">Siguiente</button>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" id="submitCancelar" class="btn btn-primary input-block-level" style="background:green">Cancelar</button>
                        </div>
                    </div>
                    <?php    
                    }
                    else 
                    //si la entrada es para reseteo    
                    {
                    ?>
                    <div id="ResetButton" style="display: none">
                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" id="submit2" class="btn btn-primary input-block-level" style="background:#107AE7">Resetear</button>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <h5 style="font-size:14; font-weight: bold; align:center; ">
                            <center><a href="javascript:Logeo()"><b>Regresar al Login</b></a></center>
                            </h5>
                        </div>
                    </div>
                    </div>

                    <?php 
                    }
                    ?>
                </td>
                <td style="width: 5%"></td-->
            </tr>
        </table>
        </form>
        <?php
    }
    ?>
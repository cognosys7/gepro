<?php
    require_once(PATH_CONTROLADOR_DAO . "/DirectorioDAO.php");
    require_once(PATH_CONTROLADOR_DAO . "/UsuarioDAO.php");
    require_once(PATH_LIB . "/Collection.php");
    require_once(PATH_LIB . '/util.php'); 
    function EjecutaLN() 
    {
        $lCollection = Collection::Singleton();
        $usuariosession   = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : '';
        $PerfilIntranet   = isset($_SESSION['PerfilIntranet']) ? $_SESSION['PerfilIntranet'] : 0;
        $SeguridadPass    = isset($_SESSION['SeguridadPass']) ? $_SESSION['SeguridadPass'] : 0;
//        $Pantallazo       = isset($_SESSION['Pantallazo']) ? $_SESSION['Pantallazo'] : 0;
        
        function Reemplazar($valor)
        {
            $search  = array("'", ";", "%", "SELECT", "UPDATE", "DELETE");
            $replace = array('0', '', '', '', '', '');
            $ValorF = str_ireplace($search,$replace,$valor);
            return $ValorF;
        }
                                
        //OBTENGO LOS POST DEL FORMULARIO
        $ActionForm     = isset($_POST['ActionForm']) ? htmlspecialchars(addslashes(trim(Reemplazar($_POST['ActionForm'])))) : "";
        $pCaptcha       = isset($_POST['pCaptcha']) ? htmlspecialchars(addslashes(trim(Reemplazar($_POST['pCaptcha'])))) : "";
        $ptotal         = isset($_POST['total']) ? htmlspecialchars(addslashes(trim(Reemplazar($_POST['total'])))) : "";
        $mensaje        = isset($_POST['Mensaje']) ? htmlspecialchars(addslashes(trim(Reemplazar($_POST['Mensaje'])))) : 0;
        $CodigoUsuario  = isset($_POST['cUs']) ? htmlspecialchars(addslashes(trim(Reemplazar($_POST['cUs'])))) : 0;
        
        $Process        = 0;

        if ($usuariosession == "") 
        {
            if ($ActionForm == "Verificar")
            {
                if (($ptotal == $pCaptcha) and (strlen($pCaptcha)>0) and (strlen($ptotal)>0))
                {
                    $username       = isset($_POST['usuario']) ? htmlspecialchars(addslashes(trim(Reemplazar($_POST['usuario'])))) : "";
                    $password       = isset($_POST['clave']) ? htmlspecialchars(addslashes(trim(Reemplazar($_POST['clave'])))) : "";
                    $objUsuarioDAO  = new UsuarioDAO();
                    $lstUsuarios    = array();
                    $lstUsuarios2   = array();
                    $username       = strtoupper($username);
                    $objUsuarioDAO->RecuperaUsuarioLDAP($lstUsuarios2,$username);
                    $listaUsuarios2  = count($lstUsuarios2) > 0 ? true : false;
                    if (($listaUsuarios2 == true) || ($listaUsuarios2 > 0))
                    {
                        
                        $UsuNombreX                      = $lstUsuarios2[0]->usunombre;
                        $UsuldapX                        = $lstUsuarios2[0]->usuldap;
                        
                        if ($username == $UsuNombreX)
                        {
                            $PassEncript    = $username.$password.'Cognosys@SAC';
                        }
                        else
                        {
                           if ($username == $UsuldapX)
                           {
                               $PassEncript  = $UsuNombreX.$password.'Cognosys@SAC';
                           }
                           else
                           {
                               $PassEncript  = "";
                           }
                        }
                        
                        if (strlen($PassEncript)>0)
                        {
                            $objUsuarioDAO->VerificaUsuarioLogin($lstUsuarios, $username,md5($PassEncript));
                            $listaUsuarios  = count($lstUsuarios) > 0 ? true : false;
                            if (($listaUsuarios == true) || ($listaUsuarios > 0))
                            {
                                $IdUsuario                      = $lstUsuarios[0]->idusuario;
                                $PersonaNom                     = $lstUsuarios[0]->Persona;
                                $idpersona                      = $lstUsuarios[0]->idpersona;
                                $IdPersonal                     = $lstUsuarios[0]->idpersonal;
                                $UorNombre                      = $lstUsuarios[0]->UorNombre;
                                $IdUnidadOrganica               = $lstUsuarios[0]->IdUnidadOrganica;
                                $IdPersonaJefe                  = $lstUsuarios[0]->IdPersonaJefe;
                                $_SESSION['usuario']            = $IdUsuario;
                                $_SESSION['persona']            = $idpersona;
                                $_SESSION['personal']           = $IdPersonal;
                                $_SESSION['personaNombre']      = $PersonaNom;
                                $_SESSION['centroNombre']       = $UorNombre;
                                $_SESSION['centroId']           = $IdUnidadOrganica;
                                $_SESSION['IdPersonaJefe']      = $IdPersonaJefe;
                                $_SESSION['horaIngreso']        = date("h");
                                $_SESSION['minutoIngreso']      = date("i");
                                $_SESSION['horarioIngreso']     = date("A");
                                $_SESSION['Pantallazo'] = 0;
                                
                                //var_dump($lstUsuarios); echo '<br>'.$username .' = '. $password ; exit;
                                if ($username == $password)
                                {   
                                    $_SESSION['PerfilIntranet'] = 0;
                                    $_SESSION['SeguridadPass']  = 0;
                                    //echo'entre:'.$_SESSION['PerfilIntranet'].' - '.$_SESSION['SeguridadPass'] ;
                                    header("Location:".INTRANET."/Vista/AntiRefresh.php?Pagina=Clave");
                                    exit;
                                }
                                $_SESSION['SeguridadPass']      = 1;
                                $lstDirectorioReg               = array();
                                $objDirectorioDAO               = new DirectorioDAO();
                                $objDirectorioDAO->VerificaDirectorioSelect($lstDirectorioReg,$IdPersonal);
                                $listaDirectorio                = count($lstDirectorioReg) > 0 ? true : false;
                                if (($listaDirectorio == true) || ($listaDirectorio > 0)) 
                                {
                                    $_SESSION['PerfilIntranet'] = 1;
//                                    header("Location:".INTRANET."/Vista/AntiRefresh.php?Pagina=Dashboard");                                    
                                    // forzar ingreso al modulo PRINCIPAL, no intranet
                                    header("Location:../../essalud/Vista/AntiRefresh.php?Pagina=Dashboard");
                                    exit;
                                }
                                else
                                {
                                    
                                    $_SESSION['PerfilIntranet'] = 0;
//                                    header("Location:".INTRANET."/Vista/AntiRefresh.php?Pagina=Dashboard");
                                       header("Location:../../essalud/Vista/AntiRefresh.php?Pagina=Dashboard");
                                    exit;
                                }
                                exit;
                            }
                            else
                            {
                                $mensaje = 1;
                            }
                        }
                        else
                        {
                            $mensaje = 1;
                        }
                    }
                    else
                    {
                        $mensaje = 1;
                    }
                }
                else
                {
                    $mensaje = 2;
                }
            }

            if ($ActionForm == "Recuperar")
            {
                if (($ptotal == $pCaptcha) and (strlen($pCaptcha)>0) and (strlen($ptotal)>0))
                {
                    $dni            = isset($_POST['dni']) ? htmlspecialchars($_POST['dni']) : "";
                    $lstUsuarios    = array();
                    $objUsuarioDAO  = new UsuarioDAO();
                    $objUsuarioDAO->RecuperaUsuarioLogin($lstUsuarios, $dni);
                    $listaUsuarios  = count($lstUsuarios) > 0 ? true : false;
                    if (($listaUsuarios == true) || ($listaUsuarios > 0))
                    {
                        $IdUsuario                      = $lstUsuarios[0]->idusuario;
                        header("Location:".INTRANET."/Vista/LogiRefresh.php?Act=ProcesaUsuario&&Usr=".$IdUsuario);
                        exit;
                    }
                    else
                    {
                        $mensaje = 1;
                    }
                }
                else
                {
                    $mensaje = 2;
                }
            }
            
            if ($ActionForm == "ProcesaUsuario")
            {
                $Process = 1;
                $lstUsuarios        = array();
                $objUsuarioDAO      = new UsuarioDAO();
                $objUsuarioDAO->VerificaUsuarioSelect($lstUsuarios, $CodigoUsuario);
                $listaUsuarios      = count($lstUsuarios) > 0 ? true : false;
                if (($listaUsuarios == true) || ($listaUsuarios > 0))
                {
                    $DNIUser        = $lstUsuarios[0]->PerNroDocumento;
                    $ImgDato        = $lstUsuarios[0]->usudatorecupera;
                }
                $lCollection->Add('DNIUser', $DNIUser);
                $lCollection->Add('ImgDato', $ImgDato);
            }
            
            if ($ActionForm == "CancelarRecuperacion")
            {
                header("Location:".INTRANET."/Vista/LogiRefresh.php");
                exit;
            }
            
            
//  SE RESETEA CON LA VISTA DE IMAGENES DE RECUPERACION
            if ($ActionForm == "InciarRecuperacion")
            {
                $valsec             = isset($_POST['valsec']) ? htmlspecialchars($_POST['valsec']) : 0;
                if (($ptotal == $pCaptcha) and (strlen($pCaptcha)>0) and (strlen($ptotal)>0))
                {
                    $lstUsuarios    = array();
                    $objUsuarioDAO  = new UsuarioDAO();
                    $objUsuarioDAO->RecuperaUsuarioLogin2($lstUsuarios, $CodigoUsuario,$valsec);
                    $listaUsuarios  = count($lstUsuarios) > 0 ? true : false;
                    if (($listaUsuarios == true) || ($listaUsuarios > 0))
                    {
                        $lstUsuarioUpd                  = array();
                        $objUsuarioDAO                  = new UsuarioDAO();
                        $IdUsuario                      = $lstUsuarios[0]->idusuario;
                        $PersonaNom                     = $lstUsuarios[0]->Persona;
                        $idpersona                      = $lstUsuarios[0]->idpersona;
                        $IdPersonal                     = $lstUsuarios[0]->idpersonal;
                        $UorNombre                      = $lstUsuarios[0]->UorNombre;
                        $_SESSION['usuario']            = $IdUsuario;
                        $_SESSION['persona']            = $idpersona;
                        $_SESSION['personal']           = $IdPersonal;
                        $_SESSION['personaNombre']      = $PersonaNom;
                        $_SESSION['centroNombre']       = $UorNombre;
                        $_SESSION['Pantallazo']         = 0;
                        $_SESSION['PerfilIntranet']     = 0;
                        $_SESSION['SeguridadPass']      = 0;
                        $PerNroDocumento                = $lstUsuarios[0]->PerNroDocumento;
                        
                        //  SE ENCRIPTA EL DNI DEL USUARIO, COMO PREDETERMINADO
                        $PassEncript                    = md5($PerNroDocumento.$PerNroDocumento.'Cognosys@SAC');
                        //RESETEAR CLAVE
                        $lstParametrosR                     = array();
                        $lstParametrosR['Clave']            = $PassEncript;
                        $lstParametrosR['Codigo']           = $IdUsuario;
                        $lstParametrosR['PCODIGO']          = str_repeat("\0", 200);
                        $lstParametrosR['PMENSAJE']         = str_repeat("\0", 200);
                        $procedure_paramsRS = array(
                             array(&$lstParametrosR['Clave'], SQLSRV_PARAM_IN)
                            , array(&$lstParametrosR['Codigo'], SQLSRV_PARAM_IN)
                            , array(&$lstParametrosR['PCODIGO'], SQLSRV_PARAM_OUT)
                            , array(&$lstParametrosR['PMENSAJE'], SQLSRV_PARAM_OUT)
                        );
                        $objUsuarioDAO->ActualizaClaveUsuario2($lstUsuarioUpd,$procedure_paramsRS);
                        header("Location:".INTRANET."/Vista/AntiRefresh.php?Pagina=Clave");
                        exit;
                    }
                    else
                    {
                        //INICIO EL BLOQUEO HASTA 3 INTENTOS
                        $mensaje = 1;
                        header("Location:".INTRANET."/Vista/LogiRefresh.php?Act=ProcesaUsuario&&Usr=".$CodigoUsuario."&&Msj=".$mensaje);
                        exit;
                    }
                }
                else
                {
                    $mensaje = 2;
                    header("Location:".INTRANET."/Vista/LogiRefresh.php?Act=ProcesaUsuario&&Usr=".$CodigoUsuario."&&Msj=".$mensaje);
                    exit;
                }
            }
        }
        else 
        {
            $_SESSION['Pantallazo'] = 1;
            if ($SeguridadPass == 0) 
            {
                header("Location:".INTRANET."/Vista/AntiRefresh.php?Pagina=Clave");
                exit;
            }
            else
            {
                if ($PerfilIntranet == 0) 
                {
                    header('Location:Perfil.php');
                    header("Location:".INTRANET."/Vista/AntiRefresh.php?Pagina=Perfil");
                    exit;
                } 
                else
                {
                    header("Location:".INTRANET."/Vista/AntiRefresh.php?Pagina=Dashboard");
                    exit;
                }
            }
        }
        
        $lCollection->Add('Process', $Process);
        $lCollection->Add('Mensaje', $mensaje);
        $lCollection->Add('CodigoUsuario', $CodigoUsuario);
    }
?>
<?php
  /* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : SGPAM
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada 
  //  Propósito       : Envío de email de lutilizando vista ALERTA_CONTRATO_RIESGO
  //  Fecha           : lunes, 12 de agosto de 2019 11:30
  //  Modificado      : 01 de Setiembre 2019
  //
  //***************************************************************************** */

    require_once ("Configuracion.php");
    require_once ("../../../lib/PHPMailer/PHPMailerAutoload.php");     // libreria : PHPMailer-5.2.11 
    
    ///////////////////// Crear objeto y Configuración parametros de Email
    $mail = new PHPMailer();
    
    $mail->isSMTP() ;                                   // protocolo
    $mail->SMTPAuth     = true ;                        // autentificacion del email
    $mail->SMTPSecure   = $Autentificacion ;            // tipo de seguridad. difiere con google, outlook, etc
    $mail->Host         = $HostEmail ;                  // host de gmail
    $mail->Port         = $PuertoEmail ;                // puerto php
    
    $mail->Username     = $EmisorEmail ;                // Correo de donde enviaremos los correos
    $mail->Password     = $EmisorClave ;                // Password de la cuenta de envío
    $mail->setFrom($EmisorEmail, $EmisorAlias);         // visualizacion del emisor
	$mail->isHTML(true);         						// visualizacion HTML
    
    
    
    
    
    function EnviarEmail($Componente,$mail){

        //require_once(PATH_CONTROLADOR_DAO . "/".$Componente."dao.php");
        require_once("../../../Controlador/DAO/".$Componente."dao.php");
        $Clase = $Componente."_DAO";
        $SelCampos  = 'SelCampos_'.$Componente;

        /////////////////////// Crear objeto DataSet y enviar EMail
        $DataSet = array();
        $Objeto = new $Clase();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = " Ide, AlertaTitulo, AlertaMensaje, ReceptorEmail, ReceptorNombre ";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto->$SelCampos($DataSet, $procedure_parametrosMS);


        for ($i = 0; $i < count($DataSet); $i++) {
            if (strlen($DataSet[$i]->Ide > 0)) {

                    ///////////////////// Parametros variables, segun Base de Datos
                    $mail->Subject = $DataSet[$i]->AlertaTitulo ;       // Titulo de Mensaje
                    $mail->Body    = $DataSet[$i]->AlertaMensaje;       // Texto de Email

                    $mail->addAddress( $DataSet[$i]->ReceptorEmail , $DataSet[$i]->ReceptorNombre );  // Correo receptor   

                    ///////////////////// Enviar EMail
                    if($mail->send()) {
                            echo 'Correo enviado a '. $DataSet[$i]->ReceptorNombre . ': '.$DataSet[$i]->ReceptorEmail.'<br>' ;
                    } else {
                            echo 'Error al enviar correo a '. $DataSet[$i]->ReceptorNombre . ': '.$DataSet[$i]->ReceptorEmail.'<br>';
                    }


            }
        }
            
    
    }
    
?>
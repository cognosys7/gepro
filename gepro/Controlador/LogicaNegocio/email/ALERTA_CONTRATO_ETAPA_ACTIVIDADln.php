<?php
  /* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : SGPAM
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada 
  //  Propósito       : Envío de email de lutilizando vista BIBD_CONT_CONCEPTO_ALERTA
  //  Fecha           : lunes, 12 de agosto de 2019 11:30
  //  Modificado      : 01 de Setiembre 2019
  //
  //***************************************************************************** */

    require_once ("objetoPHPMailer.php");

    
    EnviarEmail("ALERTA_CONTRATO_ETAPA_ACTIVIDAD",$mail);
    
?>
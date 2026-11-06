<?php
// Slim 2 no es de PHP 8: un aviso de obsolescencia no debe tumbar la API (Slim::handleErrors)
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

require_once './lib/Slim/Slim.php';

require_once 'Conexion.php';

require_once 'bibd_proyecto.php';
require_once 'bibd_proyecto_principal.php';
require_once 'bibd_proy_pip.php';
require_once 'bibd_proy_ubigeo.php';


require_once 'bibd_proy_comunicacion.php';
require_once 'bibd_proy_comunic_interesados.php';


require_once 'bibd_proy_leccion_aprendida.php';

require_once 'bibd_proy_gestion_social.php';
require_once 'bibd_proy_gestion_social_activ.php';
require_once 'bibd_proy_gestion_social_activ_archivo.php';
require_once 'bibd_proy_gestion_social_benef.php';
require_once 'bibd_proy_gestion_social_intere.php';
require_once 'bibd_proy_gestion_social_queja.php';

// 09/07/2021
require_once 'bibd_proy_costo_componente.php';
require_once 'bibd_proy_oportunidad_riesgo.php';
require_once 'bibd_proy_accion_gestion.php';
require_once 'bibd_proy_accion_correctiva.php';
// 21/07/2021
require_once 'bibd_proy_social_objetivo_esp.php';

require_once 'bibd_contrato.php';
require_once 'bibd_contrato_archivo.php';

require_once 'bibd_proceso.php';
require_once 'bibd_proceso_cronograma.php';
require_once 'bibd_proceso_item.php';
require_once 'bibd_proceso_item_postor.php';

require_once 'bibd_cont_etapa.php';
require_once 'bibd_cont_etapa_actividad.php';
require_once 'bibd_cont_etapa_indic_mensual.php';
require_once 'bibd_cont_etapa_recurso.php';
require_once 'bibd_cont_etapa_seguimiento.php';
require_once 'bibd_cont_etapa_seguimiento_archivo.php';

require_once 'bibd_cont_etapa_control.php'; // 18/05/2021
require_once 'bibd_cont_ampliacion.php'; // 18/05/2021

require_once 'bibd_cont_interesados.php';

require_once 'bibd_cont_calidad_entregable.php';
require_once 'bibd_cont_calidad_archivo.php';
require_once 'bibd_cont_calidad_contenido.php';

require_once 'bibd_cont_riesgo_problema.php';
require_once 'bibd_cont_riesgo_recurso.php';

require_once 'bibd_cont_concepto.php';
require_once 'bibd_cont_concepto_archivo.php';

require_once 'bibd_cont_documentacion.php';
require_once 'bibd_cont_documentacion_archivo.php';

require_once 'bibd_cont_seguimiento.php';

require_once 'bibd_seg_auditoria.php';
require_once 'bibd_seg_perfil_accesos.php';
require_once 'bibd_seg_usuario_perfil.php';

require_once 'bibd_proy_edt.php';
require_once 'bibd_proy_seguimiento_archivo.php';

// Autocarga de la librería
\Slim\Slim::registerAutoloader();

// Creando una instancia del Slim
$app = new \Slim\Slim();
$app->response->header('Content-Type', 'application/json');


// Servicio GET
$app->get('/bibd_proyecto', function(){
    $lista = bibd_proyecto();
    echo json_encode($lista);
});
$app->get('/bibd_proyecto_principal', function(){
    $lista = bibd_proyecto_principal();
    echo json_encode($lista);
});


// Servicio GET
$app->get('/bibd_proy_pip', function(){
    $lista = bibd_proy_pip();
    echo json_encode($lista);
});


// Servicio GET
$app->get('/bibd_proy_ubigeo', function(){
    $lista = bibd_proy_ubigeo();
    echo json_encode($lista);
});




// Servicio GET
$app->get('/bibd_proy_comunicacion', function(){
    $lista = bibd_proy_comunicacion();
    echo json_encode($lista);
});

// Servicio GET
$app->get('/bibd_proy_comunic_interesados', function(){
    $lista = bibd_proy_comunic_interesados();
    echo json_encode($lista);
});




// Servicio GET
$app->get('/bibd_proy_leccion_aprendida', function(){
    $lista = bibd_proy_leccion_aprendida();
    echo json_encode($lista);
});




// Servicio GET
$app->get('/bibd_proy_gestion_social', function(){
    $lista = bibd_proy_gestion_social();
    echo json_encode($lista);
});

// Servicio GET
$app->get('/bibd_proy_gestion_social_activ', function(){
    $lista = bibd_proy_gestion_social_activ();
    echo json_encode($lista);
});
$app->get('/bibd_proy_gestion_social_activ_archivo', function(){
    $lista = bibd_proy_gestion_social_activ_archivo();
    echo json_encode($lista);
});

// Servicio GET
$app->get('/bibd_proy_gestion_social_benef', function(){
    $lista = bibd_proy_gestion_social_benef();
    echo json_encode($lista);
});

// Servicio GET
$app->get('/bibd_proy_gestion_social_intere', function(){
    $lista = bibd_proy_gestion_social_intere();
    echo json_encode($lista);
});

// Servicio GET
$app->get('/bibd_proy_gestion_social_queja', function(){
    $lista = bibd_proy_gestion_social_queja();
    echo json_encode($lista);
});

// 09/07/2021
// Servicio GET

$app->get('/bibd_proy_costo_componente', function(){
    $lista = bibd_proy_costo_componente();
    echo json_encode($lista);
});

$app->get('/bibd_proy_oportunidad_riesgo', function(){
    $lista = bibd_proy_oportunidad_riesgo();
    echo json_encode($lista);
});

$app->get('/bibd_proy_accion_gestion', function(){
    $lista = bibd_proy_accion_gestion();
    echo json_encode($lista);
});

$app->get('/bibd_proy_accion_correctiva', function(){
    $lista = bibd_proy_accion_correctiva();
    echo json_encode($lista);
});

// 21/07/2021
// Servicio GET
$app->get('/bibd_proy_social_objetivo_esp', function(){
    $lista = bibd_proy_social_objetivo_esp();
    echo json_encode($lista);
});



// Servicio GET
$app->get('/bibd_contrato', function(){
    $lista = bibd_contrato();
    echo json_encode($lista);
});

// Servicio GET
$app->get('/bibd_contrato_archivo', function(){
    $lista = bibd_contrato_archivo();
    echo json_encode($lista);
});




// Servicio GET
$app->get('/bibd_proceso', function(){
    $lista = bibd_proceso();
    echo json_encode($lista);
});

// Servicio GET
$app->get('/bibd_proceso_cronograma', function(){
    $lista = bibd_proceso_cronograma();
    echo json_encode($lista);
});

// Servicio GET
$app->get('/bibd_proceso_item', function(){
    $lista = bibd_proceso_item();
    echo json_encode($lista);
});

// Servicio GET
$app->get('/bibd_proceso_item_postor', function(){
    $lista = bibd_proceso_item_postor();
    echo json_encode($lista);
});




// Servicio GET
$app->get('/bibd_cont_etapa', function(){
    $lista = bibd_cont_etapa();
    echo json_encode($lista);
});

// Servicio GET
$app->get('/bibd_cont_etapa_actividad', function(){
    $lista = bibd_cont_etapa_actividad();
    echo json_encode($lista);
});

// Servicio GET
$app->get('/bibd_cont_etapa_indic_mensual', function(){
    $lista = bibd_cont_etapa_indic_mensual();
    echo json_encode($lista);
});

// Servicio GET
$app->get('/bibd_cont_etapa_recurso', function(){
    $lista = bibd_cont_etapa_recurso();
    echo json_encode($lista);
});

// Servicio GET
$app->get('/bibd_cont_etapa_seguimiento', function(){
    $lista = bibd_cont_etapa_seguimiento();
    echo json_encode($lista);
});
// Servicio GET
$app->get('/bibd_cont_etapa_seguimiento_archivo', function(){
    $lista = bibd_cont_etapa_seguimiento_archivo();
    echo json_encode($lista);
});

// Servicio GET --nuevo 18/05/2021
$app->get('/bibd_cont_etapa_control', function(){
      $lista = bibd_cont_etapa_control();
      echo json_encode($lista);
});

$app->get('/bibd_cont_ampliacion', function(){
      $lista = bibd_cont_ampliacion();
      echo json_encode($lista);
});

// Servicio GET
$app->get('/bibd_cont_interesados', function(){
    $lista = bibd_cont_interesados();
    echo json_encode($lista);
});




// Servicio GET
$app->get('/bibd_cont_calidad_entregable', function(){
    $lista = bibd_cont_calidad_entregable();
    echo json_encode($lista);
});

// Servicio GET
$app->get('/bibd_cont_calidad_archivo', function(){
    $lista = bibd_cont_calidad_archivo();
    echo json_encode($lista);
});

// Servicio GET
$app->get('/bibd_cont_calidad_contenido', function(){
    $lista = bibd_cont_calidad_contenido();
    echo json_encode($lista);
});




// Servicio GET
$app->get('/bibd_cont_riesgo_problema', function(){
    $lista = bibd_cont_riesgo_problema();
    echo json_encode($lista);
});

// Servicio GET
$app->get('/bibd_cont_riesgo_recurso', function(){
    $lista = bibd_cont_riesgo_recurso();
    echo json_encode($lista);
});



// Servicio GET
$app->get('/bibd_cont_concepto', function(){
    $lista = bibd_cont_concepto();
    echo json_encode($lista);
});

// Servicio GET
$app->get('/bibd_cont_concepto_archivo', function(){
    $lista = bibd_cont_concepto_archivo();
    echo json_encode($lista);
});




// Servicio GET
$app->get('/bibd_cont_documentacion', function(){
    $lista = bibd_cont_documentacion();
    echo json_encode($lista);
});

// Servicio GET
$app->get('/bibd_cont_documentacion_archivo', function(){
    $lista = bibd_cont_documentacion_archivo();
    echo json_encode($lista);
});




// Servicio GET
$app->get('/bibd_cont_seguimiento', function(){
    $lista = bibd_cont_seguimiento();
    echo json_encode($lista);
});




// Servicio GET
$app->get('/bibd_seg_auditoria', function(){
    $lista = bibd_seg_auditoria();
    echo json_encode($lista);
});

// Servicio GET
$app->get('/bibd_seg_perfil_accesos', function(){
    $lista = bibd_seg_perfil_accesos();
    echo json_encode($lista);
});

// Servicio GET
$app->get('/bibd_seg_usuario_perfil', function(){
    $lista = bibd_seg_usuario_perfil();
    echo json_encode($lista);
});

// Servicio GET
$app->get('/bibd_proy_edt', function(){
    $lista = bibd_proy_edt();
    echo json_encode($lista);
});

// Servicio GET
$app->get('/bibd_proy_seguimiento_archivo', function(){
    $lista = bibd_proy_seguimiento_archivo();
    echo json_encode($lista);
});



$app->run();
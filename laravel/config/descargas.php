<?php

/*
|--------------------------------------------------------------------------
| Descargas de Excel del menu
|--------------------------------------------------------------------------
| Pagina del sistema actual => URL del archivo. Son los mismos archivos que abrian las vistas
| PEX_*vista.php (publicados por AMSAC): cada cliente pone aqui los suyos. /descargas/{Pagina} valida
| el acceso del perfil y redirige al archivo.
*/

return [

    'PEX_PRY_2CONTRATOS' => env('GEPRO_PEX_PRY_2CONTRATOS', 'http://sgpam.amsac.pe/SGPAM_archivos/TablerosExcel/SGPAM_PRY_2CONTRATOS.xlsm'),
    'PEX_PRY_3GESTION_SOCIAL' => env('GEPRO_PEX_PRY_3GESTION_SOCIAL', 'http://sgpam.amsac.pe/SGPAM_archivos/TablerosExcel/SGPAM_PRY_3GESTION_SOCIAL.xlsm'),
    'PEX_PRY_4LECCIONES' => env('GEPRO_PEX_PRY_4LECCIONES', 'http://sgpam.amsac.pe/SGPAM_archivos/TablerosExcel/SGPAM_PRY_4LECCIONES.xlsm'),
    'PEX_PRY_ANEXO3' => env('GEPRO_PEX_PRY_ANEXO3', 'http://sgpam.amsac.pe/SGPAM_archivos/TablerosExcel/FichaTecnicaProyecto_Ingenieria_Anexo3.xlsm'),
    'PEX_PRY_CONT_21ETAPAS' => env('GEPRO_PEX_PRY_CONT_21ETAPAS', 'http://sgpam.amsac.pe/SGPAM_archivos/TablerosExcel/SGPAM_PRY_CONT_21ETAPAS.xlsm'),
    'PEX_PRY_CONT_22RIESGOS' => env('GEPRO_PEX_PRY_CONT_22RIESGOS', 'http://sgpam.amsac.pe/SGPAM_archivos/TablerosExcel/SGPAM_PRY_CONT_22RIESGOS.xlsm'),
    'PEX_PRY_CONT_24INTERESADOS' => env('GEPRO_PEX_PRY_CONT_24INTERESADOS', 'http://sgpam.amsac.pe/SGPAM_archivos/TablerosExcel/SGPAM_PRY_CONT_24INTERESADOS.xlsm'),
    'PEX_PRY_CONT_25DOCUMENTOS' => env('GEPRO_PEX_PRY_CONT_25DOCUMENTOS', 'http://sgpam.amsac.pe/SGPAM_archivos/TablerosExcel/SGPAM_PRY_CONT_25DOCUMENTOS.xlsm'),
    'PEX_PRY_CONT_26CALIDAD' => env('GEPRO_PEX_PRY_CONT_26CALIDAD', 'http://sgpam.amsac.pe/SGPAM_archivos/TablerosExcel/SGPAM_PRY_CONT_26CALIDAD.xlsm'),

];

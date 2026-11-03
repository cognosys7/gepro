<?php

/*
|--------------------------------------------------------------------------
| Tableros (Power BI) del menu
|--------------------------------------------------------------------------
| Pagina del sistema actual => URL del reporte publicado. Son los mismos reportes que mostraban las
| vistas PBI_*vista.php (publicados por AMSAC): cada cliente pone aqui los suyos. Se muestran en
| /tableros/{Pagina} dentro de la pantalla de GEPRO; el nombre sale de la opcion del menu.
*/

return [

    'PBI_GASTOS_HISTORICOS' => env('GEPRO_PBI_GASTOS_HISTORICOS', 'https://app.powerbi.com/view?r=eyJrIjoiNDEyN2Y2OTktNzE4OS00YjhjLWI3OTMtOWNiMTY5NDFmY2E5IiwidCI6IjhkNmE0OTg0LThlZTAtNGEzNi1iNDA1LWQ2NzhmNDdmZGE5MSIsImMiOjR9'),
    'PBI_CONTRATO_ORDENES' => env('GEPRO_PBI_CONTRATO_ORDENES', 'https://app.powerbi.com/view?r=eyJrIjoiZmQ1MjFhNzMtMDAwOC00N2I3LWE0MWUtY2FjMzA2Y2IzOWJiIiwidCI6IjhkNmE0OTg0LThlZTAtNGEzNi1iNDA1LWQ2NzhmNDdmZGE5MSIsImMiOjR9'),
    'PBI_FINANCIERO_CONSOLIDADO' => env('GEPRO_PBI_FINANCIERO_CONSOLIDADO', 'https://app.powerbi.com/view?r=eyJrIjoiNjk1ZDg3MjQtOGVhMS00MjE5LTg4YTQtNjkzODY1ODE3MjkyIiwidCI6IjhkNmE0OTg0LThlZTAtNGEzNi1iNDA1LWQ2NzhmNDdmZGE5MSIsImMiOjR9&pageName=ReportSectiona5825f4a19be50dbeca0'),
    'PBI_FINANCIERO_DETALLADO' => env('GEPRO_PBI_FINANCIERO_DETALLADO', 'https://app.powerbi.com/view?r=eyJrIjoiNDhhYjJkMmItNWYzMC00MWNhLTgwODItYzY0MzhiMTNiM2I4IiwidCI6IjhkNmE0OTg0LThlZTAtNGEzNi1iNDA1LWQ2NzhmNDdmZGE5MSIsImMiOjR9&pageName=ReportSectionaaefc3dc98a61b867ace'),
    'PBI_PRY_3GESTION_SOCIAL' => env('GEPRO_PBI_PRY_3GESTION_SOCIAL', 'https://app.powerbi.com/view?r=eyJrIjoiMzQ1MTYxNGItNmRhYi00MmQ1LTk5ZWEtNWIwY2M2ODFiNzdkIiwidCI6IjhkNmE0OTg0LThlZTAtNGEzNi1iNDA1LWQ2NzhmNDdmZGE5MSIsImMiOjR9'),
    'PBI_TABLEROS_SEGUIMIENTO' => env('GEPRO_PBI_TABLEROS_SEGUIMIENTO', 'https://app.powerbi.com/view?r=eyJrIjoiMDU0MzdjZGUtMzc4Zi00MzgzLTkwYjktNDYyMjI5ZTU5M2MzIiwidCI6IjhkNmE0OTg0LThlZTAtNGEzNi1iNDA1LWQ2NzhmNDdmZGE5MSIsImMiOjR9&pageName=ReportSection'),
    'PBI_PRY_CONT_21ETAPAS' => env('GEPRO_PBI_PRY_CONT_21ETAPAS', 'https://app.powerbi.com/view?r=eyJrIjoiYjhmMTc5MDYtMTJjNi00ZjdjLTk5OWMtNWI0MDU3ZmUwYjgxIiwidCI6IjhkNmE0OTg0LThlZTAtNGEzNi1iNDA1LWQ2NzhmNDdmZGE5MSIsImMiOjR9'),
    'PBI_PRY_2CONTRATOS' => env('GEPRO_PBI_PRY_2CONTRATOS', 'https://app.powerbi.com/view?r=eyJrIjoiNTdjNDc1YWQtMDQwNi00NzQ5LWJhYTEtOWZiNTFiNjYzMDc4IiwidCI6IjhkNmE0OTg0LThlZTAtNGEzNi1iNDA1LWQ2NzhmNDdmZGE5MSIsImMiOjR9'),
    // Del menu del sistema de seguridad (/seguridad/tableros/{Pagina})
    'PBI_SEG_USUARIOS_ROL' => env('GEPRO_PBI_SEG_USUARIOS_ROL', 'https://app.powerbi.com/view?r=eyJrIjoiM2Y4MWU2OGEtY2VjMS00N2ZhLTk4NzktM2NhYTVkZDRjZjgyIiwidCI6IjhkNmE0OTg0LThlZTAtNGEzNi1iNDA1LWQ2NzhmNDdmZGE5MSIsImMiOjR9'),
    'PBI_TABLERO_PRESUPUESTO' => env('GEPRO_PBI_TABLERO_PRESUPUESTO', 'https://app.powerbi.com/view?r=eyJrIjoiM2QxZmQwMTctYjRhMC00MWM4LTgwMTUtZjMyNWI3YTE0NmVhIiwidCI6IjhkNmE0OTg0LThlZTAtNGEzNi1iNDA1LWQ2NzhmNDdmZGE5MSIsImMiOjR9'),

];

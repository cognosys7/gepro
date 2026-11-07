<?php

/*
|--------------------------------------------------------------------------
| Textos guia de los formularios
|--------------------------------------------------------------------------
| Lenguaje de cada pantalla de config/catalogos.php, separado de su logica para que se pueda ajustar
| por cliente sin tocar las definiciones. Solo son textos: las columnas y los SP no cambian.
|
| Pagina => [
|   'singular', 'plural', 'femenino' => arman "Banco registrado." y "Aun no hay bancos registrados."
|   'descripcion' => para que sirve la pantalla
|   'siguiente'   => que hacer despues de registrar (solo acciones que existen en la grilla)
|   'campos'      => columna => 'ayuda' o ['etiqueta' => ..., 'ayuda' => ..., 'en_grilla' => ...]
| ]
| Si cambia la etiqueta de una columna de la grilla, esta conserva su titulo corto. Las pantallas con 'segun'
| cambian sus etiquetas segun lo elegido: esas etiquetas se dejan en config/catalogos.php.
*/

$etapa = ['etiqueta' => 'Etapa del proyecto'];
$etapaCorta = $etapa + ['en_grilla' => 'Etapa'];

return [

    // ---------- CONFIGURACION ----------
    'GEN_PORTAFOLIO_PROYECTO' => [
        'singular' => 'Portafolio', 'plural' => 'portafolios',
        'descripcion' => 'Agrupe los proyectos relacionados para verlos y gestionarlos juntos.',
        'campos' => ['DES_PORTAFOLIO' => 'Nombre con el que se reconoce al grupo de proyectos.'],
    ],
    'GEN_PROGRAMA_PROYECTO' => [
        'singular' => 'Programa', 'plural' => 'programas',
        'descripcion' => 'Conjuntos mayores a los que pertenecen los proyectos. Ej.: una cuenca.',
    ],
    'GEN_ROLES' => [
        'singular' => 'Rol', 'plural' => 'roles',
        'descripcion' => 'Funciones que puede cumplir una persona en cada etapa del contrato.',
    ],
    'GEN_TIPO_RIESGO' => [
        'singular' => 'Tipo de riesgo', 'plural' => 'tipos de riesgo',
        'descripcion' => 'Categorías para clasificar los riesgos de los contratos.',
    ],
    'GEN_PROBABILIDAD_RIESGO' => [
        'singular' => 'Nivel de probabilidad', 'plural' => 'niveles de probabilidad',
        'descripcion' => 'Escala para medir qué tan probable es que ocurra un riesgo.',
        'campos' => ['NUM_VALOR' => 'Se multiplica por el impacto para calcular la prioridad.'],
    ],
    'GEN_IMPACTO_RIESGO' => [
        'singular' => 'Nivel de impacto', 'plural' => 'niveles de impacto',
        'descripcion' => 'Escala para medir cuánto afectaría un riesgo si ocurre.',
        'campos' => ['NUM_VALOR' => 'Se multiplica por la probabilidad para calcular la prioridad.'],
    ],
    'GEN_PRIORIDAD_RIESGO' => [
        'singular' => 'Nivel de prioridad', 'plural' => 'niveles de prioridad',
        'descripcion' => 'Escala que indica qué riesgos atender primero.',
    ],
    'GEN_MATRIZ_CONOCIMIENTO_PROCESO' => [
        'singular' => 'Conocimiento', 'plural' => 'conocimientos',
        'descripcion' => 'Cruce de áreas de conocimiento y grupos de procesos del PMI, usado para clasificar los documentos.',
        'campos' => ['COD_ORDEN' => 'Posición en la que aparece en las listas.'],
    ],
    'GEN_CENTRO_COSTO' => ['descripcion' => 'Centros de costo a los que se asignan los proyectos.'],
    'PROC_TIPO' => [
        'singular' => 'Tipo de proceso', 'plural' => 'tipos de proceso',
        'descripcion' => 'Modalidades de selección usadas en las contrataciones.',
    ],
    'GEN_FUENTE_FINANCIAMIENTO' => ['descripcion' => 'Fuentes de las que provienen los recursos.'],
    'GEN_CUENTA_CONTABLE' => ['descripcion' => 'Cuentas contables disponibles para el registro de gastos.'],
    'GEN_BANCO' => ['singular' => 'Banco', 'plural' => 'bancos', 'descripcion' => 'Entidades financieras que emiten las cartas fianza.'],
    'GEN_PROVEEDOR' => ['singular' => 'Proveedor', 'plural' => 'proveedores', 'descripcion' => 'Empresas y personas que brindan bienes o servicios a los proyectos.'],
    'GEN_CARGO' => ['singular' => 'Cargo', 'plural' => 'cargos', 'descripcion' => 'Puestos que ocupan las personas involucradas en los proyectos.'],
    'GEN_TABLAS' => [
        'singular' => 'Valor', 'plural' => 'valores',
        'descripcion' => 'Listas de valores que usan los formularios del sistema.',
        'campos' => ['COD_ORDEN' => 'Posición en la que aparece en la lista.'],
    ],
    'GEN_INTERVENCION' => [
        'singular' => 'Fase', 'plural' => 'fases', 'femenino' => true,
        'descripcion' => 'Etapas por las que pasa un proyecto, desde el estudio hasta el cierre.',
    ],
    'GEN_MODO_EJECUCION' => [
        'singular' => 'Modalidad', 'plural' => 'modalidades', 'femenino' => true,
        'descripcion' => 'Formas de llevar a cabo el trabajo de un contrato.',
    ],
    'Gen_intervencion_comp' => [
        'singular' => 'Hito', 'plural' => 'hitos',
        'descripcion' => 'Hitos clave de cada fase del proyecto.',
        'campos' => [
            'IDE_INTERVENCION' => $etapaCorta,
            'COMP_PRINCIPAL' => 'Posición del hito dentro de la fase.',
        ],
    ],
    'GEN_COMPONENTE' => [
        'singular' => 'Etapa', 'plural' => 'etapas', 'femenino' => true,
        'descripcion' => 'Etapas que puede tener un contrato.',
    ],
    'GEN_INDICADOR' => [
        'singular' => 'Indicador', 'plural' => 'indicadores',
        'descripcion' => 'Medidas para hacer seguimiento al avance de cada fase.',
        'campos' => [
            'TIP_PERIODO_PROGRAMACION' => 'Cada cuánto se programa la meta.',
            'TIP_PERIODO_EJECUCION' => 'Cada cuánto se reporta el avance.',
            'DES_UNIDAD_MEDIDA' => 'En qué se mide. Ej.: porcentaje, hectáreas.',
        ],
    ],
    'GEN_ENTREGABLE' => [
        'singular' => 'Entregable', 'plural' => 'entregables',
        'descripcion' => 'Productos que debe presentar cada fase del proyecto.',
        'campos' => ['IDE_FASE_COMPONENTE' => $etapaCorta, 'NUM_ORDEN' => 'Posición en la que aparece en las listas.'],
    ],
    'GEN_RECURSO' => [
        'singular' => 'Recurso', 'plural' => 'recursos',
        'descripcion' => 'Personas y medios disponibles para asignar a los contratos.',
    ],
    'GEN_CONCEPTO_SOCIAL' => [
        'singular' => 'Concepto', 'plural' => 'conceptos',
        'descripcion' => 'Conceptos para clasificar las actividades de gestión social.',
    ],
    'GEN_COMUNIDAD' => [
        'singular' => 'Comunidad', 'plural' => 'comunidades', 'femenino' => true,
        'descripcion' => 'Comunidades y centros poblados del ámbito de los proyectos.',
    ],
    'GEN_ESPECIFICA_GASTO' => ['singular' => 'Específica de gasto', 'plural' => 'específicas de gasto', 'femenino' => true, 'descripcion' => 'Clasificador presupuestal del gasto público.'],
    'GEN_UBIGEO' => [
        'singular' => 'Ubicación', 'plural' => 'ubicaciones', 'femenino' => true,
        'descripcion' => 'Regiones, provincias y distritos que usan los formularios.',
    ],
    'GEN_ENTIDAD' => [
        'singular' => 'Sede', 'plural' => 'sedes', 'femenino' => true,
        'descripcion' => 'Entidades que ejecutan los proyectos y los procesos de selección.',
    ],
    'GEN_PIP' => ['singular' => 'Proyecto de inversión', 'plural' => 'proyectos de inversión', 'descripcion' => 'Proyectos del Banco de Inversiones (Invierte.pe).'],
    'PROC_UNIDAD_MEDIDA' => ['singular' => 'Unidad de medida', 'plural' => 'unidades de medida', 'femenino' => true, 'descripcion' => 'Unidades en que se expresan los ítems de los procesos de selección.'],

    // ---------- CONTRATO ----------
    'PROY_COMPONENTE' => [
        'singular' => 'Etapa', 'plural' => 'etapas', 'femenino' => true,
        'descripcion' => 'Divida el contrato en etapas para controlar su avance y sus costos.',
        'siguiente' => 'Controle sus montos en «Control anual de la etapa», en su fila.',
        'campos' => ['IMP_COMPONENTE' => 'Monto asignado a esta etapa.'],
    ],
    'PROY_CONT_ETAPA_CONTROL' => [
        'singular' => 'Control anual', 'plural' => 'controles anuales',
        'descripcion' => 'Compare lo planificado y lo ejecutado de la etapa. Los montos se acumulan desde el control mensual.',
        'siguiente' => 'Detalle los meses en «Control mensual», en su fila.',
    ],
    'PROY_CONT_COMP_CONTROL_DET' => [
        'singular' => 'Mes', 'plural' => 'meses',
        'descripcion' => 'Registre cada valorización mensual: los montos se calculan solos y se acumulan en el control anual.',
        'campos' => [
            'NUM_ANIO_PROVISION' => 'Año al que corresponde el pago, si es distinto.',
            'NUM_MES_PROVISION' => 'Mes al que corresponde el pago, si es distinto.',
            'DES_CONCEPTO_PAGO' => 'Ej.: Valorización N.° 03, mayo 2022.',
            'IMP_AMORT_ADEL_DIR' => ['etiqueta' => 'Amortización del adelanto directo'],
            'IMP_AMORT_ADEL_MAT' => ['etiqueta' => 'Amortización del adelanto de materiales'],
            'IMP_DEDUC_ADEL_DIR' => ['etiqueta' => 'Deducción del adelanto directo'],
            'IMP_DEDUC_ADEL_MAT' => ['etiqueta' => 'Deducción del adelanto de materiales'],
        ],
    ],
    'PROY_COMP_RECURSO' => [
        'singular' => 'Recurso', 'plural' => 'recursos',
        'descripcion' => 'Personas y medios asignados a esta etapa, con la función de cada uno.',
    ],
    'CONTRATO' => [
        'singular' => 'Contrato', 'plural' => 'contratos',
        'descripcion' => 'Datos del contrato: proveedor, montos, cartas fianza, gastos y archivos.',
        'campos' => [
            'COD_UNICO_ORDEN' => ['etiqueta' => 'Código de orden'],
            'DES_CONTRATO' => ['etiqueta' => 'Descripción del contrato'],
        ],
    ],
    'BIDM_GASTO_CONSOLIDA' => ['descripcion' => 'Gastos registrados del contrato, para contrastarlos con lo planificado.'],
    'CONT_INTERESADOS' => [
        'singular' => 'Interesado', 'plural' => 'interesados',
        'descripcion' => 'Identifique a quienes influyen en el contrato o se ven afectados por él, y qué esperan.',
        'campos' => [
            'TIP_INTERNO_EXTERNO' => ['etiqueta' => '¿Es interno o externo?'],
            'DES_REQUERIMIENTOS_PRIMORDIALES' => 'Qué necesita del proyecto.',
            'DES_EXPECTATIVAS_PRINCIPALES' => 'Qué espera obtener o que suceda.',
            'DES_ESTRATEGIA_PRINCIPAL' => 'Qué haremos para gestionar a este interesado.',
            'DES_FASE_MAYOR_INTERES' => 'En qué momento del proyecto le importa más participar.',
        ],
    ],
    'CONT_DOCUMENTACION' => [
        'singular' => 'Documento', 'plural' => 'documentos',
        'descripcion' => 'Reúna los enlaces a los documentos del contrato, ordenados por tema.',
        'campos' => [
            'IDE_CONOC_PROC' => 'Área de conocimiento y proceso del PMI al que pertenece.',
            'DES_DOCUMENTO' => ['etiqueta' => 'Enlace del documento', 'ayuda' => 'Dirección (URL) del documento en SharePoint.'],
        ],
    ],
    'CONT_CALIDAD' => [
        'singular' => 'Revisión', 'plural' => 'revisiones', 'femenino' => true,
        'descripcion' => 'Registre quién revisó, validó y aprobó cada entregable, y sus observaciones.',
        'siguiente' => 'Si hubo observaciones, regístrelas en «Contenido observado del entregable», en su fila.',
        'campos' => ['NUM_REVISION' => 'Número de veces que se ha revisado este entregable.'],
    ],
    'CONT_CAL_CONTENIDO' => [
        'singular' => 'Observación', 'plural' => 'observaciones', 'femenino' => true,
        'descripcion' => 'Indique qué parte del entregable fue observada y por qué.',
    ],
    'PROY_RIESGO_RECURSO' => [
        'singular' => 'Responsable', 'plural' => 'responsables',
        'descripcion' => 'Personas que dan seguimiento a este riesgo.',
    ],
    'CONTRATO_CONCEPTO' => [
        'singular' => 'Carta fianza', 'plural' => 'cartas fianza', 'femenino' => true,
        'descripcion' => 'Controle las garantías del contrato y sus fechas de vencimiento.',
        'campos' => [
            'COD_TIPO_DOCUMENTO' => 'Número que figura en el documento.',
            'FEC_TERMINO' => 'Fecha de vencimiento de la garantía.',
        ],
    ],
    'PROCESO_CONTRATO' => ['singular' => 'Proceso', 'plural' => 'procesos', 'descripcion' => 'Proceso de selección del que proviene este contrato.'],
    'PROY_CONT_AMPLIACION' => [
        'singular' => 'Ampliación', 'plural' => 'ampliaciones', 'femenino' => true,
        'descripcion' => 'Registre los plazos del contrato y sus cambios. Los campos se ajustan al tipo que elija.',
    ],

    // ---------- PROCESOS DE SELECCION ----------
    'PROCESO' => [
        'singular' => 'Proceso', 'plural' => 'procesos',
        'descripcion' => 'Registre los procesos de selección, con sus ítems y su cronograma.',
        'siguiente' => 'Agregue sus ítems y su cronograma desde su fila.',
        'campos' => [
            'IDE_CONVOCATORIA' => 'Código de la convocatoria en el SEACE. No se puede cambiar después.',
            'COD_PAC' => 'Código en el Plan Anual de Contrataciones.',
            'IMP_VAL_REFERENCIAL' => 'Costo estimado de la contratación.',
        ],
    ],
    'PROC_ITEM' => [
        'singular' => 'Ítem', 'plural' => 'ítems',
        'descripcion' => 'Partes del proceso que se adjudican por separado. Cada ítem crea su proyecto.',
        'siguiente' => 'Agregue sus postores desde su fila.',
    ],
    'PROC_POSTORES' => [
        'singular' => 'Postor', 'plural' => 'postores',
        'descripcion' => 'Empresas que se presentaron a este ítem y sus ofertas.',
        'campos' => ['VAL_REFERENCIAL_ITEM' => 'Se propone desde el ítem.'],
    ],
    'PROC_CRONOGRAMA' => [
        'singular' => 'Actividad', 'plural' => 'actividades', 'femenino' => true,
        'descripcion' => 'Fechas de cada actividad del proceso de selección.',
    ],

    // ---------- PROYECTO ----------
    'PROY_LECCION_APRENDIDA' => [
        'singular' => 'Lección', 'plural' => 'lecciones', 'femenino' => true,
        'descripcion' => 'Conserve lo aprendido para repetir lo que funcionó y no repetir los errores.',
        'campos' => [
            'IDE_FASE_COMPONENTE' => $etapaCorta,
            'DES_LECCION_APRENDIDA' => 'Qué originó la situación.',
            'DES_RECOMENDACION' => 'Qué provocó la situación.',
            'DES_ACCION_PROPUESTA' => 'Qué se hizo o qué conviene hacer si vuelve a ocurrir.',
        ],
    ],
    'PROY_SOCIAL_OBJETIVO_ESP' => [
        'singular' => 'Objetivo', 'plural' => 'objetivos',
        'descripcion' => 'Defina qué se busca lograr con la comunidad y cómo se medirá.',
        'campos' => ['DES_INDICADOR' => 'Cómo se comprobará el logro. Ej.: porcentaje de talleres ejecutados.'],
    ],
    'PROY_ACCION_GESTION' => [
        'singular' => 'Acción', 'plural' => 'acciones', 'femenino' => true,
        'descripcion' => 'Registre los avances y gestiones más importantes del proyecto.',
    ],
    'PROY_ACCION_CORRECTIVA' => [
        'singular' => 'Desviación', 'plural' => 'desviaciones', 'femenino' => true,
        'descripcion' => 'Registre lo que se apartó del plan y qué se hizo para corregirlo.',
        'campos' => [
            'DES_DESVIACION_IDENTIFICADA' => 'Qué se apartó de lo planificado.',
            'DES_ACCION_CORRECTIVA' => 'Qué se hizo o se hará para corregirlo.',
        ],
    ],
    'PROY_OPORTUNIDAD_RIESGO' => [
        'singular' => 'Riesgo', 'plural' => 'riesgos',
        'descripcion' => 'Evalúe los riesgos y oportunidades de mejora del proyecto.',
        'campos' => [
            'NUM_VALORACION' => ['etiqueta' => 'Valoración (probabilidad × impacto)', 'ayuda' => 'Se calcula con la probabilidad y el impacto.'],
        ],
    ],
    'PROY_COSTO_COMPONENTE' => [
        'singular' => 'Actualización de costos', 'plural' => 'actualizaciones de costos', 'femenino' => true,
        'descripcion' => 'Actualice el costo y el avance físico del proyecto en cada etapa.',
        'campos' => ['DES_ACTUALIZACION' => 'Por qué cambió el costo.'],
    ],
    'PROY_SEGUIMIENTO' => [
        'singular' => 'Seguimiento', 'plural' => 'seguimientos',
        'descripcion' => 'Bitácora del proyecto: qué pasó y cuándo, con sus archivos.',
    ],
    'PROY_PIP' => [
        'singular' => 'Proyecto de inversión', 'plural' => 'proyectos de inversión',
        'descripcion' => 'Enlace este proyecto con su registro en el Banco de Inversiones.',
        'campos' => ['IDE_PIP' => 'Escriba el código o el nombre para buscarlo.'],
    ],
    'PROY_COMUNICACION' => [
        'singular' => 'Comunicación', 'plural' => 'comunicaciones', 'femenino' => true,
        'descripcion' => 'Planifique qué se comunica, a quién, cómo y con qué frecuencia.',
        'siguiente' => 'Indique quiénes participan en «Interesados de la comunicación», en su fila.',
        'campos' => ['DES_GLOSARIO_TERMINOS' => 'Términos técnicos que conviene aclarar a los destinatarios.'],
    ],
    'PROY_COM_INTERESADOS' => [
        'singular' => 'Interesado', 'plural' => 'interesados',
        'descripcion' => 'Personas que participan en esta comunicación y su responsabilidad.',
    ],
    'PROY_ACT_UBIGEO' => [
        'singular' => 'Lugar', 'plural' => 'lugares',
        'descripcion' => 'Lugares que se benefician con el proyecto.',
        'campos' => ['COD_UBIGEO' => ['etiqueta' => 'Ubicación', 'ayuda' => 'Escriba el nombre del distrito, la provincia o la región para buscarlo.']],
    ],
    'PROY_GESTION_SOCIAL' => [
        'singular' => 'Comunidad', 'plural' => 'comunidades', 'femenino' => true,
        'descripcion' => 'Comunidades que participan en el proyecto y cuántas personas se benefician.',
        'siguiente' => 'Registre sus beneficios, interesados, quejas y actividades desde su fila.',
        'campos' => ['DES_INTERVENCION' => $etapa, 'IDE_ETAPA_CONTRATO' => $etapa, 'IDE_COMUNIDAD' => 'Escriba el nombre para buscarla.'],
    ],
    'PROY_GESTION_BENEFICIOS' => [
        'singular' => 'Beneficio', 'plural' => 'beneficios',
        'descripcion' => 'Beneficios que recibe la comunidad con el proyecto.',
    ],
    'PROY_INTERESADOS_SOCIAL' => [
        'singular' => 'Interesado', 'plural' => 'interesados',
        'descripcion' => 'Personas de la comunidad vinculadas al proyecto.',
    ],
    'PROY_GESTION_QUEJAS' => [
        'singular' => 'Queja', 'plural' => 'quejas', 'femenino' => true,
        'descripcion' => 'Registre las quejas de la comunidad y haga seguimiento hasta atenderlas.',
        'campos' => ['DES_RESPUESTA' => 'Qué se hizo para atender la queja.'],
    ],
    'PROY_GESTION_ACTIVIDADES' => [
        'singular' => 'Actividad', 'plural' => 'actividades', 'femenino' => true,
        'descripcion' => 'Actividades con la comunidad: las programadas y las realizadas.',
    ],

];

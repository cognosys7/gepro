<?php

/*
|--------------------------------------------------------------------------
| Catalogos (mantenimientos simples) de GEPRO
|--------------------------------------------------------------------------
| Clave: Pagina del sistema actual (Antirefresh.php?Pagina=...). Cada catalogo usa la misma grilla
| y el mismo formulario (App\Livewire\CatalogoTabla y CatalogoFormulario) y graba con su SP_<TABLA>
| (Insert / Update / Delete), como el sistema actual:
| - tabla, id (identidad), sp, estado: columna de estado. La grilla lista los que no estan en '2'
|   (eliminado) y el nombre del estado sale de GEN_TABLAS 99; eliminar es baja logica del SP.
| - parametros: los de Insert/Update del SP en su orden (sin pUsuario, pIdError, pMensajeError).
|   Los que no estan en "campos" se conservan como estan al editar y van vacios al registrar.
| - campos: columna => [etiqueta, tipo, opciones]. Tipos: texto, area, numero, combo.
|   Opciones: requerido, max (largo de la columna), grilla (se muestra en la grilla),
|   solo_lectura (no se edita: venia del sistema financiero), tabla (combo de GEN_TABLAS) o
|   lista ([tabla, id, descripcion, estado] para combos de otra tabla).
|   oculto: solo en la grilla (el formulario del sistema actual no lo muestra; se conserva).
| - filtro: condiciones fijas de la grilla, como las de su SelGrd.
| - jerarquia (Tablas maestras, Entregables, Concepto de gestion social): ver App\Support\Catalogo.
| - nuevo / editar / eliminar: lo que permite el sistema actual (botones y columnas de su grilla).
*/

$estado = ['Estado', 'combo', ['requerido' => true, 'tabla' => '99', 'grilla' => true]];

return [

    'GEN_PORTAFOLIO_PROYECTO' => [
        'titulo' => 'Portafolio de proyectos', 'icono' => 'fa-briefcase',
        'tabla' => 'dbo.GEN_PORTAFOLIO_PROYECTO', 'id' => 'IDE_PORTAFOLIO', 'sp' => 'dbo.SP_GEN_PORTAFOLIO_PROYECTO', 'estado' => 'EST_PORTAFOLIO',
        'parametros' => ['DES_PORTAFOLIO', 'TIP_GRUPO_PORTAFOLIO', 'EST_PORTAFOLIO'],
        'campos' => [
            'TIP_GRUPO_PORTAFOLIO' => ['Tipo', 'combo', ['tabla' => '74', 'grilla' => true]],
            'DES_PORTAFOLIO' => ['Portafolio', 'area', ['requerido' => true, 'max' => 100, 'grilla' => true]],
            'EST_PORTAFOLIO' => $estado,
        ],
        'nuevo' => true, 'editar' => true, 'eliminar' => true,
    ],

    'GEN_PROGRAMA_PROYECTO' => [
        'titulo' => 'Programas de proyectos', 'icono' => 'fa-diagram-project',
        'tabla' => 'dbo.GEN_PROGRAMA_PROYECTO', 'id' => 'IDE_PROGRAMA', 'sp' => 'dbo.SP_GEN_PROGRAMA_PROYECTO', 'estado' => 'EST_PROGRAMA',
        'parametros' => ['DES_PROGRAMA', 'EST_PROGRAMA'],
        'campos' => [
            'DES_PROGRAMA' => ['Programa', 'area', ['requerido' => true, 'max' => 100, 'grilla' => true]],
            'EST_PROGRAMA' => $estado,
        ],
        'nuevo' => true, 'editar' => true, 'eliminar' => true,
    ],

    'GEN_ROLES' => [
        'titulo' => 'Roles por etapa contractual', 'icono' => 'fa-user-tag',
        'tabla' => 'dbo.GEN_ROLES', 'id' => 'IDE_ROL', 'sp' => 'dbo.SP_GEN_ROLES', 'estado' => 'EST_ROL',
        'parametros' => ['IDE_FASE', 'DES_ROL', 'EST_ROL'],
        'campos' => [
            'IDE_FASE' => ['Etapa contractual', 'combo', ['requerido' => true, 'grilla' => true, 'lista' => ['dbo.GEN_FASE', 'IDE_FASE', 'DES_FASE', 'EST_FASE']]],
            'DES_ROL' => ['Rol', 'texto', ['requerido' => true, 'max' => 150, 'grilla' => true]],
            'EST_ROL' => $estado,
        ],
        'nuevo' => true, 'editar' => true, 'eliminar' => true,
    ],

    'GEN_TIPO_RIESGO' => [
        'titulo' => 'Tipos de riesgo', 'icono' => 'fa-triangle-exclamation',
        'tabla' => 'dbo.GEN_TIPO_RIESGO', 'id' => 'IDE_TIPO_RIESGO', 'sp' => 'dbo.SP_GEN_TIPO_RIESGO', 'estado' => 'EST_TIPO_RIESGO',
        'parametros' => ['DES_TIPO_RIESGO', 'EST_TIPO_RIESGO'],
        'campos' => [
            'DES_TIPO_RIESGO' => ['Descripción', 'texto', ['requerido' => true, 'max' => 50, 'grilla' => true]],
            'EST_TIPO_RIESGO' => $estado,
        ],
        'nuevo' => true, 'editar' => true, 'eliminar' => true,
    ],

    'GEN_PROBABILIDAD_RIESGO' => [
        'titulo' => 'Probabilidad de riesgos', 'icono' => 'fa-dice',
        'tabla' => 'dbo.GEN_PROBABILIDAD_RIESGO', 'id' => 'IDE_PROBABILIDAD', 'sp' => 'dbo.SP_GEN_PROBABILIDAD_RIESGO', 'estado' => 'EST_PROBABILIDAD',
        'parametros' => ['DES_PROBABILIDAD', 'NUM_VALOR', 'EST_PROBABILIDAD'],
        'campos' => [
            'DES_PROBABILIDAD' => ['Definición', 'texto', ['requerido' => true, 'max' => 50, 'grilla' => true]],
            'NUM_VALOR' => ['Valor', 'numero', ['requerido' => true, 'grilla' => true]],
            'EST_PROBABILIDAD' => $estado,
        ],
        'nuevo' => true, 'editar' => true, 'eliminar' => true,
    ],

    'GEN_IMPACTO_RIESGO' => [
        'titulo' => 'Impacto de riesgos', 'icono' => 'fa-bolt',
        'tabla' => 'dbo.GEN_IMPACTO_RIESGO', 'id' => 'IDE_IMPACTO', 'sp' => 'dbo.SP_GEN_IMPACTO_RIESGO', 'estado' => 'EST_IMPACTO',
        'parametros' => ['DES_IMPACTO', 'NUM_VALOR', 'EST_IMPACTO'],
        'campos' => [
            'DES_IMPACTO' => ['Definición', 'texto', ['requerido' => true, 'max' => 20, 'grilla' => true]],
            'NUM_VALOR' => ['Valor', 'numero', ['requerido' => true, 'grilla' => true]],
            'EST_IMPACTO' => $estado,
        ],
        'nuevo' => true, 'editar' => true, 'eliminar' => true,
    ],

    'GEN_PRIORIDAD_RIESGO' => [
        'titulo' => 'Prioridad de riesgos', 'icono' => 'fa-arrow-up-wide-short',
        'tabla' => 'dbo.GEN_PRIORIDAD_RIESGO', 'id' => 'IDE_PRIORIDAD', 'sp' => 'dbo.SP_GEN_PRIORIDAD_RIESGO', 'estado' => 'EST_PRIORIDAD',
        'parametros' => ['DES_PRIORIDAD', 'NUM_VALOR', 'EST_PRIORIDAD'],
        'campos' => [
            'DES_PRIORIDAD' => ['Definición', 'texto', ['requerido' => true, 'max' => 50, 'grilla' => true]],
            'NUM_VALOR' => ['Valor', 'numero', ['requerido' => true, 'grilla' => true]],
            'EST_PRIORIDAD' => $estado,
        ],
        'nuevo' => true, 'editar' => true, 'eliminar' => true,
    ],

    'GEN_MATRIZ_CONOCIMIENTO_PROCESO' => [
        'titulo' => 'Matriz de conocimiento PMI', 'icono' => 'fa-table-cells',
        'tabla' => 'dbo.GEN_MATRIZ_CONOCIMIENTO_PROCESO', 'id' => 'IDE_CONOC_PROC', 'sp' => 'dbo.SP_GEN_MATRIZ_CONOCIMIENTO_PROCESO', 'estado' => 'EST_CONOC_PROC',
        'parametros' => ['TIP_AREA_CONOCIMIENTO', 'TIP_GRUPO_PROCESO', 'DES_CRUCE_CONOC_PROC', 'DES_ABREVIATURA', 'COD_ORDEN', 'EST_CONOC_PROC'],
        'campos' => [
            'TIP_AREA_CONOCIMIENTO' => ['Área de conocimiento', 'combo', ['requerido' => true, 'tabla' => '82', 'grilla' => true]],
            'TIP_GRUPO_PROCESO' => ['Grupo de proceso', 'combo', ['requerido' => true, 'tabla' => '83', 'grilla' => true]],
            'DES_CRUCE_CONOC_PROC' => ['Descripción del conocimiento', 'area', ['requerido' => true, 'max' => 400, 'grilla' => true]],
            'DES_ABREVIATURA' => ['Abreviatura', 'texto', ['max' => 150, 'grilla' => true]],
            'COD_ORDEN' => ['Orden', 'texto', ['requerido' => true, 'max' => 10, 'grilla' => true]],
            'EST_CONOC_PROC' => $estado,
        ],
        'nuevo' => true, 'editar' => true, 'eliminar' => true,
    ],

    'GEN_CENTRO_COSTO' => [
        'titulo' => 'Centros de costo', 'icono' => 'fa-building-columns',
        'tabla' => 'dbo.GEN_CENTRO_COSTO', 'id' => 'IDE_CENCOSTO', 'sp' => 'dbo.SP_GEN_CENTRO_COSTO', 'estado' => 'EST_CENCOSTO',
        'parametros' => ['COD_CENCOSTO', 'DES_CENCOSTO', 'EST_CENCOSTO'],
        'campos' => [
            'COD_CENCOSTO' => ['Código', 'texto', ['requerido' => true, 'max' => 10, 'grilla' => true]],
            'DES_CENCOSTO' => ['Centro de costo', 'area', ['requerido' => true, 'max' => 80, 'grilla' => true]],
            'EST_CENCOSTO' => $estado,
        ],
        'nuevo' => false, 'editar' => false, 'eliminar' => false,
    ],

    'PROC_TIPO' => [
        'titulo' => 'Tipos de proceso de selección', 'icono' => 'fa-list-ol',
        'tabla' => 'dbo.PROC_TIPO', 'id' => 'IDE_TIPO_PROC', 'sp' => 'dbo.SP_PROC_TIPO', 'estado' => 'EST_PROC_TIPO',
        'parametros' => ['TIPO_PROC', 'SIGLA_PROC', 'EST_PROC_TIPO'],
        'campos' => [
            'TIPO_PROC' => ['Tipo de proceso', 'texto', ['requerido' => true, 'max' => 70, 'grilla' => true]],
            'SIGLA_PROC' => ['Abreviatura', 'texto', ['requerido' => true, 'max' => 20, 'grilla' => true]],
            'EST_PROC_TIPO' => $estado,
        ],
        'nuevo' => true, 'editar' => true, 'eliminar' => true,
    ],

    'GEN_FUENTE_FINANCIAMIENTO' => [
        'titulo' => 'Fuentes de financiamiento', 'icono' => 'fa-sack-dollar',
        'tabla' => 'dbo.GEN_FUENTE_FINANCIAMIENTO', 'id' => 'IDE_FTE_FTO', 'sp' => 'dbo.SP_GEN_FUENTE_FINANCIAMIENTO', 'estado' => 'EST_FTE_FTO',
        'parametros' => ['COD_FTE_FTO', 'DES_FTE_FTO', 'EST_FTE_FTO'],
        'campos' => [
            'NUM_ANHO' => ['Año', 'texto', ['grilla' => true, 'solo_lectura' => true]],
            'COD_FTE_FTO' => ['Código interno', 'texto', ['requerido' => true, 'max' => 20, 'grilla' => true]],
            'DES_FTE_FTO' => ['Fuente de financiamiento', 'texto', ['requerido' => true, 'max' => 200, 'grilla' => true]],
            'EST_FTE_FTO' => $estado,
        ],
        'nuevo' => false, 'editar' => false, 'eliminar' => false,
    ],

    'GEN_CUENTA_CONTABLE' => [
        'titulo' => 'Cuentas contables', 'icono' => 'fa-book',
        'tabla' => 'dbo.GEN_CUENTA_CONTABLE', 'id' => 'IDE_CUENTA_CONTABLE', 'sp' => 'dbo.SP_GEN_CUENTA_CONTABLE', 'estado' => 'EST_CUENTA_CONTABLE',
        'parametros' => ['COD_CUENTA_CONTABLE', 'DES_CUENTA_CONTABLE', 'EST_CUENTA_CONTABLE'],
        'campos' => [
            'COD_CUENTA_CONTABLE' => ['Código interno', 'texto', ['requerido' => true, 'max' => 20, 'grilla' => true]],
            'DES_CUENTA_CONTABLE' => ['Cuenta contable', 'texto', ['requerido' => true, 'max' => 500, 'grilla' => true]],
            'EST_CUENTA_CONTABLE' => $estado,
        ],
        'nuevo' => false, 'editar' => false, 'eliminar' => false,
    ],

    'GEN_BANCO' => [
        'titulo' => 'Bancos', 'icono' => 'fa-building-columns',
        'tabla' => 'dbo.GEN_BANCO', 'id' => 'IDE_BANCO', 'sp' => 'dbo.SP_GEN_BANCO', 'estado' => 'EST_BANCO',
        'parametros' => ['COD_INTERNO', 'DES_BANCO', 'COD_RUC', 'DES_LOGO', 'DES_COMENTARIO', 'EST_BANCO'],
        'campos' => [
            'COD_INTERNO' => ['Código interno', 'texto', ['max' => 3, 'grilla' => true, 'solo_lectura' => true]],
            'COD_RUC' => ['R.U.C.', 'texto', ['requerido' => true, 'max' => 15, 'grilla' => true, 'solo_lectura' => true]],
            'DES_BANCO' => ['Entidad financiera', 'texto', ['requerido' => true, 'max' => 120, 'grilla' => true, 'solo_lectura' => true]],
            'DES_COMENTARIO' => ['Comentario', 'area', ['max' => 1000, 'grilla' => true]],
            'EST_BANCO' => $estado,
        ],
        'nuevo' => false, 'editar' => true, 'eliminar' => false,
    ],

    'GEN_PROVEEDOR' => [
        'titulo' => 'Proveedores', 'icono' => 'fa-truck-field',
        'tabla' => 'dbo.GEN_PROVEEDOR', 'id' => 'IDE_PROVEEDOR', 'sp' => 'dbo.SP_GEN_PROVEEDOR', 'estado' => 'EST_PROVEEDOR',
        'parametros' => ['COD_PROVEEDOR', 'COD_RUC', 'DES_PROVEEDOR', 'DES_DIRECCION', 'DES_COMENTARIO', 'EST_PROVEEDOR'],
        'campos' => [
            'COD_PROVEEDOR' => ['Código', 'texto', ['max' => 10, 'grilla' => true, 'solo_lectura' => true]],
            'COD_RUC' => ['R.U.C. / D.N.I.', 'texto', ['requerido' => true, 'max' => 12, 'grilla' => true, 'solo_lectura' => true]],
            'DES_PROVEEDOR' => ['Proveedor', 'texto', ['requerido' => true, 'max' => 200, 'grilla' => true, 'solo_lectura' => true]],
            'DES_DIRECCION' => ['Dirección', 'area', ['max' => 200, 'grilla' => true, 'solo_lectura' => true]],
            'DES_COMENTARIO' => ['Comentario', 'area', ['max' => 2000]],
            'EST_PROVEEDOR' => $estado,
        ],
        'nuevo' => false, 'editar' => true, 'eliminar' => false,
    ],

    'GEN_CARGO' => [
        'titulo' => 'Cargos', 'icono' => 'fa-id-badge',
        'tabla' => 'dbo.GEN_CARGO', 'id' => 'IDE_CARGO', 'sp' => 'dbo.SP_GEN_CARGO', 'estado' => 'EST_CARGO',
        'parametros' => ['DES_CARGO', 'EST_CARGO'],
        'campos' => [
            'DES_CARGO' => ['Cargo', 'area', ['requerido' => true, 'max' => 250, 'grilla' => true]],
            'EST_CARGO' => $estado,
        ],
        'nuevo' => true, 'editar' => true, 'eliminar' => true,
    ],

    'GEN_TABLAS' => [
        'titulo' => 'Tablas maestras', 'icono' => 'fa-table-list',
        'tabla' => 'dbo.GEN_TABLAS', 'id' => 'IDE_TABLA', 'sp' => 'dbo.SP_GEN_TABLAS', 'estado' => 'EST_ITEM',
        'parametros' => ['COD_TABLA', 'COD_ITEM', 'DES_ITEM', 'DES_ABREVIATURA', 'COD_ORDEN', 'EST_ITEM'],
        'campos' => [
            'COD_ITEM' => ['Código', 'texto', ['requerido' => true, 'max' => 10, 'grilla' => true]],
            'DES_ITEM' => ['Descripción', 'texto', ['requerido' => true, 'max' => 150, 'grilla' => true]],
            'DES_ABREVIATURA' => ['Abreviatura', 'texto', ['max' => 150, 'grilla' => true]],
            'COD_ORDEN' => ['Orden de visualización', 'numero', ['grilla' => true]],
            'EST_ITEM' => $estado,
        ],
        //LAS TABLAS SON LOS ITEMS DE COD_TABLA = 0; LOS VALORES DE CADA TABLA TIENEN COD_TABLA = SU CODIGO
        'jerarquia' => [
            'raiz' => ['filtro' => ['COD_TABLA' => '0'], 'valores' => ['COD_TABLA' => '0']],
            'hijo' => ['filtro' => ['COD_TABLA' => '{COD_ITEM}'], 'valores' => ['COD_TABLA' => '{COD_ITEM}']],
            'padre' => ['COD_TABLA' => '0', 'COD_ITEM' => '{COD_TABLA}'],
            'niveles' => 2, 'boton' => ['Ver valores', 'fa-list'], 'titulo' => 'DES_ITEM',
        ],
        'nuevo' => true, 'editar' => true, 'eliminar' => true,
    ],

    /*
    | 2.1 Fases y componentes, 2.3 Modalidad y 2.4 Hitos claves: el menu del sistema actual las tiene pero
    | sus pantallas no existen; las tablas y sus SP si (GEN_INTERVENCION, GEN_MODO_EJECUCION, GEN_INTERVENCION_COMP)
    */
    'GEN_INTERVENCION' => [
        'titulo' => 'Fases y componentes', 'icono' => 'fa-diagram-project',
        'tabla' => 'dbo.GEN_INTERVENCION', 'id' => 'IDE_INTERVENCION', 'sp' => 'dbo.SP_GEN_INTERVENCION', 'estado' => 'EST_INTERVENCION',
        'parametros' => ['IDE_SECTOR', 'DES_INTERVENCION', 'NUM_NIVEL', 'IDE_INTERVENCION_SUP', 'DES_RUBRO', 'TIP_SECTOR_PIRCC', 'EST_INTERVENCION'],
        //SECTOR DE GEPRO (14): NIVEL 1 = ENTIDAD, NIVEL 2 = FASES, NIVEL 3 = COMPONENTES (LOS QUE USAN LOS CONTRATOS)
        'filtro' => ['IDE_SECTOR' => 14],
        'campos' => [
            'DES_INTERVENCION' => ['Descripción', 'texto', ['requerido' => true, 'max' => 150, 'grilla' => true]],
            'DES_RUBRO' => ['Rubro', 'texto', ['max' => 200, 'grilla' => true]],
            'EST_INTERVENCION' => $estado,
        ],
        'jerarquia' => [
            'raiz' => ['filtro' => ['NUM_NIVEL' => 1], 'valores' => ['NUM_NIVEL' => '1', 'IDE_SECTOR' => '14']],
            'hijo' => ['filtro' => ['IDE_INTERVENCION_SUP' => '{id}'], 'valores' => ['IDE_INTERVENCION_SUP' => '{id}', 'NUM_NIVEL' => '{NUM_NIVEL+1}', 'IDE_SECTOR' => '{IDE_SECTOR}']],
            'padre' => ['IDE_INTERVENCION' => '{IDE_INTERVENCION_SUP}'],
            'niveles' => 3, 'boton' => ['Ver fases / componentes', 'fa-sitemap'], 'titulo' => 'DES_INTERVENCION',
        ],
        'nuevo' => true, 'editar' => true, 'eliminar' => true,
    ],

    'GEN_MODO_EJECUCION' => [
        'titulo' => 'Modalidades de ejecución', 'icono' => 'fa-gears',
        'tabla' => 'dbo.GEN_MODO_EJECUCION', 'id' => 'IDE_MODO_EJECUCION', 'sp' => 'dbo.SP_GEN_MODO_EJECUCION', 'estado' => 'EST_MODO_EJECUCION',
        'parametros' => ['DES_MODO_EJECUCION', 'DES_ABREVIATURA', 'EST_MODO_EJECUCION'],
        'campos' => [
            'DES_MODO_EJECUCION' => ['Modalidad', 'texto', ['requerido' => true, 'max' => 150, 'grilla' => true]],
            'DES_ABREVIATURA' => ['Abreviatura', 'texto', ['max' => 20, 'grilla' => true]],
            'EST_MODO_EJECUCION' => $estado,
        ],
        'nuevo' => true, 'editar' => true, 'eliminar' => true,
    ],

    'Gen_intervencion_comp' => [
        'titulo' => 'Hitos claves por componente', 'icono' => 'fa-flag-checkered',
        'tabla' => 'dbo.GEN_INTERVENCION_COMP', 'id' => 'IDE_INTERVENCION_COMP', 'sp' => 'dbo.SP_GEN_INTERVENCION_COMP', 'estado' => 'EST_INTERVENCION_COMP',
        'parametros' => ['IDE_INTERVENCION', 'IDE_COMPONENTE', 'COMP_PRINCIPAL', 'IDE_MODO_EJECUCION', 'IDE_TIPO_PROC', 'EST_INTERVENCION_COMP'],
        //QUE ETAPAS (HITOS) TIENE CADA FASE - COMPONENTE: DE AQUI SALE EL COMBO DE ETAPAS DE LOS CONTRATOS
        'campos' => [
            'IDE_INTERVENCION' => ['Fase - componente', 'combo', ['requerido' => true, 'grilla' => true, 'lista' => ['dbo.GEN_INTERVENCION', 'IDE_INTERVENCION', 'DES_INTERVENCION', 'EST_INTERVENCION', ['IDE_SECTOR' => 14, 'NUM_NIVEL' => 3]]]],
            'IDE_COMPONENTE' => ['Etapa (hito)', 'combo', ['requerido' => true, 'grilla' => true, 'lista' => ['dbo.GEN_COMPONENTE', 'IDE_COMPONENTE', 'DES_COMPONENTE', 'EST_COMPONENTE']]],
            'COMP_PRINCIPAL' => ['Orden principal', 'numero', ['grilla' => true]],
            'IDE_MODO_EJECUCION' => ['Modalidad de ejecución', 'combo', ['grilla' => true, 'lista' => ['dbo.GEN_MODO_EJECUCION', 'IDE_MODO_EJECUCION', 'DES_MODO_EJECUCION', 'EST_MODO_EJECUCION']]],
            'IDE_TIPO_PROC' => ['Tipo de proceso', 'combo', ['lista' => ['dbo.PROC_TIPO', 'IDE_TIPO_PROC', 'TIPO_PROC', 'EST_PROC_TIPO']]],
            'EST_INTERVENCION_COMP' => $estado,
        ],
        'orden' => [['IDE_INTERVENCION', 'asc'], ['COMP_PRINCIPAL', 'asc']],
        'nuevo' => true, 'editar' => true, 'eliminar' => true,
    ],

    'GEN_COMPONENTE' => [
        'titulo' => 'Etapas del contrato', 'icono' => 'fa-layer-group',
        'tabla' => 'dbo.GEN_COMPONENTE', 'id' => 'IDE_COMPONENTE', 'sp' => 'dbo.SP_GEN_COMPONENTE', 'estado' => 'EST_COMPONENTE',
        'parametros' => ['IDE_FASE', 'DES_COMPONENTE', 'DES_ABREVIATURA', 'EST_COMPONENTE'],
        'campos' => [
            'IDE_FASE' => ['Fase', 'combo', ['grilla' => true, 'oculto' => true, 'lista' => ['dbo.GEN_FASE', 'IDE_FASE', 'DES_FASE', 'EST_FASE']]],
            'DES_COMPONENTE' => ['Etapa de contrato', 'texto', ['requerido' => true, 'max' => 100, 'grilla' => true]],
            'DES_ABREVIATURA' => ['Abreviatura', 'texto', ['requerido' => true, 'max' => 100, 'grilla' => true]],
            'EST_COMPONENTE' => $estado,
        ],
        'nuevo' => true, 'editar' => true, 'eliminar' => true,
    ],

    'GEN_INDICADOR' => [
        'titulo' => 'Indicadores por fase', 'icono' => 'fa-gauge',
        'tabla' => 'dbo.GEN_INDICADOR', 'id' => 'IDE_INDICADOR', 'sp' => 'dbo.SP_GEN_INDICADOR', 'estado' => 'EST_INDICADOR',
        'parametros' => ['IDE_INTERVENCION', 'DES_INDICADOR', 'TIP_INDICADOR', 'TIP_PRIORIDAD', 'TIP_PERIODO_PROGRAMACION', 'TIP_PERIODO_EJECUCION', 'DES_UNIDAD_MEDIDA', 'EST_INDICADOR'],
        'campos' => [
            'IDE_INTERVENCION' => ['Fase', 'combo', ['requerido' => true, 'grilla' => true, 'lista' => ['dbo.GEN_INTERVENCION', 'IDE_INTERVENCION', 'DES_INTERVENCION', 'EST_INTERVENCION', ['NUM_NIVEL' => 2]]]],
            'DES_INDICADOR' => ['Nombre del indicador', 'texto', ['requerido' => true, 'max' => 80, 'grilla' => true]],
            'TIP_INDICADOR' => ['Tipo de indicador', 'combo', ['requerido' => true, 'tabla' => '9', 'grilla' => true]],
            'TIP_PRIORIDAD' => ['Prioridad', 'combo', ['requerido' => true, 'tabla' => '10']],
            'TIP_PERIODO_PROGRAMACION' => ['Periodo de programación', 'combo', ['requerido' => true, 'tabla' => '11', 'grilla' => true]],
            'TIP_PERIODO_EJECUCION' => ['Periodo de ejecución', 'combo', ['requerido' => true, 'tabla' => '11', 'grilla' => true]],
            'DES_UNIDAD_MEDIDA' => ['Unidad de medida', 'texto', ['requerido' => true, 'max' => 20, 'grilla' => true]],
            'EST_INDICADOR' => $estado,
        ],
        'nuevo' => true, 'editar' => true, 'eliminar' => true,
    ],

    'GEN_ENTREGABLE' => [
        'titulo' => 'Entregables por componente', 'icono' => 'fa-box-archive',
        'tabla' => 'dbo.GEN_ENTREGABLE', 'id' => 'IDE_ENTREGABLE', 'sp' => 'dbo.SP_GEN_ENTREGABLE', 'estado' => 'EST_ENTREGABLE',
        'parametros' => ['IDE_FASE_COMPONENTE', 'GEN_IDE_ENTREGABLE', 'DES_ENTREGABLE', 'DES_ABREVIATURA', 'NUM_NIVEL', 'NUM_ORDEN', 'EST_ENTREGABLE'],
        'campos' => [
            'IDE_FASE_COMPONENTE' => ['Fase - componente', 'combo', ['grilla' => true, 'lista' => ['dbo.GEN_INTERVENCION', 'IDE_INTERVENCION', 'DES_INTERVENCION', 'EST_INTERVENCION', ['IDE_SECTOR' => 14, 'NUM_NIVEL' => 3]]]],
            'DES_ENTREGABLE' => ['Entregable', 'texto', ['requerido' => true, 'max' => 200, 'grilla' => true]],
            'DES_ABREVIATURA' => ['Abreviatura', 'texto', ['requerido' => true, 'max' => 100, 'grilla' => true]],
            'NUM_ORDEN' => ['Orden visual', 'texto', ['requerido' => true, 'max' => 20, 'grilla' => true]],
            'EST_ENTREGABLE' => $estado,
        ],
        //NIVEL 1: ENTREGABLES; NIVEL 2: SUS SUB-ENTREGABLES (HEREDAN LA FASE - COMPONENTE DEL PADRE)
        'jerarquia' => [
            'raiz' => ['filtro' => ['NUM_NIVEL' => 1], 'valores' => ['NUM_NIVEL' => '1']],
            'hijo' => ['filtro' => ['GEN_IDE_ENTREGABLE' => '{id}'], 'valores' => ['GEN_IDE_ENTREGABLE' => '{id}', 'NUM_NIVEL' => '2', 'IDE_FASE_COMPONENTE' => '{IDE_FASE_COMPONENTE}']],
            'padre' => ['IDE_ENTREGABLE' => '{GEN_IDE_ENTREGABLE}'],
            'niveles' => 2, 'boton' => ['Ver sub-entregables', 'fa-sitemap'], 'titulo' => 'DES_ENTREGABLE',
        ],
        'nuevo' => true, 'editar' => true, 'eliminar' => true,
    ],

    'GEN_RECURSO' => [
        'titulo' => 'Recursos', 'icono' => 'fa-people-carry-box',
        'tabla' => 'dbo.GEN_RECURSO', 'id' => 'IDE_RECURSO', 'sp' => 'dbo.SP_GEN_RECURSO', 'estado' => 'EST_RECURSO',
        'parametros' => ['IDE_ENTIDAD', 'TIP_RECURSO', 'COD_RECURSO', 'DES_RECURSO', 'EST_RECURSO'],
        'campos' => [
            'IDE_ENTIDAD' => ['Sede ejecutora', 'combo', ['requerido' => true, 'grilla' => true, 'lista' => ['dbo.GEN_ENTIDAD', 'IDE_ENTIDAD', 'DES_ENTIDAD', 'EST_ENTIDAD']]],
            'TIP_RECURSO' => ['Tipo de recurso', 'combo', ['requerido' => true, 'tabla' => '21', 'grilla' => true]],
            'DES_RECURSO' => ['Nombre o descripción', 'texto', ['requerido' => true, 'max' => 200, 'grilla' => true]],
            'EST_RECURSO' => $estado,
        ],
        'nuevo' => true, 'editar' => true, 'eliminar' => true,
    ],

    'GEN_CONCEPTO_SOCIAL' => [
        'titulo' => 'Conceptos de gestión social', 'icono' => 'fa-people-group',
        'tabla' => 'dbo.GEN_CONCEPTO_SOCIAL', 'id' => 'IDE_CONCEPTO', 'sp' => 'dbo.SP_GEN_CONCEPTO_SOCIAL', 'estado' => 'EST_CONCEPTO',
        'parametros' => ['DES_CONCEPTO', 'DES_CONCEPTO_ABREVIATURA', 'TIP_UNIDAD_MEDIDA', 'NUM_NIVEL', 'EST_CONCEPTO', 'IDE_RUBRO'],
        'campos' => [
            'DES_CONCEPTO' => ['Concepto', 'area', ['requerido' => true, 'max' => 200, 'grilla' => true]],
            'DES_CONCEPTO_ABREVIATURA' => ['Abreviatura', 'texto', ['max' => 20, 'grilla' => true]],
            'TIP_UNIDAD_MEDIDA' => ['Unidad de medida', 'combo', ['requerido' => true, 'tabla' => '79', 'grilla' => true]],
            'EST_CONCEPTO' => $estado,
        ],
        //RUBROS EN EL NIVEL 11 Y SU DETALLE HASTA EL NIVEL 14 (IDE_RUBRO = CONCEPTO SUPERIOR)
        'jerarquia' => [
            'raiz' => ['filtro' => ['NUM_NIVEL' => 11], 'valores' => ['NUM_NIVEL' => '11', 'IDE_RUBRO' => '0']],
            'hijo' => ['filtro' => ['IDE_RUBRO' => '{id}', 'NUM_NIVEL' => '{NUM_NIVEL+1}'], 'valores' => ['IDE_RUBRO' => '{id}', 'NUM_NIVEL' => '{NUM_NIVEL+1}']],
            'padre' => ['IDE_CONCEPTO' => '{IDE_RUBRO}'],
            'niveles' => 4, 'boton' => ['Ver detalle', 'fa-sitemap'], 'titulo' => 'DES_CONCEPTO',
        ],
        'nuevo' => true, 'editar' => true, 'eliminar' => true,
    ],

    'GEN_COMUNIDAD' => [
        'titulo' => 'Comunidades y centros poblados', 'icono' => 'fa-house-flag',
        'tabla' => 'dbo.GEN_COMUNIDAD', 'id' => 'IDE_COMUNIDAD', 'sp' => 'dbo.SP_GEN_COMUNIDAD', 'estado' => 'EST_COMUNIDAD',
        'parametros' => ['COD_UBIGEO', 'DES_COMUNIDAD', 'EST_COMUNIDAD'],
        'campos' => [
            'COD_UBIGEO' => ['UBIGEO (departamento / provincia / distrito)', 'combo', ['grilla' => true, 'lista' => ['dbo.GEN_UBIGEO', 'COD_UBIGEO', "CONCAT(LTRIM(RTRIM(COD_UBIGEO)), ' - ', DES_DEPARTAMENTO, ' / ', DES_PROVINCIA, ' / ', DES_DISTRITO)", 'EST_UBIGEO', ['NUM_NIVEL' => 3]]]],
            'DES_COMUNIDAD' => ['Comunidad - CC.PP.', 'texto', ['max' => 200, 'grilla' => true]],
            'EST_COMUNIDAD' => $estado,
        ],
        'nuevo' => true, 'editar' => true, 'eliminar' => true,
    ],

    'GEN_ESPECIFICA_GASTO' => [
        'titulo' => 'Específicas de gasto', 'icono' => 'fa-receipt',
        'tabla' => 'dbo.GEN_ESPECIFICA_GASTO', 'id' => 'IDE_ESPECIFICA_GASTO', 'sp' => 'dbo.SP_GEN_ESPECIFICA_GASTO', 'estado' => 'EST_ESPECIFICA_GASTO',
        'parametros' => ['NUM_ANHO', 'COD_ESPECIFICA_GASTO', 'DES_ESPECIFICA_GASTO', 'COD_GENERICA', 'DES_GENERICA', 'COD_SUBGENERICA', 'DES_SUBGENERICA',
            'COD_SUBGENERICA_DET', 'DES_SUBGNERICA_DET', 'COD_ESPECIFICA', 'DES_ESPECIFICA', 'COD_ESPECIFICA_DET', 'DES_ESPECIFICA_DET', 'EST_ESPECIFICA_GASTO'],
        'campos' => [
            'NUM_ANHO' => ['Año fiscal', 'texto', ['requerido' => true, 'max' => 4, 'grilla' => true, 'solo_lectura' => true]],
            'COD_ESPECIFICA_GASTO' => ['Cód. específica de gasto', 'texto', ['requerido' => true, 'max' => 30, 'grilla' => true, 'solo_lectura' => true]],
            'DES_ESPECIFICA_GASTO' => ['Específica de gasto', 'texto', ['requerido' => true, 'max' => 200, 'grilla' => true, 'solo_lectura' => true]],
            'COD_GENERICA' => ['Cód. genérica', 'texto', ['max' => 10]],
            'DES_GENERICA' => ['Genérica', 'texto', ['max' => 100]],
            'COD_SUBGENERICA' => ['Cód. subgenérica', 'texto', ['max' => 15]],
            'DES_SUBGENERICA' => ['Subgenérica', 'texto', ['max' => 100]],
            'COD_SUBGENERICA_DET' => ['Cód. subgenérica detalle', 'texto', ['max' => 15]],
            'DES_SUBGNERICA_DET' => ['Subgenérica detalle', 'texto', ['max' => 100]],
            'COD_ESPECIFICA' => ['Cód. específica', 'texto', ['max' => 15]],
            'DES_ESPECIFICA' => ['Específica', 'texto', ['max' => 100]],
            'COD_ESPECIFICA_DET' => ['Cód. específica detalle', 'texto', ['max' => 15]],
            'DES_ESPECIFICA_DET' => ['Específica detalle', 'texto', ['max' => 100]],
            'EST_ESPECIFICA_GASTO' => $estado,
        ],
        //EL SISTEMA ACTUAL TIENE "NUEVO", PERO AÑO, CODIGO Y DESCRIPCION (OBLIGATORIOS) SON DE SOLO LECTURA:
        //NO SE PUEDE REGISTRAR UNA NUEVA; TAMPOCO ELIMINAR (COLUMNA OCULTA)
        'nuevo' => false, 'editar' => true, 'eliminar' => false,
    ],

    'GEN_UBIGEO' => [
        'titulo' => 'UBIGEO (ubicación geográfica)', 'icono' => 'fa-map-location-dot',
        //LA CLAVE ES EL CODIGO DE UBIGEO (TEXTO): SP_GEN_UBIGEO LO RECIBE EN @pCodigo
        'tabla' => 'dbo.GEN_UBIGEO', 'id' => 'COD_UBIGEO', 'sp' => 'dbo.SP_GEN_UBIGEO', 'estado' => 'EST_UBIGEO',
        'parametros' => ['COD_UBIGEO', 'COD_UBIGEO_SUP', 'DES_DEPARTAMENTO', 'DES_PROVINCIA', 'DES_DISTRITO', 'NUM_NIVEL', 'GEO_LONGITUD', 'GEO_LATITUD', 'EST_UBIGEO'],
        'campos' => [
            'COD_UBIGEO' => ['UBIGEO', 'texto', ['requerido' => true, 'max' => 12, 'grilla' => true, 'solo_lectura' => true, 'unico' => true]],
            'NUM_NIVEL' => ['Nivel', 'combo', ['requerido' => true, 'tabla' => '20', 'solo_lectura' => true]],
            'DES_DEPARTAMENTO' => ['Región', 'texto', ['requerido' => true, 'max' => 40, 'grilla' => true]],
            'DES_PROVINCIA' => ['Provincia', 'texto', ['max' => 40, 'grilla' => true]],
            'DES_DISTRITO' => ['Distrito', 'texto', ['max' => 40, 'grilla' => true]],
            'GEO_LONGITUD' => ['Longitud geográfica', 'texto', ['requerido' => true, 'max' => 30, 'grilla' => true]],
            'GEO_LATITUD' => ['Latitud geográfica', 'texto', ['requerido' => true, 'max' => 30, 'grilla' => true]],
            'EST_UBIGEO' => $estado,
        ],
        'nuevo' => true, 'editar' => true, 'eliminar' => true,
    ],

    'GEN_ENTIDAD' => [
        'titulo' => 'Sedes ejecutoras / entidades', 'icono' => 'fa-landmark',
        'tabla' => 'dbo.GEN_ENTIDAD', 'id' => 'IDE_ENTIDAD', 'sp' => 'dbo.SP_GEN_ENTIDAD', 'estado' => 'EST_ENTIDAD',
        'parametros' => ['IDE_SECTOR', 'COD_RUC', 'DES_ENTIDAD', 'TIP_ENTIDAD', 'NUM_NIVEL', 'EST_ENTIDAD', 'SEC_EJEC'],
        //EL SISTEMA ACTUAL OCULTA EL SECTOR Y EL RUC (Y PONIA SIEMPRE EL RUC DE AMSAC): AQUI SE MUESTRAN
        //PARA QUE CADA SEDE NUEVA QUEDE CON SU SECTOR (LA GRILLA SOLO LISTA LAS QUE TIENEN SECTOR)
        'campos' => [
            'IDE_SECTOR' => ['Sector', 'combo', ['requerido' => true, 'grilla' => true, 'lista' => ['dbo.GEN_SECTOR', 'IDE_SECTOR', 'DES_SECTOR', 'EST_SECTOR']]],
            'COD_RUC' => ['RUC', 'texto', ['max' => 12, 'grilla' => true]],
            'SEC_EJEC' => ['Sec. ejecutora', 'texto', ['max' => 10, 'grilla' => true, 'oculto' => true]],
            'DES_ENTIDAD' => ['Sede', 'texto', ['requerido' => true, 'max' => 150, 'grilla' => true]],
            'TIP_ENTIDAD' => ['Tipo de entidad', 'combo', ['requerido' => true, 'tabla' => '6', 'grilla' => true]],
            'EST_ENTIDAD' => $estado,
        ],
        'nuevo' => true, 'editar' => true, 'eliminar' => true,
    ],

    'GEN_PIP' => [
        'titulo' => 'Proyectos de inversión (Invierte.pe)', 'icono' => 'fa-file-invoice-dollar',
        'tabla' => 'dbo.GEN_PIP', 'id' => 'IDE_PIP', 'sp' => 'dbo.SP_GEN_PIP', 'estado' => 'EST_PIP',
        'parametros' => ['COD_SNIP', 'COD_UNICO', 'COD_PROYECTO', 'DES_PIP', 'FEC_REGISTRO', 'FEC_VIABILIDAD', 'IMP_MONTO_VIABLE', 'DES_FUNCION',
            'DES_PROGRAMA', 'DES_SUBPROGRAMA', 'DES_NIVEL', 'DES_SECTOR', 'DES_PLIEGO', 'DES_UNIDAD_EJECUTORA', 'DES_RESPONSABLE_VIABLE',
            'IMP_MONTO_F15', 'IMP_MONTO_F16', 'IMP_COSTO_ACTUALIZADO', 'NUM_BENEFICIARIOS', 'EST_INVIERTE', 'TIP_PIP', 'TIP_PIP_CODIGO', 'EST_PIP', 'DES_OBSERVACION'],
        //LOS DATOS VIENEN DEL BANCO DE INVERSIONES: SOLO SE EDITAN LA DENOMINACION Y EL ESTADO DE INVIERTE
        'campos' => [
            'COD_SNIP' => ['Código SNIP', 'texto', ['grilla' => true, 'oculto' => true]],
            'COD_UNICO' => ['Código único', 'texto', ['grilla' => true, 'oculto' => true]],
            'COD_PROYECTO' => ['Código de proyecto', 'texto', ['requerido' => true, 'max' => 30, 'grilla' => true, 'solo_lectura' => true]],
            'DES_PIP' => ['Denominación del proyecto', 'area', ['requerido' => true, 'max' => 500, 'grilla' => true]],
            'FEC_REGISTRO' => ['Fecha de registro', 'fecha', ['solo_lectura' => true]],
            'FEC_VIABILIDAD' => ['Fecha de viabilidad', 'fecha', ['solo_lectura' => true]],
            'IMP_MONTO_VIABLE' => ['Monto viable', 'numero', ['grilla' => true, 'solo_lectura' => true]],
            'DES_FUNCION' => ['Función', 'texto', ['solo_lectura' => true]],
            'DES_PROGRAMA' => ['Programa', 'texto', ['solo_lectura' => true]],
            'DES_SUBPROGRAMA' => ['Subprograma', 'texto', ['solo_lectura' => true]],
            'DES_NIVEL' => ['Nivel', 'texto', ['solo_lectura' => true]],
            'DES_SECTOR' => ['Sector', 'texto', ['solo_lectura' => true]],
            'DES_PLIEGO' => ['Pliego', 'texto', ['solo_lectura' => true]],
            'DES_UNIDAD_EJECUTORA' => ['Unidad ejecutora', 'texto', ['solo_lectura' => true]],
            'DES_RESPONSABLE_VIABLE' => ['Responsable de viabilidad', 'texto', ['solo_lectura' => true]],
            'IMP_MONTO_F15' => ['Monto F15', 'numero', ['solo_lectura' => true]],
            'IMP_MONTO_F16' => ['Monto F16', 'numero', ['solo_lectura' => true]],
            'IMP_COSTO_ACTUALIZADO' => ['Costo actualizado', 'numero', ['solo_lectura' => true]],
            'NUM_BENEFICIARIOS' => ['Número de beneficiarios', 'numero', ['solo_lectura' => true]],
            'EST_INVIERTE' => ['Estado de Invierte', 'combo', ['tabla' => '60']],
            'EST_PIP' => ['Estado', 'combo', ['tabla' => '57', 'grilla' => true, 'oculto' => true]],
        ],
        'nuevo' => false, 'editar' => true, 'eliminar' => false,
    ],

    /*
    | Pantallas que dependen de otro registro ('de'): se abren en la ventana modal desde Contratos.
    | Contrato -> Etapas (PROY_COMPONENTE) -> Control anual (PROY_CONT_ETAPA_CONTROL) -> Control mensual
    | (PROY_CONT_COMP_CONTROL_DET); Etapas -> Recursos (PROY_COMP_RECURSO). El acceso se valida con
    | Proyectos ('acceso'). Los SP hacen el trabajo de fondo: el de etapas crea su plan y actividades y el
    | del control mensual recalcula los totales del control anual.
    */

    'PROY_COMPONENTE' => [
        'titulo' => 'Etapas del contrato', 'icono' => 'fa-layer-group', 'acceso' => 'PROYECTO',
        'tabla' => 'dbo.PROY_COMPONENTE', 'id' => 'IDE_PROY_COMPONENTE', 'sp' => 'dbo.SP_PROY_COMPONENTE',
        'estado' => 'IDE_ESTADO', 'eliminado' => '9',
        'de' => ['tabla' => 'dbo.PROYECTO_ACTIVIDAD', 'id' => 'IDE_PROYECTO_ACTIVIDAD', 'columna' => 'IDE_PROYECTO_ACTIVIDAD',
            'titulo' => "CONCAT(LTRIM(RTRIM(X.COD_PROYECTO)), ' · ', X.DES_PROYECTO)"],
        'parametros' => ['IDE_PROYECTO_ACTIVIDAD', 'IDE_CARTERA', 'IDE_COMPONENTE', 'NUM_SEC_COMPONENTE', 'IDE_MODO_EJECUCION', 'IDE_PROC_ITEM', 'IMP_COMPONENTE', 'IDE_ESTADO'],
        'campos' => [
            //SOLO LAS ETAPAS DE LA FASE - COMPONENTE (INTERVENCION) DEL CONTRATO
            'IDE_COMPONENTE' => ['Etapa del componente', 'combo', ['requerido' => true, 'grilla' => true,
                'lista' => ['dbo.GEN_COMPONENTE', 'IDE_COMPONENTE', 'DES_COMPONENTE', 'EST_COMPONENTE'],
                'filtro_sql' => ['IDE_COMPONENTE IN (SELECT IDE_COMPONENTE FROM dbo.GEN_INTERVENCION_COMP WHERE IDE_INTERVENCION = ?)', ['{de.IDE_INTERVENCION}']]]],
            'IDE_CARTERA' => ['Etapa contractual', 'combo', ['requerido' => true, 'grilla' => true, 'lista' => ['dbo.PROY_CARTERA', 'IDE_CARTERA', 'DES_CARTERA', 'EST_CARTERA']]],
            'IDE_MODO_EJECUCION' => ['Modo de ejecución', 'combo', ['requerido' => true, 'grilla' => true, 'lista' => ['dbo.GEN_MODO_EJECUCION', 'IDE_MODO_EJECUCION', 'DES_MODO_EJECUCION', 'EST_MODO_EJECUCION']]],
            'IDE_ESTADO' => ['Estado', 'combo', ['requerido' => true, 'grilla' => true, 'excluir' => ['9'], 'lista' => ['dbo.GEN_ESTADO', 'IDE_ESTADO', 'DES_ESTADO', 'EST_ESTADO']]],
            'FEC_INICIO' => ['Fecha inicio', 'fecha', ['grilla' => true, 'expresion' => '(SELECT TOP 1 P.FEC_INICIO FROM dbo.PROY_COMPONENTE_PLAN P WHERE P.IDE_PROY_COMPONENTE = T.IDE_PROY_COMPONENTE ORDER BY P.IDE_PLAN DESC)']],
            'FEC_TERMINO' => ['Fecha fin', 'fecha', ['grilla' => true, 'expresion' => '(SELECT TOP 1 P.FEC_TERMINO FROM dbo.PROY_COMPONENTE_PLAN P WHERE P.IDE_PROY_COMPONENTE = T.IDE_PROY_COMPONENTE ORDER BY P.IDE_PLAN DESC)']],
            'IMP_COMPONENTE' => ['Importe (S/)', 'numero', ['requerido' => true, 'grilla' => true]],
        ],
        'acciones' => [
            ['Control', 'fa-gauge-high', 'gr-azul', 'Control anual de la etapa', ['catalogo' => 'PROY_CONT_ETAPA_CONTROL']],
            ['Recurso', 'fa-briefcase', 'gr-violeta', 'Recursos de la etapa', ['catalogo' => 'PROY_COMP_RECURSO']],
        ],
        'nuevo' => true, 'editar' => true, 'eliminar' => true,
    ],

    'PROY_CONT_ETAPA_CONTROL' => [
        'titulo' => 'Control anual de la etapa', 'icono' => 'fa-gauge-high', 'acceso' => 'PROYECTO',
        'tabla' => 'dbo.PROY_CONT_ETAPA_CONTROL', 'id' => 'IDE_CONT_ETAPA_CONTROL', 'sp' => 'dbo.SP_PROY_CONT_ETAPA_CONTROL', 'estado' => 'EST_ETAPA_CONTROL',
        'de' => ['tabla' => 'dbo.PROY_COMPONENTE', 'id' => 'IDE_PROY_COMPONENTE', 'columna' => 'IDE_PROY_COMPONENTE',
            'titulo' => "CONCAT((SELECT G.DES_COMPONENTE FROM dbo.GEN_COMPONENTE G WHERE G.IDE_COMPONENTE = X.IDE_COMPONENTE), ' · ', (SELECT CONCAT(LTRIM(RTRIM(A.COD_PROYECTO)), ' - ', A.DES_PROYECTO) FROM dbo.PROYECTO_ACTIVIDAD A WHERE A.IDE_PROYECTO_ACTIVIDAD = X.IDE_PROYECTO_ACTIVIDAD))"],
        'parametros' => ['IDE_PROY_COMPONENTE', 'IDE_PLAN', 'NUM_ANIO', 'TIP_CONCEPTO', 'IMP_BRUTO', 'IMP_IMPONIBLE', 'PCT_IGV', 'IMP_IGV', 'IMP_NETO', 'IMP_PENALIDAD', 'IMP_PAGO', 'EST_ETAPA_CONTROL'],
        //LOS MONTOS SON LA SUMA DEL CONTROL MENSUAL (LOS RECALCULA SP_PROY_CONT_COMP_CONTROL_DET)
        'campos' => [
            'IDE_PLAN' => ['Plan', 'combo', ['requerido' => true, 'grilla' => true, 'lista' => ['dbo.GEN_PLAN', 'IDE_PLAN', 'DES_PLAN', 'EST_PLAN']]],
            'TIP_CONCEPTO' => ['Concepto', 'combo', ['requerido' => true, 'grilla' => true, 'tabla' => '66', 'solo' => [3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]]],
            'IMP_BRUTO' => ['Monto bruto', 'numero', ['grilla' => true, 'calculado' => true]],
            'IMP_NETO' => ['Monto neto facturado', 'numero', ['grilla' => true, 'calculado' => true]],
            'IMP_PAGO' => ['Monto a pagar', 'numero', ['grilla' => true, 'calculado' => true]],
            'EST_ETAPA_CONTROL' => ['Estado', 'combo', ['requerido' => true, 'grilla' => true, 'tabla' => '102', 'excluir' => ['2']]],
        ],
        'nuevo_valores' => ['PCT_IGV' => '0.18', 'EST_ETAPA_CONTROL' => '11', 'IMP_BRUTO' => '0', 'IMP_IMPONIBLE' => '0', 'IMP_IGV' => '0', 'IMP_NETO' => '0', 'IMP_PENALIDAD' => '0', 'IMP_PAGO' => '0'],
        //COMO SU SelGrd: POR EL NOMBRE DEL PLAN Y DEL CONCEPTO ("5. REPROG 04" DESPUES DE "5. REPROG 01")
        'orden' => [
            ['(SELECT P.DES_PLAN FROM dbo.GEN_PLAN P WHERE P.IDE_PLAN = T.IDE_PLAN)', 'asc'],
            ["(SELECT G.DES_ITEM FROM dbo.GEN_TABLAS G WHERE G.COD_TABLA = '66' AND G.COD_ITEM = T.TIP_CONCEPTO)", 'asc'],
        ],
        'acciones' => [
            ['Detalle', 'fa-calendar-days', 'gr-ambar', 'Control mensual', ['catalogo' => 'PROY_CONT_COMP_CONTROL_DET']],
        ],
        'nuevo' => true, 'editar' => true, 'eliminar' => true,
    ],

    'PROY_CONT_COMP_CONTROL_DET' => [
        'titulo' => 'Control mensual de la etapa', 'icono' => 'fa-calendar-days', 'acceso' => 'PROYECTO',
        'tabla' => 'dbo.PROY_CONT_COMP_CONTROL_DET', 'id' => 'IDE_CONT_ETAPA_CONTROL_DET', 'sp' => 'dbo.SP_PROY_CONT_COMP_CONTROL_DET', 'estado' => 'EST_ETAPA_CONTROL_DET',
        'de' => ['tabla' => 'dbo.PROY_CONT_ETAPA_CONTROL', 'id' => 'IDE_CONT_ETAPA_CONTROL', 'columna' => 'IDE_CONT_ETAPA_CONTROL',
            'titulo' => "CONCAT((SELECT P.DES_PLAN FROM dbo.GEN_PLAN P WHERE P.IDE_PLAN = X.IDE_PLAN), ' · ', (SELECT T.DES_ITEM FROM dbo.GEN_TABLAS T WHERE T.COD_TABLA = '66' AND T.COD_ITEM = X.TIP_CONCEPTO))"],
        'parametros' => ['IDE_CONT_ETAPA_CONTROL', 'NUM_ITEM', 'NUM_ANIO', 'NUM_MES', 'DES_CONCEPTO_PAGO', 'PCT_AVANCE', 'IMP_BRUTO', 'IMP_REAJUSTE',
            'IMP_AMORT_ADEL_DIR', 'IMP_AMORT_ADEL_MAT', 'IMP_AMORTIZACION', 'IMP_SALDO_SIN_IGV', 'IMP_DEDUC_ADEL_DIR', 'IMP_DEDUC_ADEL_MAT', 'IMP_IMPONIBLE',
            'PCT_IGV', 'IMP_IGV', 'IMP_NETO', 'IMP_PENALIDAD', 'IMP_RETENCION', 'IMP_PAGO', 'EST_ETAPA_CONTROL_DET', 'NUM_MES_PROVISION', 'NUM_ANIO_PROVISION'],
        'campos' => [
            'NUM_ANIO' => ['Año', 'combo', ['requerido' => true, 'grilla' => true, 'tabla' => '101', 'clave_numerica' => true]],
            'NUM_MES' => ['Mes', 'combo', ['requerido' => true, 'grilla' => true, 'tabla' => '18', 'clave_numerica' => true]],
            'NUM_ANIO_PROVISION' => ['Año provisión', 'combo', ['tabla' => '101', 'clave_numerica' => true]],
            'NUM_MES_PROVISION' => ['Mes provisión', 'combo', ['tabla' => '18', 'clave_numerica' => true]],
            'DES_CONCEPTO_PAGO' => ['Concepto de pago', 'area', ['requerido' => true, 'max' => 150, 'grilla' => true]],
            'PCT_AVANCE' => ['% de avance', 'numero', ['seccion' => 'Montos']],
            'IMP_BRUTO' => ['Monto bruto', 'numero', ['grilla' => true, 'seccion' => 'Montos']],
            'IMP_REAJUSTE' => ['Reajustes', 'numero', ['grilla' => true, 'seccion' => 'Montos']],
            'IMP_AMORT_ADEL_DIR' => ['Amort. adelanto directo', 'numero', ['grilla' => true, 'seccion' => 'Montos']],
            'IMP_AMORT_ADEL_MAT' => ['Amort. adelanto materiales', 'numero', ['grilla' => true, 'seccion' => 'Montos']],
            'IMP_AMORTIZACION' => ['Amortización', 'numero', ['seccion' => 'Montos']],
            'IMP_SALDO_SIN_IGV' => ['Saldo sin IGV', 'numero', ['grilla' => true, 'seccion' => 'Montos', 'auto' => true]],
            'IMP_DEDUC_ADEL_DIR' => ['Deduc. adelanto directo', 'numero', ['grilla' => true, 'seccion' => 'Montos']],
            'IMP_DEDUC_ADEL_MAT' => ['Deduc. adelanto materiales', 'numero', ['grilla' => true, 'seccion' => 'Montos']],
            'IMP_IMPONIBLE' => ['Monto imponible', 'numero', ['grilla' => true, 'seccion' => 'Montos', 'auto' => true]],
            'PCT_IGV' => ['% IGV', 'numero', ['oculto' => true]],
            'IMP_IGV' => ['IGV (18%)', 'numero', ['grilla' => true, 'seccion' => 'Montos', 'auto' => true]],
            'IMP_NETO' => ['Neto facturado', 'numero', ['grilla' => true, 'seccion' => 'Montos', 'auto' => true]],
            'IMP_PENALIDAD' => ['Penalidad', 'numero', ['grilla' => true, 'seccion' => 'Montos']],
            'IMP_RETENCION' => ['Retención', 'numero', ['grilla' => true, 'seccion' => 'Montos']],
            'IMP_PAGO' => ['Monto a pagar', 'numero', ['grilla' => true, 'seccion' => 'Montos', 'auto' => true]],
            'EST_ETAPA_CONTROL_DET' => ['Estado', 'combo', ['oculto' => true, 'tabla' => '99']],
        ],
        //EL % DE IGV Y EL PLAN (PARA LA FORMULA) SALEN DEL CONTROL ANUAL; EL AÑO INICIAL ES EL ACTUAL
        'nuevo_valores' => ['PCT_IGV' => '{de.PCT_IGV}', 'EST_ETAPA_CONTROL_DET' => '1', 'NUM_ANIO' => date('y'), 'PCT_AVANCE' => '0',
            'IMP_BRUTO' => '0', 'IMP_REAJUSTE' => '0', 'IMP_AMORT_ADEL_DIR' => '0', 'IMP_AMORT_ADEL_MAT' => '0', 'IMP_AMORTIZACION' => '0',
            'IMP_DEDUC_ADEL_DIR' => '0', 'IMP_DEDUC_ADEL_MAT' => '0', 'IMP_PENALIDAD' => '0', 'IMP_RETENCION' => '0'],
        'calculo' => App\Calculos\ControlMensual::class,
        'orden' => [['NUM_ANIO', 'asc'], ['NUM_MES', 'asc']],
        'acciones' => [
            ['Archivo', 'fa-paperclip', 'gr-teal', 'Archivos adjuntos', ['legado' => ['GEN_ARCHIVO', ['PIDE' => '{id}', 'Tabla' => 'PROY_CONT_COMP_CONTROL_DET']]]],
        ],
        'nuevo' => true, 'editar' => true, 'eliminar' => true,
    ],

    'PROY_COMP_RECURSO' => [
        'titulo' => 'Recursos de la etapa', 'icono' => 'fa-briefcase', 'acceso' => 'PROYECTO',
        'tabla' => 'dbo.PROY_COMP_RECURSO', 'id' => 'IDE_PROY_COMP_REC', 'sp' => 'dbo.SP_PROY_COMP_RECURSO', 'estado' => 'EST_PROY_COMP_REC',
        'de' => ['tabla' => 'dbo.PROY_COMPONENTE', 'id' => 'IDE_PROY_COMPONENTE', 'columna' => 'IDE_PROY_COMPONENTE',
            'titulo' => "CONCAT((SELECT G.DES_COMPONENTE FROM dbo.GEN_COMPONENTE G WHERE G.IDE_COMPONENTE = X.IDE_COMPONENTE), ' · ', (SELECT CONCAT(LTRIM(RTRIM(A.COD_PROYECTO)), ' - ', A.DES_PROYECTO) FROM dbo.PROYECTO_ACTIVIDAD A WHERE A.IDE_PROYECTO_ACTIVIDAD = X.IDE_PROYECTO_ACTIVIDAD))"],
        'parametros' => ['IDE_PROY_COMPONENTE', 'IDE_RECURSO', 'IDE_ROL', 'EST_PROY_COMP_REC'],
        'campos' => [
            'IDE_RECURSO' => ['Recurso', 'combo', ['requerido' => true, 'grilla' => true, 'lista' => ['dbo.GEN_RECURSO', 'IDE_RECURSO', 'DES_RECURSO', 'EST_RECURSO']]],
            'IDE_ROL' => ['Rol o función', 'combo', ['requerido' => true, 'grilla' => true, 'lista' => ['dbo.GEN_ROLES', 'IDE_ROL', 'DES_ROL', 'EST_ROL', ['IDE_FASE' => 18]]]],
            'EST_PROY_COMP_REC' => $estado,
        ],
        'nuevo' => true, 'editar' => true, 'eliminar' => true,
    ],

    'PROC_UNIDAD_MEDIDA' => [
        'titulo' => 'Unidades de medida', 'icono' => 'fa-ruler',
        'tabla' => 'dbo.PROC_UNIDAD_MEDIDA', 'id' => 'IDE_UNIDAD_MEDIDA', 'sp' => 'dbo.SP_PROC_UNIDAD_MEDIDA', 'estado' => 'EST_UNIDAD_MEDIDA',
        'parametros' => ['UNIDAD_MEDIDA', 'EST_UNIDAD_MEDIDA'],
        'campos' => [
            'UNIDAD_MEDIDA' => ['Unidad de medida', 'texto', ['requerido' => true, 'max' => 70, 'grilla' => true]],
            'EST_UNIDAD_MEDIDA' => $estado,
        ],
        'nuevo' => true, 'editar' => true, 'eliminar' => true,
    ],

    //13. ACTOS PREPARATORIOS: PROCESOS DE SELECCION (PROCESO) CON SUS ITEMS Y SU CRONOGRAMA
    'PROCESO' => [
        'titulo' => 'Actos preparatorios (procesos de selección)', 'icono' => 'fa-file-signature',
        'tabla' => 'dbo.PROCESO', 'id' => 'IDE_CONVOCATORIA', 'sp' => 'dbo.SP_PROCESO', 'estado' => 'EST_PROCESO',
        //LA CLAVE ES EL CODIGO DE LA CONVOCATORIA EN EL SEACE: LA ESCRIBE EL USUARIO Y EL SP LA RECIBE EN @pCodigo
        'codigo' => 'IDE_CONVOCATORIA',
        'parametros' => ['IDE_CONVOCATORIA', 'IDE_TIPO_PROC', 'IDE_PLAN', 'IDE_ENTIDAD_EJECUTORA', 'IDE_CENCOSTO', 'COD_PAC', 'DES_DEPTO_EJECUTORA', 'DES_PROV_EJECUTORA',
            'DES_DIST_EJECUTORA', 'NUM_ANO_EJE', 'NUM_PROC_ESPECIFICO', 'DES_OBJETO', 'TIP_OBJETO', 'IMP_VAL_REFERENCIAL', 'DES_URL_PROCESO', 'EST_PROCESO'],
        'campos' => [
            'IDE_CONVOCATORIA' => ['Código del proceso', 'texto', ['requerido' => true, 'max' => 9, 'digitos' => true, 'grilla' => true, 'buscar' => true, 'solo_lectura' => true, 'unico' => true]],
            'IDE_ENTIDAD_EJECUTORA' => ['Unidad ejecutora', 'combo', ['requerido' => true, 'grilla' => true, 'lista' => ['dbo.GEN_ENTIDAD', 'IDE_ENTIDAD', 'DES_ENTIDAD', 'EST_ENTIDAD']]],
            'DES_OBJETO' => ['Objeto de contratación', 'area', ['requerido' => true, 'max' => 500, 'grilla' => true]],
            'IMP_VAL_REFERENCIAL' => ['Valor referencial (S/)', 'numero', ['requerido' => true, 'grilla' => true]],
            'NUM_ITEMS' => ['Ítems', 'numero', ['grilla' => true, 'expresion' => "(SELECT COUNT(*) FROM dbo.PROC_ITEM I WHERE I.IDE_CONVOCATORIA = T.IDE_CONVOCATORIA AND I.EST_PROCESO_ITEM <> '2')"]],
            'IDE_TIPO_PROC' => ['Tipo de proceso', 'combo', ['requerido' => true, 'lista' => ['dbo.PROC_TIPO', 'IDE_TIPO_PROC', 'TIPO_PROC', 'EST_PROC_TIPO']]],
            'TIP_OBJETO' => ['Tipo de objeto', 'combo', ['requerido' => true, 'tabla' => '1']],
            'NUM_PROC_ESPECIFICO' => ['Nº de proceso', 'texto', ['requerido' => true, 'max' => 500]],
            'NUM_ANO_EJE' => ['Año de ejecución', 'texto', ['requerido' => true, 'max' => 4, 'digitos' => true]],
            'COD_PAC' => ['Código PAC', 'texto', ['requerido' => true, 'max' => 50]],
            'IDE_CENCOSTO' => ['Centro de costo', 'combo', ['lista' => ['dbo.GEN_CENTRO_COSTO', 'IDE_CENCOSTO', 'DES_CENCOSTO', 'EST_CENCOSTO']]],
            'DES_DEPTO_EJECUTORA' => ['Departamento', 'texto', ['requerido' => true, 'max' => 100, 'seccion' => 'Lugar de ejecución']],
            'DES_PROV_EJECUTORA' => ['Provincia', 'texto', ['requerido' => true, 'max' => 100, 'seccion' => 'Lugar de ejecución']],
            'DES_DIST_EJECUTORA' => ['Distrito', 'texto', ['requerido' => true, 'max' => 100, 'seccion' => 'Lugar de ejecución']],
            'EST_PROCESO' => $estado,
        ],
        //COMO SU SelGrd: POR UNIDAD EJECUTORA Y OBJETO
        'orden' => [['(SELECT E.DES_ENTIDAD FROM dbo.GEN_ENTIDAD E WHERE E.IDE_ENTIDAD = T.IDE_ENTIDAD_EJECUTORA)', 'asc'], ['DES_OBJETO', 'asc']],
        'acciones' => [
            ['OSCE', 'fa-landmark-flag', 'gr-violeta', 'Ficha del proceso en el SEACE (OSCE)', ['url' => 'https://prodapp2.seace.gob.pe/seacebus-uiwd-pub/fichaSeleccion/fichaSeleccion.xhtml?idSistema=3&ongei=1&idConvocatoria={id}']],
            ['Ítems', 'fa-list-check', 'gr-verde', 'Ítems del proceso', ['catalogo' => 'PROC_ITEM']],
            ['Cronograma', 'fa-calendar-days', 'gr-azul', 'Cronograma del proceso', ['catalogo' => 'PROC_CRONOGRAMA']],
        ],
        'nuevo' => true, 'editar' => true, 'eliminar' => true,
    ],

    'PROC_ITEM' => [
        'titulo' => 'Ítems del proceso', 'icono' => 'fa-list-check', 'acceso' => 'PROCESO',
        'tabla' => 'dbo.PROC_ITEM', 'id' => 'IDE_PROC_ITEM', 'sp' => 'dbo.SP_PROC_ITEM', 'estado' => 'EST_PROCESO_ITEM',
        'de' => ['tabla' => 'dbo.PROCESO', 'id' => 'IDE_CONVOCATORIA', 'columna' => 'IDE_CONVOCATORIA',
            'titulo' => "CONCAT(CAST(X.IDE_CONVOCATORIA AS varchar(12)), ' - ', X.DES_OBJETO)"],
        //AL REGISTRAR UN ITEM, EL SP CREA SU PROYECTO (SP_PROYECTO_ACTIVIDAD)
        'parametros' => ['IDE_CONVOCATORIA', 'COD_ITEM', 'COD_PROYECTO', 'DES_DEPTO_ITEM', 'DES_PROV_ITEM', 'DES_DIST_ITEM', 'DES_ITEM', 'CNT_PROPUESTAS',
            'FEC_PUBLICACION', 'FEC_BUENA_PRO_INICIAL', 'FEC_BUENA_PRO_FINAL', 'FEC_APELACION', 'FEC_ADJUDICACION', 'FEC_INICIO_CONTRATO', 'FEC_TERMINO_CONTRATO',
            'COD_CONTRATO', 'IMP_VAL_REFERENCIAL_ITEM', 'IMP_VAL_ADJUDICADO_ITEM', 'COD_RUC_POSTOR_GANADOR', 'DES_POSTOR_GANADOR', 'EST_PROCESO_ITEM',
            'DES_OBSERVACION', 'IDE_MODO_EJECUCION', 'IDE_UNIDAD_MEDIDA', 'CNT_ITEM'],
        'campos' => [
            'COD_ITEM' => ['Nº ítem', 'texto', ['requerido' => true, 'max' => 2, 'digitos' => true, 'grilla' => true]],
            'COD_PROYECTO' => ['Código del proyecto', 'texto', ['calculado' => true, 'grilla' => true]],
            'DES_ITEM' => ['Objeto de contratación', 'area', ['requerido' => true, 'max' => 500, 'grilla' => true]],
            'IMP_VAL_REFERENCIAL_ITEM' => ['Valor referencial (S/)', 'numero', ['requerido' => true, 'grilla' => true]],
            'IDE_MODO_EJECUCION' => ['Modo de ejecución', 'combo', ['requerido' => true, 'lista' => ['dbo.GEN_MODO_EJECUCION', 'IDE_MODO_EJECUCION', 'DES_MODO_EJECUCION', 'EST_MODO_EJECUCION']]],
            'IDE_UNIDAD_MEDIDA' => ['Unidad de medida', 'combo', ['requerido' => true, 'lista' => ['dbo.PROC_UNIDAD_MEDIDA', 'IDE_UNIDAD_MEDIDA', 'UNIDAD_MEDIDA', 'EST_UNIDAD_MEDIDA']]],
            'CNT_ITEM' => ['Cantidad', 'numero', ['requerido' => true]],
            'CNT_PROPUESTAS' => ['Nº de propuestas', 'numero', []],
            //EL ESTADO ES TEXTO ('2' ES ELIMINADO); CON CONTRATADO O EN EJECUCIÓN EL SP DEJA EL PROYECTO EN EJECUCION
            'EST_PROCESO_ITEM' => ['Estado', 'combo', ['requerido' => true, 'grilla' => true, 'valores' => ['EN PROCESO', 'ACTIVO', 'CONTRATADO', 'EN EJECUCIÓN', 'CANCELADO']]],
            'DES_DEPTO_ITEM' => ['Departamento', 'texto', ['requerido' => true, 'max' => 100, 'seccion' => 'Lugar de ejecución']],
            'DES_PROV_ITEM' => ['Provincia', 'texto', ['requerido' => true, 'max' => 100, 'seccion' => 'Lugar de ejecución']],
            'DES_DIST_ITEM' => ['Distrito', 'texto', ['requerido' => true, 'max' => 100, 'seccion' => 'Lugar de ejecución']],
            'FEC_PUBLICACION' => ['Publicación', 'fecha', ['grilla' => true, 'seccion' => 'Fechas']],
            'FEC_BUENA_PRO_INICIAL' => ['Buena pro inicial', 'fecha', ['grilla' => true, 'seccion' => 'Fechas']],
            'FEC_BUENA_PRO_FINAL' => ['Buena pro final', 'fecha', ['seccion' => 'Fechas']],
            'FEC_APELACION' => ['Apelación', 'fecha', ['seccion' => 'Fechas']],
            'FEC_ADJUDICACION' => ['Adjudicación', 'fecha', ['grilla' => true, 'seccion' => 'Fechas']],
            'FEC_INICIO_CONTRATO' => ['Inicio del contrato', 'fecha', ['seccion' => 'Fechas']],
            'FEC_TERMINO_CONTRATO' => ['Término del contrato', 'fecha', ['seccion' => 'Fechas']],
            'COD_CONTRATO' => ['Nº de contrato', 'texto', ['max' => 60, 'seccion' => 'Adjudicación']],
            'IMP_VAL_ADJUDICADO_ITEM' => ['Valor adjudicado (S/)', 'numero', ['seccion' => 'Adjudicación']],
            'COD_RUC_POSTOR_GANADOR' => ['RUC del postor ganador', 'texto', ['max' => 15, 'digitos' => true, 'seccion' => 'Adjudicación']],
            'DES_POSTOR_GANADOR' => ['Postor ganador', 'texto', ['max' => 150, 'seccion' => 'Adjudicación']],
            'DES_OBSERVACION' => ['Observación', 'area', ['max' => 500, 'seccion' => 'Adjudicación']],
        ],
        'nuevo_valores' => ['EST_PROCESO_ITEM' => 'EN PROCESO'],
        'orden' => [['COD_ITEM', 'asc']],
        'acciones' => [
            ['Postores', 'fa-user-tie', 'gr-verde', 'Postores del ítem', ['legado' => ['PROC_POSTORES', ['PIDE_PROC_ITEM' => '{id}']]]],
        ],
        'nuevo' => true, 'editar' => true, 'eliminar' => true,
    ],

    'PROC_CRONOGRAMA' => [
        'titulo' => 'Cronograma del proceso', 'icono' => 'fa-calendar-days', 'acceso' => 'PROCESO',
        'tabla' => 'dbo.PROC_CRONOGRAMA', 'id' => 'IDE_CRONOGRAMA', 'sp' => 'dbo.SP_PROC_CRONOGRAMA', 'estado' => 'EST_PROC_CRONOGRAMA',
        'de' => ['tabla' => 'dbo.PROCESO', 'id' => 'IDE_CONVOCATORIA', 'columna' => 'IDE_CONVOCATORIA',
            'titulo' => "CONCAT(CAST(X.IDE_CONVOCATORIA AS varchar(12)), ' - ', X.DES_OBJETO)"],
        'parametros' => ['IDE_CONVOCATORIA', 'NUM_CONVOCATORIA', 'IDE_ORDEN', 'FEC_PUBLICACION', 'DES_ACTIVIDAD', 'FEC_INICIO', 'FEC_TERMINO', 'EST_PROC_CRONOGRAMA'],
        'campos' => [
            'IDE_ORDEN' => ['Nº de orden', 'numero', ['requerido' => true, 'grilla' => true]],
            'DES_ACTIVIDAD' => ['Actividad', 'texto', ['requerido' => true, 'max' => 40, 'grilla' => true]],
            'FEC_PUBLICACION' => ['Publicación', 'fecha', ['requerido' => true, 'grilla' => true]],
            'FEC_INICIO' => ['Inicio', 'fecha', ['requerido' => true, 'grilla' => true]],
            'FEC_TERMINO' => ['Finalización', 'fecha', ['requerido' => true, 'grilla' => true]],
            'EST_PROC_CRONOGRAMA' => $estado,
        ],
        'orden' => [['IDE_ORDEN', 'asc']],
        'nuevo' => true, 'editar' => true, 'eliminar' => true,
    ],


    //PANTALLAS DEL CONTRATO (PROYECTO_ACTIVIDAD) Y DEL PROYECTO QUE SE ABREN DESDE SUS GRILLAS
    'CONTRATO' => [
        'titulo' => 'Detalle del contrato', 'icono' => 'fa-file-lines', 'acceso' => 'PROYECTO',
        'tabla' => 'dbo.CONTRATO', 'id' => 'IDE_CONTRATO', 'sp' => 'dbo.SP_CONTRATO', 'estado' => 'EST_CONTRATO',
        //EL CONTRATO SE ENLAZA AL PROYECTO_ACTIVIDAD EN PROY_CONTRATO (LO CREA SP_PROYECTO_ACTIVIDAD)
        'de' => ['tabla' => 'dbo.PROYECTO_ACTIVIDAD', 'id' => 'IDE_PROYECTO_ACTIVIDAD',
            'enlace' => '{T}.IDE_CONTRATO IN (SELECT PC.IDE_CONTRATO FROM dbo.PROY_CONTRATO PC WHERE PC.IDE_PROYECTO_ACTIVIDAD = ?)',
            'titulo' => "CONCAT(LTRIM(RTRIM(X.COD_PROYECTO)), ' · ', X.DES_PROYECTO)"],
        'parametros' => ['IDE_PROVEEDOR', 'IDE_ADM_CONTRATO', 'COD_CONTRATO', 'COD_CONTRATO_ENTIDAD', 'COD_CONTRATO_SUP', 'DES_CONTRATO', 'TIP_CONTRATO', 'FEC_CONTRATO',
            'FEC_INICIO_CONTRATO', 'FEC_TERMINO_CONTRATO', 'FEC_CIERRE_CONTRATO', 'IMP_IMPONIBLE', 'IMP_IMPUESTOS', 'IMP_TOTAL', 'IMG_CONTRATO', 'DES_COMENTARIO', 'EST_CONTRATO'],
        'campos' => [
            'COD_UNICO_ORDEN' => ['Cód. orden', 'texto', ['calculado' => true, 'grilla' => true]],
            'COD_CONTRATO_ENTIDAD' => ['Documento interno', 'texto', ['max' => 40, 'grilla' => true]],
            'DES_CONTRATO' => ['Definición', 'area', ['max' => 1000, 'grilla' => true]],
            'IDE_PROVEEDOR' => ['Proveedor', 'combo', ['requerido' => true, 'grilla' => true, 'lista' => ['dbo.GEN_PROVEEDOR', 'IDE_PROVEEDOR', 'DES_PROVEEDOR', 'EST_PROVEEDOR']]],
            //LAS FECHAS NO SE EDITAN AQUI (EL SISTEMA ACTUAL LAS OCULTA EN EL FORMULARIO)
            'FEC_INICIO_CONTRATO' => ['Inicio', 'fecha', ['oculto' => true, 'grilla' => true]],
            'FEC_TERMINO_CONTRATO' => ['Término', 'fecha', ['oculto' => true, 'grilla' => true]],
            'FEC_CIERRE_CONTRATO' => ['Cierre', 'fecha', ['oculto' => true, 'grilla' => true]],
            'IMP_TOTAL' => ['Monto total (S/)', 'numero', ['grilla' => true]],
            'COD_CONTRATO' => ['Número de contrato', 'texto', ['max' => 20]],
            'TIP_CONTRATO' => ['Tipo', 'combo', ['tabla' => '64']],
            'IMP_IMPONIBLE' => ['Monto imponible (S/)', 'numero', []],
            'IMP_IMPUESTOS' => ['Monto impuesto (S/)', 'numero', []],
            'EST_CONTRATO' => ['Estado', 'combo', ['requerido' => true, 'grilla' => true, 'tabla' => '84']],
        ],
        'acciones' => [
            ['Carta fianza', 'fa-money-check-dollar', 'gr-verde', 'Carta fianza y conceptos del contrato', ['legado' => ['CONTRATO_CONCEPTO', ['PIDE' => '{id}']]]],
            ['Gastos', 'fa-sack-dollar', 'gr-verde', 'Gasto consolidado del contrato', ['legado' => ['BIDM_GASTO_CONSOLIDA', ['PIDE' => '{id}']]]],
            ['Archivo', 'fa-paperclip', 'gr-teal', 'Archivos adjuntos del contrato', ['legado' => ['GEN_ARCHIVO', ['PIDE' => '{id}', 'Tabla' => 'CONTRATO']]]],
        ],
        //EL CONTRATO SE REGISTRA DESDE LA GRILLA DE CONTRATOS DEL PROYECTO
        'nuevo' => false, 'editar' => true, 'eliminar' => true,
    ],

    'PROY_RIESGO_PROBLEMA' => [
        'titulo' => 'Riesgos del contrato', 'icono' => 'fa-triangle-exclamation', 'acceso' => 'PROYECTO',
        'tabla' => 'dbo.PROY_RIESGO_PROBLEMA', 'id' => 'IDE_RIESGO_PROB', 'sp' => 'dbo.SP_PROY_RIESGO_PROBLEMA', 'estado' => 'EST_RIESGO',
        'de' => ['tabla' => 'dbo.PROYECTO_ACTIVIDAD', 'id' => 'IDE_PROYECTO_ACTIVIDAD', 'columna' => 'IDE_PROYECTO_ACTIVIDAD',
            'titulo' => "CONCAT(LTRIM(RTRIM(X.COD_PROYECTO)), ' · ', X.DES_PROYECTO)"],
        'parametros' => ['IDE_PROYECTO_ACTIVIDAD', 'IDE_PROC_ITEM', 'IDE_TIPO_RIESGO_PROB', 'TIP_RIESGO_PROB', 'DES_NOMBRE', 'DES_DETALLE', 'IDE_IMPACTO', 'IDE_PROBABILIDAD',
            'IDE_PRIORIDAD', 'DES_CAUSA_PROBLEMA', 'DES_CONSECUENCIA_RIESGO', 'DES_SOLUCION', 'FEC_INICIO_SOLUCION', 'FEC_TERMINO_SOLUCION', 'EST_RIESGO'],
        'campos' => [
            'IDE_TIPO_RIESGO_PROB' => ['Tipo de riesgo', 'combo', ['requerido' => true, 'grilla' => true, 'lista' => ['dbo.GEN_TIPO_RIESGO', 'IDE_TIPO_RIESGO', 'DES_TIPO_RIESGO', 'EST_TIPO_RIESGO']]],
            'TIP_RIESGO_PROB' => ['Tipo de estrategia', 'combo', ['requerido' => true, 'grilla' => true, 'tabla' => '85']],
            'DES_NOMBRE' => ['Código del riesgo', 'texto', ['requerido' => true, 'max' => 200, 'grilla' => true]],
            'DES_DETALLE' => ['Descripción del riesgo', 'area', ['requerido' => true, 'max' => 1000, 'grilla' => true]],
            'DES_CAUSA_PROBLEMA' => ['Causa generadora', 'area', ['max' => 1000]],
            'IDE_PROBABILIDAD' => ['Probabilidad de ocurrencia', 'combo', ['requerido' => true, 'seccion' => 'Evaluación', 'lista' => ['dbo.GEN_PROBABILIDAD_RIESGO', 'IDE_PROBABILIDAD', 'DES_PROBABILIDAD', 'EST_PROBABILIDAD']]],
            'IDE_IMPACTO' => ['Impacto', 'combo', ['requerido' => true, 'seccion' => 'Evaluación', 'lista' => ['dbo.GEN_IMPACTO_RIESGO', 'IDE_IMPACTO', 'DES_IMPACTO', 'EST_IMPACTO']]],
            //PROBABILIDAD X IMPACTO (App\Calculos\PrioridadRiesgo)
            'IDE_PRIORIDAD' => ['Prioridad', 'combo', ['requerido' => true, 'auto' => true, 'grilla' => true, 'seccion' => 'Evaluación', 'lista' => ['dbo.GEN_PRIORIDAD_RIESGO', 'IDE_PRIORIDAD', 'DES_PRIORIDAD', 'EST_PRIORIDAD'], 'excluir' => [11]]],
            'DES_CONSECUENCIA_RIESGO' => ['Disparador del riesgo', 'area', ['max' => 1000, 'seccion' => 'Respuesta']],
            'DES_SOLUCION' => ['Acción para dar respuesta al riesgo', 'area', ['max' => 1000, 'seccion' => 'Respuesta']],
            'FEC_INICIO_SOLUCION' => ['Inicio de la acción', 'fecha', ['requerido' => true, 'seccion' => 'Respuesta']],
            'FEC_TERMINO_SOLUCION' => ['Término de la acción', 'fecha', ['seccion' => 'Respuesta']],
            'EST_RIESGO' => ['Estado', 'combo', ['requerido' => true, 'grilla' => true, 'tabla' => '4', 'seccion' => 'Respuesta']],
        ],
        'calculo' => App\Calculos\PrioridadRiesgo::class,
        'calculo_texto' => 'Calcular la prioridad automáticamente',
        'orden' => [['IDE_RIESGO_PROB', 'desc']],
        'acciones' => [
            ['Recurso', 'fa-briefcase', 'gr-azul', 'Recursos del riesgo', ['legado' => ['PROY_RIESGO_RECURSO', ['PIDE_RIESGO_PROB' => '{id}', 'PIDE_PROYECTO_ACTIVIDAD' => '{de}']]]],
        ],
        'nuevo' => true, 'editar' => true, 'eliminar' => true,
    ],

    'CONT_INTERESADOS' => [
        'titulo' => 'Interesados del contrato', 'icono' => 'fa-users', 'acceso' => 'PROYECTO',
        //IDE_CONTRATO GUARDA EL IDE_PROYECTO_ACTIVIDAD (ASI LO GRABA EL SISTEMA ACTUAL)
        'tabla' => 'dbo.CONT_INTERESADOS', 'id' => 'IDE_CONT_INTERESADO', 'sp' => 'dbo.SP_CONT_INTERESADOS', 'estado' => 'EST_CONT_INTERESADO',
        'de' => ['tabla' => 'dbo.PROYECTO_ACTIVIDAD', 'id' => 'IDE_PROYECTO_ACTIVIDAD', 'columna' => 'IDE_CONTRATO',
            'titulo' => "CONCAT(LTRIM(RTRIM(X.COD_PROYECTO)), ' · ', X.DES_PROYECTO)"],
        'parametros' => ['IDE_CONTRATO', 'IDE_RECURSO', 'IDE_ROL', 'IDE_PUESTO', 'DES_LOCALIZACION', 'DES_MAIL', 'DES_TELEFONO', 'DES_REQUERIMIENTOS_PRIMORDIALES',
            'DES_EXPECTATIVAS_PRINCIPALES', 'TIP_INFLUENCIA_POTENCIAL', 'DES_FASE_MAYOR_INTERES', 'TIP_INTERNO_EXTERNO', 'TIP_CLASIFICACION', 'DES_INTERES_PROYECTO',
            'TIP_EVALUACION_IMPACTO', 'DES_ESTRATEGIA_PRINCIPAL', 'DES_OBSERVACION', 'EST_CONT_INTERESADO'],
        'campos' => [
            'IDE_RECURSO' => ['Personal', 'combo', ['requerido' => true, 'grilla' => true, 'lista' => ['dbo.GEN_RECURSO', 'IDE_RECURSO', 'DES_RECURSO', 'EST_RECURSO']]],
            'IDE_ROL' => ['Rol', 'combo', ['grilla' => true, 'lista' => ['dbo.GEN_ROLES', 'IDE_ROL', 'DES_ROL', 'EST_ROL']]],
            'IDE_PUESTO' => ['Cargo', 'combo', ['grilla' => true, 'lista' => ['dbo.GEN_CARGO', 'IDE_CARGO', 'DES_CARGO', 'EST_CARGO']]],
            'DES_LOCALIZACION' => ['Organización / institución', 'texto', ['requerido' => true, 'max' => 100, 'grilla' => true]],
            'DES_MAIL' => ['Correo', 'texto', ['max' => 100]],
            'DES_TELEFONO' => ['Teléfono', 'texto', ['max' => 50, 'grilla' => true]],
            'TIP_INTERNO_EXTERNO' => ['Pertenencia institucional', 'combo', ['requerido' => true, 'tabla' => '70']],
            'DES_OBSERVACION' => ['Dirección', 'area', ['max' => 1000]],
            'DES_REQUERIMIENTOS_PRIMORDIALES' => ['Requerimientos', 'area', ['requerido' => true, 'max' => 1000, 'grilla' => true, 'seccion' => 'Interés en el proyecto']],
            'DES_EXPECTATIVAS_PRINCIPALES' => ['Expectativas', 'area', ['requerido' => true, 'max' => 1000, 'grilla' => true, 'seccion' => 'Interés en el proyecto']],
            'DES_ESTRATEGIA_PRINCIPAL' => ['Acción', 'area', ['max' => 1000, 'seccion' => 'Interés en el proyecto']],
            'DES_INTERES_PROYECTO' => ['Interés del proyecto', 'area', ['max' => 1000, 'seccion' => 'Interés en el proyecto']],
            'DES_FASE_MAYOR_INTERES' => ['Fase de mayor interés', 'area', ['max' => 1000, 'seccion' => 'Interés en el proyecto']],
            'TIP_CLASIFICACION' => ['Tipo de interesado', 'combo', ['requerido' => true, 'grilla' => true, 'tabla' => '71', 'seccion' => 'Clasificación']],
            'TIP_INFLUENCIA_POTENCIAL' => ['Tipo de influencia', 'combo', ['tabla' => '69', 'seccion' => 'Clasificación']],
            'TIP_EVALUACION_IMPACTO' => ['Impacto de su evaluación', 'combo', ['tabla' => '72', 'seccion' => 'Clasificación']],
            'EST_CONT_INTERESADO' => ['Estado', 'combo', ['requerido' => true, 'tabla' => '99', 'grilla' => true, 'seccion' => 'Clasificación']],
        ],
        'nuevo' => true, 'editar' => true, 'eliminar' => true,
    ],

    'CONT_DOCUMENTACION' => [
        'titulo' => 'Documentos del contrato', 'icono' => 'fa-folder-open', 'acceso' => 'PROYECTO',
        //IDE_CONTRATO GUARDA EL IDE_PROYECTO_ACTIVIDAD (ASI LO GRABA EL SISTEMA ACTUAL)
        'tabla' => 'dbo.CONT_DOCUMENTACION', 'id' => 'IDE_CONT_DOCUM', 'sp' => 'dbo.SP_CONT_DOCUMENTACION', 'estado' => 'EST_DOCUMENTO',
        'de' => ['tabla' => 'dbo.PROYECTO_ACTIVIDAD', 'id' => 'IDE_PROYECTO_ACTIVIDAD', 'columna' => 'IDE_CONTRATO',
            'titulo' => "CONCAT(LTRIM(RTRIM(X.COD_PROYECTO)), ' · ', X.DES_PROYECTO)"],
        'parametros' => ['IDE_CONTRATO', 'IDE_CONOC_PROC', 'FEC_DOCUMENTO', 'DES_DOCUMENTO', 'EST_DOCUMENTO'],
        'campos' => [
            'IDE_CONOC_PROC' => ['Conocimiento del proceso (PMI)', 'combo', ['requerido' => true, 'grilla' => true, 'lista' => ['dbo.GEN_MATRIZ_CONOCIMIENTO_PROCESO', 'IDE_CONOC_PROC', 'DES_CRUCE_CONOC_PROC', 'EST_CONOC_PROC']]],
            'FEC_DOCUMENTO' => ['Fecha de registro', 'fecha', ['grilla' => true]],
            'DES_DOCUMENTO' => ['Ruta del contenido (SharePoint)', 'area', ['requerido' => true, 'max' => 500, 'grilla' => true]],
            'EST_DOCUMENTO' => $estado,
        ],
        'acciones' => [
            ['Contenido', 'fa-paperclip', 'gr-teal', 'Ver el contenido', ['campo' => 'DES_DOCUMENTO']],
        ],
        'nuevo' => true, 'editar' => true, 'eliminar' => true,
    ],

    'PROY_LECCION_APRENDIDA' => [
        'titulo' => 'Lecciones aprendidas', 'icono' => 'fa-lightbulb', 'acceso' => 'PROYECTO',
        'tabla' => 'dbo.PROY_LECCION_APRENDIDA', 'id' => 'IDE_LECCION_APRENDIDA', 'sp' => 'dbo.SP_PROY_LECCION_APRENDIDA', 'estado' => 'EST_LECCION',
        'de' => ['tabla' => 'dbo.PROYECTO', 'id' => 'IDE_PROYECTO', 'columna' => 'IDE_PROYECTO',
            'titulo' => "CONCAT(LTRIM(RTRIM(X.COD_UNICO)), ' · ', X.DES_LARGA_PROYECTO)"],
        'parametros' => ['IDE_PROYECTO', 'IDE_FASE_COMPONENTE', 'COD_LECCION_APRENDIDA', 'TIP_LECCION', 'IDE_TIPO_RIESGO', 'DES_LECCION_APRENDIDA', 'DES_RIESGO',
            'TIP_IMPACTO_SITUACION', 'DES_RECOMENDACION', 'DES_ACCION_PROPUESTA', 'FEC_LECCION', 'EST_LECCION'],
        'campos' => [
            'IDE_FASE_COMPONENTE' => ['Fase - componente', 'combo', ['requerido' => true, 'grilla' => true, 'lista' => ['dbo.GEN_INTERVENCION', 'IDE_INTERVENCION', 'DES_INTERVENCION', 'EST_INTERVENCION', ['NUM_NIVEL' => 3, 'IDE_SECTOR' => 14]]]],
            'COD_LECCION_APRENDIDA' => ['Código de lección', 'texto', ['max' => 20, 'grilla' => true]],
            'TIP_LECCION' => ['Tipo de lección', 'combo', ['requerido' => true, 'grilla' => true, 'tabla' => '80']],
            'IDE_TIPO_RIESGO' => ['Tipo de riesgo', 'combo', ['grilla' => true, 'lista' => ['dbo.GEN_TIPO_RIESGO', 'IDE_TIPO_RIESGO', 'DES_TIPO_RIESGO', 'EST_TIPO_RIESGO']]],
            'FEC_LECCION' => ['Fecha de la lección', 'fecha', ['requerido' => true]],
            'DES_RIESGO' => ['Descripción de riesgos', 'area', ['max' => 2000]],
            'DES_LECCION_APRENDIDA' => ['Causa', 'area', ['requerido' => true, 'max' => 2000, 'grilla' => true]],
            'TIP_IMPACTO_SITUACION' => ['Tipo de impacto', 'combo', ['requerido' => true, 'tabla' => '81']],
            'DES_RECOMENDACION' => ['Efecto', 'area', ['max' => 2000]],
            'DES_ACCION_PROPUESTA' => ['Respuesta sugerida o realizada', 'area', ['max' => 2000]],
            'EST_LECCION' => $estado,
        ],
        'nuevo' => true, 'editar' => true, 'eliminar' => true,
    ],


];

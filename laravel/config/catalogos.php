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

];

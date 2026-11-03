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

<?php

define('VERIFICA_CATALOGO_SELECCIONADO',
        "SELECT IdCatalogo,CatGrupo,CatSubGrupo,CatDescripcion
            FROM general.tgcatalogo
            WHERE CatEstado = 1 and IdCatalogo = %d
            ORDER BY CatDescripcion
"
);

define('VERIFICA_CATALOGO_NOMBRE',
        "SELECT IdCatalogo,CatGrupo,CatSubGrupo,CatDescripcion
            FROM general.tgcatalogo
            WHERE CatEstado = 1 and CatDescripcion = '%s' and CatSubGrupo = 0 and CatTipo = 0
            ORDER BY CatDescripcion
"
);

define('VERIFICA_CATALOGO_NOMBRE_GRUPO',
        "SELECT IdCatalogo,CatGrupo,CatSubGrupo,CatDescripcion
            FROM general.tgcatalogo
            WHERE CatEstado = 1 and CatGrupo = %d and CatDescripcion = '%s' and CatTipo = 0
            ORDER BY CatDescripcion
"
);

define('VERIFICA_CATALOGO_NOMBRE_SUBGRUPO',
        "SELECT IdCatalogo,CatGrupo,CatSubGrupo,CatDescripcion
            FROM general.tgcatalogo
            WHERE CatEstado = 1 and CatGrupo = %d and CatSubGrupo = %d and CatDescripcion = '%s' and CatTipo <> 0
            ORDER BY CatDescripcion
"
);

define('LISTA_CATALOGO_GRUPO_SUBGRUPO',
        "SELECT IdCatalogo,CatGrupo,CatSubGrupo,CatDescripcion
            FROM general.tgcatalogo
            WHERE CatEstado = 1 and CatGrupo = %d and CatSubGrupo = %d and CatTipo <> 0
            ORDER BY CatDescripcion
"
);

?>
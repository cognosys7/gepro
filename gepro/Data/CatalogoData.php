<?php
define('VERIFICA_CATALOGO_SELECCIONADO',
        "EXEC general.paVerificaDatosCatalogoxId @pIdCatalogo = %d"
);

define('VERIFICA_CATALOGO_NOMBRE',
        "EXEC general.paVerificaCatalogoGrupoSubgrupoDesc2 @pIdCatalogo = 0, @pCatDescripcion = '%s', @pCatGrupo = 0, @pCatSubGrupo = 0, @CatTipo = 0, @pTipo = 1"
);

define('VERIFICA_CATALOGO_NOMBRE_GRUPO',
        "EXEC general.paVerificaCatalogoGrupoSubgrupoDesc2 @pIdCatalogo = 0, @pCatDescripcion = '%s', @pCatGrupo = %d, @pCatSubGrupo = 0, @CatTipo = 0, @pTipo = 2"
);

define('LISTA_CATALOGO_GRUPO_SUBGRUPO_SCRIPT',
        "EXEC general.paListaCatalogoGrupoSubGrupoScript @pCatGrupo = ?, @pCatSubGrupo = ?, @pCatTipo = 0, @pScript = ?"
    );

define('VERIFICA_CATALOGO_NOMBRE_SUBGRUPO',
        "EXEC general.paVerificaCatalogoGrupoSubgrupoDesc2 @pIdCatalogo = 0, @pCatDescripcion = '%s', @pCatGrupo = %d, @pCatSubGrupo = %d, @CatTipo = 0, @pTipo = 3"
);

?>
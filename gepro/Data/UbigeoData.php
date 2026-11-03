<?php
define('LISTA_DEPARTAMENTO',
        "EXEC general.paListaDepartamentos"
);

define('LISTA_PROVINCIA',
        "EXEC general.paListaProvincias @pIdUbigeo = ?"
);

define('LISTA_DISTRITO',
        "EXEC general.paListaDistrito @pIdUbigeo = ?"
);

define('UBIGEO_SELECCIONADO',
        "EXEC general.paVerificaUbigeo @pIdUbigeo = ?, @pTipo = ?"
);
?>

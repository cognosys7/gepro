<?php
define('LISTA_NOTICIAS_TOP',
        "EXEC Intranet.paVerificaNoticias @pTop = ?"
);

define('LISTA_NOTICIA_IMAGENES',
        "EXEC Intranet.paListaNoticiasImagenes @pIdNoticia = ?"
);

define('VERIFICA_NOTICIA_XID',
        "EXEC Intranet.paVerificaNoticiasxId @pIdNoticia = ?"
);

define('VERIFICA_COMUNICADO_PRINCIPAL',
        "EXEC Intranet.paVerificaComunicadoPrincipal"
);

define('LISTA_COMUNICADO_TOP',
        "EXEC Intranet.paVerificaComunicados @pTop = ?"
);

define('VERIFICA_ENLACE',
        "EXEC Intranet.paVerificaEnlace"
);
?>
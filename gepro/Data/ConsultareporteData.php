<?php
/*
 * ALNIX DIC 2015
 */
define('SELECT_REPORTE_01',
"EXEC papeleta.paListarReporteGenerico
        @Año=?, @Mes=?, @IdMotivo=?, @IdOficina=?, @IdEstado=?, @IdSituacion=?,@NombreEmpleado=?, @ApellidoEmpleado=?, @RangoFecha=?"
);
/*
 * ALNIX DIC 2015
 */
define('SELECT_PAPELETA_ANIO',
"EXEC general.paListarAño"
);
/*
 * ALNIX DIC 2015
 */
define('SELECT_PAPELETA_MES',
"EXEC general.paListarMes"
);

define('SELECT_PAPELETA_MOTIVO',
"EXEC papeleta.paListarMotivo"
);

define('SELECT_PAPELETA_OFICINA',
"EXEC general.paListaUnidadOrganica"
);

define('SELECT_PAPELETA_SITUACION',
"EXEC papeleta.paListarSituacion"
);

define('SELECT_PAPELETA_ESTADO',
"EXEC papeleta.paListarEstado"
);
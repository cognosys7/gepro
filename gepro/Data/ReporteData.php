<?php

define('SELECT_REPORTE_FAMILIA',
"EXEC dbo.paListarReporteFamilias
      @FAMILIA=?, @IDE_UBIGEO=?"
);

define('SELECT_DEPARTAMENTO',
"EXEC dbo.paListarDepartamento"
);

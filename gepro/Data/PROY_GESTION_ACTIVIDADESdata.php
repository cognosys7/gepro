<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : PROY_GESTION_ACTIVIDADESDATA de la tabla PROY_GESTION_ACTIVIDADES
  //  Fecha           : domingo, 26 de mayo de 2019 6:23:54
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-G
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_PROY_GESTION_ACTIVIDADES', "EXEC dbo.SP_PROY_GESTION_ACTIVIDADES
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROY_GESTION_ACTIVIDADES', "EXEC dbo.SP_PROY_GESTION_ACTIVIDADES
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROY_GESTION_ACTIVIDADES', "EXEC dbo.SP_PROY_GESTION_ACTIVIDADES
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PROY_GESTION_ACTIVIDADES', "EXEC dbo.SP_PROY_GESTION_ACTIVIDADES
     @TipoAccion= 'SelGrd'
    ,@rp = ?
    ,@sortname = ?
    ,@sortorder = ?
    ,@page = ?
    ,@filtro = ?
    ,@codigoMensaje = ?
    ,@Mensaje = ?
    ,@nTotal = ?
"
);


//Seleccionar Datos para Grilla Busqueda
define('SelGrd_PROY_GESTION_ACTIVIDADES_busqueda', "EXEC dbo.SP_PROY_GESTION_ACTIVIDADES
     @TipoAccion= 'SelGrd_busqueda'
    ,@rp = ?
    ,@sortname = ?
    ,@sortorder = ?
    ,@page = ?
    ,@filtro = ?
    ,@codigoMensaje = ?
    ,@Mensaje = ?
    ,@nTotal = ?
"
);




//MANTENIMIENTO
define('Insert_PROY_GESTION_ACTIVIDADES', "EXEC dbo.SP_PROY_GESTION_ACTIVIDADES
     @TipoAccion = 'Insert'
		,@IDE_GESTION_SOCIAL = ?
		,@TIP_ACTIVIDAD = ?
		,@DES_ACTIV_PROGRAMADA = ?
		,@FEC_ACTIV_PROGRAMADA = ?
		,@DES_ACTIV_REALIZADA = ?
		,@FEC_ACTIV_REALIZADA = ?
		,@EST_ACTIVIDAD = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROY_GESTION_ACTIVIDADES', "EXEC dbo.SP_PROY_GESTION_ACTIVIDADES
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_GESTION_SOCIAL = ?
		,@TIP_ACTIVIDAD = ?
		,@DES_ACTIV_PROGRAMADA = ?
		,@FEC_ACTIV_PROGRAMADA = ?
		,@DES_ACTIV_REALIZADA = ?
		,@FEC_ACTIV_REALIZADA = ?
		,@EST_ACTIVIDAD = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_PROY_GESTION_ACTIVIDADES', "EXEC dbo.SP_PROY_GESTION_ACTIVIDADES
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

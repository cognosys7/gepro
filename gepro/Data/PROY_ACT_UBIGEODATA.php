
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROY_ACT_UBIGEODATA de la tabla PROY_ACT_UBIGEO
  //  Fecha           : lunes, 20 de noviembre de 2017 04:02:18 p.m.
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_PROY_ACT_UBIGEO', "EXEC dbo.SP_PROY_ACT_UBIGEO
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROY_ACT_UBIGEO', "EXEC dbo.SP_PROY_ACT_UBIGEO
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROY_ACT_UBIGEO', "EXEC dbo.SP_PROY_ACT_UBIGEO
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PROY_ACT_UBIGEO', "EXEC dbo.SP_PROY_ACT_UBIGEO
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



//MANTENIMIENTO
define('Insert_PROY_ACT_UBIGEO', "EXEC dbo.SP_PROY_ACT_UBIGEO
     @TipoAccion = 'Insert'
		,@IDE_PROYECTO_ACTIVIDAD = ?
		,@COD_UBIGEO = ?
		,@GEO_LONGITUD_UBICACION = ?
		,@GEO_LATITUD_UBICACION = ?
		,@EST_PROY_ACT_UBIGEO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROY_ACT_UBIGEO', "EXEC dbo.SP_PROY_ACT_UBIGEO
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_PROYECTO_ACTIVIDAD = ?
		,@COD_UBIGEO = ?
		,@GEO_LONGITUD_UBICACION = ?
		,@GEO_LATITUD_UBICACION = ?
		,@EST_PROY_ACT_UBIGEO = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_PROY_ACT_UBIGEO', "EXEC dbo.SP_PROY_ACT_UBIGEO
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

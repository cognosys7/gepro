<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : CONT_CAL_CONTENIDODATA de la tabla CONT_CAL_CONTENIDO
  //  Fecha           : miércoles, 5 de junio de 2019 4:08:03
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-J
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_CONT_CAL_CONTENIDO', "EXEC dbo.SP_CONT_CAL_CONTENIDO
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_CONT_CAL_CONTENIDO', "EXEC dbo.SP_CONT_CAL_CONTENIDO
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_CONT_CAL_CONTENIDO', "EXEC dbo.SP_CONT_CAL_CONTENIDO
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_CONT_CAL_CONTENIDO', "EXEC dbo.SP_CONT_CAL_CONTENIDO
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
define('SelGrd_CONT_CAL_CONTENIDO_busqueda', "EXEC dbo.SP_CONT_CAL_CONTENIDO
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
define('Insert_CONT_CAL_CONTENIDO', "EXEC dbo.SP_CONT_CAL_CONTENIDO
     @TipoAccion = 'Insert'
		,@IDE_CONT_CALIDAD = ?
		,@IDE_ENTREGABLE = ?
		,@DES_OBSERV_CONTENIDO = ?
		,@EST_CAL_CONTENIDO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_CONT_CAL_CONTENIDO', "EXEC dbo.SP_CONT_CAL_CONTENIDO
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_CONT_CALIDAD = ?
		,@IDE_ENTREGABLE = ?
		,@DES_OBSERV_CONTENIDO = ?
		,@EST_CAL_CONTENIDO = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_CONT_CAL_CONTENIDO', "EXEC dbo.SP_CONT_CAL_CONTENIDO
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

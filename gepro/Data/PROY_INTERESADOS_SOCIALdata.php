<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : PROY_INTERESADOS_SOCIALDATA de la tabla PROY_INTERESADOS_SOCIAL
  //  Fecha           : domingo, 26 de mayo de 2019 5:12:14
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-G
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_PROY_INTERESADOS_SOCIAL', "EXEC dbo.SP_PROY_INTERESADOS_SOCIAL
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROY_INTERESADOS_SOCIAL', "EXEC dbo.SP_PROY_INTERESADOS_SOCIAL
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROY_INTERESADOS_SOCIAL', "EXEC dbo.SP_PROY_INTERESADOS_SOCIAL
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PROY_INTERESADOS_SOCIAL', "EXEC dbo.SP_PROY_INTERESADOS_SOCIAL
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
define('SelGrd_PROY_INTERESADOS_SOCIAL_busqueda', "EXEC dbo.SP_PROY_INTERESADOS_SOCIAL
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
define('Insert_PROY_INTERESADOS_SOCIAL', "EXEC dbo.SP_PROY_INTERESADOS_SOCIAL
     @TipoAccion = 'Insert'
		,@IDE_GESTION_SOCIAL = ?
		,@IDE_CONT_INTERESADO = ?
		,@EST_INTERESADO_SOCIAL = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROY_INTERESADOS_SOCIAL', "EXEC dbo.SP_PROY_INTERESADOS_SOCIAL
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_GESTION_SOCIAL = ?
		,@IDE_CONT_INTERESADO = ?
		,@EST_INTERESADO_SOCIAL = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_PROY_INTERESADOS_SOCIAL', "EXEC dbo.SP_PROY_INTERESADOS_SOCIAL
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

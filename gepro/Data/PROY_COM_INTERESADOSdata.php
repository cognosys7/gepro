<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa			  : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : PROY_COM_INTERESADOSDATA de la tabla PROY_COM_INTERESADOS
  //  Fecha           : viernes, 28 de junio de 2019 21:23:01
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO
  //  Modificado      : 29 de Junio 2019
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_PROY_COM_INTERESADOS', "EXEC dbo.SP_PROY_COM_INTERESADOS
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROY_COM_INTERESADOS', "EXEC dbo.SP_PROY_COM_INTERESADOS
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROY_COM_INTERESADOS', "EXEC dbo.SP_PROY_COM_INTERESADOS
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PROY_COM_INTERESADOS', "EXEC dbo.SP_PROY_COM_INTERESADOS
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
define('Insert_PROY_COM_INTERESADOS', "EXEC dbo.SP_PROY_COM_INTERESADOS
     @TipoAccion = 'Insert'
		,@IDE_COMUNICACION = ?
		,@IDE_CONT_INTERESADO = ?
		,@TIP_RESPONSABILIDAD = ?
		,@DES_COMENTARIO = ?
		,@EST_PROY_COM_INTERESADO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROY_COM_INTERESADOS', "EXEC dbo.SP_PROY_COM_INTERESADOS
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_COMUNICACION = ?
		,@IDE_CONT_INTERESADO = ?
		,@TIP_RESPONSABILIDAD = ?
		,@DES_COMENTARIO = ?
		,@EST_PROY_COM_INTERESADO = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_PROY_COM_INTERESADOS', "EXEC dbo.SP_PROY_COM_INTERESADOS
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : PROY_GESTION_BENEFICIOSDATA de la tabla PROY_GESTION_BENEFICIOS
  //  Fecha           : domingo, 26 de mayo de 2019 21:34:12
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-G
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_PROY_GESTION_BENEFICIOS', "EXEC dbo.SP_PROY_GESTION_BENEFICIOS
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROY_GESTION_BENEFICIOS', "EXEC dbo.SP_PROY_GESTION_BENEFICIOS
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROY_GESTION_BENEFICIOS', "EXEC dbo.SP_PROY_GESTION_BENEFICIOS
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PROY_GESTION_BENEFICIOS', "EXEC dbo.SP_PROY_GESTION_BENEFICIOS
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
define('SelGrd_PROY_GESTION_BENEFICIOS_busqueda', "EXEC dbo.SP_PROY_GESTION_BENEFICIOS
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
define('Insert_PROY_GESTION_BENEFICIOS', "EXEC dbo.SP_PROY_GESTION_BENEFICIOS
     @TipoAccion = 'Insert'
		,@IDE_GESTION_SOCIAL = ?
		,@IDE_CONCEPTO = ?
		,@CAN_CONCEPTO = ?
		,@FEC_INICIO = ?
		,@FEC_TERMINO = ?
		,@EST_BENEF_SOCIAL = ?
    ,@DES_ACTIVIDAD = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROY_GESTION_BENEFICIOS', "EXEC dbo.SP_PROY_GESTION_BENEFICIOS
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_GESTION_SOCIAL = ?
		,@IDE_CONCEPTO = ?
		,@CAN_CONCEPTO = ?
		,@FEC_INICIO = ?
		,@FEC_TERMINO = ?
		,@EST_BENEF_SOCIAL = ?
    ,@DES_ACTIVIDAD = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_PROY_GESTION_BENEFICIOS', "EXEC dbo.SP_PROY_GESTION_BENEFICIOS
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

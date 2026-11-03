
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : CONT_INTERESADOSDATA de la tabla CONT_INTERESADOS
  //  Fecha           : sábado, 25 de mayo de 2019 1:43:01
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-G
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_CONT_INTERESADOS', "EXEC dbo.SP_CONT_INTERESADOS
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_CONT_INTERESADOS', "EXEC dbo.SP_CONT_INTERESADOS
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_CONT_INTERESADOS', "EXEC dbo.SP_CONT_INTERESADOS
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);


//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_Recursos_CONT_INTERESADOS', "EXEC dbo.SP_CONT_INTERESADOS
     @TipoAccion= 'SelCampos_Recursos'
	,@campos = ?
    ,@filtro = ?"
);


//Seleccionar Datos para Grilla
define('SelGrd_CONT_INTERESADOS', "EXEC dbo.SP_CONT_INTERESADOS
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
define('SelGrd_CONT_INTERESADOS_busqueda', "EXEC dbo.SP_CONT_INTERESADOS
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
define('Insert_CONT_INTERESADOS', "EXEC dbo.SP_CONT_INTERESADOS
     @TipoAccion = 'Insert'
		,@IDE_CONTRATO = ?
		,@IDE_RECURSO = ?
		,@IDE_ROL = ?
		,@IDE_PUESTO = ?
		,@DES_LOCALIZACION = ?
		,@DES_MAIL = ?
		,@DES_TELEFONO = ?
		,@DES_REQUERIMIENTOS_PRIMORDIALES = ?
		,@DES_EXPECTATIVAS_PRINCIPALES = ?
		,@TIP_INFLUENCIA_POTENCIAL = ?
		,@DES_FASE_MAYOR_INTERES = ?
		,@TIP_INTERNO_EXTERNO = ?
		,@TIP_CLASIFICACION = ?
		,@DES_INTERES_PROYECTO = ?
		,@TIP_EVALUACION_IMPACTO = ?
		,@DES_ESTRATEGIA_PRINCIPAL = ?
		,@DES_OBSERVACION = ?
		,@EST_CONT_INTERESADO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_CONT_INTERESADOS', "EXEC dbo.SP_CONT_INTERESADOS
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_CONTRATO = ?
		,@IDE_RECURSO = ?
		,@IDE_ROL = ?
		,@IDE_PUESTO = ?
		,@DES_LOCALIZACION = ?
		,@DES_MAIL = ?
		,@DES_TELEFONO = ?
		,@DES_REQUERIMIENTOS_PRIMORDIALES = ?
		,@DES_EXPECTATIVAS_PRINCIPALES = ?
		,@TIP_INFLUENCIA_POTENCIAL = ?
		,@DES_FASE_MAYOR_INTERES = ?
		,@TIP_INTERNO_EXTERNO = ?
		,@TIP_CLASIFICACION = ?
		,@DES_INTERES_PROYECTO = ?
		,@TIP_EVALUACION_IMPACTO = ?
		,@DES_ESTRATEGIA_PRINCIPAL = ?
		,@DES_OBSERVACION = ?
		,@EST_CONT_INTERESADO = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_CONT_INTERESADOS', "EXEC dbo.SP_CONT_INTERESADOS
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);


<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION.NET
//  Empresa			  : www.cognosys.com.pe
//  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Hector Lopez Sanchez                    
//  Propósito       : PLANDATA de la tabla PLAN
//  Fecha           : viernes, 5 de enero de 2018 12:23:42
//  Desde el Modelo : RCC
//  Modificado      : 16 de Octubre 2017
//
//******************************************************************************/

//Seleccionar count
define('Count_PLAN',
"EXEC dbo.SP_PLAN
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PLAN',
"EXEC dbo.SP_PLAN
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"   
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PLAN',
"EXEC dbo.SP_PLAN
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PLAN',
"EXEC dbo.SP_PLAN
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
define('Insert_PLAN',
"EXEC dbo.SP_PLAN
     @TipoAccion = 'Insert'
		,@IDE_DIRECTORIO = ?
		,@IDE_ENTIDAD_SOLICITANTE = ?
		,@IDE_ENTIDAD_EJECUTORA = ?
		,@IDE_INTERVENCION = ?
		,@TIP_PLAN = ?
		,@COD_PLAN = ?
		,@DES_PLAN = ?
		,@TIP_FUENTE = ?
		,@IMP_APROBADO = ?
		,@TIP_GASTO = ?
		,@EST_PLAN = ?
		,@DES_ALCANCE = ?
		,@DES_OBSERVACION = ?
		,@FEC_OBSERVACION = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PLAN',
"EXEC dbo.SP_PLAN
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_DIRECTORIO = ?
		,@IDE_ENTIDAD_SOLICITANTE = ?
		,@IDE_ENTIDAD_EJECUTORA = ?
		,@IDE_INTERVENCION = ?
		,@TIP_PLAN = ?
		,@COD_PLAN = ?
		,@DES_PLAN = ?
		,@TIP_FUENTE = ?
		,@IMP_APROBADO = ?
		,@TIP_GASTO = ?
		,@EST_PLAN = ?
		,@DES_ALCANCE = ?
		,@DES_OBSERVACION = ?
		,@FEC_OBSERVACION = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);        

define('Delete_PLAN',
"EXEC dbo.SP_PLAN
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

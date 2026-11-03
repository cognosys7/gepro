
<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : MODULO DE PLANIFICACION
//  Entidad         : AUTORIDAD PARA LA RECONSTRUCCIÓN CON CAMBIOS. PRESIDENCIA DEL CONSEJO DE MINISTROS
//  Autores         : ING. EDGAR DAVID PISFIL AHUMADA                   
//  Propósito       : fuente_financDATA de la tabla fuente_financ
//  Fecha           : viernes, 26 de octubre de 2018 13:10:56
//  Desde el Modelo : PDM - AMSAC
//  Modificado      : 16 de Octubre 2017
//
//******************************************************************************/

//Seleccionar count
define('Count_fuente_financ',
"EXEC siaf.SP_fuente_financ
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_fuente_financ',
"EXEC siaf.SP_fuente_financ
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"   
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_fuente_financ',
"EXEC siaf.SP_fuente_financ
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_fuente_financ',
"EXEC siaf.SP_fuente_financ
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
define('Insert_fuente_financ',
"EXEC siaf.SP_fuente_financ
     @TipoAccion = 'Insert'
		,@ANO_EJE 
                ,@ORIGEN 
                ,@FUENTE_FINANC 
                ,@NOMBRE 
                ,@ESTADO 
                ,@AMBITO 
                ,@ES_PRESUPUESTAL 
                ,@ES_MODIFICABLE 
                ,@FUENTE_FINANC_AGREGADA 
                ,@ES_PPTM 
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_fuente_financ',
"EXEC siaf.SP_fuente_financ
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@ANO_EJE 
                ,@ORIGEN 
                ,@FUENTE_FINANC 
                ,@NOMBRE 
                ,@ESTADO 
                ,@AMBITO 
                ,@ES_PRESUPUESTAL 
                ,@ES_MODIFICABLE 
                ,@FUENTE_FINANC_AGREGADA 
                ,@ES_PPTM 
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);        

define('Delete_fuente_financ',
"EXEC siaf.SP_fuente_financ
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);
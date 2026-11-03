
<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : MODULO DE PLANIFICACION
//  Entidad         : AUTORIDAD PARA LA RECONSTRUCCIÓN CON CAMBIOS. PRESIDENCIA DEL CONSEJO DE MINISTROS
//  Autores         : ING. EDGAR DAVID PISFIL AHUMADA                   
//  Propósito       : componente_nombreDATA de la tabla componente_nombre
//  Fecha           : viernes, 26 de octubre de 2018 13:10:56
//  Desde el Modelo : PDM - AMSAC
//  Modificado      : 16 de Octubre 2017
//
//******************************************************************************/

//Seleccionar count
define('Count_componente_nombre',
"EXEC siaf.SP_componente_nombre
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_componente_nombre',
"EXEC siaf.SP_componente_nombre
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"   
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_componente_nombre',
"EXEC siaf.SP_componente_nombre
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_componente_nombre',
"EXEC siaf.SP_componente_nombre
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
define('Insert_componente_nombre',
"EXEC siaf.SP_componente_nombre
     @TipoAccion = 'Insert'
                ,@ANO_EJE = ?
              ,@COMPONENTE = ?
              ,@TIPO_COMPONENTE = ?
              ,@NOMBRE = ?
              ,@ESTADO = ?
              ,@AMBITO = ?
              ,@ES_PRESUPUESTAL = ?
              ,@AMBITO_EN = ?
              ,@ES_GENERICO = ?
              ,@ES_FONIPREL = ?
              ,@AMBITO_PROGRAMA = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_componente_nombre',
"EXEC siaf.SP_componente_nombre
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@ANO_EJE = ?
              ,@TIPO_COMPONENTE = ?
              ,@NOMBRE = ?
              ,@ESTADO = ?
              ,@AMBITO = ?
              ,@ES_PRESUPUESTAL = ?
              ,@AMBITO_EN = ?
              ,@ES_GENERICO = ?
              ,@ES_FONIPREL = ?
              ,@AMBITO_PROGRAMA = ? 
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);        

define('Delete_componente_nombre',
"EXEC siaf.SP_componente_nombre
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : MODULO DE PLANIFICACION
//  Entidad         : AUTORIDAD PARA LA RECONSTRUCCIÓN CON CAMBIOS. PRESIDENCIA DEL CONSEJO DE MINISTROS
//  Autores         : ING. EDGAR DAVID PISFIL AHUMADA                   
//  Propósito       : programa_ppto_nombreDATA de la tabla programa_ppto_nombre
//  Fecha           : viernes, 26 de octubre de 2018 13:10:56
//  Desde el Modelo : PDM - AMSAC
//  Modificado      : 16 de Octubre 2017
//
//******************************************************************************/

//Seleccionar count
define('Count_programa_ppto_nombre',
"EXEC siaf.SP_programa_ppto_nombre
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_programa_ppto_nombre',
"EXEC siaf.SP_programa_ppto_nombre
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"   
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_programa_ppto_nombre',
"EXEC siaf.SP_programa_ppto_nombre
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_programa_ppto_nombre',
"EXEC siaf.SP_programa_ppto_nombre
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
define('Insert_programa_ppto_nombre',
"EXEC siaf.SP_programa_ppto_nombre
     @TipoAccion = 'Insert'
               @ANO_EJE = ?
              , @PROGRAMA_PPTO = ?
              , @NOMBRE = ?
              , @TIPO_PROGRAMA_PPTO = ?
              , @AMBITO = ?
              , @ESTADO = ?
              , @AMBITO_EN = ?
              , @FINALIDAD_FIJA = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_programa_ppto_nombre',
"EXEC siaf.SP_programa_ppto_nombre
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		  @ANO_EJE
                , @NOMBRE
                , @TIPO_PROGRAMA_PPTO
                , @AMBITO
                , @ESTADO
                , @AMBITO_EN
                , @FINALIDAD_FIJA
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);        

define('Delete_programa_ppto_nombre',
"EXEC siaf.SP_programa_ppto_nombre
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : MODULO DE PLANIFICACION
//  Entidad         : AUTORIDAD PARA LA RECONSTRUCCIÓN CON CAMBIOS. PRESIDENCIA DEL CONSEJO DE MINISTROS
//  Autores         : ING. EDGAR DAVID PISFIL AHUMADA                   
//  Propósito       : genericaDATA de la tabla generica
//  Fecha           : viernes, 26 de octubre de 2018 13:10:56
//  Desde el Modelo : PDM - AMSAC
//  Modificado      : 16 de Octubre 2017
//
//******************************************************************************/

//Seleccionar count
define('Count_generica',
"EXEC siaf.SP_generica
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_generica',
"EXEC siaf.SP_generica
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"   
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_generica',
"EXEC siaf.SP_generica
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_generica',
"EXEC siaf.SP_generica
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
define('Insert_generica',
"EXEC siaf.SP_generica
     @TipoAccion = 'Insert'
		,@ANO_EJE 
                ,@TIPO_TRANSACCION 
                ,@GENERICA 
                ,@DESCRIPCIO 
                ,@ID_GRUPO_CLASIFICADOR 
                ,@AMBITO 
                ,@ESTADO 
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_generica',
"EXEC siaf.SP_generica
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@ANO_EJE 
                ,@TIPO_TRANSACCION 
                ,@GENERICA 
                ,@DESCRIPCIO 
                ,@ID_GRUPO_CLASIFICADOR 
                ,@AMBITO 
                ,@ESTADO 
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);        

define('Delete_generica',
"EXEC siaf.SP_generica
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);
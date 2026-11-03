
<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION.NET
//  Empresa			  : www.cognosys.com.pe
//  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Edgar David Pisfil Ahumada                    
//  Propósito       : GEN_TABLASDATA de la tabla GEN_TABLAS
//  Fecha           : viernes, 3 de mayo de 2019 13:41:16
//  Desde el Modelo : PDM - AMSAC - AJUSTADO
//  Modificado      : 16 de Octubre 2017
//
//******************************************************************************/

//Seleccionar count
define('Count_GEN_TABLAS',
"EXEC dbo.SP_GEN_TABLAS
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_GEN_TABLAS',
"EXEC dbo.SP_GEN_TABLAS
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"   
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_GEN_TABLAS',
"EXEC dbo.SP_GEN_TABLAS
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_GEN_TABLAS',
"EXEC dbo.SP_GEN_TABLAS
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
/***EDGAR***/
define('SelGrd_GEN_TABLAS_pAuxiliar',
"EXEC dbo.SP_GEN_TABLAS
     @TipoAccion= 'SelGrd'
    ,@rp = ?
    ,@sortname = ?
    ,@sortorder = ?
    ,@page = ?
    ,@filtro = ?
    ,@codigoMensaje = ?
    ,@Mensaje = ?
    ,@nTotal = ?
    ,@pAuxiliar='Anidado'
"
);
/***EDGAR***/


//MANTENIMIENTO
define('Insert_GEN_TABLAS',
"EXEC dbo.SP_GEN_TABLAS
     @TipoAccion = 'Insert'
		,@COD_TABLA = ?
		,@COD_ITEM = ?
		,@DES_ITEM = ?
		,@DES_ABREVIATURA = ?
		,@COD_ORDEN = ?
		,@EST_ITEM = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_GEN_TABLAS',
"EXEC dbo.SP_GEN_TABLAS
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@COD_TABLA = ?
		,@COD_ITEM = ?
		,@DES_ITEM = ?
		,@DES_ABREVIATURA = ?
		,@COD_ORDEN = ?
		,@EST_ITEM = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);        

define('Delete_GEN_TABLAS',
"EXEC dbo.SP_GEN_TABLAS
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);
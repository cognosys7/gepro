
<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION.NET
//  Empresa			  : www.cognosys.com.pe
//  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Edgar David Pisfil Ahumada                    
//  Propósito       : PROY_CARTERADATA de la tabla PROY_CARTERA
//  Fecha           : lunes, 20 de noviembre de 2017 11:07:32 a.m.
//  Desde el Modelo : PDM - AMSAC
//  Modificado      : 16 de Octubre 2017
//
//******************************************************************************/

//Seleccionar count
define('Count_PROY_CARTERA',
"EXEC dbo.SP_PROY_CARTERA
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROY_CARTERA',
"EXEC dbo.SP_PROY_CARTERA
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"   
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROY_CARTERA',
"EXEC dbo.SP_PROY_CARTERA
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PROY_CARTERA',
"EXEC dbo.SP_PROY_CARTERA
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
define('Insert_PROY_CARTERA',
"EXEC dbo.SP_PROY_CARTERA
     @TipoAccion = 'Insert'
		,@IDE_FASE = ?
		,@DES_CARTERA = ?
		,@EST_CARTERA = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROY_CARTERA',
"EXEC dbo.SP_PROY_CARTERA
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_FASE = ?
		,@DES_CARTERA = ?
		,@EST_CARTERA = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);        

define('Delete_PROY_CARTERA',
"EXEC dbo.SP_PROY_CARTERA
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);
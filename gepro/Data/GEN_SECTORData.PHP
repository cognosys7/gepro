
<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION.NET
//  Empresa			  : www.cognosys.com.pe
//  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Edgar David Pisfil Ahumada                    
//  Propósito       : GEN_SECTORDATA de la tabla GEN_SECTOR
//  Fecha           : martes, 31 de octubre de 2017 03:00:39 p.m.
//  Desde el Modelo : PDM AMSAC
//  Modificado      : 16 de Octubre 2017
//
//******************************************************************************/

//Seleccionar count
define('Count_GEN_SECTOR',
"EXEC dbo.SP_GEN_SECTOR
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_GEN_SECTOR',
"EXEC dbo.SP_GEN_SECTOR
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"   
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_GEN_SECTOR',
"EXEC dbo.SP_GEN_SECTOR
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_GEN_SECTOR',
"EXEC dbo.SP_GEN_SECTOR
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
define('Insert_GEN_SECTOR',
"EXEC dbo.SP_GEN_SECTOR
     @TipoAccion = 'Insert'
		,@COD_SECTOR = ?
		,@DES_SECTOR = ?
		,@DES_SECTOR_ABREVIATURA = ?
		,@EST_SECTOR = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_GEN_SECTOR',
"EXEC dbo.SP_GEN_SECTOR
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@COD_SECTOR = ?
		,@DES_SECTOR = ?
		,@DES_SECTOR_ABREVIATURA = ?
		,@EST_SECTOR = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);        

define('Delete_GEN_SECTOR',
"EXEC dbo.SP_GEN_SECTOR
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);
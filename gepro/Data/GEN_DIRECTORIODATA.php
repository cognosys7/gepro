
<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION.NET
//  Empresa			  : www.cognosys.com.pe
//  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Hector Lopez Sanchez                    
//  Propósito       : GEN_DIRECTORIODATA de la tabla GEN_DIRECTORIO
//  Fecha           : jueves, 4 de enero de 2018 11:05:07
//  Desde el Modelo : RCC
//  Modificado      : 16 de Octubre 2017
//
//******************************************************************************/

//Seleccionar count
define('Count_GEN_DIRECTORIO',
"EXEC dbo.SP_GEN_DIRECTORIO
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_GEN_DIRECTORIO',
"EXEC dbo.SP_GEN_DIRECTORIO
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"   
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_GEN_DIRECTORIO',
"EXEC dbo.SP_GEN_DIRECTORIO
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_GEN_DIRECTORIO',
"EXEC dbo.SP_GEN_DIRECTORIO
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
define('Insert_GEN_DIRECTORIO',
"EXEC dbo.SP_GEN_DIRECTORIO
     @TipoAccion = 'Insert'
		,@DES_DIRECTORIO = ?
		,@FEC_APROBACION = ?
		,@EST_DIRECTORIO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_GEN_DIRECTORIO',
"EXEC dbo.SP_GEN_DIRECTORIO
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@DES_DIRECTORIO = ?
		,@FEC_APROBACION = ?
		,@EST_DIRECTORIO = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);        

define('Delete_GEN_DIRECTORIO',
"EXEC dbo.SP_GEN_DIRECTORIO
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

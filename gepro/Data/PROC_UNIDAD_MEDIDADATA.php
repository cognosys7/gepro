
<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION.NET
//  Empresa			  : www.cognosys.com.pe
//  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Hector Lopez Sanchez                    
//  Propósito       : PROC_UNIDAD_MEDIDADATA de la tabla PROC_UNIDAD_MEDIDA
//  Fecha           : miércoles, 1 de noviembre de 2017 09:39:47
//  Desde el Modelo : PDM AMSAC
//  Modificado      : 16 de Octubre 2017
//
//******************************************************************************/

//Seleccionar count
define('Count_PROC_UNIDAD_MEDIDA',
"EXEC dbo.SP_PROC_UNIDAD_MEDIDA
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROC_UNIDAD_MEDIDA',
"EXEC dbo.SP_PROC_UNIDAD_MEDIDA
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"   
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROC_UNIDAD_MEDIDA',
"EXEC dbo.SP_PROC_UNIDAD_MEDIDA
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PROC_UNIDAD_MEDIDA',
"EXEC dbo.SP_PROC_UNIDAD_MEDIDA
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
define('Insert_PROC_UNIDAD_MEDIDA',
"EXEC dbo.SP_PROC_UNIDAD_MEDIDA
     @TipoAccion = 'Insert'
		,@UNIDAD_MEDIDA = ?
		,@EST_UNIDAD_MEDIDA = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROC_UNIDAD_MEDIDA',
"EXEC dbo.SP_PROC_UNIDAD_MEDIDA
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@UNIDAD_MEDIDA = ?
		,@EST_UNIDAD_MEDIDA = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);        

define('Delete_PROC_UNIDAD_MEDIDA',
"EXEC dbo.SP_PROC_UNIDAD_MEDIDA
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);
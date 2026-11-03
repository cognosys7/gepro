<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION.NET
//  Empresa			  : www.cognosys.com.pe
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Edgar David Pisfil Ahumada                    
//  Propósito       : PROY_COMP_SEGUIMIENTO2DATA de la tabla PROY_COMP_SEGUIMIENTO2
//  Fecha           : miércoles, 18 de setiembre de 2019 17:56:29
//  Desde el Modelo : PDM - Modelo Físico de Datos - SGPAM - J8(1)
//  Modificado      : 29 de Junio 2019
//
//******************************************************************************/

//Seleccionar count
define('Count_PROY_COMP_SEGUIMIENTO2',
"EXEC dbo.SP_PROY_COMP_SEGUIMIENTO2
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROY_COMP_SEGUIMIENTO2',
"EXEC dbo.SP_PROY_COMP_SEGUIMIENTO2
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"   
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROY_COMP_SEGUIMIENTO2',
"EXEC dbo.SP_PROY_COMP_SEGUIMIENTO2
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PROY_COMP_SEGUIMIENTO2',
"EXEC dbo.SP_PROY_COMP_SEGUIMIENTO2
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
define('Insert_PROY_COMP_SEGUIMIENTO2',
"EXEC dbo.SP_PROY_COMP_SEGUIMIENTO2
     @TipoAccion = 'Insert'
		,@IDE_PROY_COMPONENTE = ?
		,@FEC_SEGUIMIENTO = ?
		,@DES_SEGUIMIENTO = ?
		,@TIP_SEGUIMIENTO = ?
		,@EST_SEGUIMIENTO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROY_COMP_SEGUIMIENTO2',
"EXEC dbo.SP_PROY_COMP_SEGUIMIENTO2
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_PROY_COMPONENTE = ?
		,@FEC_SEGUIMIENTO = ?
		,@DES_SEGUIMIENTO = ?
		,@TIP_SEGUIMIENTO = ?
		,@EST_SEGUIMIENTO = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);        

define('Delete_PROY_COMP_SEGUIMIENTO2',
"EXEC dbo.SP_PROY_COMP_SEGUIMIENTO2
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);
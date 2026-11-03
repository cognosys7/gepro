
<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION.NET
//  Empresa			  : www.cognosys.com.pe
//  Autores         : Julio C�sar Meza Yangali - mezayangali@gmail.com - 
//                    Edgar David Pisfil Ahumada                    
//  Prop�sito       : GEN_INTERVENCION_COMPDATA de la tabla GEN_INTERVENCION_COMP
//  Fecha           : mi�rcoles, 9 de mayo de 2018 12:05:14
//  Desde el Modelo : PDM - AMSAC
//  Modificado      : 16 de Octubre 2017
//
//******************************************************************************/

//Seleccionar count
define('Count_GEN_INTERVENCION_COMP',
"EXEC dbo.SP_GEN_INTERVENCION_COMP
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_GEN_INTERVENCION_COMP',
"EXEC dbo.SP_GEN_INTERVENCION_COMP
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"   
);

//Seleccionar Registros Por Condici�n Generada Por el Usuario
define('SelCampos_GEN_INTERVENCION_COMP',
"EXEC dbo.SP_GEN_INTERVENCION_COMP
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);


//Seleccionar Registros Por Condici�n Generada Por el Usuario
define('SelCampos2_GEN_INTERVENCION_COMP',
"EXEC dbo.SP_GEN_INTERVENCION_COMP
     @TipoAccion= 'SelCampos2'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_GEN_INTERVENCION_COMP',
"EXEC dbo.SP_GEN_INTERVENCION_COMP
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
define('Insert_GEN_INTERVENCION_COMP',
"EXEC dbo.SP_GEN_INTERVENCION_COMP
     @TipoAccion = 'Insert'
		,@IDE_INTERVENCION = ?
		,@IDE_COMPONENTE = ?
		,@COMP_PRINCIPAL = ?
		,@IDE_MODO_EJECUCION = ?
		,@IDE_TIPO_PROC = ?
		,@EST_INTERVENCION_COMP = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_GEN_INTERVENCION_COMP',
"EXEC dbo.SP_GEN_INTERVENCION_COMP
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_INTERVENCION = ?
		,@IDE_COMPONENTE = ?
		,@COMP_PRINCIPAL = ?
		,@IDE_MODO_EJECUCION = ?
		,@IDE_TIPO_PROC = ?
		,@EST_INTERVENCION_COMP = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);        

define('Delete_GEN_INTERVENCION_COMP',
"EXEC dbo.SP_GEN_INTERVENCION_COMP
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

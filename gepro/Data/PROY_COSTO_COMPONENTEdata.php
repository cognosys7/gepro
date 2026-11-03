<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : SISTEMA DE GESTION DE PROYECTOS
//  Empresa	    	  : ACTIVOS MINEROS S.A.C.
//  Autores         : Ing. julio César Meza Yangali                    
//  Propósito       : PROY_COSTO_COMPONENTEdata de la tabla PROY_COSTO_COMPONENTE
//  Fecha           : sábado, 3 de julio de 2021 6:37:49
//  Desde el Modelo : PDM - Modelo Físico de Datos - SGPAM
//  Modificado      : sábado, 3 de julio de 2021 6:37:49
//
//******************************************************************************/


//Seleccionar count
define('Count_PROY_COSTO_COMPONENTE',
"EXEC dbo.SP_PROY_COSTO_COMPONENTE
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROY_COSTO_COMPONENTE',
"EXEC dbo.SP_PROY_COSTO_COMPONENTE
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"   
);


//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROY_COSTO_COMPONENTE',
"EXEC dbo.SP_PROY_COSTO_COMPONENTE
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);


//Seleccionar Datos para Grilla
define('SelGrd_PROY_COSTO_COMPONENTE',
"EXEC dbo.SP_PROY_COSTO_COMPONENTE
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
define('Insert_PROY_COSTO_COMPONENTE',
"EXEC dbo.SP_PROY_COSTO_COMPONENTE
     @TipoAccion = 'Insert'
		,@IDE_PROYECTO = ?
		,@FEC_CAMBIO = ?
		,@PCT_AVANCE_FISICO = ?
		,@IMP_CTO_PLAN_CIERRE = ?
		,@IMP_CTO_PERFIL = ?
		,@IMP_CTO_EXPEDIENTE = ?
		,@IMP_CTO_OBRA = ?
		,@IMP_CTO_SUPERVISION = ?
		,@IMP_CTO_GESTION_PROY = ?
		,@IMP_CTO_CAPACITACION = ?
		,@IMP_CTO_POST_CIERRE = ?
		,@TIP_COMPONENTE_ACT = ?
		,@DES_ACTUALIZACION = ?
		,@EST_CAMBIO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROY_COSTO_COMPONENTE',
"EXEC dbo.SP_PROY_COSTO_COMPONENTE
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_PROYECTO = ?
		,@FEC_CAMBIO = ?
		,@PCT_AVANCE_FISICO = ?
		,@IMP_CTO_PLAN_CIERRE = ?
		,@IMP_CTO_PERFIL = ?
		,@IMP_CTO_EXPEDIENTE = ?
		,@IMP_CTO_OBRA = ?
		,@IMP_CTO_SUPERVISION = ?
		,@IMP_CTO_GESTION_PROY = ?
		,@IMP_CTO_CAPACITACION = ?
		,@IMP_CTO_POST_CIERRE = ?
		,@TIP_COMPONENTE_ACT = ?
		,@DES_ACTUALIZACION = ?
		,@EST_CAMBIO = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);        


define('Delete_PROY_COSTO_COMPONENTE',
"EXEC dbo.SP_PROY_COSTO_COMPONENTE
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

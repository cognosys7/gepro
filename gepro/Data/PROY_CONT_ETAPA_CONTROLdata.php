<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : SISTEMA DE GESTION DE PROYECTOS
//  Empresa	    : ACTIVOS MINEROS S.A.C.
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
//                    Ing. Edgar David Pisfil Ahumada                   
//  Propósito       : PROY_CONT_ETAPA_CONTROLdata de la tabla PROY_CONT_ETAPA_CONTROL
//  Fecha           : martes, 25 de mayo de 2021 14:14:58
//  Desde el Modelo : PDM - Modelo Físico de Datos - SGPAM
//  Modificado      : martes, 25 de mayo de 2021 14:14:58
//******************************************************************************/


//Seleccionar count
define('Count_PROY_CONT_ETAPA_CONTROL', "EXEC dbo.SP_PROY_CONT_ETAPA_CONTROL
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROY_CONT_ETAPA_CONTROL', "EXEC dbo.SP_PROY_CONT_ETAPA_CONTROL
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);


//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROY_CONT_ETAPA_CONTROL', "EXEC dbo.SP_PROY_CONT_ETAPA_CONTROL
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);


//Seleccionar Datos para Grilla
define('SelGrd_PROY_CONT_ETAPA_CONTROL', "EXEC dbo.SP_PROY_CONT_ETAPA_CONTROL
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
define('Insert_PROY_CONT_ETAPA_CONTROL', "EXEC dbo.SP_PROY_CONT_ETAPA_CONTROL
     @TipoAccion = 'Insert'
		,@IDE_PROY_COMPONENTE = ?
		,@IDE_PLAN = ?
		,@NUM_ANIO = ?
		,@TIP_CONCEPTO = ?
		,@IMP_BRUTO = ?
		,@IMP_IMPONIBLE = ?
		,@PCT_IGV = ?
		,@IMP_IGV = ?
		,@IMP_NETO = ?
		,@IMP_PENALIDAD = ?
		,@IMP_PAGO = ?
		,@EST_ETAPA_CONTROL = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROY_CONT_ETAPA_CONTROL', "EXEC dbo.SP_PROY_CONT_ETAPA_CONTROL
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_PROY_COMPONENTE = ?
		,@IDE_PLAN = ?
		,@NUM_ANIO = ?
		,@TIP_CONCEPTO = ?
		,@IMP_BRUTO = ?
		,@IMP_IMPONIBLE = ?
		,@PCT_IGV = ?
		,@IMP_IGV = ?
		,@IMP_NETO = ?
		,@IMP_PENALIDAD = ?
		,@IMP_PAGO = ?
		,@EST_ETAPA_CONTROL = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);


define('Delete_PROY_CONT_ETAPA_CONTROL', "EXEC dbo.SP_PROY_CONT_ETAPA_CONTROL
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

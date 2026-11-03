<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : SISTEMA DE GESTION DE PROYECTOS
//  Empresa	    : ACTIVOS MINEROS S.A.C.
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
//                    Ing. Edgar David Pisfil Ahumada                   
//  Propósito       : PROY_CONT_COMP_CONTROL_DETdata de la tabla PROY_CONT_COMP_CONTROL_DET
//  Fecha           : martes, 25 de mayo de 2021 14:14:34
//  Desde el Modelo : PDM - Modelo Físico de Datos - SGPAM
//  Modificado      : martes, 25 de mayo de 2021 14:14:34
//******************************************************************************/


//Seleccionar count
define('Count_PROY_CONT_COMP_CONTROL_DET', "EXEC dbo.SP_PROY_CONT_COMP_CONTROL_DET
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROY_CONT_COMP_CONTROL_DET', "EXEC dbo.SP_PROY_CONT_COMP_CONTROL_DET
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);


//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROY_CONT_COMP_CONTROL_DET', "EXEC dbo.SP_PROY_CONT_COMP_CONTROL_DET
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);


//Seleccionar Datos para Grilla
define('SelGrd_PROY_CONT_COMP_CONTROL_DET', "EXEC dbo.SP_PROY_CONT_COMP_CONTROL_DET
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
define('Insert_PROY_CONT_COMP_CONTROL_DET', "EXEC dbo.SP_PROY_CONT_COMP_CONTROL_DET
     @TipoAccion = 'Insert'
		,@IDE_CONT_ETAPA_CONTROL = ?
		,@NUM_ITEM = ?
		,@NUM_ANIO = ?
		,@NUM_MES = ?
		,@DES_CONCEPTO_PAGO = ?
		,@PCT_AVANCE = ?
		,@IMP_BRUTO = ?
		,@IMP_REAJUSTE = ?
		,@IMP_AMORT_ADEL_DIR = ?
		,@IMP_AMORT_ADEL_MAT = ?
		,@IMP_AMORTIZACION = ?
		,@IMP_SALDO_SIN_IGV = ?
		,@IMP_DEDUC_ADEL_DIR = ?
		,@IMP_DEDUC_ADEL_MAT = ?
		,@IMP_IMPONIBLE = ?
		,@PCT_IGV = ?
		,@IMP_IGV = ?
		,@IMP_NETO = ?
		,@IMP_PENALIDAD = ?
		,@IMP_RETENCION = ?
		,@IMP_PAGO = ?
		,@EST_ETAPA_CONTROL_DET = ?
		,@NUM_MES_PROVISION = ?
		,@NUM_ANIO_PROVISION = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROY_CONT_COMP_CONTROL_DET', "EXEC dbo.SP_PROY_CONT_COMP_CONTROL_DET
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_CONT_ETAPA_CONTROL = ?
		,@NUM_ITEM = ?
		,@NUM_ANIO = ?
		,@NUM_MES = ?
		,@DES_CONCEPTO_PAGO = ?
		,@PCT_AVANCE = ?
		,@IMP_BRUTO = ?
		,@IMP_REAJUSTE = ?
		,@IMP_AMORT_ADEL_DIR = ?
		,@IMP_AMORT_ADEL_MAT = ?
		,@IMP_AMORTIZACION = ?
		,@IMP_SALDO_SIN_IGV = ?
		,@IMP_DEDUC_ADEL_DIR = ?
		,@IMP_DEDUC_ADEL_MAT = ?
		,@IMP_IMPONIBLE = ?
		,@PCT_IGV = ?
		,@IMP_IGV = ?
		,@IMP_NETO = ?
		,@IMP_PENALIDAD = ?
		,@IMP_RETENCION = ?
		,@IMP_PAGO = ?
		,@EST_ETAPA_CONTROL_DET = ?	
		,@NUM_MES_PROVISION = ?
		,@NUM_ANIO_PROVISION = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);


define('Delete_PROY_CONT_COMP_CONTROL_DET', "EXEC dbo.SP_PROY_CONT_COMP_CONTROL_DET
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

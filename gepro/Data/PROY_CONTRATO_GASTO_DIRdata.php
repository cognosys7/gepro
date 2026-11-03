<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : PROY_CONTRATO_GASTO_DIRDATA de la tabla PROY_CONTRATO_GASTO_DIR
  //  Fecha           : martes, 28 de mayo de 2019 21:00:04
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-I
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_PROY_CONTRATO_GASTO_DIR', "EXEC dbo.SP_PROY_CONTRATO_GASTO_DIR
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROY_CONTRATO_GASTO_DIR', "EXEC dbo.SP_PROY_CONTRATO_GASTO_DIR
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROY_CONTRATO_GASTO_DIR', "EXEC dbo.SP_PROY_CONTRATO_GASTO_DIR
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PROY_CONTRATO_GASTO_DIR', "EXEC dbo.SP_PROY_CONTRATO_GASTO_DIR
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


//Seleccionar Datos para Grilla Busqueda
define('SelGrd_PROY_CONTRATO_GASTO_DIR_busqueda', "EXEC dbo.SP_PROY_CONTRATO_GASTO_DIR
     @TipoAccion= 'SelGrd_busqueda'
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
define('Insert_PROY_CONTRATO_GASTO_DIR', "EXEC dbo.SP_PROY_CONTRATO_GASTO_DIR
     @TipoAccion = 'Insert'
                ,@IDE_CONTRATO_ETAPA = ?
		,@COD_ANHO_EJECUCION = ?
		,@IDE_CENCOSTO = ?
		,@IDE_ESPECIFICA_GASTO = ?
		,@IDE_CUENTA_CONTABLE = ?
		,@IDE_FTE_FTO = ?
		,@IMP_PIA = ?
		,@IMP_PIM = ?
		,@IMP_COMPROMISO = ?
		,@IMP_DEVENGADO = ?
		,@IMP_GIRADO = ?
		,@EST_CONT_PRESUPUESTO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROY_CONTRATO_GASTO_DIR', "EXEC dbo.SP_PROY_CONTRATO_GASTO_DIR
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_CONTRATO_ETAPA = ?
		,@COD_ANHO_EJECUCION = ?
		,@IDE_CENCOSTO = ?
		,@IDE_ESPECIFICA_GASTO = ?
		,@IDE_CUENTA_CONTABLE = ?
		,@IDE_FTE_FTO = ?
		,@IMP_PIA = ?
		,@IMP_PIM = ?
		,@IMP_COMPROMISO = ?
		,@IMP_DEVENGADO = ?
		,@IMP_GIRADO = ?
		,@EST_CONT_PRESUPUESTO = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_PROY_CONTRATO_GASTO_DIR', "EXEC dbo.SP_PROY_CONTRATO_GASTO_DIR
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

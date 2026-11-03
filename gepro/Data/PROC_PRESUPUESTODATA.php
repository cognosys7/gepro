
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Hector Lopez Sanchez
  //  Propósito       : PROC_PRESUPUESTODATA de la tabla PROC_PRESUPUESTO
  //  Fecha           : jueves, 02 de noviembre de 2017 05:29:54 p.m.
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_PROC_PRESUPUESTO', "EXEC dbo.SP_PROC_PRESUPUESTO
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROC_PRESUPUESTO', "EXEC dbo.SP_PROC_PRESUPUESTO
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROC_PRESUPUESTO', "EXEC dbo.SP_PROC_PRESUPUESTO
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PROC_PRESUPUESTO', "EXEC dbo.SP_PROC_PRESUPUESTO
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
define('Insert_PROC_PRESUPUESTO', "EXEC dbo.SP_PROC_PRESUPUESTO
     @TipoAccion = 'Insert'
		,@IDE_CONVOCATORIA = ?
		,@IDE_PROC_ITEM = ?
		,@SEC_FUNC = ?
		,@COD_FTE_FTO = ?
		,@COD_ESPECIFICA_GASTO = ?
		,@COD_CERTIFICADO_PRES = ?
		,@SEC_EJEC = ?
		,@COD_EXPEDIENTE_SIAF = ?
		,@DES_FTE_FTO = ?
		,@DES_ESPECIFICA_GASTO = ?
		,@IMP_CERTIFICADO_PRES = ?
		,@EST_PROC_PRESUPUESTO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROC_PRESUPUESTO', "EXEC dbo.SP_PROC_PRESUPUESTO
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_CONVOCATORIA = ?
		,@IDE_PROC_ITEM = ?
		,@SEC_FUNC = ?
		,@COD_FTE_FTO = ?
		,@COD_ESPECIFICA_GASTO = ?
		,@COD_CERTIFICADO_PRES = ?
		,@SEC_EJEC = ?
		,@COD_EXPEDIENTE_SIAF = ?
		,@DES_FTE_FTO = ?
		,@DES_ESPECIFICA_GASTO = ?
		,@IMP_CERTIFICADO_PRES = ?
		,@EST_PROC_PRESUPUESTO = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_PROC_PRESUPUESTO', "EXEC dbo.SP_PROC_PRESUPUESTO
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

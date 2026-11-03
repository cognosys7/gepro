<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : CONT_CALIDADDATA de la tabla CONT_CALIDAD
  //  Fecha           : miércoles, 5 de junio de 2019 0:46:48
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-J
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_CONT_CALIDAD', "EXEC dbo.SP_CONT_CALIDAD
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_CONT_CALIDAD', "EXEC dbo.SP_CONT_CALIDAD
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_CONT_CALIDAD', "EXEC dbo.SP_CONT_CALIDAD
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_CONT_CALIDAD', "EXEC dbo.SP_CONT_CALIDAD
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
define('SelGrd_CONT_CALIDAD_busqueda', "EXEC dbo.SP_CONT_CALIDAD
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
define('Insert_CONT_CALIDAD', "EXEC dbo.SP_CONT_CALIDAD
     @TipoAccion = 'Insert'
		,@IDE_CONTRATO = ?
		,@IDE_ENTREGABLE = ?
                ,@DES_ENTREGABLE = ?
		,@NUM_REVISION = ?
		,@COD_INFORME = ?
		,@FEC_INFORME = ?
		,@IDE_REC_REVISADO = ?
		,@IDE_REC_VALIDADO = ?
		,@IDE_REC_APROBADO = ?
		,@DES_OBSERV_INFORME = ?
		,@CAN_OBSERVACIONES = ?
		,@EST_ENTREGABLE = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_CONT_CALIDAD', "EXEC dbo.SP_CONT_CALIDAD
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_CONTRATO = ?
		,@IDE_ENTREGABLE = ?
                ,@DES_ENTREGABLE = ?
		,@NUM_REVISION = ?
		,@COD_INFORME = ?
		,@FEC_INFORME = ?
		,@IDE_REC_REVISADO = ?
		,@IDE_REC_VALIDADO = ?
		,@IDE_REC_APROBADO = ?
		,@DES_OBSERV_INFORME = ?
		,@CAN_OBSERVACIONES = ?
		,@EST_ENTREGABLE = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_CONT_CALIDAD', "EXEC dbo.SP_CONT_CALIDAD
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

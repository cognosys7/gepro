
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : ACUERDODATA de la tabla ACUERDO
  //  Fecha           : miércoles, 1 de noviembre de 2017 12:19:31
  //  Desde el Modelo : PDM AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_ACUERDO', "EXEC dbo.SP_ACUERDO
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_ACUERDO', "EXEC dbo.SP_ACUERDO
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_ACUERDO', "EXEC dbo.SP_ACUERDO
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_ACUERDO', "EXEC dbo.SP_ACUERDO
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
define('Insert_ACUERDO', "EXEC dbo.SP_ACUERDO
     @TipoAccion = 'Insert'
		,@IDE_DIRECTORIO = ?
		,@IDE_ENTIDAD_SOLICITANTE = ?
		,@IDE_ENTIDAD_EJECUTORA = ?
		,@IDE_INTERVENCION_GRUPO = ?
		,@IDE_INTERVENCION_DET = ?
		,@COD_ACUERDO = ?
		,@DES_ACUERDO = ?
		,@IMP_APROBADO_DIRECTORIO = ?
		,@IMP_TRANSFERIDO_DS = ?
		,@TIP_GASTO = ?
		,@EST_ACUERDO = ?
		,@DES_OBSERVACION = ?
		,@FEC_OBSERVACION = ?
		,@USER_INSERT = ?
		,@FECHA_INSERT = ?
		,@USER_UPDATE = ?
		,@FECHA_UPDATE = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_ACUERDO', "EXEC dbo.SP_ACUERDO
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_DIRECTORIO = ?
		,@IDE_ENTIDAD_SOLICITANTE = ?
		,@IDE_ENTIDAD_EJECUTORA = ?
		,@IDE_INTERVENCION_GRUPO = ?
		,@IDE_INTERVENCION_DET = ?
		,@COD_ACUERDO = ?
		,@DES_ACUERDO = ?
		,@IMP_APROBADO_DIRECTORIO = ?
		,@IMP_TRANSFERIDO_DS = ?
		,@TIP_GASTO = ?
		,@EST_ACUERDO = ?
		,@DES_OBSERVACION = ?
		,@FEC_OBSERVACION = ?
		,@USER_INSERT = ?
		,@FECHA_INSERT = ?
		,@USER_UPDATE = ?
		,@FECHA_UPDATE = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_ACUERDO', "EXEC dbo.SP_ACUERDO
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

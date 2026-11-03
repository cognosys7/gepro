
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROC_ITEMDATA de la tabla PROC_ITEM
  //  Fecha           : jueves, 02 de noviembre de 2017 10:33:22 a.m.
  //  Desde el Modelo : PDM AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_PROC_ITEM', "EXEC dbo.SP_PROC_ITEM
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROC_ITEM', "EXEC dbo.SP_PROC_ITEM
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROC_ITEM', "EXEC dbo.SP_PROC_ITEM
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PROC_ITEM', "EXEC dbo.SP_PROC_ITEM
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
define('Insert_PROC_ITEM', "EXEC dbo.SP_PROC_ITEM
     @TipoAccion = 'Insert'
		,@IDE_CONVOCATORIA = ?
		,@COD_ITEM = ?
		,@COD_PROYECTO = ?
		,@DES_DEPTO_ITEM = ?
		,@DES_PROV_ITEM = ?
		,@DES_DIST_ITEM = ?
		,@DES_ITEM = ?
		,@CNT_PROPUESTAS = ?
		,@FEC_PUBLICACION = ?
		,@FEC_BUENA_PRO_INICIAL = ?
		,@FEC_BUENA_PRO_FINAL = ?
		,@FEC_APELACION = ?
		,@FEC_ADJUDICACION = ?
		,@FEC_INICIO_CONTRATO = ?
		,@FEC_TERMINO_CONTRATO = ?
		,@COD_CONTRATO = ?
		,@IMP_VAL_REFERENCIAL_ITEM = ?
		,@IMP_VAL_ADJUDICADO_ITEM = ?
		,@COD_RUC_POSTOR_GANADOR = ?
		,@DES_POSTOR_GANADOR = ?
		,@EST_PROCESO_ITEM = ?
		,@DES_OBSERVACION = ?
		,@IDE_MODO_EJECUCION = ?
		,@IDE_UNIDAD_MEDIDA = ?
		,@CNT_ITEM = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROC_ITEM', "EXEC dbo.SP_PROC_ITEM
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_CONVOCATORIA = ?
		,@COD_ITEM = ?
		,@COD_PROYECTO = ?
		,@DES_DEPTO_ITEM = ?
		,@DES_PROV_ITEM = ?
		,@DES_DIST_ITEM = ?
		,@DES_ITEM = ?
		,@CNT_PROPUESTAS = ?
		,@FEC_PUBLICACION = ?
		,@FEC_BUENA_PRO_INICIAL = ?
		,@FEC_BUENA_PRO_FINAL = ?
		,@FEC_APELACION = ?
		,@FEC_ADJUDICACION = ?
		,@FEC_INICIO_CONTRATO = ?
		,@FEC_TERMINO_CONTRATO = ?
		,@COD_CONTRATO = ?
		,@IMP_VAL_REFERENCIAL_ITEM = ?
		,@IMP_VAL_ADJUDICADO_ITEM = ?
		,@COD_RUC_POSTOR_GANADOR = ?
		,@DES_POSTOR_GANADOR = ?
		,@EST_PROCESO_ITEM = ?
		,@DES_OBSERVACION = ?
		,@IDE_MODO_EJECUCION = ?
		,@IDE_UNIDAD_MEDIDA = ?
		,@CNT_ITEM = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_PROC_ITEM', "EXEC dbo.SP_PROC_ITEM
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

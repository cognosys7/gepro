
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROCESODATA de la tabla PROCESO
  //  Fecha           : jueves, 2 de noviembre de 2017 23:26:22
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_PROCESO', "EXEC dbo.SP_PROCESO
     @TipoAccion= 'Count'
    ,@filtro = ?
    ,@pUsuario = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROCESO', "EXEC dbo.SP_PROCESO
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROCESO', "EXEC dbo.SP_PROCESO
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PROCESO', "EXEC dbo.SP_PROCESO
     @TipoAccion= 'SelGrd'
    ,@rp = ?
    ,@sortname = ?
    ,@sortorder = ?
    ,@page = ?
    ,@filtro = ?
    ,@pUsuario = ?
    ,@codigoMensaje = ?
    ,@Mensaje = ?
    ,@nTotal = ?
"
);


//Seleccionar Datos para Grilla Busqueda
define('SelGrd_PROCESO_busqueda', "EXEC dbo.SP_PROCESO
     @TipoAccion= 'SelGrd_busqueda'
    ,@rp = ?
    ,@sortname = ?
    ,@sortorder = ?
    ,@page = ?
    ,@filtro = ?
    ,@pUsuario = ?
    ,@codigoMensaje = ?
    ,@Mensaje = ?
    ,@nTotal = ?
"
);





//MANTENIMIENTO
define('Insert_PROCESO', "EXEC dbo.SP_PROCESO
     @TipoAccion = 'Insert'
                ,@pCodigo = ?    
		,@IDE_TIPO_PROC = ?
		,@IDE_PLAN = ?
		,@IDE_ENTIDAD_EJECUTORA = ?
		
		,@IDE_CENCOSTO = ?
		,@COD_PAC = ?
		
                ,@DES_DEPTO_EJECUTORA = ?
		,@DES_PROV_EJECUTORA = ?
		,@DES_DIST_EJECUTORA = ?
		,@NUM_ANO_EJE = ?
		,@NUM_PROC_ESPECIFICO = ?
		,@DES_OBJETO = ?
		,@TIP_OBJETO = ?
		,@IMP_VAL_REFERENCIAL = ?
		,@DES_URL_PROCESO = ?
		,@EST_PROCESO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROCESO', "EXEC dbo.SP_PROCESO
     @TipoAccion = 'Update'
    ,@pCodigo = ?
	
	,@IDE_CONVOCATORIA = ?
		,@IDE_TIPO_PROC = ?
		,@IDE_PLAN = ?
		,@IDE_ENTIDAD_EJECUTORA = ?
		
		,@IDE_CENCOSTO = ?
		,@COD_PAC = ?
		
                ,@DES_DEPTO_EJECUTORA = ?
		,@DES_PROV_EJECUTORA = ?
		,@DES_DIST_EJECUTORA = ?
		,@NUM_ANO_EJE = ?
		,@NUM_PROC_ESPECIFICO = ?
		,@DES_OBJETO = ?
		,@TIP_OBJETO = ?
		,@IMP_VAL_REFERENCIAL = ?
		,@DES_URL_PROCESO = ?
		,@EST_PROCESO = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_PROCESO', "EXEC dbo.SP_PROCESO
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

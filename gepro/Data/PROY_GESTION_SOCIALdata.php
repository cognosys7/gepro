
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROY_GESTION_SOCIALDATA de la tabla PROY_GESTION_SOCIAL
  //  Fecha           : domingo, 26 de mayo de 2019 4:35:47
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-G
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_PROY_GESTION_SOCIAL', "EXEC dbo.SP_PROY_GESTION_SOCIAL
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROY_GESTION_SOCIAL', "EXEC dbo.SP_PROY_GESTION_SOCIAL
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROY_GESTION_SOCIAL', "EXEC dbo.SP_PROY_GESTION_SOCIAL
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PROY_GESTION_SOCIAL', "EXEC dbo.SP_PROY_GESTION_SOCIAL
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
define('SelGrd_PROY_GESTION_SOCIAL_busqueda', "EXEC dbo.SP_PROY_GESTION_SOCIAL
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
define('Insert_PROY_GESTION_SOCIAL', "EXEC dbo.SP_PROY_GESTION_SOCIAL
     @TipoAccion = 'Insert'
		,@IDE_PROYECTO = ?
		,@IDE_COMUNIDAD = ?
		,@IDE_ETAPA_CONTRATO = ?
		,@NUM_BENEFICIARIOS = ?
		,@TIP_UNIDAD_BENEFICIARIO = ?
		,@DES_UNIDAD_BENEFICIARIO = ?
		,@EST_MATRIZ_RC = ?
		,@EST_ACTA_APROBACION = ?
		,@EST_GESTION_SOCIAL = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROY_GESTION_SOCIAL', "EXEC dbo.SP_PROY_GESTION_SOCIAL
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_PROYECTO = ?
		,@IDE_COMUNIDAD = ?
		,@IDE_ETAPA_CONTRATO = ?
		,@NUM_BENEFICIARIOS = ?
		,@TIP_UNIDAD_BENEFICIARIO = ?
		,@DES_UNIDAD_BENEFICIARIO = ?
		,@EST_MATRIZ_RC = ?
		,@EST_ACTA_APROBACION = ?
		,@EST_GESTION_SOCIAL = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_PROY_GESTION_SOCIAL', "EXEC dbo.SP_PROY_GESTION_SOCIAL
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

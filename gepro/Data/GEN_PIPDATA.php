
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_PIPDATA de la tabla GEN_PIP
  //  Fecha           : lunes, 24 de septiembre de 2018 10:38:34
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_GEN_PIP', "EXEC dbo.SP_GEN_PIP
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_GEN_PIP', "EXEC dbo.SP_GEN_PIP
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_GEN_PIP', "EXEC dbo.SP_GEN_PIP
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_GEN_PIP', "EXEC dbo.SP_GEN_PIP
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

//Seleccionar Datos para Grilla
define('SelGrd_GEN_PIP_busqueda', "EXEC dbo.SP_GEN_PIP
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
define('Insert_GEN_PIP', "EXEC dbo.SP_GEN_PIP
     @TipoAccion = 'Insert'
		,@COD_SNIP = ?
		,@COD_UNICO = ?
		,@COD_PROYECTO = ?
		,@DES_PIP = ?
		,@FEC_REGISTRO = ?
		,@FEC_VIABILIDAD = ?
		,@IMP_MONTO_VIABLE = ?
		,@DES_FUNCION = ?
		,@DES_PROGRAMA = ?
		,@DES_SUBPROGRAMA = ?
		,@DES_NIVEL = ?
		,@DES_SECTOR = ?
		,@DES_PLIEGO = ?
		,@DES_UNIDAD_EJECUTORA = ?
		,@DES_RESPONSABLE_VIABLE = ?
		,@IMP_MONTO_F15 = ?
		,@IMP_MONTO_F16 = ?
		,@IMP_COSTO_ACTUALIZADO = ?
		,@NUM_BENEFICIARIOS = ?
		,@EST_INVIERTE = ?
		,@TIP_PIP = ?
		,@TIP_PIP_CODIGO = ?
		,@EST_PIP = ?
		,@DES_OBSERVACION = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_GEN_PIP', "EXEC dbo.SP_GEN_PIP
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@COD_SNIP = ?
		,@COD_UNICO = ?
		,@COD_PROYECTO = ?
		,@DES_PIP = ?
		,@FEC_REGISTRO = ?
		,@FEC_VIABILIDAD = ?
		,@IMP_MONTO_VIABLE = ?
		,@DES_FUNCION = ?
		,@DES_PROGRAMA = ?
		,@DES_SUBPROGRAMA = ?
		,@DES_NIVEL = ?
		,@DES_SECTOR = ?
		,@DES_PLIEGO = ?
		,@DES_UNIDAD_EJECUTORA = ?
		,@DES_RESPONSABLE_VIABLE = ?
		,@IMP_MONTO_F15 = ?
		,@IMP_MONTO_F16 = ?
		,@IMP_COSTO_ACTUALIZADO = ?
		,@NUM_BENEFICIARIOS = ?
		,@EST_INVIERTE = ?
		,@TIP_PIP = ?
		,@TIP_PIP_CODIGO = ?
		,@EST_PIP = ?
		,@DES_OBSERVACION = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_GEN_PIP', "EXEC dbo.SP_GEN_PIP
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

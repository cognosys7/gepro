
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : CONTRATODATA de la tabla CONTRATO
  //  Fecha           : miércoles, 8 de mayo de 2019 13:16:39
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-E
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_CONTRATO', "EXEC dbo.SP_CONTRATO
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_CONTRATO', "EXEC dbo.SP_CONTRATO
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_CONTRATO', "EXEC dbo.SP_CONTRATO
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_CONTRATO', "EXEC dbo.SP_CONTRATO
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

/*EDGAR*/
//Seleccionar Datos para Grilla
define('SelGrd_CONTRATO_busqueda', "EXEC dbo.SP_CONTRATO
     @TipoAccion= 'SelGrd_buscador'
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
/*EDGAR*/


//MANTENIMIENTO
define('Insert_CONTRATO', "EXEC dbo.SP_CONTRATO
     @TipoAccion = 'Insert'
		,@IDE_PROVEEDOR = ?
		,@IDE_ADM_CONTRATO = ?
		,@COD_CONTRATO = ?
		,@COD_CONTRATO_ENTIDAD = ?
		,@COD_CONTRATO_SUP = ?
		,@DES_CONTRATO = ?
		,@TIP_CONTRATO = ?
		,@FEC_CONTRATO = ?
		,@FEC_INICIO_CONTRATO = ?
		,@FEC_TERMINO_CONTRATO = ?
		,@FEC_CIERRE_CONTRATO = ?
		,@IMP_IMPONIBLE = ?
		,@IMP_IMPUESTOS = ?
		,@IMP_TOTAL = ?
		,@IMG_CONTRATO = ?
		,@DES_COMENTARIO = ?
		,@EST_CONTRATO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_CONTRATO', "EXEC dbo.SP_CONTRATO
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_PROVEEDOR = ?
		,@IDE_ADM_CONTRATO = ?
		,@COD_CONTRATO = ?
		,@COD_CONTRATO_ENTIDAD = ?
		,@COD_CONTRATO_SUP = ?
		,@DES_CONTRATO = ?
		,@TIP_CONTRATO = ?
		,@FEC_CONTRATO = ?
		,@FEC_INICIO_CONTRATO = ?
		,@FEC_TERMINO_CONTRATO = ?
		,@FEC_CIERRE_CONTRATO = ?
		,@IMP_IMPONIBLE = ?
		,@IMP_IMPUESTOS = ?
		,@IMP_TOTAL = ?
		,@IMG_CONTRATO = ?
		,@DES_COMENTARIO = ?
		,@EST_CONTRATO = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_CONTRATO', "EXEC dbo.SP_CONTRATO
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

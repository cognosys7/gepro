
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_CENTRO_COSTODATA de la tabla GEN_CENTRO_COSTO
  //  Fecha           : domingo, 5 de mayo de 2019 10:39:22
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-D
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_GEN_CENTRO_COSTO', "EXEC dbo.SP_GEN_CENTRO_COSTO
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_GEN_CENTRO_COSTO', "EXEC dbo.SP_GEN_CENTRO_COSTO
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_GEN_CENTRO_COSTO', "EXEC dbo.SP_GEN_CENTRO_COSTO
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_GEN_CENTRO_COSTO', "EXEC dbo.SP_GEN_CENTRO_COSTO
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
define('Insert_GEN_CENTRO_COSTO', "EXEC dbo.SP_GEN_CENTRO_COSTO
     @TipoAccion = 'Insert'
		,@COD_CENCOSTO = ?
		,@DES_CENCOSTO = ?
		,@EST_CENCOSTO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_GEN_CENTRO_COSTO', "EXEC dbo.SP_GEN_CENTRO_COSTO
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@COD_CENCOSTO = ?
		,@DES_CENCOSTO = ?
		,@EST_CENCOSTO = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_GEN_CENTRO_COSTO', "EXEC dbo.SP_GEN_CENTRO_COSTO
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

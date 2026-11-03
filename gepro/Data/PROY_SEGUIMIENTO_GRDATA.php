
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROY_SEGUIMIENTO_GRDATA de la tabla PROY_SEGUIMIENTO_GR
  //  Fecha           : domingo, 16 de setiembre de 2018 01:28:27
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_PROY_SEGUIMIENTO_GR', "EXEC dbo.SP_PROY_SEGUIMIENTO_GR
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROY_SEGUIMIENTO_GR', "EXEC dbo.SP_PROY_SEGUIMIENTO_GR
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROY_SEGUIMIENTO_GR', "EXEC dbo.SP_PROY_SEGUIMIENTO_GR
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PROY_SEGUIMIENTO_GR', "EXEC dbo.SP_PROY_SEGUIMIENTO_GR
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
define('Insert_PROY_SEGUIMIENTO_GR', "EXEC dbo.SP_PROY_SEGUIMIENTO_GR
     @TipoAccion = 'Insert'
		,@IDE_PROYECTO_ACTIVIDAD = ?
		,@DES_ADVERTENCIA = ?
		,@DES_MEDIDA = ?
		,@FEC_SEGUIMIENTO = ?
		,@EST_PROY_SEGUIMIENTO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROY_SEGUIMIENTO_GR', "EXEC dbo.SP_PROY_SEGUIMIENTO_GR
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_PROYECTO_ACTIVIDAD = ?
		,@DES_ADVERTENCIA = ?
		,@DES_MEDIDA = ?
		,@FEC_SEGUIMIENTO = ?
		,@EST_PROY_SEGUIMIENTO = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_PROY_SEGUIMIENTO_GR', "EXEC dbo.SP_PROY_SEGUIMIENTO_GR
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

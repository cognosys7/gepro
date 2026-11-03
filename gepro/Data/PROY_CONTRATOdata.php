
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROY_CONTRATODATA de la tabla PROY_CONTRATO
  //  Fecha           : jueves, 9 de mayo de 2019 3:26:09
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-E
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_PROY_CONTRATO', "EXEC dbo.SP_PROY_CONTRATO
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROY_CONTRATO', "EXEC dbo.SP_PROY_CONTRATO
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROY_CONTRATO', "EXEC dbo.SP_PROY_CONTRATO
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PROY_CONTRATO', "EXEC dbo.SP_PROY_CONTRATO
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
define('Insert_PROY_CONTRATO', "EXEC dbo.SP_PROY_CONTRATO
     @TipoAccion = 'Insert'
		,@IDE_PROYECTO = ?
		,@IDE_PROYECTO_ACTIVIDAD = ?
		,@IDE_CONTRATO = ?
		,@EST_PROY_CONTRATO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROY_CONTRATO', "EXEC dbo.SP_PROY_CONTRATO
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_PROYECTO = ?
		,@IDE_PROYECTO_ACTIVIDAD = ?
		,@IDE_CONTRATO = ?
		,@EST_PROY_CONTRATO = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_PROY_CONTRATO', "EXEC dbo.SP_PROY_CONTRATO
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

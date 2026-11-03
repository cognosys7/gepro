
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_PROGRAMA_PROYECTODATA de la tabla GEN_PROGRAMA_PROYECTO
  //  Fecha           : sábado, 11 de mayo de 2019 22:10:56
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-E
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_GEN_PROGRAMA_PROYECTO', "EXEC dbo.SP_GEN_PROGRAMA_PROYECTO
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_GEN_PROGRAMA_PROYECTO', "EXEC dbo.SP_GEN_PROGRAMA_PROYECTO
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_GEN_PROGRAMA_PROYECTO', "EXEC dbo.SP_GEN_PROGRAMA_PROYECTO
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_GEN_PROGRAMA_PROYECTO', "EXEC dbo.SP_GEN_PROGRAMA_PROYECTO
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
define('Insert_GEN_PROGRAMA_PROYECTO', "EXEC dbo.SP_GEN_PROGRAMA_PROYECTO
     @TipoAccion = 'Insert'
		,@DES_PROGRAMA = ?
		,@EST_PROGRAMA = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_GEN_PROGRAMA_PROYECTO', "EXEC dbo.SP_GEN_PROGRAMA_PROYECTO
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@DES_PROGRAMA = ?
		,@EST_PROGRAMA = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_GEN_PROGRAMA_PROYECTO', "EXEC dbo.SP_GEN_PROGRAMA_PROYECTO
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

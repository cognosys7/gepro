
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_PORTAFOLIO_PROYECTODATA de la tabla GEN_PORTAFOLIO_PROYECTO
  //  Fecha           : sábado, 25 de mayo de 2019 1:07:20
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-G
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_GEN_PORTAFOLIO_PROYECTO', "EXEC dbo.SP_GEN_PORTAFOLIO_PROYECTO
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_GEN_PORTAFOLIO_PROYECTO', "EXEC dbo.SP_GEN_PORTAFOLIO_PROYECTO
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_GEN_PORTAFOLIO_PROYECTO', "EXEC dbo.SP_GEN_PORTAFOLIO_PROYECTO
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_GEN_PORTAFOLIO_PROYECTO', "EXEC dbo.SP_GEN_PORTAFOLIO_PROYECTO
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
define('SelGrd_GEN_PORTAFOLIO_PROYECTO_busqueda', "EXEC dbo.SP_GEN_PORTAFOLIO_PROYECTO
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
define('Insert_GEN_PORTAFOLIO_PROYECTO', "EXEC dbo.SP_GEN_PORTAFOLIO_PROYECTO
     @TipoAccion = 'Insert'
		,@DES_PORTAFOLIO = ?
		,@TIP_GRUPO_PORTAFOLIO = ?
		,@EST_PORTAFOLIO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_GEN_PORTAFOLIO_PROYECTO', "EXEC dbo.SP_GEN_PORTAFOLIO_PROYECTO
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@DES_PORTAFOLIO = ?
		,@TIP_GRUPO_PORTAFOLIO = ?
		,@EST_PORTAFOLIO = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_GEN_PORTAFOLIO_PROYECTO', "EXEC dbo.SP_GEN_PORTAFOLIO_PROYECTO
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

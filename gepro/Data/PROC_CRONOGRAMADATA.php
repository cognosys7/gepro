
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Hector Lopez Sanchez
  //  Propósito       : PROC_CRONOGRAMADATA de la tabla PROC_CRONOGRAMA
  //  Fecha           : miércoles, 1 de noviembre de 2017 20:55:33
  //  Desde el Modelo : PDM AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_PROC_CRONOGRAMA', "EXEC dbo.SP_PROC_CRONOGRAMA
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROC_CRONOGRAMA', "EXEC dbo.SP_PROC_CRONOGRAMA
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROC_CRONOGRAMA', "EXEC dbo.SP_PROC_CRONOGRAMA
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PROC_CRONOGRAMA', "EXEC dbo.SP_PROC_CRONOGRAMA
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
define('Insert_PROC_CRONOGRAMA', "EXEC dbo.SP_PROC_CRONOGRAMA
     @TipoAccion = 'Insert'
		,@IDE_CONVOCATORIA = ?
		,@NUM_CONVOCATORIA = ?
		,@IDE_ORDEN = ?
		,@FEC_PUBLICACION = ?
		,@DES_ACTIVIDAD = ?
		,@FEC_INICIO = ?
		,@FEC_TERMINO = ?
		,@EST_PROC_CRONOGRAMA = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROC_CRONOGRAMA', "EXEC dbo.SP_PROC_CRONOGRAMA
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_CONVOCATORIA = ?
		,@NUM_CONVOCATORIA = ?
		,@IDE_ORDEN = ?
		,@FEC_PUBLICACION = ?
		,@DES_ACTIVIDAD = ?
		,@FEC_INICIO = ?
		,@FEC_TERMINO = ?
		,@EST_PROC_CRONOGRAMA = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_PROC_CRONOGRAMA', "EXEC dbo.SP_PROC_CRONOGRAMA
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

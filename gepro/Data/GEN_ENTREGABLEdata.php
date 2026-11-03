<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : GEN_ENTREGABLEDATA de la tabla GEN_ENTREGABLE
  //  Fecha           : martes, 4 de junio de 2019 20:06:50
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-J
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_GEN_ENTREGABLE', "EXEC dbo.SP_GEN_ENTREGABLE
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_GEN_ENTREGABLE', "EXEC dbo.SP_GEN_ENTREGABLE
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_GEN_ENTREGABLE', "EXEC dbo.SP_GEN_ENTREGABLE
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_GEN_ENTREGABLE', "EXEC dbo.SP_GEN_ENTREGABLE
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
define('SelGrd_GEN_ENTREGABLE_busqueda', "EXEC dbo.SP_GEN_ENTREGABLE
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


//Seleccionar Datos para Grilla Busqueda
define('SelGrd_GEN_ENTREGABLE_pAuxiliar', "EXEC dbo.SP_GEN_ENTREGABLE
     @TipoAccion= 'SelGrd'
    ,@rp = ?
    ,@sortname = ?
    ,@sortorder = ?
    ,@page = ?
    ,@filtro = ?
    ,@codigoMensaje = ?
    ,@Mensaje = ?
    ,@nTotal = ?
    ,@pAuxiliar='Anidado'
"
);


//MANTENIMIENTO
define('Insert_GEN_ENTREGABLE', "EXEC dbo.SP_GEN_ENTREGABLE
     @TipoAccion = 'Insert'
		,@IDE_FASE_COMPONENTE = ?
		,@GEN_IDE_ENTREGABLE = ?
		,@DES_ENTREGABLE = ?
		,@DES_ABREVIATURA = ?
		,@NUM_NIVEL = ?
		,@NUM_ORDEN = ?
		,@EST_ENTREGABLE = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_GEN_ENTREGABLE', "EXEC dbo.SP_GEN_ENTREGABLE
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_FASE_COMPONENTE = ?
		,@GEN_IDE_ENTREGABLE = ?
		,@DES_ENTREGABLE = ?
		,@DES_ABREVIATURA = ?
		,@NUM_NIVEL = ?
		,@NUM_ORDEN = ?
		,@EST_ENTREGABLE = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_GEN_ENTREGABLE', "EXEC dbo.SP_GEN_ENTREGABLE
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : PROY_GESTION_QUEJASDATA de la tabla PROY_GESTION_QUEJAS
  //  Fecha           : domingo, 26 de mayo de 2019 19:51:43
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-G
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_PROY_GESTION_QUEJAS', "EXEC dbo.SP_PROY_GESTION_QUEJAS
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROY_GESTION_QUEJAS', "EXEC dbo.SP_PROY_GESTION_QUEJAS
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROY_GESTION_QUEJAS', "EXEC dbo.SP_PROY_GESTION_QUEJAS
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PROY_GESTION_QUEJAS', "EXEC dbo.SP_PROY_GESTION_QUEJAS
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
define('SelGrd_PROY_GESTION_QUEJAS_busqueda', "EXEC dbo.SP_PROY_GESTION_QUEJAS
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
define('Insert_PROY_GESTION_QUEJAS', "EXEC dbo.SP_PROY_GESTION_QUEJAS
     @TipoAccion = 'Insert'
		,@IDE_GESTION_SOCIAL = ?
		,@DES_QUEJA = ?
		,@TIP_IMPACTO = ?
		,@TIP_CANALIZA = ?
		,@IDE_CENCOSTO_ASIGNADO = ?
                ,@IDE_CONT_INTERESADO = ?
		,@FEC_QUEJA = ?
		,@EST_ATENDIDO = ?
		,@FEC_ATENDIDO = ?
                ,@DES_RESPUESTA = ?
		,@EST_QUEJA = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROY_GESTION_QUEJAS', "EXEC dbo.SP_PROY_GESTION_QUEJAS
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_GESTION_SOCIAL = ?
		,@DES_QUEJA = ?
		,@TIP_IMPACTO = ?
		,@TIP_CANALIZA = ?
		,@IDE_CENCOSTO_ASIGNADO = ?
                ,@IDE_CONT_INTERESADO = ?
		,@FEC_QUEJA = ?
		,@EST_ATENDIDO = ?
		,@FEC_ATENDIDO = ?
                ,@DES_RESPUESTA = ?
		,@EST_QUEJA = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_PROY_GESTION_QUEJAS', "EXEC dbo.SP_PROY_GESTION_QUEJAS
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

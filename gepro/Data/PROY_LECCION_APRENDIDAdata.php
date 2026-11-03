<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : PROY_LECCION_APRENDIDADATA de la tabla PROY_LECCION_APRENDIDA
  //  Fecha           : lunes, 3 de junio de 2019 8:23:58
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-J
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_PROY_LECCION_APRENDIDA', "EXEC dbo.SP_PROY_LECCION_APRENDIDA
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROY_LECCION_APRENDIDA', "EXEC dbo.SP_PROY_LECCION_APRENDIDA
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROY_LECCION_APRENDIDA', "EXEC dbo.SP_PROY_LECCION_APRENDIDA
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PROY_LECCION_APRENDIDA', "EXEC dbo.SP_PROY_LECCION_APRENDIDA
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
define('SelGrd_PROY_LECCION_APRENDIDA_busqueda', "EXEC dbo.SP_PROY_LECCION_APRENDIDA
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
define('Insert_PROY_LECCION_APRENDIDA', "EXEC dbo.SP_PROY_LECCION_APRENDIDA
     @TipoAccion = 'Insert'
		,@IDE_PROYECTO = ?
		,@IDE_FASE_COMPONENTE = ?
		,@COD_LECCION_APRENDIDA = ?
		,@TIP_LECCION = ?
		,@IDE_TIPO_RIESGO = ?
		,@DES_LECCION_APRENDIDA = ?
                ,@DES_RIESGO = ?
		,@TIP_IMPACTO_SITUACION = ?
		,@DES_RECOMENDACION = ?
		,@DES_ACCION_PROPUESTA = ?
		,@FEC_LECCION = ?
		,@EST_LECCION = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROY_LECCION_APRENDIDA', "EXEC dbo.SP_PROY_LECCION_APRENDIDA
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_PROYECTO = ?
		,@IDE_FASE_COMPONENTE = ?
		,@COD_LECCION_APRENDIDA = ?
		,@TIP_LECCION = ?
		,@IDE_TIPO_RIESGO = ?
		,@DES_LECCION_APRENDIDA = ?
                ,@DES_RIESGO = ?
		,@TIP_IMPACTO_SITUACION = ?
		,@DES_RECOMENDACION = ?
		,@DES_ACCION_PROPUESTA = ?
		,@FEC_LECCION = ?
		,@EST_LECCION = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_PROY_LECCION_APRENDIDA', "EXEC dbo.SP_PROY_LECCION_APRENDIDA
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

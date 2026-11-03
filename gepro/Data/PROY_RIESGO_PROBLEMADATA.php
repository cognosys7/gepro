
<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION.NET
//  Empresa         : www.cognosys.com.pe
//  Autores         : Julio Cesar Meza Yangali - mezayangali@gmail.com - 
//                    Edgar David Pisfil Ahumada                    
//  Prop�sito       : PROY_RIESGO_PROBLEMADATA de la tabla PROY_RIESGO_PROBLEMA
//  Fecha           : lunes, 6 de noviembre de 2017 11:24:29
//  Desde el Modelo : RCC
//  Modificado      : 16 de Octubre 2017
//
//******************************************************************************/

//Seleccionar count
define('Count_PROY_RIESGO_PROBLEMA',
"EXEC dbo.SP_PROY_RIESGO_PROBLEMA
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROY_RIESGO_PROBLEMA',
"EXEC dbo.SP_PROY_RIESGO_PROBLEMA
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"   
);

//Seleccionar Registros Por Condici�n Generada Por el Usuario
define('SelCampos_PROY_RIESGO_PROBLEMA',
"EXEC dbo.SP_PROY_RIESGO_PROBLEMA
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PROY_RIESGO_PROBLEMA',
"EXEC dbo.SP_PROY_RIESGO_PROBLEMA
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
define('Insert_PROY_RIESGO_PROBLEMA',
"EXEC dbo.SP_PROY_RIESGO_PROBLEMA
     @TipoAccion = 'Insert'
		,@IDE_PROYECTO_ACTIVIDAD = ?
		,@IDE_PROC_ITEM = ?
		,@IDE_TIPO_RIESGO_PROB = ?
		,@TIP_RIESGO_PROB = ?
		,@DES_NOMBRE = ?
		,@DES_DETALLE = ?
		,@IDE_IMPACTO = ?
		,@IDE_PROBABILIDAD = ?
		,@IDE_PRIORIDAD = ?
		,@DES_CAUSA_PROBLEMA = ?
		,@DES_CONSECUENCIA_RIESGO = ?
		,@DES_SOLUCION = ?
		,@FEC_INICIO_SOLUCION = ?
		,@FEC_TERMINO_SOLUCION = ?
		,@EST_RIESGO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROY_RIESGO_PROBLEMA',
"EXEC dbo.SP_PROY_RIESGO_PROBLEMA
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_PROYECTO_ACTIVIDAD = ?
		,@IDE_PROC_ITEM = ?
		,@IDE_TIPO_RIESGO_PROB = ?
		,@TIP_RIESGO_PROB = ?
		,@DES_NOMBRE = ?
		,@DES_DETALLE = ?
		,@IDE_IMPACTO = ?
		,@IDE_PROBABILIDAD = ?
		,@IDE_PRIORIDAD = ?
		,@DES_CAUSA_PROBLEMA = ?
		,@DES_CONSECUENCIA_RIESGO = ?
		,@DES_SOLUCION = ?
		,@FEC_INICIO_SOLUCION = ?
		,@FEC_TERMINO_SOLUCION = ?
		,@EST_RIESGO = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);        

define('Delete_PROY_RIESGO_PROBLEMA',
"EXEC dbo.SP_PROY_RIESGO_PROBLEMA
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

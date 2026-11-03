<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION.NET
//  Empresa			  : www.cognosys.com.pe
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Edgar David Pisfil Ahumada                    
//  Propósito       : PROY_COMUNICACIONDATA de la tabla PROY_COMUNICACION
//  Fecha           : viernes, 28 de junio de 2019 20:22:48
//  Desde el Modelo : PDM - AMSAC - AJUSTADO
//  Modificado      : 29 de Junio 2019
//
//******************************************************************************/

//Seleccionar count
define('Count_PROY_COMUNICACION',
"EXEC dbo.SP_PROY_COMUNICACION
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROY_COMUNICACION',
"EXEC dbo.SP_PROY_COMUNICACION
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"   
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROY_COMUNICACION',
"EXEC dbo.SP_PROY_COMUNICACION
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PROY_COMUNICACION',
"EXEC dbo.SP_PROY_COMUNICACION
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
define('Insert_PROY_COMUNICACION',
"EXEC dbo.SP_PROY_COMUNICACION
     @TipoAccion = 'Insert'
		,@IDE_PROYECTO = ?
		,@DES_COMUNICACION = ?
		,@FEC_INICIO = ?
		,@FEC_TERMINO = ?
		,@TIP_DIRECCION_EMISOR_RECEPTOR = ?
		,@TIP_FRECUENCIA = ?
		,@TIP_COMPLEJIDAD_COMUNICACION = ?
		,@TIP_METODO_COMUNICACION = ?
		,@TIP_MEDIO_COMUNICACION = ?
		,@DES_GLOSARIO_TERMINOS = ?
		,@EST_COMUNICACION = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROY_COMUNICACION',
"EXEC dbo.SP_PROY_COMUNICACION
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_PROYECTO = ?
		,@DES_COMUNICACION = ?
		,@FEC_INICIO = ?
		,@FEC_TERMINO = ?
		,@TIP_DIRECCION_EMISOR_RECEPTOR = ?
		,@TIP_FRECUENCIA = ?
		,@TIP_COMPLEJIDAD_COMUNICACION = ?
		,@TIP_METODO_COMUNICACION = ?
		,@TIP_MEDIO_COMUNICACION = ?
		,@DES_GLOSARIO_TERMINOS = ?
		,@EST_COMUNICACION = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);        

define('Delete_PROY_COMUNICACION',
"EXEC dbo.SP_PROY_COMUNICACION
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);
<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : SISTEMA DE GESTION DE PROYECTOS
//  Empresa	    : ACTIVOS MINEROS S.A.C.
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
//                    Ing. Edgar David Pisfil Ahumada                   
//  Propósito       : BIDM_GASTO_CONSOLIDAdata de la tabla BIDM_GASTO_CONSOLIDA
//  Fecha           : martes, 25 de mayo de 2021 14:13:37
//  Desde el Modelo : PDM - Modelo Físico de Datos - SGPAM
//  Modificado      : martes, 25 de mayo de 2021 14:13:37
//******************************************************************************/


//Seleccionar count
define('Count_BIDM_GASTO_CONSOLIDA', "EXEC dbo.SP_BIDM_GASTO_CONSOLIDA
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_BIDM_GASTO_CONSOLIDA', "EXEC dbo.SP_BIDM_GASTO_CONSOLIDA
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);


//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_BIDM_GASTO_CONSOLIDA', "EXEC dbo.SP_BIDM_GASTO_CONSOLIDA
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);


//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_sumMonto_BIDM_GASTO_CONSOLIDA', "EXEC dbo.SP_BIDM_GASTO_CONSOLIDA
     @TipoAccion= 'SelCampos_sumMonto'
	,@campos = ?
    ,@filtro = ?"
);


//Seleccionar Datos para Grilla
define('SelGrd_BIDM_GASTO_CONSOLIDA', "EXEC dbo.SP_BIDM_GASTO_CONSOLIDA
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
define('Insert_BIDM_GASTO_CONSOLIDA', "EXEC dbo.SP_BIDM_GASTO_CONSOLIDA
     @TipoAccion = 'Insert'
		,@AsientoIde = ?
		,@AsientoNumDocumento = ?
		,@AsientoAnio = ?
		,@AsientoPeriodo = ?
		,@CencoCodigo = ?
		,@CencoNombre = ?
		,@ContratoOrden = ?
		,@OrdenCodigo = ?
		,@ActorDocumento = ?
		,@ActorNombre = ?
		,@ProyectoCodigo = ?
		,@ProyectoNombreCorto = ?
		,@ProyGrupoCodigo = ?
		,@CtaCodigo = ?
		,@CtaNomPartida = ?
		,@CtaNomClase = ?
		,@CtaNombre = ?
		,@FuenteAbrev = ?
		,@AsientoMontoSoles = ?
		,@Fase = ?
		,@Componente = ?
		,@EST_BIDM_GASTO_CONSOLIDA = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_BIDM_GASTO_CONSOLIDA', "EXEC dbo.SP_BIDM_GASTO_CONSOLIDA
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@AsientoIde = ?
		,@AsientoNumDocumento = ?
		,@AsientoAnio = ?
		,@AsientoPeriodo = ?
		,@CencoCodigo = ?
		,@CencoNombre = ?
		,@ContratoOrden = ?
		,@OrdenCodigo = ?
		,@ActorDocumento = ?
		,@ActorNombre = ?
		,@ProyectoCodigo = ?
		,@ProyectoNombreCorto = ?
		,@ProyGrupoCodigo = ?
		,@CtaCodigo = ?
		,@CtaNomPartida = ?
		,@CtaNomClase = ?
		,@CtaNombre = ?
		,@FuenteAbrev = ?
		,@AsientoMontoSoles = ?
		,@Fase = ?
		,@Componente = ?
		,@EST_BIDM_GASTO_CONSOLIDA = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);


define('Delete_BIDM_GASTO_CONSOLIDA', "EXEC dbo.SP_BIDM_GASTO_CONSOLIDA
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

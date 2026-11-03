
<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION.NET
//  Empresa			  : www.cognosys.com.pe
//  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Hector Lopez Sanchez                    
//  Propósito       : DATA de la tabla TGUBIGEO
//  Fecha           : lunes, 23 de octubre de 2017 17:08:32
//  Desde el Modelo : PDM AMSAC
//  Modificado      : 16 de Octubre 2017
//
//******************************************************************************/

//Seleccionar count
define('Count_TGUBIGEO',
"EXEC general.SP_TGUBIGEO
     @TipoAccion= 'Count'
    ,@filtro = ?"
);

/*
//Seleccionar un Registro Por Clave Primaria
define('SelPk_TGUBIGEO',
"EXEC general.SP_TGUBIGEO
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"   
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_TGUBIGEO',
"EXEC general.SP_TGUBIGEO
     @TipoAccion= 'SelCampos'
    ,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_TGUBIGEO',
"EXEC general.SP_TGUBIGEO
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
define('Insert_TGUBIGEO',
"EXEC general.SP_TGUBIGEO
     @TipoAccion = 'Insert'
		,@Ubigeo = ?,
		,@UbiDepartamento = ?,
		,@UbiProvincia = ?,
		,@UbiDistrito = ?,
		,@UbiLocalidad = ?,
		,@UbiEstado = ?,
		,@UbiUsuRegistra = ?,
		,@UbiFecRegistra = ?,
		,@UbiUsuActualiza = ?,
		,@UbiFecActualiza = ?,
		,@IdRegion = ?,
		,@Latitud = ?,
		,@Longitud = ?,
		,@est_tgubigeo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_TGUBIGEO',
"EXEC general.SP_TGUBIGEO
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@Ubigeo = ?,
		,@UbiDepartamento = ?,
		,@UbiProvincia = ?,
		,@UbiDistrito = ?,
		,@UbiLocalidad = ?,
		,@UbiEstado = ?,
		,@UbiUsuRegistra = ?,
		,@UbiFecRegistra = ?,
		,@UbiUsuActualiza = ?,
		,@UbiFecActualiza = ?,
		,@IdRegion = ?,
		,@Latitud = ?,
		,@Longitud = ?,
		,@est_tgubigeo = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);        

define('Delete_TGUBIGEO',
"EXEC general.SP_TGUBIGEO
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);
 
 */
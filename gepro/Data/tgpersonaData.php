
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : tgpersonaDATA de la tabla tgpersona
  //  Fecha           : martes, 24 de julio de 2018 08:12:19 p.m.
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_tgpersona', "EXEC dbo.SP_tgpersona
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_tgpersona', "EXEC dbo.SP_tgpersona
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_tgpersona', "EXEC dbo.SP_tgpersona
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

/* * *EDGAR---************* */
define('SelCampos_tgpersona2', "EXEC dbo.SP_tgpersona
     @TipoAccion= 'SelCampos2'
	,@campos = ?
    ,@filtro = ?"
);
/* * *EDGAR---************* */

//Seleccionar Datos para Grilla
define('SelGrd_tgpersona', "EXEC dbo.SP_tgpersona
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



////MANTENIMIENTO
//define('Insert_tgpersona',
//"EXEC dbo.SP_tgpersona
//     @TipoAccion = 'Insert'
//		,@IdPersona = ?
//		,@PerApePaterno = ?
//		,@PerApeMaterno = ?
//		,@PerNombres = ?
//		,@PerDocumento = ?
//		,@PerNroDocumento = ?
//		,@PerEstadoCivil = ?
//		,@PerFecNacimiento = ?
//		,@PerFecNacProbable = ?
//		,@PerNacPais = ?
//		,@PerNacUbigeo = ?
//		,@PerNacPoblado = ?
//		,@PerFecDefuncion = ?
//		,@PerDirPais = ?
//		,@PerDirUbigeo = ?
//		,@PerDirPoblado = ?
//		,@PerDireccion = ?
//		,@PerReferencia = ?
//		,@PerSexo = ?
//		,@PerTelefono = ?
//		,@PerCorreo = ?
//		,@PerEstado = ?
//		,@PerUsuRegistra = ?
//		,@PerFecRegistra = ?
//		,@PerUsuActualiza = ?
//		,@PerFecActualiza = ?
//		,@PerGradoInstruccion = ?
//		,@PerPadre = ?
//		,@PerMadre = ?
//    ,@pUsuario = ?
//    ,@pIdError  = ?
//    ,@pMensajeError  = ?"
//);
//
//
//define('Update_tgpersona',
//"EXEC dbo.SP_tgpersona
//     @TipoAccion = 'Update'
//    ,@pCodigo = ?
//		,@IdPersona = ?
//		,@PerApePaterno = ?
//		,@PerApeMaterno = ?
//		,@PerNombres = ?
//		,@PerDocumento = ?
//		,@PerNroDocumento = ?
//		,@PerEstadoCivil = ?
//		,@PerFecNacimiento = ?
//		,@PerFecNacProbable = ?
//		,@PerNacPais = ?
//		,@PerNacUbigeo = ?
//		,@PerNacPoblado = ?
//		,@PerFecDefuncion = ?
//		,@PerDirPais = ?
//		,@PerDirUbigeo = ?
//		,@PerDirPoblado = ?
//		,@PerDireccion = ?
//		,@PerReferencia = ?
//		,@PerSexo = ?
//		,@PerTelefono = ?
//		,@PerCorreo = ?
//		,@PerEstado = ?
//		,@PerUsuRegistra = ?
//		,@PerFecRegistra = ?
//		,@PerUsuActualiza = ?
//		,@PerFecActualiza = ?
//		,@PerGradoInstruccion = ?
//		,@PerPadre = ?
//		,@PerMadre = ?	
//    ,@pUsuario = ?
//    ,@pIdError  = ?
//    ,@pMensajeError = ?"
//);        
//
//define('Delete_tgpersona',
//"EXEC general.SP_tgpersona
//     @TipoAccion = 'Delete'
//    ,@pCodigo = ?
//    ,@pUsuario = ?
//    ,@pIdError  = ?
//    ,@pMensajeError = ?"
//);
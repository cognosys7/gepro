
<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION.NET
//  Empresa			  : www.cognosys.com.pe
//  Autores         : Julio C�sar Meza Yangali - mezayangali@gmail.com - 
//                    Edgar David Pisfil Ahumada                    
//  Prop�sito       : GEN_NORMATIVADATA de la tabla GEN_NORMATIVA
//  Fecha           : viernes, 5 de enero de 2018 14:30:25
//  Desde el Modelo : PDM - AMSAC
//  Modificado      : 16 de Octubre 2017
//
//******************************************************************************/

//Seleccionar count
define('Count_GEN_NORMATIVA',
"EXEC dbo.SP_GEN_NORMATIVA
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_GEN_NORMATIVA',
"EXEC dbo.SP_GEN_NORMATIVA
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"   
);

//Seleccionar Registros Por Condici�n Generada Por el Usuario
define('SelCampos_GEN_NORMATIVA',
"EXEC dbo.SP_GEN_NORMATIVA
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_GEN_NORMATIVA',
"EXEC dbo.SP_GEN_NORMATIVA
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
define('Insert_GEN_NORMATIVA',
"EXEC dbo.SP_GEN_NORMATIVA
     @TipoAccion = 'Insert'
		,@COD_NORMATIVA = ?
		,@FEC_PUBLICACION = ?
		,@IMP_NORMATIVA = ?
                ,@TIP_NORMATIVA = ?
		,@EST_NORMATIVA = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_GEN_NORMATIVA',
"EXEC dbo.SP_GEN_NORMATIVA
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@COD_NORMATIVA = ?
		,@FEC_PUBLICACION = ?
		,@IMP_NORMATIVA = ?
                ,@TIP_NORMATIVA = ?
		,@EST_NORMATIVA = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);        

define('Delete_GEN_NORMATIVA',
"EXEC dbo.SP_GEN_NORMATIVA
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

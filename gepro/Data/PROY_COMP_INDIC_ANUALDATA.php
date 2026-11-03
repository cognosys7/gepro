
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROY_COMP_INDIC_ANUALDATA de la tabla PROY_COMP_INDIC_ANUAL
  //  Fecha           : sábado, 6 de enero de 2018 22:05:41
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_PROY_COMP_INDIC_ANUAL', "EXEC dbo.SP_PROY_COMP_INDIC_ANUAL
    @TipoAccion= 'Count'        
    ,@filtro = ?
    ,@IDE_PROY_COMPONENTE = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROY_COMP_INDIC_ANUAL', "EXEC dbo.SP_PROY_COMP_INDIC_ANUAL
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROY_COMP_INDIC_ANUAL', "EXEC dbo.SP_PROY_COMP_INDIC_ANUAL
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PROY_COMP_INDIC_ANUAL', "EXEC dbo.SP_PROY_COMP_INDIC_ANUAL
     @TipoAccion= 'SelGrd'
    ,@rp = ?
    ,@sortname = ?
    ,@sortorder = ?
    ,@page = ?
    ,@filtro = ?
    ,@IDE_PROY_COMPONENTE = ?
    ,@codigoMensaje = ?
    ,@Mensaje = ?
    ,@nTotal = ?
"
);



//MANTENIMIENTO
define('Insert_PROY_COMP_INDIC_ANUAL', "EXEC dbo.SP_PROY_COMP_INDIC_ANUAL
    @TipoAccion = 'Insert'
    ,@IDE_PROY_COMPONENTE=?
    ,@IDE_COMPONENTE_PLAN = ?
    ,@IDE_INDICADOR = ?
    ,@IDE_COMP_ACTIVIDAD = ?
    ,@COD_ANHO = ?
    ,@NUM_VALOR = ?
    ,@EST_COMP_INDIC_ANUAL = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROY_COMP_INDIC_ANUAL', "EXEC dbo.SP_PROY_COMP_INDIC_ANUAL
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_COMPONENTE_PLAN = ?
		,@IDE_INDICADOR = ?
		,@IDE_COMP_ACTIVIDAD = ?
		,@COD_ANHO = ?
		,@NUM_VALOR = ?
		,@EST_COMP_INDIC_ANUAL = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_PROY_COMP_INDIC_ANUAL', "EXEC dbo.SP_PROY_COMP_INDIC_ANUAL
     @TipoAccion = 'Delete'
    ,@IDE_PROY_COMPONENTE= ?
    ,@IDE_INDICADOR = ?
    ,@COD_ANHO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

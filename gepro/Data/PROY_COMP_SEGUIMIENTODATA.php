
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROY_COMP_SEGUIMIENTODATA de la tabla PROY_COMP_SEGUIMIENTO
  //  Fecha           : viernes, 17 de mayo de 2019 22:48:03
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-G
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_PROY_COMP_SEGUIMIENTO', "EXEC dbo.SP_PROY_COMP_SEGUIMIENTO
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROY_COMP_SEGUIMIENTO', "EXEC dbo.SP_PROY_COMP_SEGUIMIENTO
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROY_COMP_SEGUIMIENTO', "EXEC dbo.SP_PROY_COMP_SEGUIMIENTO
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PROY_COMP_SEGUIMIENTO', "EXEC dbo.SP_PROY_COMP_SEGUIMIENTO
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
define('Insert_PROY_COMP_SEGUIMIENTO', "EXEC dbo.SP_PROY_COMP_SEGUIMIENTO
     @TipoAccion = 'Insert'
                ,@IDE_PROY_COMPONENTE = ?
		,@DES_SEGUIMIENTO = ?
		,@EST_SEGUIMIENTO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROY_COMP_SEGUIMIENTO', "EXEC dbo.SP_PROY_COMP_SEGUIMIENTO
     @TipoAccion = 'Update'
    ,@pCodigo = ?
                ,@IDE_PROY_COMPONENTE = ?
		,@DES_SEGUIMIENTO = ?
		,@EST_SEGUIMIENTO = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_PROY_COMP_SEGUIMIENTO', "EXEC dbo.SP_PROY_COMP_SEGUIMIENTO
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

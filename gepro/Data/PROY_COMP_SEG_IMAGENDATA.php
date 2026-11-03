
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Edgar David Pisfil Ahumada
  //  Propósito       : PROY_COMP_SEG_IMAGENDATA de la tabla PROY_COMP_SEG_IMAGEN
  //  Fecha           : viernes, 18 de mayo de 2018 12:03:55
  //  Desde el Modelo : PDM - AMSAC
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_PROY_COMP_SEG_IMAGEN', "EXEC dbo.SP_PROY_COMP_SEG_IMAGEN
     @TipoAccion= 'Count'
    ,@filtro = ?"
);

//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROY_COMP_SEG_IMAGEN', "EXEC dbo.SP_PROY_COMP_SEG_IMAGEN
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROY_COMP_SEG_IMAGEN', "EXEC dbo.SP_PROY_COMP_SEG_IMAGEN
     @TipoAccion= 'SelCampos'
    ,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PROY_COMP_SEG_IMAGEN', "EXEC dbo.SP_PROY_COMP_SEG_IMAGEN
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
define('Insert_PROY_COMP_SEG_IMAGEN', "EXEC dbo.SP_PROY_COMP_SEG_IMAGEN
     @TipoAccion = 'Insert'
    ,@IDE_SEGUIMIENTO = ?
    ,@IMG_RUTA = ?
    ,@IMG_PROYECTO = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROY_COMP_SEG_IMAGEN', "EXEC dbo.SP_PROY_COMP_SEG_IMAGEN
     @TipoAccion = 'Update'
    ,@pCodigo = ?    
    ,@IMG_RUTA = ?
    ,@IMG_PROYECTO = ?    
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_PROY_COMP_SEG_IMAGEN', "EXEC dbo.SP_PROY_COMP_SEG_IMAGEN
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

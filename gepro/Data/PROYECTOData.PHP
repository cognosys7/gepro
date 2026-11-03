
<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa	      : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROYECTODATA de la tabla PROYECTO
  //  Fecha           : domingo, 5 de mayo de 2019 9:28:20
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-D
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

//Seleccionar count
define('Count_PROYECTO', "EXEC dbo.SP_PROYECTO
     @TipoAccion= 'Count'
    ,@filtro = ?"
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROYECTO', "EXEC dbo.SP_PROYECTO
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROYECTO', "EXEC dbo.SP_PROYECTO
     @TipoAccion= 'SelCampos'
	,@campos = ?
    ,@filtro = ?"
);



//Seleccionar Datos para Grilla
define('SelGrd_PROYECTO110', "EXEC dbo.SP_PROYECTO
     @TipoAccion= 'SelGrd'
    ,@rp = ?
    ,@sortname = ?
    ,@sortorder = ?
    ,@page = ?
    ,@filtro = ?
    ,@codigoMensaje = ?
    ,@Mensaje = ?
    ,@nTotal = ?
    ,@pAuxiliar ='110'
"
);
define('SelGrd_PROYECTO210', "EXEC dbo.SP_PROYECTO
     @TipoAccion= 'SelGrd'
    ,@rp = ?
    ,@sortname = ?
    ,@sortorder = ?
    ,@page = ?
    ,@filtro = ?
    ,@codigoMensaje = ?
    ,@Mensaje = ?
    ,@nTotal = ?
    ,@pAuxiliar ='210'
"
);
define('SelGrd_PROYECTO211', "EXEC dbo.SP_PROYECTO
     @TipoAccion= 'SelGrd'
    ,@rp = ?
    ,@sortname = ?
    ,@sortorder = ?
    ,@page = ?
    ,@filtro = ?
    ,@codigoMensaje = ?
    ,@Mensaje = ?
    ,@nTotal = ?
    ,@pAuxiliar ='211'
"
);
define('SelGrd_PROYECTO212', "EXEC dbo.SP_PROYECTO
     @TipoAccion= 'SelGrd'
    ,@rp = ?
    ,@sortname = ?
    ,@sortorder = ?
    ,@page = ?
    ,@filtro = ?
    ,@codigoMensaje = ?
    ,@Mensaje = ?
    ,@nTotal = ?
    ,@pAuxiliar ='212'
"
);
define('SelGrd_PROYECTO214', "EXEC dbo.SP_PROYECTO
     @TipoAccion= 'SelGrd'
    ,@rp = ?
    ,@sortname = ?
    ,@sortorder = ?
    ,@page = ?
    ,@filtro = ?
    ,@codigoMensaje = ?
    ,@Mensaje = ?
    ,@nTotal = ?
    ,@pAuxiliar ='214'
"
);
define('SelGrd_PROYECTO215', "EXEC dbo.SP_PROYECTO
     @TipoAccion= 'SelGrd'
    ,@rp = ?
    ,@sortname = ?
    ,@sortorder = ?
    ,@page = ?
    ,@filtro = ?
    ,@codigoMensaje = ?
    ,@Mensaje = ?
    ,@nTotal = ?
    ,@pAuxiliar ='215'
"
);
define('SelGrd_PROYECTO216', "EXEC dbo.SP_PROYECTO
     @TipoAccion= 'SelGrd'
    ,@rp = ?
    ,@sortname = ?
    ,@sortorder = ?
    ,@page = ?
    ,@filtro = ?
    ,@codigoMensaje = ?
    ,@Mensaje = ?
    ,@nTotal = ?
    ,@pAuxiliar ='216'
"
);
define('SelGrd_PROYECTO310', "EXEC dbo.SP_PROYECTO
     @TipoAccion= 'SelGrd'
    ,@rp = ?
    ,@sortname = ?
    ,@sortorder = ?
    ,@page = ?
    ,@filtro = ?
    ,@codigoMensaje = ?
    ,@Mensaje = ?
    ,@nTotal = ?
    ,@pAuxiliar ='310'
"
);
define('SelGrd_PROYECTO410', "EXEC dbo.SP_PROYECTO
     @TipoAccion= 'SelGrd'
    ,@rp = ?
    ,@sortname = ?
    ,@sortorder = ?
    ,@page = ?
    ,@filtro = ?
    ,@codigoMensaje = ?
    ,@Mensaje = ?
    ,@nTotal = ?
    ,@pAuxiliar ='410'
"
);
define('SelGrd_PROYECTO510', "EXEC dbo.SP_PROYECTO
     @TipoAccion= 'SelGrd'
    ,@rp = ?
    ,@sortname = ?
    ,@sortorder = ?
    ,@page = ?
    ,@filtro = ?
    ,@codigoMensaje = ?
    ,@Mensaje = ?
    ,@nTotal = ?
    ,@pAuxiliar ='510'
"
);










//MANTENIMIENTO
define('Insert_PROYECTO', "EXEC dbo.SP_PROYECTO
     @TipoAccion = 'Insert'
		,@IDE_PORTAFOLIO = ?
		,@IDE_PROGRAMA = ?
		,@IDE_CENCOSTO = ?
		,@IDE_ENTIDAD_EJECUTORA = ?
		,@IDE_ETAPA_CONTRATO = ?
		,@COD_INTERNO = ?
		,@COD_UNICO = ?
		,@COD_SNIP = ?
		,@DES_LARGA_PROYECTO = ?
		,@DES_CORTA_PROYECTO = ?
		,@DES_PROYECTO_ENGLISH = ?
		,@TIP_MONEDA = ?
		,@IMP_APROBADO_LOC = ?
		,@IMP_APROBADO_EXT = ?
		,@FEC_APROBACION = ?
		,@FEC_INICIO_PROY = ?
		,@FEC_TERMINO_PROY = ?
		,@DES_UBICACION_PROYECTO = ?
		,@DES_UNIDAD_FORMULADORA = ?
		,@DES_VIABILIDAD = ?
		,@DES_AREA_INTERVENCION = ?
		,@DES_CUENCA_HIDROGRAFICA = ?
		,@NUM_PAMS = ?
		,@DES_STAKEHOLDER = ?
		,@DES_ESTATUS = ?
		,@DES_ACCION_GESTION = ?
                ,@DES_ACCION_GESTION_SOCIAL = ?
		,@DES_ACCION_CORRECTIVA = ?
		,@DES_OPORTUNIDAD_MEJORA = ?
		,@TIP_PROYECTO = ?
		,@TIP_GRUPO_PROYECTO = ?
		,@NUM_BENEFICIARIOS = ?
		,@EST_PROYECTO = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROYECTO', "EXEC dbo.SP_PROYECTO
     @TipoAccion = 'Update'
    ,@pCodigo = ?
		,@IDE_PORTAFOLIO = ?
		,@IDE_PROGRAMA = ?
		,@IDE_CENCOSTO = ?
		,@IDE_ENTIDAD_EJECUTORA = ?
		,@IDE_ETAPA_CONTRATO = ?
		,@COD_INTERNO = ?
		,@COD_UNICO = ?
		,@COD_SNIP = ?
		,@DES_LARGA_PROYECTO = ?
		,@DES_CORTA_PROYECTO = ?
		,@DES_PROYECTO_ENGLISH = ?
		,@TIP_MONEDA = ?
		,@IMP_APROBADO_LOC = ?
		,@IMP_APROBADO_EXT = ?
		,@FEC_APROBACION = ?
		,@FEC_INICIO_PROY = ?
		,@FEC_TERMINO_PROY = ?
		,@DES_UBICACION_PROYECTO = ?
		,@DES_UNIDAD_FORMULADORA = ?
		,@DES_VIABILIDAD = ?
		,@DES_AREA_INTERVENCION = ?
		,@DES_CUENCA_HIDROGRAFICA = ?
		,@NUM_PAMS = ?
		,@DES_STAKEHOLDER = ?
		,@DES_ESTATUS = ?
		,@DES_ACCION_GESTION = ?
                ,@DES_ACCION_GESTION_SOCIAL = ?
		,@DES_ACCION_CORRECTIVA = ?
		,@DES_OPORTUNIDAD_MEJORA = ?
		,@TIP_PROYECTO = ?
		,@TIP_GRUPO_PROYECTO = ?
		,@NUM_BENEFICIARIOS = ?
		,@EST_PROYECTO = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

define('Delete_PROYECTO', "EXEC dbo.SP_PROYECTO
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);

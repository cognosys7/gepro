
<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION.NET
//  Empresa			  : www.cognosys.com.pe
//  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Edgar David Pisfil Ahumada                    
//  Propósito       : PROYECTO_ACTIVIDADDATA de la tabla PROYECTO_ACTIVIDAD
//  Fecha           : viernes, 3 de noviembre de 2017 10:00:11
//  Desde el Modelo : PDM - AMSAC
//  Modificado      : 16 de Octubre 2017
//
//******************************************************************************/

//Seleccionar count
define('Count_PROYECTO_ACTIVIDAD',
"EXEC dbo.SP_PROYECTO_ACTIVIDAD
     @TipoAccion= 'Count'
    ,@filtro = ?
    ,@pUsuario = ?"
    
);


//Seleccionar un Registro Por Clave Primaria
define('SelPk_PROYECTO_ACTIVIDAD',
"EXEC dbo.SP_PROYECTO_ACTIVIDAD
     @TipoAccion = 'SelPk' 
    ,@pCodigo=?"   
);

//Seleccionar Registros Por Condición Generada Por el Usuario

define('SelCampos_PROYECTO_ACTIVIDAD',
"EXEC dbo.SP_PROYECTO_ACTIVIDAD
     @TipoAccion= 'SelCampos'
    ,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Registros Por Condición Generada Por el Usuario
define('SelCampos_PROYECTO_ACTIVIDAD2',
"EXEC dbo.SP_PROYECTO_ACTIVIDAD
     @TipoAccion= 'SelCampos2'
    ,@campos = ?
    ,@filtro = ?"
);

//Seleccionar Datos para Grilla
define('SelGrd_PROYECTO_ACTIVIDAD',
"EXEC dbo.SP_PROYECTO_ACTIVIDAD
     @TipoAccion= 'SelGrd'
    ,@rp = ?
    ,@sortname = ?
    ,@sortorder = ?
    ,@page = ?
    ,@filtro = ?
    ,@pUsuario = ?
    ,@codigoMensaje = ?
    ,@Mensaje = ?
    ,@nTotal = ?
"
);



//MANTENIMIENTO
define('Insert_PROYECTO_ACTIVIDAD',
"EXEC dbo.SP_PROYECTO_ACTIVIDAD
     @TipoAccion = 'Insert'
    ,@IDE_PROYECTO = ?
    ,@COD_PROYECTO = ?
    ,@IDE_ENTIDAD_EJECUTORA = ?
    ,@IDE_PROCESO_ITEM = ?
    ,@IDE_PRIORIZACION = ?
    ,@IDE_INTERVENCION = ?
    ,@GRUPO_TIPO_INTERVENCION = ?
    ,@TIP_PROYECTO_ACTIVIDAD = ?
    ,@DES_PROYECTO = ?
    ,@DES_PROYECTO_ITEM = ?
    ,@DES_PROYECTO_ABREV = ?
    ,@IMP_INVERSION = ?
    ,@IMP_FINANCIADO = ?
    ,@IMP_TRANSFERIDO = ?
    ,@IMP_VALOR_REFERENCIAL = ?
    ,@IMP_COSTO_ACTUAL = ?
    ,@IMP_LIQUIDADO = ?    
    ,@DES_UBICACION = ?
    ,@GEO_LONGITUD_UBICACION = ?
    ,@GEO_LATITUD_UBICACION = ?
    ,@EST_PROYECTO_ACTIVIDAD = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError  = ?"
);


define('Update_PROYECTO_ACTIVIDAD',
"EXEC dbo.SP_PROYECTO_ACTIVIDAD
     @TipoAccion = 'Update'
    ,@pCodigo = ?

        ,@IDE_PROYECTO = ?
        ,@COD_PROYECTO = ?
        ,@IDE_ENTIDAD_EJECUTORA = ?
        ,@IDE_PROCESO_ITEM = ?
        ,@IDE_PRIORIZACION = ?
        ,@IDE_INTERVENCION = ?
        ,@GRUPO_TIPO_INTERVENCION = ?
        ,@TIP_PROYECTO_ACTIVIDAD = ?
        ,@DES_PROYECTO = ?
        ,@DES_PROYECTO_ITEM = ?
        ,@DES_PROYECTO_ABREV = ?
        ,@IMP_INVERSION = ?
        ,@IMP_FINANCIADO = ?
        ,@IMP_TRANSFERIDO = ?
        ,@IMP_VALOR_REFERENCIAL = ?
        ,@IMP_COSTO_ACTUAL = ?
        ,@IMP_LIQUIDADO = ?
        ,@DES_UBICACION = ?
        ,@GEO_LONGITUD_UBICACION = ?
        ,@GEO_LATITUD_UBICACION = ?
        ,@EST_PROYECTO_ACTIVIDAD = ?	
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);        

define('Delete_PROYECTO_ACTIVIDAD',
"EXEC dbo.SP_PROYECTO_ACTIVIDAD
     @TipoAccion = 'Delete'
    ,@pCodigo = ?
    ,@pUsuario = ?
    ,@pIdError  = ?
    ,@pMensajeError = ?"
);
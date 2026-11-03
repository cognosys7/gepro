<?php
/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION.NET
//  Empresa	    : www.cognosys.com.pe
//  Autores         : Hector Lopez Sanchez                    
//  Propósito       : SEG_ENTIDAD_USUARIODATA de la tabla SEG_ENTIDAD_USUARIO
//  Fecha           : miércoles, 21 de febrero de 2018 06:14:41 p.m.
//  Desde el Modelo : PDM - AMSAC
//  Modificado      : 16 de Octubre 2017
//
//******************************************************************************/

//Seleccionar Datos para Grilla
define('Rpt_Formato1_RPT_INTERVENCIONES',"EXEC dbo.SP_RPT_INTERVENCIONES
     @TipoAccion= 'Rpt_Formato1'
    ,@pUsuario = ?
"
);



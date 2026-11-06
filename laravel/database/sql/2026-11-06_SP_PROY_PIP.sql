-- Corrige dbo.SP_PROY_PIP 'Insert': actualizaba PROYECTO con WHERE IDE_PROYECTO = @IDE_PIP.
-- Aplicado en BDGEPRO el 2026-11-06. Ejecutar una vez en cada base; es seguro repetirlo.
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
/***EDGAR***/

ALTER PROCEDURE [dbo].[SP_PROY_PIP] 
/********************************************************************************
|
|  Header_Package of Extend Generation PD 16.6
|  ==========================================
|  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com - 
|                    Ing. Edgar David Pisfil Ahumada 
|  Propósito       : Cabecera del Store Procedure para tabla PROY_PIP
|  Generado por    : user el sábado, 15 de junio de 2019 16:49:34
|  Desde el Modelo : PDM - AMSAC - AJUSTADO-J
|  Modificado      : 12 de Octubre del 2017
|
********************************************************************************/

		--CONSTANTE PARA ELEGIR EL TIPO DE OPERACION EN LA BASE DE SATOS
		@TipoAccion nvarchar (20) = ''
		--CONSTANTES PARA CONTAR Y FILTRAR
		,@filtro VARCHAR(MAX) = NULL
		--CONSTANTE PARA LA GRILLA Y PAGINACION
		,@rp INT = NULL
		,@sortname VARCHAR(50) = NULL
		,@sortorder VARCHAR(50) = NULL
		,@page INT = NULL
		--,@filtro VARCHAR(MAX) = NULL
		,@codigoMensaje TEXT = NULL OUTPUT
		,@Mensaje TEXT = NULL OUTPUT
		,@nTotal INT = NULL OUTPUT
		,@Campos VARCHAR (MAX) = NULL   
		--CONSTANTE DE CONTROL DE ERRORES PARA INSERTAR, ACTUALIZAR O ELIMINAR
		,@pIdError varchar (10) = NULL OUTPUT
		,@pMensajeError varchar (200) = NULL OUTPUT
		--CONSTANTES PARA LA TABLA
		,@pUsuario int = NULL		
		--VARIABLES PARA LA MANIPULACI? DE DATOS
				,@IDE_PIP numeric(9) = NULL
				,@IDE_PROYECTO numeric(9) = NULL
				,@COD_SNIP varchar(10) = NULL
				,@COD_UNICO varchar(10) = NULL
				,@COD_INFOBRAS varchar(10) = NULL
				,@COD_INTERNO varchar(10) = NULL
				,@EST_PROY_SNIP varchar(3) = NULL
				,@CHK varchar(1) = NULL
				,@EST_PROY_PIP varchar(3) = NULL
		--VARIABLES PARA SELECCIONAR, ACTUALIZAR, ELIMINAR  O FILTROS DE DATOS
      ,@pCodigo INT = NULL	
/***EDGAR***/
      --VARIABLES PARA PERFIL Y ROLES COMPLEJOS
		,@pRol varchar(50) = NULL
		,@pModo varchar(50) = NULL
      ,@pAuxiliar varchar(50) = NULL
/***EDGAR***/
	 
AS
BEGIN
SET LANGUAGE 'spanish'
SET XACT_ABORT, NOCOUNT ON

	 BEGIN TRY
    
    
		      /*************************************************************************
		      * COUNT DEL SELGRID
			   *************************************************************************/		 
				 IF (@TipoAccion = 'Count')
				 BEGIN
						DECLARE @sSqlScriptCount NVARCHAR(4000)
						SET @sSqlScriptCount = 
						N'SELECT COUNT(1) as IDE_PROY_PIP
							    from
							       dbo.PROY_PIP as T
							       left join  GEN_PIP as PIP on 	PIP.IDE_PIP=T.IDE_PIP
							       left join  GEN_TABLAS as T3 on 	T3.COD_TABLA=98 and T3.COD_ITEM=T.CHK
							       left join  GEN_TABLAS as T2 on 	T2.COD_TABLA=98 and T2.COD_ITEM=T.EST_PROY_SNIP 
							       left join  GEN_TABLAS as T1 on 	T1.COD_TABLA=99 and T1.COD_ITEM=T.EST_PROY_PIP  
								where
								   EST_PROY_PIP<>''2'' ' +  @filtro
							EXECUTE sp_executesql @sSqlScriptCount
							RETURN
				 END		
      
      
				 /*************************************************************************
				 * Seleccionar un Registro Por Clave Primaria
				 *************************************************************************/
				 IF (@TipoAccion = 'SelPk')
				 BEGIN
						SELECT	
									IDE_PROY_PIP,
									IDE_PIP,
									IDE_PROYECTO,
									COD_SNIP,
									COD_UNICO,
									COD_INFOBRAS,
									COD_INTERNO,
									EST_PROY_SNIP,
									CHK,
									EST_PROY_PIP
						FROM
						DBO.PROY_PIP
						WHERE 
								IDE_PROY_PIP = @pCodigo

				 END 
				 
				 /*************************************************************************
				 * Seleccionar Registros Por Condición Generada Por el Usuario
				 *************************************************************************/
				 IF (@TipoAccion = 'SelCampos')
				 BEGIN
							SET NOCOUNT ON;	
							DECLARE @sSqlScriptSel NVARCHAR(4000)
							SET @sSqlScriptSel = 
							N'SELECT  '+ @Campos +
							
								 ' FROM ( SELECT ' + @Campos +
								 ' FROM    
									 DBO.PROY_PIP
								WHERE 
								                  EST_PROY_PIP <> ''2''' 	+ @filtro + ' ) A ';							
							EXECUTE sp_executesql @sSqlScriptSel
							RETURN
				 END 
				 
				 /*************************************************************************
				 * Seleccionar Datos para Grilla
				 *************************************************************************/
				
               IF (@TipoAccion = 'SelGrd')
               BEGIN
                     DECLARE @sPaginado NVARCHAR(4000)
                     DECLARE @sOrdenacion NVARCHAR(4000)
                     DECLARE @sSqlScript NVARCHAR(4000)
                     DECLARE @nInicio INT = 0;
                     DECLARE @nMulti INT = 0;
                     SET @nInicio = ((@Page - 1) * @rp + 1);
                     SET @nMulti = @Page * @rp;
                     SET @sPaginado =N' WHERE NFILA BETWEEN ' + CONVERT(NVARCHAR(MAX), @nInicio) + ' AND ' + CONVERT(NVARCHAR(MAX), @nMulti) ;
                     --Ordenacion de los resultados
                     SET @sOrdenacion = 'ORDER BY ' + @sortname + ' ' + @sortorder;
                     SET NOCOUNT ON;	
                     SET @sSqlScript = 
                     
                     N'SELECT 
                             ID,
                              
							 '' <button class="btn btn-green btn-small" type="button" onclick= abrirSNIPF3(''+CONVERT(NVARCHAR(10),COD_SNIP)+'') title="Abrir SNIP - MEF" >''+COD_SNIP+''</button> '',
                              --COD_SNIP,

                              COD_UNICO,
                              DES_PIP,
                              COD_INFOBRAS,
                              COD_INTERNO,
                              EstadoSNIP,
                              CheckReg,
                              Estado,
                              NFILA
                           								
                           
                           '+ 
 /***EDGAR***/             IIF( @pAuxiliar='Anidado' , ',''<button type=button class = "btn btn-green btn-small" onclick=AbrirValores(''+CONVERT(NVARCHAR(10),COD_ITEM)+'') title = "Ver valores" id=view16></button> '' as Boton3' , ''  )
         						+'
                           
                           ,''<input type=button onclick=EditarInformacion('' + CONVERT(NVARCHAR(10),ID) + '') title="Modificar PROY_PIP" id=editar16>'' as Boton1
                           ,''<input type=button onclick=EliminarInformacion('' + CONVERT(NVARCHAR(10),ID) + '') title="Eliminar PROY_PIP" id=eliminar16>'' as Boton2
                        FROM  
                           ( SELECT  
                                       T.IDE_PROY_PIP as ID     ,
                                        PIP.COD_SNIP as COD_SNIP     ,
                                        PIP.COD_UNICO as COD_UNICO     ,
                                        PIP.DES_PIP as DES_PIP     ,
                                        T.COD_INFOBRAS as COD_INFOBRAS     ,
                                        T.COD_INTERNO as COD_INTERNO     ,
                                        T2.DES_ITEM as EstadoSNIP     ,
                                        T3.DES_ITEM as CheckReg     ,
                                        T1.DES_ITEM as Estado     ,
                                        ROW_NUMBER() OVER (ORDER BY  T.IDE_PROY_PIP ) as NFILA 
                                 from
                                    dbo.PROY_PIP as T
                                    left join  GEN_PIP as PIP on 	PIP.IDE_PIP=T.IDE_PIP
                                    left join  GEN_TABLAS as T3 on 	T3.COD_TABLA=98 and T3.COD_ITEM=T.CHK
                                    left join  GEN_TABLAS as T2 on 	T2.COD_TABLA=98 and T2.COD_ITEM=T.EST_PROY_SNIP 
                                    left join  GEN_TABLAS as T1 on 	T1.COD_TABLA=99 and T1.COD_ITEM=T.EST_PROY_PIP  
                                 where
                                    EST_PROY_PIP<>''2'' ' +  @filtro +') A ' 				
                        + @sPaginado 
                        + @sOrdenacion;
                     --print @sSqlScript
                     EXECUTE sp_executesql @sSqlScript
                     RETURN
               END 										
				 
	
				 
				 /*************************************************************************
				 * Insertar Registros
				 *************************************************************************/
				 IF (@TipoAccion = 'Insert')
				 BEGIN
						BEGIN TRANSACTION

						DECLARE @cuentaRegistros INT = ( SELECT COUNT(1) FROM  DBO.PROY_PIP WHERE IDE_PROYECTO=@IDE_PROYECTO AND 	EST_PROY_PIP<>'2'	) ;

						IF ( @cuentaRegistros = 0 )
							BEGIN
								
								
								--INSERTO 
								INSERT DBO.PROY_PIP
									(
											IDE_PIP,
											IDE_PROYECTO,
											COD_SNIP,
											COD_UNICO,
											COD_INFOBRAS,
											COD_INTERNO,
											EST_PROY_SNIP,
											CHK,
											EST_PROY_PIP

										,USER_INSERT ,FECHA_INSERT
									)
									VALUES
									(
											@IDE_PIP,
											@IDE_PROYECTO,
											@COD_SNIP,
											@COD_UNICO,
											@COD_INFOBRAS,
											@COD_INTERNO,
											@EST_PROY_SNIP,
											@CHK,
											@EST_PROY_PIP

										,@pUsuario ,GETDATE()
									)

									

									-- MODIFICO
									UPDATE DBO.PROYECTO SET
										COD_SNIP=@COD_SNIP
										,COD_UNICO=@COD_UNICO
									WHERE IDE_PROYECTO = @IDE_PROYECTO
									;


									SET @pIdError= 1
									SET @pMensajeError ='OK'

							END

						COMMIT TRANSACTION
				 END
				 
				 /*************************************************************************
				 * Actualizar Registros
				 *************************************************************************/
				 IF (@TipoAccion = 'Update')
				 BEGIN
						BEGIN TRANSACTION   
							UPDATE DBO.PROY_PIP
							SET 
									IDE_PIP = @IDE_PIP,
									IDE_PROYECTO = @IDE_PROYECTO,
									COD_SNIP = @COD_SNIP,
									COD_UNICO = @COD_UNICO,
									COD_INFOBRAS = @COD_INFOBRAS,
									COD_INTERNO = @COD_INTERNO,
									EST_PROY_SNIP = @EST_PROY_SNIP,
									CHK = @CHK,
									EST_PROY_PIP = @EST_PROY_PIP

                                    ,USER_UPDATE  = @pUsuario ,FECHA_UPDATE = GETDATE()
							WHERE							
								IDE_PROY_PIP = @pCodigo
							;

							

							-- MODIFICO
							UPDATE DBO.PROYECTO SET
								COD_SNIP=@COD_SNIP
								,COD_UNICO=@COD_UNICO
							WHERE IDE_PROYECTO = @IDE_PROYECTO
							;


							--MENSAJE DE OPERACION
							SET @pIdError= 3
							SET @pMensajeError ='OK'
						COMMIT TRANSACTION
				 END
				 
				 /*************************************************************************
				 * Eliminar Registros
				 *************************************************************************/
				 IF (@TipoAccion = 'Delete')
				 BEGIN
						BEGIN TRANSACTION
						
                   
                           UPDATE DBO.PROY_PIP
                           SET 
                              EST_PROY_PIP = '2'
/***EDGAR***/
                              ,USER_UPDATE  = @pUsuario ,FECHA_UPDATE = GETDATE()
/***EDGAR***/								
                           WHERE							
									   IDE_PROY_PIP = @pCodigo
							;



							-- MODIFICO
							UPDATE DBO.PROYECTO SET
								COD_SNIP=NULL
								,COD_UNICO=NULL
							WHERE IDE_PROYECTO in ( SELECT IDE_PROYECTO FROM  DBO.PROY_PIP WHERE IDE_PROY_PIP = @pCodigo )
							;

						  
						COMMIT TRANSACTION
				 END
     END TRY
     BEGIN CATCH
            
             SET @pIdError=ERROR_NUMBER()
             SET @pMensajeError =ERROR_MESSAGE()
             ROLLBACK TRANSACTION
             DECLARE @ERROR_NUMBER INT
             DECLARE @ERROR_SEVERITY INT
             DECLARE @ERROR_STATE INT
             DECLARE @ERROR_PROCEDURE VARCHAR(MAX)
             DECLARE @ERROR_LINE INT
             DECLARE @ERROR_MESSAGE VARCHAR(MAX)
             SELECT @ERROR_NUMBER=ERROR_NUMBER() , @ERROR_SEVERITY=ERROR_SEVERITY() , @ERROR_STATE=ERROR_STATE() , @ERROR_PROCEDURE=ERROR_PROCEDURE(),@ERROR_LINE=ERROR_LINE(),@ERROR_MESSAGE=ERROR_MESSAGE()                
             EXEC seguridad.upaGuardarErroresEnLog @ERROR_NUMBER , @ERROR_SEVERITY , @ERROR_STATE ,  @ERROR_PROCEDURE,@ERROR_LINE,@ERROR_MESSAGE                
     END CATCH
END
GO

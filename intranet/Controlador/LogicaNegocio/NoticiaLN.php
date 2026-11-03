<?php
    require_once(PATH_CONTROLADOR_DAO . "/IntranetDAO.php");
    require_once(PATH_CONTROLADOR_DAO . "/SistemaDAO.php");
    require_once(PATH_CONTROLADOR_DAO . "/RutaAlmacenamientoDAO.php");
    require_once(PATH_LIB . "/Collection.php");
    require_once(PATH_LIB . '/util.php');
    require_once(PATH_LIB . '/functions.php');
    function EjecutaLN() 
    {
        ValidaSession();
        $lCollection        = Collection::Singleton();
        $PaginaFormulario   = "Noticia";
         
        $CNoticia           = isset($_REQUEST['CNoticia'])? $_REQUEST['CNoticia'] : '';
        $usuariosession     = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : '';
        
        $IdRutaAlmacenamiento       = "";
        $RutaAlmacenamiento         = "";
        $lstRuta                    = array();
        $objRutaDAO                 = new RutaAlmacenamientoDAO();
        $lstParametrosRuta          = array();
        $lstParametrosRuta['Ruta']  = "Documentos";
        $procedure_paramsRuta = array(
              array(&$lstParametrosRuta['Ruta'], SQLSRV_PARAM_IN)
        );
        $objRutaDAO->ListarRutaAlmacenamiento($lstRuta, $procedure_paramsRuta);
        $listaRutas  = count($lstRuta) > 0 ? true : false;
        if (($listaRutas == true) || ($listaRutas > 0)) 
        {
            $IdRutaAlmacenamiento     = $lstRuta[0]->IdRutaAlmacenamiento;
            $RutaAlmacenamiento       = $lstRuta[0]->RutaAlmacenamiento;
        }
            
        $FechaPublicM               = "";
        $TituloM                    = "";
        $DescripcionM               = "";
        $ImagenPortadaM             = "";
        $objIntranetDAO                         = new IntranetDAO();
        $lstNoticia                             = array();
        $lstImagemes                            = array();
        $lstParametros                          = array();
        $lstParametros['CNoticia']              = $CNoticia;
        $lstParametros['PCODIGO']               = str_repeat("\0", 100);
        $lstParametros['PMENSAJE']              = str_repeat("\0", 200);
        $procedure_paramsS = array(
            array(&$lstParametros['CNoticia'], SQLSRV_PARAM_IN)
            , array(&$lstParametros['PCODIGO'], SQLSRV_PARAM_OUT)
            , array(&$lstParametros['PMENSAJE'], SQLSRV_PARAM_OUT)
        );
        $objIntranetDAO->VerificaNoticiaxId($lstNoticia,$procedure_paramsS);
        $listaContador  = count($lstNoticia) > 0 ? true : false;
        if (($listaContador == true) || ($listaContador > 0)) 
        {
            $CNoticia                       = $lstNoticia[0]->IdNoticia;
            $FechaPublicM                   = $lstNoticia[0]->FechaPublicacion;
            $TituloM                        = $lstNoticia[0]->Titulo;
            $DescripcionM                   = $lstNoticia[0]->Descripcion;
            $ImagenPortadaM                 = $lstNoticia[0]->ImagenPortada;
            //OBTENGO  LAS IMAGENES DE LAS NOTICIAS
            $lstParametros                          = array();
            $lstParametros['CNoticia']              = $CNoticia;
            $lstParametros['PCODIGO']               = str_repeat("\0", 100);
            $lstParametros['PMENSAJE']              = str_repeat("\0", 200);
            $procedure_paramsS = array(
                array(&$lstParametros['CNoticia'], SQLSRV_PARAM_IN)
                , array(&$lstParametros['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstParametros['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $objIntranetDAO->ListaNoticiaImagenes($lstImagemes,$procedure_paramsS);
        }
        
        //LISTADO DE SISTEMAS
        $lstSistemas     = array();
        $objSistemasDAO  = new SistemaDAO();
        $objSistemasDAO->ListadoSistemasUsuarios($lstSistemas, $usuariosession);
        
        //LISTADO DE NOTICIAS
        $lstNoticias     = array();
        $lstParametrosN                          = array();
        $lstParametrosN['Top']                   = 5;
        $lstParametrosN['PCODIGO']               = str_repeat("\0", 100);
        $lstParametrosN['PMENSAJE']              = str_repeat("\0", 200);
        $procedure_paramsN = array(
            array(&$lstParametrosN['Top'], SQLSRV_PARAM_IN)
            , array(&$lstParametrosN['PCODIGO'], SQLSRV_PARAM_OUT)
            , array(&$lstParametrosN['PMENSAJE'], SQLSRV_PARAM_OUT)
        );
        $objIntranetDAO->ListaNoticia($lstNoticias,$procedure_paramsN);
        
        $lCollection->Add('CNoticia', $CNoticia);
        $lCollection->Add('FechaPublicM', $FechaPublicM);
        $lCollection->Add('TituloM', $TituloM);
        $lCollection->Add('DescripcionM', $DescripcionM);
        $lCollection->Add('ImagenPortadaM', $ImagenPortadaM);
        $lCollection->Add('RutaAlmacenamiento', $RutaAlmacenamiento);
        $lCollection->Add('lstImagemes', $lstImagemes);
        
        //LISTADO DE SISTEMAS
        $lCollection->Add('lstSistemas', $lstSistemas);
        
        //LISTADO DE NOTICIAS
        $lCollection->Add('lstNoticias', $lstNoticias);

        $lCollection->Add('PaginaFormulario', $PaginaFormulario);
    }
?>
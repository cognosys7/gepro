<?php
require_once(PATH_CONTROLADOR_DAO . "/CatalogoDAO.php");
function EjecutaLN()
{
ValidaSession();
        $lCollection = Collection::Singleton();
        
        //VARIABLES GENERALES PARA EL SISTEMA
        $PaginaFormulario   = "Ejemplo01";
        
        //OBTENGOS LOS POST ANTIREFRESH
        if (!empty($_POST['Mensaje'])) {    $mensaje = $_POST['Mensaje'];} else { $mensaje = 0;}
        
        //OBTENGO LAS SESIONES
        if (!empty($_SESSION['usuario'])) { $usuario = $_SESSION['usuario'];} else { $usuario = 0;}
        if (!empty($_SESSION['CodPerfil'])) { $perfilsession = $_SESSION['CodPerfil'];} else { $perfilsession = 0;}
        if (!empty($_SESSION['Oc'])) { $Opcionsession = $_SESSION['Oc'];} else { $Opcionsession = 0;}
        
        
        $PermisoOK = VerificaAccesoMenu($Opcionsession,$perfilsession);
	
	if($PermisoOK)
	{
		
		$lConsulta = array("Juan","Hans","José","Héctor");
		
		$lCollection->Add('lConsulta', $lConsulta);

		//LISTA DE TIPOS DE DOCUMENTOS
            $objCatalogoDAO     = new CatalogoDAO();
            $lstCatalogoG       = array();
 	    $lstCatalogoSG	= array();
            $objCatalogoDAO->VerificaCatalogoNombre($lstCatalogoG,"INFORMACION GENERAL");
	    $GrupoCat           = $lstCatalogoG[0]->CatGrupo;
            $objCatalogoDAO->VerificaCatalogoNombreGrupo($lstCatalogoSG,$GrupoCat,"TIPOS DE DOCUMENTOS");

		$lCollection->Add('lCatalogo', $lstCatalogoG);
		$lCollection->Add('lCatalogoDatos', $lstCatalogoSG);
	}

    }

?>
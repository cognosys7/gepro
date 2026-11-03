<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : REVISORES URBANOS
  //  Empresa         : Ministerio de Vivienda, Construcción y Saneamiento
  //  Autores         : ING. EDGAR DAVID PISFIL AHUMADA
  //  Fecha           : miércoles, 22 de enero de 2020 18:36:15
  //  Desde el Modelo : MF_PROCESO_LICENCIAS
  //  Modificado      : miércoles, 22 de enero de 2020 18:36:15
  //
  //***************************************************************************** */

require_once("/GEN_TABLASLNI.php");



function UsuarioEvento2( $Usuario, $Perfil , $TipoCRUD,  $SeleccionarID ) {
    
    $UsuarioEvento = array(
        'Grabar' => crudGrabarCancelar2($SeleccionarID,'true')
        ,'Nuevo' => ( $TipoCRUD=='Busqueda' ? 'false' : 'true' )
        ,'Modificar' => ( $TipoCRUD=='Busqueda' ? 'true' : 'false' )
        ,'Eliminar' => ( $TipoCRUD=='Busqueda' ? 'true' : 'false' )
        ,'ArchivoDescargar' => ( $TipoCRUD=='Busqueda' ? 'true' : 'false' )
        ,'Seleccion' => ( $TipoCRUD=='Busqueda' ? 'false' : 'true' ) 
        ,'Recursiva' => ( $TipoCRUD=='Busqueda' ? 'true' : 'false' ) 
        ,'Cancelar' => crudGrabarCancelar2($SeleccionarID,'false') 
    );
    
    if($Perfil == 'CONSULTA TOTAL' || $Perfil==63 ) {
        switch ($Usuario) {
//            case 2547:  $UsuarioEvento['Grabar'] = crudGrabarCancelar2($SeleccionarID,'false');
//                        $UsuarioEvento['Eliminar'] = 'true';
//                        $UsuarioEvento['ArchivoDescargar'] = 'true';
//                        $UsuarioEvento['Seleccion'] = 'false';
//                break;
            default:    $UsuarioEvento['Grabar'] = crudGrabarCancelar2($SeleccionarID,'false');
                        $UsuarioEvento['Nuevo'] = 'false';
                        $UsuarioEvento['Eliminar'] = 'true';
                break;
        }    
    } //echo $Perfil.' // ' ;
    
    return $UsuarioEvento ;
}

function crudGrabarCancelar2($SeleccionarID,$Ver) {
    
    $Botones = '';
//    $Evento = UsuarioEvento2($Usuario,$Perfil,$Seleccion,$SeleccionTipo);
//    $Grabar = $Evento['Grabar']; //var_dump($Evento); echo ' // '.$Grabar.' // ';die;
    
    
    if (strlen($SeleccionarID) > 0) {
        //ACTUALIZAR
        $Boton = "Actualizar";
    } else {
        //INSERT
        $Boton = "Registrar";
    }

//    $Botones = '<legend></legend>';
//    $Botones = '<hr id="hrGrabar">';
    $Botones = '';
    $Botones .= '<div class="divGrabarCancelar">';
    $Botones .= ' <button type="button" onclick="Cancelar()" class="btn">Cancelar</button>' ;
    $Botones .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
    $Botones .= ( $Ver=='true' ? '<input type="button" id="BtnForm01" class="btn btn-primary" name="btnForm" value="'.$Boton.'">  ' : '' ) ;  
    $Botones .= ' </div>' ;
    
    return $Botones ;
    
} 




function crudCancelar() {

    $Botones = '';
    $Botones .= '<div class="divGrabarCancelar">';
    $Botones .= ' <button type="button" onclick="Cancelar()" class="btn">Cancelar</button>' ;
    $Botones .= ' </div>' ;

    return $Botones ;

} 




function crud( $Usuario , $Perfil , $TipoCRUD , $SeleccionarID )
{
    $Evento = UsuarioEvento2( $Usuario , $Perfil , $TipoCRUD , $SeleccionarID );
    return $Evento; //var_dump($Evento); echo ' // '.$Grabar.' // ';die; ['Eliminar']
    
}


function crudArchivoDescargar($Usuario,$Perfil)
{
    $Evento = UsuarioEvento($Usuario,$Perfil);
    return $Evento['ArchivoDescargar']; //var_dump($Evento); echo ' // '.$Grabar.' // ';die;
    
}


////////////////////////////////////////

function extraerIDEyValor_Text ($Cide,$Vide ,$Solicitante,$Etiqueta, $Evalor,$Vvalor, $fxJava,$Vancho='width:50%',$verControl='Extrator',$Vtipo='',$Vrequerido='required',$Vlectura='readonly') { //$Vtipo='alphanumeric'
//    $verControl = ( $ver==false ? ' style="display:none"' : '' ) ;
    switch ($verControl) {
        case 'Text': $VerExtrator = ' style="display:none" ' ;
            break;
        default:                $VerExtrator = '' ;
            break;
    }
       
    $Control =  '<div class="control-group" id="div_'.$Evalor.'">';
    $Control .=      '<label class="control-label" for="'.$Cide.'">'.$Etiqueta.' : <span class="error">'.( $Vrequerido=='required' ? '*' : '' ).'</span></label>';
    $Control .=      '<div class="controls">';
    $Control .=         '<input type="hidden" name="'.$Cide.'" id="'.$Cide.'" value="'.$Vide.'"  style="width:13%;" />';
    $Control .=         '<input '.$Vlectura.' name="'.$Evalor.'" id="'.$Evalor.'" value="'.$Vvalor.'" onChange="conMayusculas(this)" maxlength="4000" type="text" class="'.$Vtipo.' '.$Vrequerido.' show-popover"  data-trigger="hover" data-content="Agrege '.$Etiqueta.' con el boton agregar(+)"   style="'.$Vancho.'" />';
    $Control .=         '<input '.$VerExtrator.' name="Submit2" type="button" value="" id="view16" title="Adjuntar '.$Etiqueta.'" onclick="add'.$fxJava.'('."'".$Solicitante."'".')"/>';
    $Control .=      '</div>';
    $Control .= '</div>';
    
    echo $Control ;
}

function extraerIDEyValor_Text2 ($Cide,$Vide ,$Solicitante,$Etiqueta, $Evalor,$Vvalor, $fxJava,$Vancho='width:50%',$verControl='Extrator',$Vtipo='',$Vrequerido='required',$Vlectura='readonly') { //$Vtipo='alphanumeric'
//    $verControl = ( $ver==false ? ' style="display:none"' : '' ) ;
    switch ($verControl) {
        case 'Text': $VerExtrator = ' style="display:none" ' ;
            break;
        default:                $VerExtrator = '' ;
            break;
    }
       
    $Control =  '<div class="control-group" id="div_'.$Evalor.'">';
    $Control .=      '<label class="control-label" for="'.$Cide.'">'.$Etiqueta.' : <span class="error">'.( $Vrequerido=='required' ? '*' : '' ).'</span></label>';
    $Control .=      '<div class="controls">';
    $Control .=         '<input type="hidden" name="'.$Cide.'" id="'.$Cide.'" value="'.$Vide.'"  style="width:13%;" />';
    $Control .=         '<input '.$Vlectura.' name="'.$Evalor.'" id="'.$Evalor.'" value="'.$Vvalor.'" onChange="conMayusculas(this)" maxlength="4000" type="text" class="'.$Vtipo.' '.$Vrequerido.' show-popover"  data-trigger="hover" data-content="Agrege '.$Etiqueta.' con el boton agregar(+)"   style="'.$Vancho.'" />';
    $Control .=         '&nbsp;<input '.$VerExtrator.' name="Submit2" type="button" value="" id="view16" title="Adjuntar '.$Etiqueta.'" onclick="add'.$fxJava.'('."'".$Solicitante."'".')"/>';
    $Control .=         '&nbsp;&nbsp;&nbsp;&nbsp;<input name="Submit2" type="button" value="" id="add16" title="Agregar nuevo '.$Etiqueta.'" onclick="abrir'.$fxJava.'('."'".$Solicitante."'".')"/>';
    $Control .=      '</div>';
    $Control .= '</div>';
    
    echo $Control ;
}



function extraerIDEyValor_Area ($Cide,$Vide ,$Solicitante,$Etiqueta, $Evalor,$Vvalor, $fxJava,$Valtura='3',$verControl='VerValor',$Vtipo='',$Vrequerido='required') { //$Vtipo='alphanumeric'
//    $verControl = ( $ver==false ? ' style="display:none"' : '' ) ;
       
    $Control =  '<div class="control-group">';
    $Control .=      '<label class="control-label" for="'.$Cide.'">'.$Etiqueta.' : <span class="error">'.( $Vrequerido=='required' ? '*' : '' ).'</span></label>';
    $Control .=      '<div class="controls">';
    $Control .=         '<input type="hidden" name="'.$Cide.'" id="'.$Cide.'" value="'.$Vide.'"  style="width:13%;" />';
    $Control .=         '<textarea readonly name="'.$Evalor.'" id="'.$Evalor.'" rows="'.$Valtura.'" onChange="conMayusculas(this)" maxlength="4000" class="xlarge '.$Vtipo.' '.$Vrequerido.' show-popover"  data-trigger="hover" data-content="Seleccione '.$Evalor.'" >'.$Vvalor.'</textarea>';				
    $Control .=         '<input name="Submit2" type="button" value="" id="add16" title="Adjuntar '.$Etiqueta.'" onclick="add'.$fxJava.'('."'".$Solicitante."'".')"/>';
    $Control .=      '</div>';
    $Control .= '</div>';
    
    echo $Control ;
}

////////////////////////////////////////

function VIS_SelCampos ($Clase,$campos,$filtro,$sortname='',$pAuxiliar=''){
    $dao        = $Clase.'_DAO';
    $SelCampos  = 'SelCampos_'.$Clase;
    
    $Resultado  =   array();
//    $setResultado  =   array();
    $Objeto     =   new $dao();  
    $procedure_parametrosMS = array(
                    array(&$campos, SQLSRV_PARAM_IN)
                    , array(&$filtro, SQLSRV_PARAM_IN)
                    , array(&$sortname, SQLSRV_PARAM_IN)
                    , array(&$pAuxiliar, SQLSRV_PARAM_IN)
    );
    
//    var_dump($Resultado);var_dump($campos);var_dump($filtro); //die;
    $Objeto->$SelCampos($Resultado, $procedure_parametrosMS);
    if (count($Resultado)>0){
        
//        foreach ($Resultado as $Etiqueta => $valor) {
//            $setResultado = array($Etiqueta => $valor) ;
//            
//        }
//       var_dump( $setResultado); die;
        
        return $Resultado;
    } else {
        return null;
    }
        
}



function VIS_SelCampos_SQL ($Clase,$campos,$filtro,$SQL){
    $dao        = $Clase.'_DAO';
    $SelCampos  = 'SelCampos_'.$SQL.$Clase; //echo $SelCampos; die;
    
    $Resultado  =   array();
//    $setResultado  =   array();
    $Objeto     =   new $dao();  
    $procedure_parametrosMS = array(
                    array(&$campos, SQLSRV_PARAM_IN)
                    , array(&$filtro, SQLSRV_PARAM_IN)
    );
    
//    var_dump($Resultado);var_dump($campos);var_dump($filtro); //die;
    $Objeto->$SelCampos($Resultado, $procedure_parametrosMS);
    if (count($Resultado)>0){
        
//        foreach ($Resultado as $Etiqueta => $valor) {
//            $setResultado = array($Etiqueta => $valor) ;
//            
//        }
//       var_dump( $setResultado); die;
        
        return $Resultado;
    } else {
        return null;
    }
        
}

/**************************************************************************************/

function visTabla_DatosPadre($Tabla,$CabezeraTamaño=10,$Titulo='') {
    
    $Titulo = '<h5>'.$Titulo.'</h5>';
    $DatosPadre = '<table class="tbDatoPadre">';
    
    foreach ($Tabla as $Etiqueta => $valor) {
        $DatosPadre .= '<tr>';
        $DatosPadre .= '<td style="width: '.$CabezeraTamaño.'%">'.$Etiqueta.' :</td>';
        $DatosPadre .= '<td style="width: '.(100-$CabezeraTamaño).'%"> ' . $valor . '</td>';
        $DatosPadre .= '</tr>';
    }
    $DatosPadre .= '</table>';
        
    echo $Titulo . $DatosPadre;
} 


function visTabla_DatosPadre_fondo($Tablas) {
    
    $DatosPadre = '<table class="tbDatoPadre">';
    $DatosPadre .= '<tr>';
    $DatosPadre .= '<td style="width:100%">'.$Tablas.'</td>';
    $DatosPadre .= '</tr>';
    $DatosPadre .= '</table>';
        
    return $DatosPadre;
} 



/**************************************************************************************/



function visGrabarCancelar_y_otros($BotonBasicos,$Boton2,$Rol='') {
    $Botones2 = '';
    $btnGrabar = '
            <input type="button" id="BtnForm01" class="btn btn-primary" name="btnForm" value="'.$BotonBasicos.'">
                &nbsp
                &nbsp
                &nbsp
                &nbsp
    ';
    
    $btnGrabar = ( $Rol=='DE_Gabinete' ? '' : $btnGrabar );
    
    $Botones = '
        <div class="form-actions">
            '.$btnGrabar.'
            <button type="button" onclick="Cancelar()" class="btn">Cancelar</button>
        
    ' ;
    
    if($Boton2<>''){
        $Botones2 ='&nbsp
                    &nbsp
                    &nbsp
                    &nbsp
                <button type="button" onclick="'.$Boton2['Funcion'].'('.$Boton2['Ide'].')" class="btn">'.$Boton2['Etiqueta'].'</button>
        '; 
    }
    $Botones .= $Botones2.'
        </div>
    ';
    
    echo $Botones;
}



/**************************************************************************************/

function visClaseVerTextIDE ($EiDe,$Vide,$Edescripcion,$Vdescripcion,$BMensaje, $Ver='') {
    $verControl = ( $Ver=='NO' ? ' style="display:none"' : '' ) ;
    
    $Control =  '<div class="control-group"'.$verControl.'>';
    $Control .=      '<label class="control-label" for="'.$EiDe.'">'.$BMensaje.': <span class="error"></span></label>';
    $Control .=      '<div class="controls">';
    $Control .=          '<input type="hidden" name="'.$EiDe.'" id="'.$EiDe.'" value="'.$Vide.'"/>';
    $Control .=          '<input name="'.$Edescripcion.'" id="'.$Edescripcion.'" value="'.$Vdescripcion.'" onChange="conMayusculas(this)" maxlength="12" type="text" class="alphanumeric required show-popover"  data-trigger="hover" data-content="'.$BMensaje.'" disabled  />';
    $Control .=      '</div>';
    $Control .= '</div>';
    
    echo $Control ;
}

function visClaseVerText ($Edescripcion,$Vdescripcion,$BMensaje, $Ver='') {
    
    $Control =  '<div class="control-group"  '.$Ver.'>';
    $Control .=      '<label class="control-label" >'.$BMensaje.' : <span class="error"></span></label>';
    $Control .=      '<div class="controls">';
    $Control .=          '<input name="'.$Edescripcion.'" id="'.$Edescripcion.'" value="'.$Vdescripcion.'" onChange="conMayusculas(this)" maxlength="12" type="text" class="alphanumeric required show-popover"  data-trigger="hover" data-content="'.$BMensaje.'" disabled  />';
    $Control .=      '</div>';
    $Control .= '</div>';
    
    echo $Control ;
}

function visClaseBuscarIDE ($EiDe,$Vide,$Edescripcion,$Vdescripcion,$BMensaje,$BfuncionJava,$ver=true) {
    $verControl = ( $ver==false ? ' style="display:none"' : '' ) ;
    
    $Control =  '<div class="control-group"'.$verControl.'>';
    $Control .=      '<label class="control-label" for="'.$EiDe.'">'.$BMensaje.': <span class="error">*</span></label>';
    $Control .=      '<div class="controls">';
    $Control .=          '<input type="hidden" name="'.$EiDe.'" id="'.$EiDe.'" value="'.$Vide.'" class="alphanumeric  show-popover"/>';
    $Control .=          '<input name="'.$Edescripcion.'" id="'.$Edescripcion.'" value="'.$Vdescripcion.'" onChange="conMayusculas(this)" maxlength="12" type="text" class="alphanumeric required show-popover"  data-trigger="hover" data-content="Busque su '.$BMensaje.' empleando el boton agregar(+)" disabled  />';
    $Control .=          '<input name="Submit2" type="button" value="" id="add16" title="Seleccionar '.$BMensaje.'" onclick=" Add'.$BfuncionJava.'('."'".$Edescripcion."'".')"/>';
    $Control .=      '</div>';
    $Control .= '</div>';
    
    echo $Control ;
}


function visClaseBuscarYverText ($Edescripcion,$Vdescripcion,$BMensaje,$BfuncionJava,$ver, $Ancho='') {
    
    $Ancho = ( $Ancho=='' ? '' : ' style="width: '.$Ancho.'%"  ' ) ;
    
    $Control =  '<div class="control-group"'.$ver.'>';
    $Control .=      '<label class="control-label" for="'.$Edescripcion.'">'.$BMensaje.': <span class="error"></span></label>';
    $Control .=      '<div class="controls">';
    $Control .=          '<input name="'.$Edescripcion.'" id="'.$Edescripcion.'" '.$Ancho.' value="'.$Vdescripcion.'" onChange="conMayusculas(this)" maxlength="12" type="text" class="alphanumeric required show-popover"  data-trigger="hover" data-content="Busque su '.$BMensaje.' empleando el boton agregar(+)" disabled  />';
    $Control .=          '<input name="Submit2" type="button" value="" id="add16" title="Seleccionar '.$BMensaje.'" onclick=" Add'.$BfuncionJava.'('."'".$Edescripcion."'".')"/>';
    $Control .=      '</div>';
    $Control .= '</div>';
    
    echo $Control ;
}




/**************************************************************************************/
function visClaseVerTextAreaIDE ($EiDe,$Vide,$Edescripcion,$Vdescripcion,$BMensaje) {
    
    $Control =  '<div class="control-group">';
    $Control .=      '<label class="control-label" for="'.$EiDe.'">'.$BMensaje.': <span class="error"></span></label>';
    $Control .=      '<div class="controls">';
    $Control .=          '<input type="hidden" name="'.$EiDe.'" id="'.$EiDe.'" value="'.$Vide.'"/>';
    $Control .=          '<textarea name="'.$Edescripcion.'" id="'.$Edescripcion.'" rows="3" onChange="conMayusculas(this)" maxlength="2000" class="xlarge alphanumeric show-popover"  data-trigger="hover" data-content="'.$BMensaje.'" disabled style="resize:none;">'.$Vdescripcion.'</textarea>';  
    $Control .=      '</div>';
    $Control .= '</div>';
    
    echo $Control ;
}

function visClaseVerTextArea ($Edescripcion,$Vdescripcion,$BMensaje,$ver=true) {
    $verControl = ( $ver==false ? ' style="display:none"' : '' ) ;
    
    $Control =  '<div class="control-group"'.$verControl.'>';
    $Control .=      '<label class="control-label">'.$BMensaje.' : <span class="error"></span></label>';
    $Control .=      '<div class="controls">';
    $Control .=          '<textarea name="'.$Edescripcion.'" id="'.$Edescripcion.'" rows="3" onChange="conMayusculas(this)" maxlength="2000" class="xlarge alphanumeric show-popover"  data-trigger="hover" data-content="'.$BMensaje.'" disabled style="resize:none;">'.$Vdescripcion.'</textarea>';  
    $Control .=      '</div>';
    $Control .= '</div>';
    
    echo $Control ;
}

function visClaseBuscarTextAreaIDE ($EiDe,$Vide,$Edescripcion,$Vdescripcion,$BMensaje,$BfuncionJava) {
    
    $Control =  '<div class="control-group">';
    $Control .=      '<label class="control-label" for="'.$EiDe.'">'.$BMensaje.': <span class="error"></span></label>';
    $Control .=      '<div class="controls">';
    $Control .=          '<input type="hidden" name="'.$EiDe.'" id="'.$EiDe.'" value="'.$Vide.'"/>';
    $Control .=          '<textarea name="'.$Edescripcion.'" id="'.$Edescripcion.'" rows="3" onChange="conMayusculas(this)" maxlength="2000" class="xlarge alphanumeric show-popover"  data-trigger="hover" data-content="'.$BMensaje.' empleando el boton agregar(+)" style="resize:none;" disabled >'.$Vdescripcion.'</textarea>';
    $Control .=          '<input name="Submit2" type="button" value="" id="add16" title="Seleccionar '.$BMensaje.'" onclick=" Add'.$BfuncionJava.'('."'".$Edescripcion."'".')"/>';
    $Control .=      '</div>';
    $Control .= '</div>';
    
    echo $Control ;
}





/**************************************************************************************/
function Fecha_formato( $Fecha , $Tipo = 'DDMMYYYY', $Separador='/' ){
    
//    if($Fecha){
        $Fecha_formato='';
        $Anio = substr($Fecha, 0,4);
        $Mes = substr($Fecha, 5,2);
        $Dia = substr($Fecha, 8,2); 
        
        switch ($Tipo){
                case 'DDMMYYYY': $Fecha_formato =  $Dia .$Separador. $Mes .$Separador. $Anio ;
                    break;
        }
        
        return $Fecha_formato;
//    }
}





function RolPermiso ($PermisosPerfil) {
    $Rol = '';
    
    $Data = GenTablas_RolAbrev($PermisosPerfil);
    $Rol = $Data['DES_ABREVIATURA'];

    return $Rol;
}

function btnGrabarDesabilitar($RolPermiso) {
    $Ver = '' ;
    switch ($RolPermiso) {
        case 'DE_Gabinete':
            $Ver = ' style="display:none" ';
            break;
        default:
            break;
    }
    return $Ver ;
}

?>
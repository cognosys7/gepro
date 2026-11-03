<?php
class DataProcedimiento{  
    public $Resultado=0;    
    private $Conexion;
    public function __construct() {       
       $this->Conectar();              
    }
     public function __destruct() {
        $this->LimpiarResultado();
    }
    Public function Conectar(){
        $serverName = "10.34.2.20";
        $connectionInfo = array( "Database"=>"PRONIED_DESARROLLO", "UID"=>"prueba", "PWD"=>"" /* clave retirada */,"CharacterSet" =>"UTF-8");
        $conn = sqlsrv_connect( $serverName, $connectionInfo);
        if( $conn === false) {
           return false;
        }
       $this->Conexion=$conn;
      
       return $this->Conexion;        
    }
    public function LimpiarResultado() {
        if ($this->Resultado) {
            $this->Resultado = 0;
        }
    }
     public function MostrarResultado($Consulta,$Parametros) { 
        $lista = array();
        $stmt = sqlsrv_query($this->Conexion, $Consulta, $Parametros);        
        if( $stmt === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        $result=sqlsrv_execute($stmt);      
        $i=0;
        do
        {            
            while ($obj=sqlsrv_fetch_object($stmt)) {
                $lista[$i]=$this->ObjetoStdClass_Array($obj);
                $i++;
            }                             
        }     
        while (sqlsrv_next_result($stmt) !== false);            
        $this->Resultado=$lista;      
        return $this->Resultado;           
    }
     public function ObjetoStdClass_Array($stdclassobject) {
        $_array = is_object($stdclassobject) ? get_object_vars($stdclassobject) : $stdclassobject;
        foreach ($_array as $key => $value) {
                $value = (is_array($value) || is_object($value)) ? ObjetoStdClass_Array($value) : $value;
                $array[$key] = $value;
        }
        return $array;
}

}
<?php

require_once("Exception.php");

class SQLServerClass {

    /**
     * instance of this class
     */
    static private $mInstance;

    /**
     * Connection to the database
     */
    private $mConnection;

    /**
     * Hostname of the database server
     */
    private $mHostname;

    /**
     * Database name
     */
    private $mDatabase;

    /**
     * Username
     */
    private $mUsername;

    /**
     * Password
     */
    private $mPassword;

    /**
     * Resultset
     */
    private $mResult;
    /**
     * Resultset
     */
    private $mResult1;

    /**
     * Number of first row of limited resultset
     */
    private $mFirstRow = 0;

    /**
     * Number of rows of limited resultset
     */
    private $mNrOfRows = 0;

    /**
     * Constructor
     * @param $aHostname hostname of database server
     * @param $aDatabase name of database
     * @param $aUsername username
     * @param $aPassword password
     */
    public function __construct($aHostname, $aDatabase, $aUsername, $aPassword) {
        $this->mHostname = $aHostname;
        $this->mDatabase = $aDatabase;
        $this->mUsername = $aUsername;
        $this->mPassword = $aPassword;

        $this->mResult = 0;

        $this->mFirstRow = 0;
        $this->mNrOfRows = 0;
    }

    /**
     * Destructor
     */
    public function __destruct() {
        $this->FreeResult();
    }

    /**
     * Singleton, use this method to be sure that only one instance of this class is used.
     * @param $aHostname hostname of database server
     * @param $aDatabase name of database
     * @param $aUsername username
     * @param $aPassword password
     * @return existing or newly created instance of MySQL class
     */
    public static function singleton($aHostname, $aDatabase, $aUsername, $aPassword) {

        if (!isset(self::$mInstance)) {
            self::$mInstance = new SQLServerClass($aHostname, $aDatabase, $aUsername, $aPassword);
        }

        return self::$mInstance;
    }

    /**
     * Clone
     * @thows Exception("cloning not allowed")
     */
    public function __clone() {
        throw new Exception(ERROR_CLONE_NOT_ALLOWED);
    }

    /**
     * Connect to database
     * @throws FatalException("No Connection")
     */
    public function Connect() {
        $conn_array = array(
            "UID" => $this->mUsername,
            "PWD" => $this->mPassword,
            "Database" => $this->mDatabase
            , "CharacterSet" => "UTF-8"
        );
        $this->mConnection = @sqlsrv_connect($this->mHostname, $conn_array);
        if ($this->mConnection === false)
            throw new FatalException(DB_ERROR_CONNECT);

//        if (sqlsrv_select_db($this->mDatabase) == false)
//            throw new FatalException(DB_ERROR_CONNECT." ".mssql_get_last_message());
    }

    /**
     * Execute select query
     * @param $aQuery query to be executed
     * @return resultset on success, false on failure
     * @throws FatalException on failure
     */
    public function DoSelect($aQuery) {

        // free result set to be sure that no old results are used
        $this->FreeResult();

        if ($this->mConnection) {
            if ($this->mNrOfRows > 0) {
                $aQuery .= " LIMIT " . $this->mFirstRow . ", " . $this->mNrOfRows . " ";

                $this->mFirstRow = 0;
                $this->mNrOfRows = 0;
            }

            $this->mResult = sqlsrv_query($this->mConnection, $aQuery);
            if ($this->mResult === false) {
                if (($errors = sqlsrv_errors() ) != null) {
                    foreach ($errors as $error) {
                        $sSQLERROR = "SQLSTATE: " . $error['SQLSTATE'] . "<br />";
                        $sSQLERROR.= "code: " . $error['code'] . "<br />";
                        $sSQLERROR.= "message: " . $error['message'] . "<br />";
                    }
                    throw new FatalException($sSQLERROR);
                }
            }
            return $this->mResult;
        }

        return false;
    }

    /**
     * Execute query
     * @param $aQuery query to be executed
     * @return resultset on success, false on failure
     */
    private function DoQuery($aQuery) {

        if ($this->mConnection)
            return sqlsrv_query($this->mConnection, $aQuery);

        return false;
    }

    /**
     * Execute update query
     * @param $aQuery query to be executed
     * @return true on success, false on failure
     * @throws FatalException on failure
     */
    public function DoUpdate($aQuery) {
        $lIsSuccessFull = $this->DoQuery($aQuery);

        if (!$lIsSuccessFull)
            throw new FatalException(DB_ERROR_UPDATE . " ");

        return $lIsSuccessFull;
    }

    /**
     * Execute insert query
     * @param $aQuery query to be executed
     * @return last inserted id on success, false on failure
     * @throws FatalException on failure
     */
    public function DoInsert($aQuery) {
        $lIsSuccessFull = $this->DoQuery($aQuery);

        if (!$lIsSuccessFull)
            throw new FatalException(DB_ERROR_INSERT . " ");

        return $lIsSuccessFull;
        //return @mssql_insert_id($this->mConnection);
    }

    /**
     * Execute delete query
     * @param $aQuery query to be executed
     * @return true on success, false on failure
     * @throws FatalException on failure
     */
    public function DoDelete($aQuery) {
        $lIsSuccessFull = $this->DoQuery($aQuery);

        if (!$lIsSuccessFull)
            throw new FatalException(DB_ERROR_DELETE . " " . mysql_error() . " " . mysql_errno());

        return $lIsSuccessFull;
    }

    /**
     * Execute count query
     * @param $aQuery query to be executed
     * @return resultset on success, false on failure
     * @throws FatalException on failure
     */
    public function DoCount($aQuery) {
        $aQuery = "SELECT COUNT(*) AS Count " . stristr($aQuery, " FROM ");
        return $this->DoSelect($aQuery);
    }

    /**
     * Fetch row and return result
     * Free result set when last row is reached
     * @return row on success, false on failure
     */
    public function GetRow() {

        if ($this->mResult) {
            // Fetch row and return result
            $lRow = sqlsrv_fetch_array($this->mResult, SQLSRV_FETCH_ASSOC);

            if ($lRow)
                return $lRow;
            else {
                // Free result set when last row is reached
                sqlsrv_free_stmt($this->mResult);
                $this->mResult = 0;
            }
        }

        return false;
    }

    /**
     * Fetch object and return result
     * Free result set when last row is reached
     * @return object on success, false on failure
     */
    public function GetObject() {

        if ($this->mResult) {
            // Fetch row and return result
            $lObject = sqlsrv_fetch_object($this->mResult);

            if ($lObject)
                return $lObject;
            else {
                // Free result set when last row is reached
                sqlsrv_free_stmt($this->mResult);
                $this->mResult = 0;
            }
        }

        return false;
    }

    /**
     * Free result set
     */
    public function FreeResult() {
        if ($this->mResult) {
            //sqlsrv_free_stmt($this->mResult);
            $this->mResult = 0;
        }
    }

    /**
     * Count number of rows in result set
     * @return number of rows
     */
    public function Count() {
        if ($this->mResult)
            return sqlsrv_num_rows($this->mResult);

        return 0;
    }

    /**
     * Get limited number of rows from query
     * This method must be called before calling DoSelect()
     *
     * @param $aFirstRow first row of subset
     * @param $aNrOfRows nr of rows in subset
     */
    public function Limit($aFirstRow, $aNrOfRows) {
        $this->mFirstRow = $aFirstRow;
        $this->mNrOfRows = $aNrOfRows;
    }

    /**
     * Ejecuta un procedimiento almacenado
     * @param $aQuery Query que será ejecutada
     * @aParametro Array de parametros
     * @return resultset on success, false on failure
     */
    public function DoExcuteSP($aQuery, $aParametro) {

        // free result set to be sure that no old results are used
        $this->FreeResult();

        if ($this->mConnection) {

            $stmt = sqlsrv_prepare($this->mConnection, $aQuery, $aParametro);

            if (!$stmt) {
                die(var_dump(sqlsrv_errors(), true));
            }

            $this->mResult = sqlsrv_execute($stmt);
            
//            $stmt1 = null;
            
//            if ($this->mResult) {
//                $stmt1 = $stmt;
//                while ($res = sqlsrv_next_result($stmt)) {
//                    // make sure all result sets are stepped through, since the output params may not be set until this happens
//                }
//                // Output params are now set,
//                //print_r($aParametro);
//            } else {
//                die(print_r(sqlsrv_errors(), true));
//            }

//            var_dump($aParametro);
//            exit;

            if ($this->mResult === false) {
                if (($errors = sqlsrv_errors() ) != null) {
                    foreach ($errors as $error) {
                        $sSQLERROR = "SQLSTATE: " . $error['SQLSTATE'] . "<br />";
                        $sSQLERROR.= "code: " . $error['code'] . "<br />";
                        $sSQLERROR.= "message: " . $error['message'] . "<br />";
                    }
                    throw new FatalException($sSQLERROR);
                }
            } else {
                $this->mResult = $stmt;
                
            }
            return $this->mResult;
        }

        return false;
    }
    /**
     * Ejecuta un procedimiento almacenado
     * @param $aQuery Query que será ejecutada
     * @aParametro Array de parametros
     * @return resultset on success, false on failure
     */
    public function DoExcuteSP1($aQuery, $aParametro) {

        // free result set to be sure that no old results are used
        $this->FreeResult();

        if ($this->mConnection) {

            $stmt = sqlsrv_prepare($this->mConnection, $aQuery, $aParametro);
            
            if (!$stmt) {
                die(var_dump(sqlsrv_errors(), true));
            }

            $this->mResult = sqlsrv_execute($stmt);
            
            if ($this->mResult === false) {
                if (($errors = sqlsrv_errors() ) != null) {
                    foreach ($errors as $error) {
                        $sSQLERROR = "SQLSTATE: " . $error['SQLSTATE'] . "<br />";
                        $sSQLERROR.= "code: " . $error['code'] . "<br />";
                        $sSQLERROR.= "message: " . $error['message'] . "<br />";
                    }
                    throw new FatalException($sSQLERROR);
                }
            } else {
                
                $lRow = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
                while ($res = sqlsrv_next_result($stmt)) {
//                    // make sure all result sets are stepped through, since the output params may not be set until this happens
                }
                $this->mResult = $stmt;
                
            }
            return $this->mResult;
        }

        return false;
    }
    /**
     * Ejecuta procedimiento almacenado 
     * OUT 
     *      1. Resulset
     *      2.  Parametros de Salida
     * @param type $aQuery
     * @param type $aParametro
     * @return boolean
     * @throws FatalException
     */
    public function DoExcuteSP2($aQuery, $aParametro,$aNombreClase) {

        // free result set to be sure that no old results are used
        $this->FreeResult();

        if ($this->mConnection) {

            $stmt = sqlsrv_prepare($this->mConnection, $aQuery, $aParametro);
            
            if (!$stmt) {
                die(var_dump(sqlsrv_errors(), true));
            }

            $bResultado = sqlsrv_execute($stmt);
            
            if ($bResultado === false) {
                if (($errors = sqlsrv_errors() ) != null) {
                    foreach ($errors as $error) {
                        $sSQLERROR = "SQLSTATE: " . $error['SQLSTATE'] . "<br />";
                        $sSQLERROR.= "code: " . $error['code'] . "<br />";
                        $sSQLERROR.= "message: " . $error['message'] . "<br />";
                    }
                    throw new FatalException($sSQLERROR);
                }
            } else {
                
                //muestra el primer resultado
                while( $lFila =  sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))
                {
                    $lObject = new $aNombreClase;

                    foreach (array_keys($lFila) as $lArrayKey)
                        $lObject->{$lArrayKey} = $lFila["$lArrayKey"];
                    
                    $this->mResult1[] = clone $lObject;

                }
                //Se mueve al siguiente resultset para poder ver los parametros de salida
                sqlsrv_next_result($stmt);
            }
            return $this->mResult1;
        }

        return false;
    }

}

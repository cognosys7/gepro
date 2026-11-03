<?php

require_once("Exception.php");

class MySqlClass {
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
           self::$mInstance = new MySqlClass($aHostname,$aDatabase,$aUsername,$aPassword);
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
       $this->mConnection = @mysql_connect($this->mHostname,$this->mUsername,$this->mPassword);
        mysql_query("SET NAMES 'utf8'");
        if ($this->mConnection === false)
            throw new FatalException(DB_ERROR_CONNECT." ".mysql_error()." ".mysql_errno());

        if (@mysql_select_db($this->mDatabase) == false)
            throw new FatalException(DB_ERROR_CONNECT." ".mysql_error()." ".mysql_errno());
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
                $aQuery .= " LIMIT ".$this->mFirstRow.", ".$this->mNrOfRows." ";

                $this->mFirstRow = 0;
                $this->mNrOfRows = 0;
            }

            $this->mResult = @mysql_query($aQuery,$this->mConnection);
            if ($this->mResult === false)
                throw new FatalException(mysql_error()." ".mysql_errno());

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
            return mysql_query($aQuery,$this->mConnection);

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
            throw new FatalException(DB_ERROR_UPDATE." ".mysql_error()." ".mysql_errno());

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
            throw new FatalException(DB_ERROR_INSERT." ".mysql_error()." ".mysql_errno());

        return mysql_insert_id($this->mConnection);
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
            throw new FatalException(DB_ERROR_DELETE." ".mysql_error()." ".mysql_errno());

        return $lIsSuccessFull;
    }

    /**
     * Execute count query
     * @param $aQuery query to be executed
     * @return resultset on success, false on failure
     * @throws FatalException on failure
     */
    public function DoCount($aQuery) {
        $aQuery = "SELECT COUNT(*) AS Count ".stristr($aQuery," FROM ");
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
            $lRow = @mysql_fetch_array($this->mResult,MYSQL_ASSOC);

            if ($lRow)
                return $lRow;
            else {
                // Free result set when last row is reached
                @mysql_free_result($this->mResult);
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
            $lObject = @mysql_fetch_object($this->mResult);

            if ($lObject)
                return $lObject;
            else {
                // Free result set when last row is reached
                @mysql_free_result($this->mResult);
                $this->mResult = 0;
            }
        }

        return false;
    }

    /**
     * Free result set
     */
    public function FreeResult()   {
        if ($this->mResult) {
            @mysql_free_result($this->mResult);
            $this->mResult = 0;
        }
    }

    /**
     * Count number of rows in result set
     * @return number of rows
     */
    public function Count() {
        if ($this->mResult)
            return mysql_num_rows($this->mResult);

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
}
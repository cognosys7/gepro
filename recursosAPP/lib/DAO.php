<?php
abstract class DAO
{
    /**
     * Connection to the databased
     */
    protected $mConnection;

    /**
     * String containing the query
     */
    protected $mQuery;

    /**
     * Object which is filled with data from database
     */
    protected $mObject = null;

    /**
     * Array of objects filled with data from database
     */
    protected $mList = null;

    /**
     * Flag to indicate if the COUNT(*)  variant of the query must be executed.
     * @see #DoCount()
     */
    protected $mDoCount = false;
    /**
     *
     * Array de parametros para el procedimiento almacenado
     * ALNIX 16JUL2015 
     */
    protected $mParametro = null;

    /**
     * Constructor
     * @param $aHostname hostname of database server
     * @param $aDatabase name of database
     * @param $aUsername username
     * @param $aPassword password
     * @param $aUseSingleton whether or not to use a singleton for the database connection.
     *        Set this paramaeter to false if you want to connect to two different database at the same time
     * @param $aDriver Indicate the driver connection that this class will use. e.g. MySQLi, Postgre
     * @throws Exception
     */
    public function __construct($aHostname, $aDatabase, $aUsername, $aPassword, $aUseSingleton=true, $aDriver=DB_DRIVER)
    {
        switch ($aDriver){
            case DRIVER_MYSQL:
                require_once (RECURSOSGEN_LIB."/MySQL.php");
                if ($aUseSingleton)
                    $this->mConnection = MySqlClass::singleton($aHostname, $aDatabase, $aUsername, $aPassword);
                else
                    $this->mConnection = new MySQLClass($aHostname, $aDatabase, $aUsername, $aPassword);
                break;
            case DRIVER_MYSQLI:
                require_once (RECURSOSGEN_LIB."/MySQLi.php");
                if ($aUseSingleton)
                    $this->mConnection = MySQLiClass::singleton($aHostname, $aDatabase, $aUsername, $aPassword);
                else
                    $this->mConnection = new MySQLiClass($aHostname, $aDatabase, $aUsername, $aPassword);
                break;
            case DRIVER_SQLSERVER:
                require_once (RECURSOSGEN_LIB."/SQLServer.php");
                if ($aUseSingleton)
                    $this->mConnection = SQLServerClass::singleton($aHostname, $aDatabase, $aUsername, $aPassword);
                else
                    $this->mConnection = new SQLServerClass($aHostname, $aDatabase, $aUsername, $aPassword);
                break;
        }

        $this->mConnection->Connect();

        if ( isset ($this->mObject))
        {
            // free object
            $this->mObject->Free();
            // unbind reference
            unset ($this->mObject);
        }

        if ( isset ($this->mList))
        {
            // free list
            $this->FreeList();
            // unbind reference
            unset ($this->mList);
        }
    }

    /**
     * Executes select query and stores data in object.
     *
     * @return true on success. false on failure
     * @throws Exception
     */
    public function Select($aClearOnFailure = true)
    {
        $this->mConnection->DoSelect($this->mQuery);

        $lRow = $this->mConnection->GetRow();
        if ($lRow){
            $this->RowToObject($lRow, $this->mObject);
            return true;
        }

        if ($aClearOnFailure && isset ($this->mObject))
        {
            $this->mObject->Clear();
        }

        return false;
    }

    /**
     * Executes select query and stores result in array of objects
     *
     * @return true on success. false on failure
     * @throws Exception
     */
    public function SelectList()
    {
        if ($this->mDoCount)
            return $this->SelectCount();

        $lIsValid = false;

        // clear array, to be sure no old results are left
        $this->FreeList();
        $this->mConnection->DoSelect($this->mQuery);

        $lClassName = get_class($this->mObject);

        $i = 0;
        while ($lRow = $this->mConnection->GetRow())
        {
            $lObject = new $lClassName();

            $this->RowToObject($lRow, $lObject);
            $this->mList[] = clone $lObject;

            $lIsValid = true;
        }

        return $lIsValid;
    }
    /**
     * Ejecuta Una consulta select y almacena resutlados en un array de objetos
     *
     * @return true on success. false on failure
     * @throws Exception
     */
    public function SelectListSP()
    {
        if ($this->mDoCount)
            return $this->SelectCount();

        $lIsValid = false;

        // clear array, to be sure no old results are left
        $this->FreeList();
        
        $this->mConnection->DoExcuteSP($this->mQuery,$this->mParametro);

        $lClassName = get_class($this->mObject);

        while ($lRow = $this->mConnection->GetRow())
        {
            $lObject = new $lClassName();

            $this->RowToObject($lRow, $lObject);
            $this->mList[] = clone $lObject;

            $lIsValid = true;
        }

        return $lIsValid;
    }
    /**
     * 
     * @return boolean
     */
    public function SelectListSP2()
    {
        if ($this->mDoCount)
            return $this->SelectCount();

        $lIsValid = false;

        // clear array, to be sure no old results are left
        $this->FreeList();
        $lClassName = get_class($this->mObject);

        $this->mList = $this->mConnection->DoExcuteSP2($this->mQuery,$this->mParametro,$lClassName);
        
        $lIsValid = true;
        return $lIsValid;
    }

    /**
     * Executes insert query
     *
     * @return last inserted id on success. false on failure
     * @throws Exception
     */
    public function Insert()
    {
        return $this->mConnection->DoInsert($this->mQuery);
    }
    /**
     * 
     * Ejecuta un procedimiento almacenado con parametros
     * ALNIX 16JUL2015
     * 
     */
    public function executeSP()
    {
        return $this->mConnection->DoExcuteSP1($this->mQuery,$this->mParametro);
    }

    /**
     * Executes update query
     *
     * @return true on success. false on failure
     * @throws Exception
     */
    public function Update()
    {
        return $this->mConnection->DoUpdate($this->mQuery);
    }

    /**
     * Executes delete query
     *
     * @return true on success. false on failure
     * @throws Exception
     */
    public function Delete()
    {
        $lIsDeleted = $this->mConnection->DoDelete($this->mQuery);

        if ($lIsDeleted && isset ($this->mObject)){
            $this->mObject->Clear();
        }

        return $lIsDeleted;
    }

    /**
     * Returns number of items in List
     *
     * @return number of items in list
     */
    public function Count()
    {
        // return number of items in list
        if (isset($this->mList))
            return count($this->mList);

        return 0;
    }

    /**
     * Get limited number of rows from query
     * This method must be called before calling SelectList()
     *
     * @param $aFirstRow first row of subset
     * @param $aNrOfRows nr of rows in subset
     */
    public function Limit($aFirstRow, $aNrOfRows)
    {
        $this->mConnection->Limit($aFirstRow, $aNrOfRows);
    }

    public function OrderBy($aOrderBySentence)
    {
        $this->mConnection->OrderBy($aOrderBySentence);
    }

    /**
     * Call this function before calling SelectList() to get the number of records for that query
     */
    public function DoCount()
    {
        $this->mDoCount = true;
    }

    /**
     * Count the number of records which will be selected by mQuery
     *
     * @return number of records which will be selected by mQuery
     * @throws Exception
     */
    private function SelectCount()
    {
        // clear array, to be sure no old results are left
        $this->FreeList();

        $this->mConnection->DoCount($this->mQuery);

        $lRow = $this->mConnection->GetRow();
        if ($lRow){
            $this->mDoCount = false;
            return $lRow["Count"];
        }

        return 0;
    }

    /**
     * Converts data row to object
     *
     * @param $aRow datarow
     * @param &$aObject object
     * @throws Exception
     */
    private function RowToObject($aRow, & $aObject)
    {
        foreach (array_keys($aRow) as $lArrayKey)
            $aObject->{$lArrayKey} = $aRow["$lArrayKey"];
    }

    /**
     * Free list and its items
     */
    private function FreeList()
    {
        if ( isset ($this->mList)){
            foreach ($this->mList as $lItem){
                if ( isset ($lItem)){
                    $lItem->Free();
                    unset ($lItem);
                }
            }
        }
    }

    public function getMQuery() {
        return $this->mQuery;
    }
    
}

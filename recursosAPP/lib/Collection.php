<?php
class Collection{
    static private $mInstance;
    private $mList = array();
    
    public function __contruct(){
        $this->mList = array();
    }
    
    final public function __destruct() {
        $this->Free();
    }
    
    public static function Singleton() {
       if (!isset(self::$mInstance)) {
           self::$mInstance = new Collection();
       }

       return self::$mInstance;
    }
    
    public function Add($aName,$aItem){
        $this->mList[$aName] = $aItem;
    }
    
    public function Get($aName) {
        if (array_key_exists($aName,$this->mList))
            return $this->mList[$aName];

        return false;
    }
    
    public function Clear() {
        foreach ($this->mList as $lItem) {
            if (method_exists($lItem,"Free"))
                //$lItem->Free();
            unset($lItem);
        }
    }
    
    public function Free() {
        if (isset($this->mList)) {
            $this->Clear();
            unset($this->mList);
        }
    }
}
?>

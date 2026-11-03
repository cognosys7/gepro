<?php

class DynamicModel{
	protected $mPropertyList = array();

	public function __construct() {
		$this->mPropertyList = array();
	}
    
    public function __destruct() {
        $this->Free();
    }

	public function __get($aPropertyName) {
		if (array_key_exists($aPropertyName,$this->mPropertyList))
			return $this->mPropertyList[$aPropertyName];

		return "";
	}

	public function __set($aPropertyName, $aPropertyValue) {
		$this->mPropertyList[$aPropertyName] = $aPropertyValue;
	}

	public function Free() {
		if (isset($this->mPropertyList)) {
			unset($this->mPropertyList);
		}
	}

	public function Clear() {
		if (isset($this->mPropertyList)) {
			foreach ($this->mPropertyList as $lProperty)
				$lProperty = "";
		}
	}

	public function GetPropertyList() {
		return $this->mPropertyList;
	}
    
    public function __toString() {
        return get_class($this);
    }

    final public function __unset($aName) {
        $this->Free();
    }
}
?>

<?php
	abstract class NP_Model
	{
    	public static function hasRequiredAttributes($compareArray)
		{	
			$reqs = static::getCreateRequiredAttributes();
			if (count(array_intersect_key(array_flip($reqs), $compareArray)) === count($reqs))
				return TRUE;

			return FALSE;	
		}

		function getArray() {

			$valuesArray = array();
			$refObj = new ReflectionObject($this);
			foreach ($refObj->getProperties() as $prop) {
				$propName = $prop->getName();
				$propValue = $this->$propName;
				if(!is_null($propValue))
					$valuesArray[$propName] = $propValue;
			}

			return $valuesArray;
    	}
		abstract static function getTableName();
		abstract static function getCreateRequiredAttributes();
	}
?>

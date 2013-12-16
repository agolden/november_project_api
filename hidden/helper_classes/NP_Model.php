<?php
	abstract class NP_Model
	{
    	abstract function getArray();
		
		public static function hasRequiredAttributes($compareArray)
		{	
			$reqs = static::getCreateRequiredAttributes();
			if (count(array_intersect_key(array_flip($reqs), $compareArray)) === count($reqs))
				return TRUE;

			return FALSE;	
		}
		
		abstract static function getCreateRequiredAttributes();
	}
?>

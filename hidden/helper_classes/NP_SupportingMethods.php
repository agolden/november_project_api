<?php
	require_once('NP_exceptions.php');

	class SupportingMethods
	{
		public static function isPositiveInteger($i)
		{
			if (!is_numeric($i) || $i < 1 || $i != round($i)) {
				return FALSE;
			}
			return TRUE;
		}
		
		public static function getValidJSON()
		{
			$inputJSON = file_get_contents('php://input');
			$input = json_decode( $inputJSON, TRUE );

			if ($_SERVER['CONTENT_TYPE'] != "application/json" || is_null($input))
				throw new BadJSONException(null);
			
			return $input;
		}

		public static function createObjectFromRequest($request, $object_name, $errorOnParamNotFound = true)
		{
			$refClass = new ReflectionClass($object_name);
			$object = $refClass->newInstance();
			foreach ($request as $key => $value) {
	    		if(!$refClass->hasProperty($key))
	    		{
	    			if($errorOnParamNotFound)
	    				throw new InvalidParameterException(null);
				}
				else
					$object->$key = $value;					
			}

			return $object;
		}
	}

?>
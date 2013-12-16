<?php
	require_once('NP_exceptions.php');

	function isPositiveInteger($i)
	{
		if (!is_numeric($i) || $i < 1 || $i != round($i)) {
			return FALSE;
		}
		return TRUE;
	}
	
	function getValidJSON()
	{
		$inputJSON = file_get_contents('php://input');
		$input = json_decode( $inputJSON, TRUE );

		if ($_SERVER['CONTENT_TYPE'] != "application/json" || is_null($input))
			throw new BadJSONException(null);
		
		return $input;
	}	

?>
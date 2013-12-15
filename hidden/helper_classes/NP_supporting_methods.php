<?php
	require_once('NP_exceptions.php');

	function getValidJSON()
	{
		$inputJSON = file_get_contents('php://input');
		$input = json_decode( $inputJSON, TRUE );

		if ($_SERVER['CONTENT_TYPE'] != "application/json" || is_null($input))
			throw new BadRequestException("Invalid or no JSON in request.");
		
		return $input;
	}	
	
	function executeSQL($stmt, &$response)
	{
		if (!$stmt->execute())
		{
			$response->errorCode = 1;
			$response->errorMessage = "Error in query.  Missing, invalidly formatted, or invalid values in request.";
		}
	}
?>
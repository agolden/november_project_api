<?php	require_once('../hidden/helper_classes/NP_RequestHandler.php');	require_once('../hidden/service_layer/NP_WorkoutLocationService.php');	require_once('../hidden/data_model/NP_UserModel.php');		class WorkoutLocationHandler extends RequestHandler	{		function handlePost($token) { $this->handleSimplePost($token); }		function handlePut($token) { $this->handleSimplePut($token); }		function handleGet($token) { $this->handleSimpleGet($token); }	}		$handler = new WorkoutLocationHandler;	$handler->handleRequest();?>
<?php	require_once('../hidden/helper_classes/NP_RequestHandler.php');	require_once('../hidden/helper_classes/NP_supporting_methods.php');	require_once('../hidden/service_layer/NP_WorkoutLocationService.php');		class WorkoutLocationHandler extends RequestHandler	{		function handleGet()		{			$workout_location_service = new WorkoutLocationService($this->DBH);			$this->response->records = $workout_location_service->getAllLocations();		}				function handlePost()		{			$request = getValidJSON();								$stmt = $this->mysqli->prepare("INSERT INTO Workout_Location (name, lat, lng) values (?, ?, ?)");			$stmt->bind_param('sss', $request['name'], $request['lat'], $request['lng']);			executeSQL($stmt, $this->response);		}				function handlePut()		{			$request = getValidJSON();								$stmt = $this->mysqli->prepare("UPDATE Workout_Location SET name=?,lat=?,lng=? WHERE ID=?");			$stmt->bind_param('ssss', $request['name'], $request['lat'], $request['lng'], $request['ID']);			executeSQL($stmt, $this->response);		}	}		$handler = new WorkoutLocationHandler;	$handler->handleRequest();?>
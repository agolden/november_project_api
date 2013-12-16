<?php	require_once('../hidden/helper_classes/NP_RequestHandler.php');	require_once('../hidden/service_layer/NP_WorkoutLocationService.php');	require_once('../hidden/data_model/NP_WorkoutLocationModel.php');		class WorkoutLocationHandler extends RequestHandler	{		function handleGet()		{			$workout_location_service = new WorkoutLocationService($this->DBH);						if(!empty($_GET['id']))				$this->response->records = $workout_location_service->getWorkoutLocationById($_GET['id']);			elseif(!empty($_GET['tribe_id']))				$this->response->records = $workout_location_service->getWorkoutLocationByTribeId($_GET['tribe_id']);			else				$this->response->records = $workout_location_service->getAllWorkoutLocations();		}				function handlePost()		{			$workout_location_service = new WorkoutLocationService($this->DBH);			$request = RequestHandler::getValidJSON();						if (!WorkoutLocationModel::hasRequiredAttributes($request))				throw new RequiredParameterMissingException(null);						$this->response->records = $workout_location_service->createWorkoutLocation($request['tribe_id'], $request['name'], $request['latitude'], $request['longitude']);		}				function handlePut()		{			$workout_location_service = new WorkoutLocationService($this->DBH);			$request = RequestHandler::getValidJSON();						$location_record = $workout_location_service->getWorkoutLocationById($_GET['id']);						//$stmt = $this->mysqli->prepare("UPDATE Workout_Location SET name=?,lat=?,lng=? WHERE ID=?");			//$stmt->bind_param('ssss', $request['name'], $request['lat'], $request['lng'], $request['ID']);			//executeSQL($stmt, $this->response);		}	}		$handler = new WorkoutLocationHandler;	$handler->handleRequest();?>
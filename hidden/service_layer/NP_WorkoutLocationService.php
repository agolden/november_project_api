<?php
	require_once('../hidden/helper_classes/NP_service.php');
	require_once('../hidden/data_model/NP_WorkoutLocationModel.php');
	
	class WorkoutLocationService extends NP_service{
    	
    	function getAllLocations()
		{
			$response = array();
			foreach($this->DBH->query('SELECT * FROM workout_location') as $record) {
				$jsonObject = new WorkoutLocationModel;
				$jsonObject->id = $record['id'];
				$jsonObject->tribe_id = $record['tribe_id'];
				$jsonObject->name = $record['name'];
				$jsonObject->lat = $record['latitude'];
				$jsonObject->lng = $record['longitude'];
				
				$response[] = $jsonObject->getArray();
			}
			return $response;
		}
	}
?>

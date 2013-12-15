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
		
		function getLocationById($id)
		{
			$response = array();
			$stmt = $this->DBH->prepare('SELECT * FROM workout_location where id = :id');
			$stmt->execute(array(':id' => $id));
			
			foreach($stmt->fetchAll() as $record) {
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

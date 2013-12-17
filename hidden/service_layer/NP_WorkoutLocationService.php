<?php
	require_once('../hidden/helper_classes/NP_Service.php');
	require_once('../hidden/data_model/NP_WorkoutLocationModel.php');
	require_once('../hidden/helper_classes/NP_exceptions.php');
	require_once('../hidden/service_layer/NP_TribeService.php');
	
	class WorkoutLocationService extends NP_service{
    	
		function __construct($dbh) {
			$this->DBH = $dbh;
			$this->uniqueErrorMessage = 'The workout location name must be unique.';
			$this->invalidReferenceMessage = 'The tribe id you referenced was not found.';
		}
		
    	function getAllWorkoutLocations()
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

		function getWorkoutLocationByTribeId($tribe_id)
		{
			$response = array();
			$stmt = $this->DBH->prepare('SELECT * FROM workout_location where tribe_id = :tribe_id');
			$stmt->execute(array(':tribe_id' => $tribe_id));
			
			foreach($stmt->fetchAll() as $record) {
				$jsonObject = new WorkoutLocationModel;
				$jsonObject->id = $record['id'];
				$jsonObject->tribe_id = $record['tribe_id'];
				$jsonObject->name = $record['name'];
				$jsonObject->lat = $record['latitude'];
				$jsonObject->lng = $record['longitude'];
				
				$response[] = $jsonObject->getArray();
			}

			//If no records, confirm whether the tribe even exists
			if (count($response) == 0)
				(new TribeService($this->DBH))->getTribeById($tribe_id);
			
			return $response;
		}
		
		function getWorkoutLocationById($id)
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
			
			if (count($response) != 1)
				throw new RecordNotFoundException("The workout location you requested was not found.");
			
			return $response;
		}
		
		function upsertWorkoutLocation($workout_location)
		{
			try
			{
				$response = array();
				$stmt = $this->DBH->prepare('INSERT INTO workout_location(tribe_id, name, latitude, longitude) VALUES (:tribe_id, :name, :latitude, :longitude)');
				$stmt->execute(array(':tribe_id' => $tribe_id, ':name' => $name, ':latitude' => $latitude, ':longitude' => $longitude));
				
				$jsonObject = new WorkoutLocationModel;
				$jsonObject->id = $this->DBH->lastInsertId();
				$jsonObject->tribe_id = $tribe_id;
				$jsonObject->name = $name;
				$jsonObject->latitude = $latitude;
				$jsonObject->longitude = $longitude;
				$response[] = $jsonObject->getArray();
				return $response;
			}
			catch (PDOException $e) { $this->handlePDOError($e); }
		}
	}
?>

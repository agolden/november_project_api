<?php
	require_once('../hidden/helper_classes/NP_Service.php');
	require_once('../hidden/helper_classes/NP_exceptions.php');
	require_once('../hidden/data_model/NP_TribeModel.php');
	
	class TribeService extends NP_service{
    	
		function getTribeById($id)
		{
			$response = array();
			$stmt = $this->DBH->prepare('SELECT * FROM tribe where id = :id');
			$stmt->execute(array(':id' => $id));
			
			foreach($stmt->fetchAll() as $record) {
				$jsonObject = new TribeModel;
				$jsonObject->id = $record['id'];
				$jsonObject->name = $record['name'];
				$jsonObject->lat = $record['latitude'];
				$jsonObject->lng = $record['longitude'];
				
				$response[] = $jsonObject->getArray();
			}
			
			if (count($response) != 1)
				throw new RecordNotFoundException("The tribe you requested was not found.");
			
			return $response;
		}
	}
?>

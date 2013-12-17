<?php
	require_once('../hidden/helper_classes/NP_Service.php');
	require_once('../hidden/helper_classes/NP_exceptions.php');
	require_once('../hidden/data_model/NP_UserModel.php');
	
	class UserService extends NP_service{
    	
		function getUserByAppToken($app_token)
		{
			$response = array();
			$stmt = $this->DBH->prepare('SELECT * FROM user where app_token = :app_token');
			$stmt->execute(array(':app_token' => $app_token));
			
			foreach($stmt->fetchAll() as $record) {
				$jsonObject = new UserModel;
				$jsonObject->id = $record['id'];
				$jsonObject->name = $record['name'];
				$jsonObject->lat = $record['latitude'];
				$jsonObject->lng = $record['longitude'];
				
				$response[] = $jsonObject->getArray();
			}
			
			if (count($response) != 1)
				throw new RecordNotFoundException("The user you requested was not found.");
			
			return $response;
		}

		function upsertUser($user)
		{
			if (empty($user->id))
			{
				//Create a new record
			}
			else
			{
				//Update the existing user
			}
		}
	}
?>

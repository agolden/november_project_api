<?php
	require_once('../hidden/helper_classes/NP_Service.php');
	require_once('../hidden/helper_classes/NP_exceptions.php');
	require_once('../hidden/data_model/NP_UserModel.php');
	
	class UserService extends NP_service{

		function __construct($dbh) {
			$this->DBH = $dbh;
			$this->uniqueErrorMessage = 'The user email must be unique.';
			//$this->invalidReferenceMessage = 'The tribe id you referenced was not found.';
		}

		function authorizeSelect($token, $input) {  }
		function authorizeInsert($input, $authenticated_user) { }
		function authorizeUpdate($input, $authenticated_user) { }

		function getUserByToken($token)
		{
			$object = new UserModel;
			$object->token = $token;
			$result = $this->doSimpleGet($object);
			return count($result) > 0 ? $result[0] : null;
		}

		function getUserByFacebookId($facebook_id)
		{
			$object = new UserModel;
			$object->facebook_id = $facebook_id;
			$result = $this->doSimpleGet($object);
			return count($result) > 0 ? $result[0] : null;
		}

		/*function authenticateUser($token)
		{
			$object = new UserModel;
			$object->token = $token;

			$response = $this->doSimpleGet($object);

			if (count($response) != 1)
				throw new AuthenticationFailedException(null);

			$this->authenticatedUser = $response[0];
		}*/
		/*function isLoggedInUserAdmin()
		{
			if (!$user)
				throw new InvalidServiceCall();
			return $this->user['isAdmin'];
		}*/




		/*private function getRecords($object = null, $token = null)
		{
			if(empty($object))
				$object = new WorkoutLocationModel;

			return $this->doSimpleGet($object);
		}*/

		//function isAdmin()

		/*function getUserByAppToken($app_token)
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
		}*/
	}
?>

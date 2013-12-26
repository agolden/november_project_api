<?php
	require_once('../hidden/helper_classes/NP_Service.php');
	require_once('../hidden/data_model/NP_TribeLeaderModel.php');
	
	class TribeLeaderService extends NP_service{
    	
		function __construct($dbh) {
			$this->DBH =  $dbh;
		}
		
    	function authorizeSelect($input, $authenticated_user) {  }

		function isUserTribeLeader($tribe_id, $user_id, $authenticated_user = null)
		{
			$object = new TribeLeaderModel;
			$object->user_id = $user_id;
			$object->tribe_id = $tribe_id;

			$response = $this->doSimpleGet($object, $authenticated_user);

			if (count($response) != 1)
				return false;

			return true;
		}
	}
?>

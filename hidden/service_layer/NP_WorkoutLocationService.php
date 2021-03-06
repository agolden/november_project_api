<?php
	require_once('../hidden/helper_classes/NP_Service.php');
	require_once('../hidden/data_model/NP_WorkoutLocationModel.php');
	require_once('../hidden/helper_classes/NP_exceptions.php');
	require_once('../hidden/helper_classes/NP_AuthenticatedUser.php');
	require_once('../hidden/service_layer/NP_TribeLeaderService.php');
	
	class WorkoutLocationService extends NP_service{
    	
		function __construct($dbh) {
			$this->DBH =  $dbh;
			$this->uniqueErrorMessage = 'The workout location name must be unique.';
			$this->invalidReferenceMessage = 'The tribe id you referenced was not found.';
		}
		
    	function getRecords($object = null, $authenticated_user = null)
		{
			if(empty($object))
				$object = new WorkoutLocationModel;

			return $this->doSimpleGet($object);
		}

		function authorizeSelect($input, $authenticated_user) {  }
		function authorizeInsert($input, $authenticated_user) { 
			if ($authenticated_user->isUserAdmin())
				return;
			
			$tribeLeaderService = new TribeLeaderService($this->DBH);
			if ($tribeLeaderService->isUserTribeLeader($input->tribe_id, $authenticated_user->getId()))
				return;

			throw new UnauthorizedUserException('The user must be an admin or tribe leader to create a workout location');
		}
		function authorizeUpdate($input, $existing, $authenticated_user) {
			
			if ($authenticated_user->isUserAdmin())
				return;
			
			$tribeLeaderService = new TribeLeaderService($this->DBH);
			if ($tribeLeaderService->isUserTribeLeader($input->tribe_id, $authenticated_user->getId()) && $tribeLeaderService->isUserTribeLeader($existing->tribe_id, $authenticated_user->getId()))
				return;

			throw new UnauthorizedUserException('The user must be an admin or tribe leader to update a workout location');
		}

		function upsert($object, $authenticated_user = null)
		{
			return $this->doSimpleUpsert($object, $authenticated_user);
		}
	}
?>

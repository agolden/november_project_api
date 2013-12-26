<?php
	require_once('../hidden/helper_classes/NP_Service.php');
	require_once('../hidden/data_model/NP_WorkoutRoutineModel.php');
	require_once('../hidden/helper_classes/NP_exceptions.php');
	require_once('../hidden/helper_classes/NP_AuthenticatedUser.php');
	require_once('../hidden/service_layer/NP_TribeLeaderService.php');
	
	class WorkoutRoutineService extends NP_service{
    	
		function __construct($dbh) {
			$this->DBH =  $dbh;
			$this->uniqueErrorMessage = 'The workout routine name must be unique.';
			$this->invalidReferenceMessage = 'The tribe id or location id you referenced was not found.';
		}
		
    	function getRecords($object = null, $authenticated_user = null)
		{
			if(empty($object))
				$object = new WorkoutRoutineModel;

			return $this->doSimpleGet($object);
		}

		function authorizeSelect($input, $authenticated_user) {  }
		function authorizeInsert($input, $authenticated_user) { 
			if ($authenticated_user->isUserAdmin())
				return;
			
			$tribeLeaderService = new TribeLeaderService($this->DBH);
			if ($tribeLeaderService->isUserTribeLeader($input->tribe_id, $authenticated_user->getId()))
				return;

			throw new UnauthorizedUserException('The user must be an admin or tribe leader to create a workout routine');
		}
		function authorizeUpdate($input, $existing, $authenticated_user) {
			
			if ($authenticated_user->isUserAdmin())
				return;
			
			$tribeLeaderService = new TribeLeaderService($this->DBH);
			if ($tribeLeaderService->isUserTribeLeader($input->tribe_id, $authenticated_user->getId()) && $tribeLeaderService->isUserTribeLeader($existing->tribe_id, $authenticated_user->getId()))
				return;

			throw new UnauthorizedUserException('The user must be an admin or tribe leader to update a workout routine');
		}

		function upsert($object, $authenticated_user = null)
		{
			return $this->doSimpleUpsert($object, $authenticated_user);
		}
	}
?>

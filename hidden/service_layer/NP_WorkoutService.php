<?php
	require_once('../hidden/helper_classes/NP_Service.php');
	require_once('../hidden/data_model/NP_WorkoutModel.php');
	require_once('../hidden/data_model/NP_WorkoutLocationModel.php');
	require_once('../hidden/data_model/NP_WorkoutRoutineModel.php');
	require_once('../hidden/helper_classes/NP_exceptions.php');
	require_once('../hidden/helper_classes/NP_AuthenticatedUser.php');
	require_once('../hidden/service_layer/NP_TribeLeaderService.php');
	require_once('../hidden/service_layer/NP_WorkoutLocationService.php');
	require_once('../hidden/service_layer/NP_WorkoutRoutineService.php');
	
	class WorkoutService extends NP_service{
    	
		function __construct($dbh) {
			$this->DBH =  $dbh;
			//$this->uniqueErrorMessage = 'The workout location name must be unique.';
			//$this->invalidReferenceMessage = 'The tribe id you referenced was not found.';
		}

		function getRecords($object = null, $authenticated_user = null)
		{
			if(empty($object))
				$object = new WorkoutModel;

			return $this->doSimpleGet($object);
		}
		
    	function getUpcomingWorkouts($tribe_id)
    	{
    		$query = 'SELECT workout.* FROM workout INNER JOIN workout_routine ON workout.prescribed_routine_id=workout_routine.id WHERE workout_date >= CURDATE()';
			$valuesArray = array();
			
			if (!empty($tribe_id))
			{
				$query .= ' AND tribe_id = :tribe_id';
				$valuesArray[":tribe_id"] = $tribe_id;
			}

			$query .= ' ORDER BY workout_date';

			$stmt = $this->DBH->prepare($query);
			$stmt->execute($valuesArray);

			$response = array();
			foreach($stmt->fetchAll() as $record) {
				$response[] = SupportingMethods::createObjectFromRequest($record, 'WorkoutModel', false);
			}
			return $response;
    	}
    	
    	function authorizeSelect($input, $authenticated_user) {  }
		function authorizeInsert($input, $authenticated_user) { 
			
			//Check to make sure user is a tribe leader of both the workout location and workout routine
			$locationTribeId = (new WorkoutLocationService($this->DBH))->getRefRecordById($input->location_id, $authenticated_user)->tribe_id;
			$routineTribeId = (new WorkoutRoutineService($this->DBH))->getRefRecordById($input->prescribed_routine_id, $authenticated_user)->tribe_id;
			
			if ($locationTribeId != $routineTribeId)
				throw new InvalidReferenceException('The workout location and routine provided are not from the same tribe.');

			if ($authenticated_user->isUserAdmin())
				return;
			
			$tribeLeaderService = new TribeLeaderService($this->DBH);
			if ($tribeLeaderService->isUserTribeLeader($locationTribeId, $authenticated_user->getId()) && $tribeLeaderService->isUserTribeLeader($routineTribeId, $authenticated_user->getId()))
				return;

			throw new UnauthorizedUserException('The user must be an admin or tribe leader to create a workout');
		}

		function authorizeUpdate($input, $existing, $authenticated_user) {
			
			$locationTribeId = (new WorkoutLocationService($this->DBH))->getRefRecordById($input->location_id, $authenticated_user)->tribe_id;
			$routineTribeId = (new WorkoutRoutineService($this->DBH))->getRefRecordById($input->prescribed_routine_id, $authenticated_user)->tribe_id;
			$existingRoutineTribeId = (new WorkoutRoutineService($this->DBH))->getRefRecordById($existing->prescribed_routine_id, $authenticated_user)->tribe_id;
			
			if ($locationTribeId != $routineTribeId)
				throw new InvalidReferenceException('The workout location and routine provided are not from the same tribe.');

			if ($authenticated_user->isUserAdmin())
				return;
			
			$tribeLeaderService = new TribeLeaderService($this->DBH);
			if ($tribeLeaderService->isUserTribeLeader($locationTribeId, $authenticated_user->getId()) && $tribeLeaderService->isUserTribeLeader($routineTribeId, $authenticated_user->getId()) && $tribeLeaderService->isUserTribeLeader($existingRoutineTribeId, $authenticated_user->getId()))
				return;

			throw new UnauthorizedUserException('The user must be an admin or tribe leader to update a workout');
		}

		function upsert($object, $authenticated_user = null)
		{
			return $this->doSimpleUpsert($object, $authenticated_user);
		}
	}
?>

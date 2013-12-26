<?php

$models = array(
	'WorkoutRoutine' => array(
		'id' => 'WorkoutRoutine',
		'properties' =>	array(
			'id' => array(
				'type' => "string",
				'description' => "The unique identifier of the routine",
				'required' => true
			),
			'tribe_id' => array(
				'type' => "string",
				'description' => "The unique identifier of the tribe to which the workout routine belongs",
				'required' => true
			),
			'location_id' => array(
				'type' => "string",
				'description' => "The unique identifier of the workout location at which the routine must be performed.  This applies only to those workouts that are, by their very nature, location-specific",
				'required' => false
			),
			'name' => array(
				'type' => "string",
				'description' => "The short name of the routine",
				'required' => true
			),
			'description' => array(
				'type' => "string",
				'description' => "The descripion of the routine, including a listing of exercises, reps, etc.",
				'required' => true
			)
		)
	),
	'WorkoutRoutineInput' => array(
		'id' => 'WorkoutRoutineInput',
		'properties' =>	array(
			'tribe_id' => array(
				'type' => "string",
				'description' => "The unique identifier of the tribe to which the workout routine belongs",
				'required' => true
			),
			'location_id' => array(
				'type' => "string",
				'description' => "The unique identifier of the workout location at which the routine must be performed.  This applies only to those workouts that are, by their very nature, location-specific",
				'required' => false
			),
			'name' => array(
				'type' => "string",
				'description' => "The short name of the routine",
				'required' => true
			),
			'description' => array(
				'type' => "string",
				'description' => "The descripion of the routine, including a listing of exercises, reps, etc.",
				'required' => true
			)
		)
	),
	'WorkoutRoutineUpdate' => array(
		'id' => 'WorkoutRoutineUpdate',
		'properties' =>	array(
			'tribe_id' => array(
				'type' => "string",
				'description' => "The unique identifier of the tribe to which the workout routine belongs",
				'required' => false
			),
			'location_id' => array(
				'type' => "string",
				'description' => "The unique identifier of the workout location at which the routine must be performed.  This applies only to those workouts that are, by their very nature, location-specific",
				'required' => false
			),
			'name' => array(
				'type' => "string",
				'description' => "The short name of the routine",
				'required' => false
			),
			'description' => array(
				'type' => "string",
				'description' => "The descripion of the routine, including a listing of exercises, reps, etc.",
				'required' => false
			)
		)
	)
);

$getWorkoutRoutines = array(
	'path' => "/workout_routines",
	'operations' => array(
		array(
			'method' => "GET",
			'summary' => "Get workout routines, with optional filters",
			'type' => "WorkoutRoutine",
			'nickname' => "getAllWorkoutRoutines",
			'parameters' => array(
				array(
					'name' => "tribe_id",
					'description' => "The unique identifier of the tribe.",
					'required' => false,
					'paramType' => "query",
					'dataType' => "integer"
				)
			)
		)
	)
);

$getWorkoutRoutine = array(
	'path' => "/workout_routines/{id}",
	'operations' => array(
		array(
			'method' => "GET",
			'summary' => "Get a specific workout routine by id",
			'type' => "WorkoutRoutine",
			'nickname' => "getWorkoutRoutine",
			'parameters' => array(
				array(
					'name' => "id",
					'description' => "The unique identifier of the workout routine.",
					'required' => true,
					'paramType' => "path",
					'dataType' => "string"
				)
			)
		)
	)
);

$createWorkoutRoutine = array(
	'path' => "/workout_routines",
	'operations' => array(
		array(
			'method' => "POST",
			'summary' => "Create a workout routine",
			'type' => "WorkoutRoutine",
			'nickname' => "createWorkoutRoutine",
			'parameters' => array(
				array(
					'name' => "Authorization",
					'description' => "The token obtained from the /access_token api (format: Bearer access_token)",
					'required' => true,
					'paramType' => "header",
					'dataType' => "string"
				),
				array(
					'name' => "workout_routine",
					'description' => "The workout routine to be created",
					'required' => true,
					'paramType' => "body",
					'dataType' => "WorkoutRoutineInput"
				)
			)
		)
	)
);

$updateWorkoutRoutine = array(
	'path' => "/workout_routines/{id}",
	'operations' => array(
		array(
			'method' => "PUT",
			'summary' => "Update a workout routine",
			'type' => "WorkoutRoutine",
			'nickname' => "updateWorkoutRoutine",
			'parameters' => array(
				array(
					'name' => "Authorization",
					'description' => "The token obtained from the /access_token api (format: Bearer access_token)",
					'required' => true,
					'paramType' => "header",
					'dataType' => "string"
				),
				array(
					'name' => "id",
					'description' => "The unique identifier of the workout routine.",
					'required' => true,
					'paramType' => "path",
					'dataType' => "string"
				),
				array(
					'name' => "workout_routine",
					'description' => "The workout routine record, containing only those fields to be updated",
					'required' => true,
					'paramType' => "body",
					'dataType' => "WorkoutRoutineUpdate"
				)
			)
		)
	)
);

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$rootDirectory = $_SERVER['REQUEST_URI'];
$rootDirectory = substr($rootDirectory, 0, strrpos($rootDirectory, '/'));
$rootDirectory = substr($rootDirectory, 0, strrpos($rootDirectory, '/'));

//Define the response
$response = array(
	'apiVersion' => "1.0.0",
	'basePath' => "$protocol$_SERVER[HTTP_HOST]$rootDirectory",
	'resourcePath' => "/workout_routines",
	'produces' => array("application/json"),
	'apis' => array($getWorkoutRoutines, $getWorkoutRoutine, $createWorkoutRoutine, $updateWorkoutRoutine),
	'models' => $models
);

echo json_encode($response);

?>
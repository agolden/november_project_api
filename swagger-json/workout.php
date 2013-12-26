<?php

$models = array(
	'Workout' => array(
		'id' => 'Workout',
		'properties' =>	array(
			'id' => array(
				'type' => "string",
				'description' => "The unique identifier of the workout",
				'required' => true
			),
			'prescribed_routine_id' => array(
				'type' => "string",
				'description' => "The unique identifier of the workout routine selected by the tribe leaders",
				'required' => true
			),
			'location_id' => array(
				'type' => "string",
				'description' => "The unique identifier of the location where the workout takes place",
				'required' => true
			),
			'workout_date' => array(
				'type' => "date",
				'description' => "The date of the workout",
				'required' => true
			)
		)
	),
	'WorkoutInput' => array(
		'id' => 'Workout',
		'properties' =>	array(
			'prescribed_routine_id' => array(
				'type' => "string",
				'description' => "The unique identifier of the workout routine selected by the tribe leaders",
				'required' => true
			),
			'location_id' => array(
				'type' => "string",
				'description' => "The unique identifier of the location where the workout takes place",
				'required' => false
			),
			'workout_date' => array(
				'type' => "date",
				'description' => "The date of the workout",
				'required' => true
			)
		)
	),
	'WorkoutUpdate' => array(
		'id' => 'Workout',
		'properties' =>	array(
			'prescribed_routine_id' => array(
				'type' => "string",
				'description' => "The unique identifier of the workout routine selected by the tribe leaders",
				'required' => false
			),
			'location_id' => array(
				'type' => "string",
				'description' => "The unique identifier of the location where the workout takes place",
				'required' => false
			),
			'workout_date' => array(
				'type' => "date",
				'description' => "The date of the workout",
				'required' => false
			)
		)
	)
);

$getUpcomingWorkouts = array(
	'path' => "/workouts/upcoming",
	'operations' => array(
		array(
			'method' => "GET",
			'summary' => "Get upcoming workouts, with optional filters",
			'type' => "Workout",
			'nickname' => "getUpcomingWorkouts",
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

$getWorkout = array(
	'path' => "/workouts/{id}",
	'operations' => array(
		array(
			'method' => "GET",
			'summary' => "Get a specific workout by id",
			'type' => "Workout",
			'nickname' => "getWorkout",
			'parameters' => array(
				array(
					'name' => "id",
					'description' => "The unique identifier of the workout.",
					'required' => true,
					'paramType' => "path",
					'dataType' => "string"
				)
			)
		)
	)
);

$createWorkout = array(
	'path' => "/workouts",
	'operations' => array(
		array(
			'method' => "POST",
			'summary' => "Create a workout",
			'type' => "Workout",
			'nickname' => "createWorkout",
			'parameters' => array(
				array(
					'name' => "Authorization",
					'description' => "The token obtained from the /access_token api (format: Bearer access_token)",
					'required' => true,
					'paramType' => "header",
					'dataType' => "string"
				),
				array(
					'name' => "workout",
					'description' => "The workout to be created",
					'required' => true,
					'paramType' => "body",
					'dataType' => "WorkoutInput"
				)
			)
		)
	)
);

$updateWorkout = array(
	'path' => "/workouts/{id}",
	'operations' => array(
		array(
			'method' => "PUT",
			'summary' => "Update a workout",
			'type' => "Workout",
			'nickname' => "updateWorkout",
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
					'description' => "The unique identifier of the workout.",
					'required' => true,
					'paramType' => "path",
					'dataType' => "string"
				),
				array(
					'name' => "workout",
					'description' => "The workout record, containing only those fields to be updated",
					'required' => true,
					'paramType' => "body",
					'dataType' => "WorkoutUpdate"
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
	'resourcePath' => "/workouts",
	'produces' => array("application/json"),
	'apis' => array($getUpcomingWorkouts, $getWorkout, $createWorkout, $updateWorkout),
	'models' => $models
);

echo json_encode($response);

?>
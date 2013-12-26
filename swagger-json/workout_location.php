<?php

$models = array(
	'WorkoutLocation' => array(
		'id' => 'WorkoutLocation',
		'properties' =>	array(
			'id' => array(
				'type' => "string",
				'description' => "The unique identifier of the location",
				'required' => true
			),
			'tribe_id' => array(
				'type' => "string",
				'description' => "The unique identifier of the tribe to which the workout location belongs",
				'required' => true
			),
			'name' => array(
				'type' => "string",
				'description' => "The name of the location, sometimes followed by the neighborhood in parentheses",
				'required' => true
			),
			'latitude' => array(
				'type' => "double",
				'description' => "The latitude of the location, in decimal degrees",
				'required' => true
			),
			'longitude' => array(
				'type' => "double",
				'description' => "The longitude of the location, in decimal degrees",
				'required' => true
			)
		)
	),
	'WorkoutLocationInput' => array(
		'id' => 'WorkoutLocationInput',
		'properties' =>	array(
			'name' => array(
				'type' => "string",
				'description' => "The name of the location, sometimes followed by the neighborhood in parentheses",
				'required' => true
			),
			'tribe_id' => array(
				'type' => "string",
				'description' => "The unique identifier of the tribe to which the workout location belongs",
				'required' => true
			),
			'latitude' => array(
				'type' => "double",
				'description' => "The latitude of the location, in decimal degrees",
				'required' => true
			),
			'longitude' => array(
				'type' => "double",
				'description' => "The longitude of the location, in decimal degrees",
				'required' => true
			)
		)
	),
	'WorkoutLocationUpdate' => array(
		'id' => 'WorkoutLocationUpdate',
		'properties' =>	array(
			'name' => array(
				'type' => "string",
				'description' => "The name of the location, sometimes followed by the neighborhood in parentheses",
				'required' => false
			),
			'tribe_id' => array(
				'type' => "string",
				'description' => "The unique identifier of the tribe to which the workout location belongs",
				'required' => false
			),
			'latitude' => array(
				'type' => "double",
				'description' => "The latitude of the location, in decimal degrees",
				'required' => false
			),
			'longitude' => array(
				'type' => "double",
				'description' => "The longitude of the location, in decimal degrees",
				'required' => false
			)
		)
	)
);

$getWorkoutLocations = array(
	'path' => "/workout_locations",
	'operations' => array(
		array(
			'method' => "GET",
			'summary' => "Get workout locations, with optional filters",
			'type' => "WorkoutLocation",
			'nickname' => "getAllWorkoutLocations",
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

$getWorkoutLocation = array(
	'path' => "/workout_locations/{id}",
	'operations' => array(
		array(
			'method' => "GET",
			'summary' => "Get a specific workout location by id",
			'type' => "WorkoutLocation",
			'nickname' => "getWorkoutLocation",
			'parameters' => array(
				array(
					'name' => "id",
					'description' => "The unique identifier of the workout location.",
					'required' => true,
					'paramType' => "path",
					'dataType' => "string"
				)
			)
		)
	)
);

$createWorkoutLocation = array(
	'path' => "/workout_locations",
	'operations' => array(
		array(
			'method' => "POST",
			'summary' => "Create a workout location",
			'type' => "WorkoutLocation",
			'nickname' => "createWorkoutLocation",
			'parameters' => array(
				array(
					'name' => "Authorization",
					'description' => "The token obtained from the /access_token api (format: Bearer access_token)",
					'required' => true,
					'paramType' => "header",
					'dataType' => "string"
				),
				array(
					'name' => "workout_location",
					'description' => "The workout location to be created",
					'required' => true,
					'paramType' => "body",
					'dataType' => "WorkoutLocationInput"
				)
			)
		)
	)
);

$updateWorkoutLocation = array(
	'path' => "/workout_locations/{id}",
	'operations' => array(
		array(
			'method' => "PUT",
			'summary' => "Update a workout location",
			'type' => "WorkoutLocation",
			'nickname' => "updateWorkoutLocation",
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
					'description' => "The unique identifier of the workout location.",
					'required' => true,
					'paramType' => "path",
					'dataType' => "string"
				),
				array(
					'name' => "workout_location",
					'description' => "The workout location record, containing only those fields to be updated",
					'required' => true,
					'paramType' => "body",
					'dataType' => "WorkoutLocationUpdate"
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
	'resourcePath' => "/workout_locations",
	'produces' => array("application/json"),
	'apis' => array($getWorkoutLocations, $getWorkoutLocation, $createWorkoutLocation, $updateWorkoutLocation),
	'models' => $models
);

echo json_encode($response);

?>
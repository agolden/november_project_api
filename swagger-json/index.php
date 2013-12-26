<?php

$response = array();
$response["apiVersion"] = "1.0.0";

$userApi = array(
	'path' => "/access_token",
	'description' => "Operations for authenticating a user to the API"
);

$workoutLocationApi = array(
	'path' => "/workout_locations",
	'description' => "Operations for viewing and maintaining the library of workout locations"
);

$workoutRoutineApi = array(
	'path' => "/workout_routines",
	'description' => "Operations for viewing and maintaining the library of workout routines"
);

$workoutApi = array(
	'path' => "/workouts",
	'description' => "Operations for viewing and maintaining the calendar of workouts"
);

$apis = array($userApi, $workoutLocationApi, $workoutRoutineApi, $workoutApi);

$info = array(
	'title' => "November Project API",
	'description' => "Mobile gateway for November Project"
	);


$response = array(
	'apiVersion' => "1.0.0",
	'apis' => $apis,
	'info' => $info
	);

echo json_encode($response);

//{"apiVersion":"1.0.0","swaggerVersion":"1.2","apis":[{"path":"/user","description":"Operations about user"},{"path":"/pet","description":"Operations about pets"}],"authorizations":{"oauth2":{"type":"oauth2","scopes":["PUBLIC"],"grantTypes":{"implicit":{"loginEndpoint":{"url":"http://petstore.swagger.wordnik.com/api/oauth/dialog"},"tokenName":"access_code"},"authorization_code":{"tokenRequestEndpoint":{"url":"http://petstore.swagger.wordnik.com/api/oauth/requestToken","clientIdName":"client_id","clientSecretName":"client_secret"},"tokenEndpoint":{"url":"http://petstore.swagger.wordnik.com/api/oauth/token","tokenName":"access_code"}}}},"apiKey":{"type":"apiKey","keyName":"api_key","passAs":"header"},"basicAuth":{"type":"basicAuth"}},"info":{"title":"Swagger Sample App","description":"This is a sample server Petstore server.  You can find out more about Swagger \n    at <a href=\"http://swagger.wordnik.com\">http://swagger.wordnik.com</a> or on irc.freenode.net, #swagger.  For this sample,\n    you can use the api key \"special-key\" to test the authorization filters","termsOfServiceUrl":"http://helloreverb.com/terms/","contact":"apiteam@wordnik.com","license":"Apache 2.0","licenseUrl":"http://www.apache.org/licenses/LICENSE-2.0.html"}}

?>

<?php

$models = array(
	'AccessToken' => array(
		'id' => 'AccessToken',
		'properties' =>	array(
			'token' => array(
				'type' => "string",
				'description' => "The access token to be used in future communication with the API.",
				'required' => true
			),
			'token_expiry' => array(
				'type' => "dateTime",
				'description' => "The expiration date of the token.  This date may be extended automatically by the server through interaction with the API.",
				'required' => true
			)
		)
	),

	'FacebookToken' => array(
		'id' => 'FacebookToken',
		'properties' =>	array(
			'facebook_token' => array(
				'type' => "string",
				'description' => "A short- or long-lived Facebook token retrieved through the Facebook SDK.",
				'required' => true
			)
		)
	)
);

//Define the endpoints
$authenticateByFacebook = array(
	'path' => "/access_token/facebook",
	'operations' => array(
		array(
			'method' => "PUT",
			'summary' => "Authenticate user by Facebook token",
			'type' => "AccessToken",
			'nickname' => "authenticateByFacebook",
			'parameters' => array(
				array(
					'name' => "facebook_token",
					'description' => "A short- or long-lived Facebook token retrieved through the Facebook SDK.",
					'required' => true,
					'paramType' => "body",
					'dataType' => "FacebookToken"
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
	'resourcePath' => "/access_token",
	'produces' => array("application/json"),
	'apis' => array($authenticateByFacebook),
	'models' => $models
);

echo json_encode($response);

?>
<?php
	require_once('NP_RequestResponse.php');
	require_once('NP_exceptions.php');
	require_once('NP_SupportingMethods.php');
	require_once('NP_DatabaseConnection.php');
	
	abstract class RequestHandler
	{
		protected $response;
		protected $DBH;

		function handleGet() { throw new MethodNotAllowed(null); }
		function handlePost() { throw new MethodNotAllowed(null); }
		function handlePut() { throw new MethodNotAllowed(null); }

		function handleRequest()
		{
			header('Content-type: application/json');
			$this->response = new NP_RequestResponse;
			
			try{
				$this->DBH = (new DatabaseConnection)->getConn();
				
				//Get the token off the request, if it exists
				$token = $this->getToken();

				$method = $_SERVER['REQUEST_METHOD'];
				switch ($method) {
					case 'GET':
						$this->handleGet($token);
						break;
					case 'POST':
						$this->handlePost($token);
						break;
					case 'PUT':
						$this->handlePut($token);
						break;
					default:
						break;
				}

			} catch (NPException $e) {
				header('error', true, $e->getHTTPCode());
				$this->response->errorCode = $e->getErrorCode();
				$this->response->errorMessage = $e->getMessage();

			} catch (Exception $e){
				header('error', true, 500);
				$this->response->errorCode = 1999;
				$this->response->errorMessage = "Server exception occurred.  Please try again later." . $e->getTraceAsString();
			}
			
			echo json_encode($this->response->getResponse());
		}

		function handleSimplePut($token = null)
		{
			$authenticated_user = new AuthenticatedUser($token, $this->DBH);
			$prefix = str_replace('Handler', '', get_class($this));

			//Get the JSON from the request
			$request = SupportingMethods::getValidJSON();
			
			//Check for required parameters
			if(empty($_GET['id']))
				throw new RequiredParameterMissingException(null);

			//Add the id to the request
			$request['id']  = $_GET['id'];
			
			//Create an object from the request
			$object = SupportingMethods::createObjectFromRequest($request, $prefix . 'Model');

			//Execute the update
			$refClass = new ReflectionClass($prefix . 'Service');
			$this->response->records = $refClass->newInstance($this->DBH)->upsert($object, $authenticated_user);
		}

		function handleSimplePost($token = null)
		{
			$authenticated_user = new AuthenticatedUser($token, $this->DBH);
			$prefix = str_replace('Handler', '', get_class($this));

			//Get the JSON from the request
			$request = SupportingMethods::getValidJSON();

			//Create an object from the request
			$object = SupportingMethods::createObjectFromRequest($request, $prefix . 'Model');
			
			if (!$object->hasRequiredAttributes($request))
				throw new RequiredParameterMissingException(null);


			//Execute the create
			$refClass = new ReflectionClass($prefix . 'Service');
			$this->response->records = $refClass->newInstance($this->DBH)->upsert($object, $authenticated_user);
		}

		function handleSimpleGet($token = null)
		{
			$prefix = str_replace('Handler', '', get_class($this));

			//Create an object from the GET
			$object = SupportingMethods::createObjectFromRequest($_GET, $prefix . 'Model');

			//Execute the select
			$refClass = new ReflectionClass($prefix . 'Service');
			
			$this->response->records = $refClass->newInstance($this->DBH)->getRecords($object, null);
		}

		private function getToken()
		{
			$token;
			if (array_key_exists('HTTP_AUTHORIZATION', $_SERVER))
				$token = $_SERVER['HTTP_AUTHORIZATION'];
			elseif(array_key_exists('REDIRECT_HTTP_AUTHORIZATION', $_SERVER))
				$token = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
			else
				return null;
			
			$count;
			$token = preg_replace("/Bearer (.*)/", "$1", $token, 1, $count);
			if ($count < 1)
				return null;

			return $token;
		}
	}
?>
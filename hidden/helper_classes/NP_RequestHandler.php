<?php
	require_once('NP_RequestResponse.php');
	require_once('NP_exceptions.php');
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
				
				$method = $_SERVER['REQUEST_METHOD'];
				switch ($method) {
					case 'GET':
						$this->handleGet();
						break;
					case 'POST':
						$this->handlePost();
						break;
					case 'PUT':
						$this->handlePut();
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
				$this->response->errorMessage = "Server exception occurred.  Please try again later.";
			}
			
			echo json_encode($this->response->getResponse());
		}

		function handleSimplePut()
		{
			$prefix = str_replace('Handler', '', get_class($this));

			//Get the JSON from the request
			$request = RequestHandler::getValidJSON();
			
			//Check for required parameters
			if(empty($_GET['id']))
				throw new RequiredParameterMissingException(null);

			//Add the id to the request
			$request['id']  = $_GET['id'];
			
			//Create an object from the request
			$object = RequestHandler::createObjectFromRequest($request, $prefix . 'Model');

			//Execute the update
			$refClass = new ReflectionClass($prefix . 'Service');
			$this->response->records = $refClass->newInstance($this->DBH)->upsert($object);
		}

		function handleSimplePost()
		{
			$prefix = str_replace('Handler', '', get_class($this));

			//Get the JSON from the request
			$request = RequestHandler::getValidJSON();

			//Create an object from the request
			$object = RequestHandler::createObjectFromRequest($request, $prefix . 'Model');
			
			if (!$object->hasRequiredAttributes($request))
				throw new RequiredParameterMissingException(null);


			//Execute the create
			$refClass = new ReflectionClass($prefix . 'Service');
			$this->response->records = $refClass->newInstance($this->DBH)->upsert($object);
		}
		
		public static function getValidJSON()
		{
			$inputJSON = file_get_contents('php://input');
			$input = json_decode( $inputJSON, TRUE );

			if ($_SERVER['CONTENT_TYPE'] != "application/json" || is_null($input))
				throw new BadJSONException(null);
			
			return $input;
		}

		public static function createObjectFromRequest($request, $object_name)
		{
			$refClass = new ReflectionClass($object_name);
			$object = $refClass->newInstance();
			foreach ($request as $key => $value) {
    			if(!$refClass->hasProperty($key))
    				throw new InvalidParameterException(null);
				$object->$key = $value;
			}

			return $object;
		}
	}
?>
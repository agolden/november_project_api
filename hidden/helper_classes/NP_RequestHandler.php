<?php
	require_once('NP_RequestResponse.php');
	require_once('NP_exceptions.php');
	require_once('NP_DatabaseConnection.php');
	
	abstract class RequestHandler
	{
		protected $mysqli;
		protected $response;
		protected $DBH;
	
		function handleGet() { throw new BadRequestException('Method not supported for this endpoint.'); }
		function handlePost() { throw new BadRequestException('Method not supported for this endpoint.'); }
		function handlePut() { throw new BadRequestException('Method not supported for this endpoint.'); }
		
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
		
		public static function getValidJSON()
		{
			$inputJSON = file_get_contents('php://input');
			$input = json_decode( $inputJSON, TRUE );

			if ($_SERVER['CONTENT_TYPE'] != "application/json" || is_null($input))
				throw new BadJSONException(null);
			
			return $input;
		}
	}
?>
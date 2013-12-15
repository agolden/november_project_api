<?php
	require_once('NP_JSONResponse.php');
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
			$this->response = new NP_JSONResponse;
			$db = parse_ini_file('../hidden/git_ignore/database.ini');
		
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
		
				echo $this->response->getResponse();
			} catch (BadRequestException $e){
				header('Invalid or missing JSON', true, 400);
			} catch (Exception $e){
				header('Server error.', true, 500);
			}
		
			$this->DBH = null;
		}
	}
?>
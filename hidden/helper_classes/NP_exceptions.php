<?php

	abstract class NPException extends Exception
	{
		protected $errorCode;
		protected $httpCode;
		
		function getErrorCode() { return $this->errorCode; }
		function getHTTPCode() { return $this->httpCode; }
	}

	class RecordNotFoundException extends NPException{
		function __construct($message) {
			if (empty($message))
				$message = 'The record you requested was not found.';
			parent::__construct($message);
			$this->errorCode = 1001;
			$this->httpCode = 400;
		}	
	}
	
	class BadJSONException extends NPException{
		function __construct($message) {
			if (empty($message))
				$message = 'The body of your request is non-existent, has invalid JSON, or your request has an incorrect content-type.';
			parent::__construct($message);
			$this->errorCode = 1002;
			$this->httpCode = 400;
		}
	}
	
	class RequiredParameterMissingException extends NPException{
		function __construct($message) {
			if (empty($message))
				$message = 'One or more required parameters is missing from your request.';
			parent::__construct($message);
			$this->errorCode = 1003;
			$this->httpCode = 400;
		}
	}
	
	class NotUniqueException extends NPException{
		function __construct($message) {
			if (empty($message))
				$message = 'One or more parameters is not unique as required.';
			parent::__construct($message);
			$this->errorCode = 1004;
			$this->httpCode = 400;
		}
	}
	
	class InvalidReferenceException extends NPException{
		function __construct($message) {
			if (empty($message))
				$message = 'One or more parameters is an invalid reference to a non-existent record.';
			parent::__construct($message);
			$this->errorCode = 1005;
			$this->httpCode = 400;
		}
	}

	class InvalidParameterException extends NPException{
		function __construct($message) {
			if (empty($message))
				$message = 'You have provided an invalid or unknown parameter in your request.';
			parent::__construct($message);
			$this->errorCode = 1006;
			$this->httpCode = 400;
		}
	}

	class MethodNotAllowed extends NPException{
		function __construct($message) {
			if (empty($message))
				$message = 'This endpoint does not accept this request method.';
			parent::__construct($message);
			$this->errorCode = 1007;
			$this->httpCode = 400;
		}
	}

	
?>
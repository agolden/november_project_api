<?php
	//require_once('NP_JSONObject.php');
	
	class NP_RequestResponse{
    	
    	public $errorCode = 0;
    	public $errorMessage = '';
        public $records = array();

    	function getResponse() {

            $response = array();
            $response['records'] = $this->records;
            $response['errorCode'] = $this->errorCode;
            $response['errorMessage'] = $this->errorMessage;

            return $response;
    	}
	}
?>

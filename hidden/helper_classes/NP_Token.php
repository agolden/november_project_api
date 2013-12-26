<?php
	class Token{
    	
    	public $token;
		public $token_expiry;
        
        function __construct($token = null) {
            
            if (empty($token))
                $this->token = bin2hex(openssl_random_pseudo_bytes(100));                
            else
                $this->token = $token;
            
            $this->token_expiry = date('Y-m-d H:i:s', strtotime("+ 10 day"));

        }
	}
?>

<?php
	require_once('../hidden/helper_classes/NP_Model.php');
	
	class UserModel extends NP_Model{
    	
    	public $id = 0;
		public $email = '';
		public $facebook_token = '';
        public $is_admin = FALSE;
        public $token = '';
        public $token_expiry = new DateTime;
        
   
    	function getArray() {
    		return array('id'=> $this->id, 'email'=> $this->email, 'facebook_token' => $this->facebook_token, 'is_admin' => $this->is_admin, 'token' => $this->token, 'token_expiry' => $this->token_expiry);
    	}
		
		public static function getCreateRequiredAttributes()
		{
			return array('email', 'token', 'token_expiry');
		}
	}
?>

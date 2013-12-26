<?php
	require_once('../hidden/helper_classes/NP_Model.php');
	
	class UserModel extends NP_Model{
    	
    	public $id;
		public $email;
        public $facebook_token;
        public $facebook_id;
        public $is_admin = FALSE;
        public $token;
        public $token_expiry;
        
   
    	public static function getTableName()
    	{
    		return "user";
    	}

    	public static function getCreateRequiredAttributes()
		{
			return array('email', 'token', 'token_expiry');
		}

        public function isUserAdmin()
        {
            return $this->is_admin;
        }

        public function isUserTribeLeader($tribe_id)
        {
            return $this->is_admin;
        }
	}
?>

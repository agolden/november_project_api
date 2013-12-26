<?php
	require_once('../hidden/helper_classes/NP_Model.php');
	
	class TribeLeaderModel extends NP_Model{
    	
    	public $id;
		public $tribe_id;
        public $user_id;
        
    	public static function getTableName()
    	{
    		return "tribe_leader";
    	}

    	public static function getCreateRequiredAttributes()
		{
			return array('tribe_id', 'user_id');
		}
	}
?>

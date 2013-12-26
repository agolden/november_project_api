<?php
	require_once('../hidden/helper_classes/NP_Model.php');
	
	class TribeModel extends NP_Model{
    	
    	public $id = 0;
		public $name = '';
        public $latitude = 0.0;
        public $longitude = 0.0;
   
    	public static function getTableName()
    	{
    		return "tribe";
    	}

    	public static function getCreateRequiredAttributes()
		{
			return array('name', 'latitude', 'longitude');
		}
	}
?>

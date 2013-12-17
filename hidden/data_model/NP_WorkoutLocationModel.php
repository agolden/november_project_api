<?php
	require_once('../hidden/helper_classes/NP_Model.php');
	
	class WorkoutLocationModel extends NP_Model{
    	
    	public $id;
		public $tribe_id;
    	public $name;
        public $latitude;
        public $longitude;
        
    	public static function getTableName()
    	{
    		return "workout_location";
    	}
		
		public static function getCreateRequiredAttributes()
		{
			return array('tribe_id', 'name', 'latitude', 'longitude');
		}
	}
?>
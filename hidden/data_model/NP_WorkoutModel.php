<?php
	require_once('../hidden/helper_classes/NP_Model.php');
	
	class WorkoutModel extends NP_Model{
    	
    	public $id;
		public $prescribed_routine_id;
    	public $location_id;
        public $workout_date;
        
    	public static function getTableName()
    	{
    		return "workout";
    	}
		
		public static function getCreateRequiredAttributes()
		{
			return array('prescribed_routine_id', 'workout_date');
		}
	}
?>
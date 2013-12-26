<?php
	require_once('../hidden/helper_classes/NP_Model.php');
	
	class WorkoutRoutineModel extends NP_Model{
    	
    	public $id;
		public $tribe_id;
    	public $location_id;
    	public $name;
        public $description;
        
    	public static function getTableName()
    	{
    		return "workout_routine";
    	}
		
		public static function getCreateRequiredAttributes()
		{
			return array('tribe_id', 'name', 'description');
		}
	}
?>
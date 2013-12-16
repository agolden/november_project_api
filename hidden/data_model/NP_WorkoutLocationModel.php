<?php
	require_once('../hidden/helper_classes/NP_Model.php');
	
	class WorkoutLocationModel extends NP_Model{
    	
    	public $id = 0;
		public $tribe_id = 0;
    	public $name = '';
        public $latitude = 0.0;
        public $longitude = 0.0;
   
    	function getArray() {
    		return array('id'=> $this->id, 'tribe_id'=> $this->tribe_id, 'name'=> $this->name, 'latitude' => $this->latitude, 'longitude' => $this->longitude);
    	}
		
		public static function getCreateRequiredAttributes()
		{
			return array('tribe_id', 'name', 'latitude', 'longitude');
		}
	}
?>

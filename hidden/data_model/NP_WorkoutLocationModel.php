<?php
	require_once('../hidden/helper_classes/NP_JSONObject.php');
	
	class WorkoutLocationModel implements NP_JSONObject{
    	
    	public $id = 0;
		public $tribe_id = 0;
    	public $name = '';
        public $lat = 0.0;
        public $lng = 0.0;
   
    	function getArray() {
    		return array('id'=> $this->id, 'tribe_id'=> $this->tribe_id, 'name'=> $this->name, 'lat' => $this->lat, 'lng' => $this->lng);
    	}
	}
?>

<?php
	require_once('NP_DatabaseConnection.php');

	abstract class NP_Service
	{
		protected $DBH;
	
		function __construct($dbh) {
			$this->DBH = $dbh;
		}
	}
?>
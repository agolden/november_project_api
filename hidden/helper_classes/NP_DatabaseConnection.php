<?php
	
	class DatabaseConnection
	{
		private $DBH;
		
		function __construct() {
			$db = parse_ini_file('../hidden/git_ignore/database.ini');
			$this->DBH = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['name'], $db['user'], $db['password']);
		}
		
		function getConn()
		{
			return $this->DBH;
		}
	}
?>
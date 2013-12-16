<?php
	require_once('NP_DatabaseConnection.php');

	abstract class NP_Service
	{
		protected $DBH;
		protected $uniqueErrorMessage;
		protected $invalidReferenceMessage;
	
		function __construct($dbh) {
			$this->DBH = $dbh;
		}
		
		function handlePDOError($e)
		{
			switch ($e->errorInfo[1])
			{
				case 1452:
					throw new InvalidReferenceException($this->invalidReferenceMessage);
					break;
				case 1062:
					throw new NotUniqueException($this->uniqueErrorMessage);
					break;
				default:
					throw $e;
			}
		}
	}
?>
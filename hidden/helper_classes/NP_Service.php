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
		
		protected function handlePDOError($e)
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

		protected function doSimpleUpsert($object)
		{
			try
			{
				if (empty($object->id))
					$this->doSimpleCreate($object);
				else
					$this->doSimpleUpdate($object);

				return $object->getArray();
			}
			catch (PDOException $e) { $this->handlePDOError($e); }
		}

		protected function doSimpleUpdate($object)
		{
			$query = 'UPDATE ' . $object->getTableName() . ' SET ';
			$valuesArray = array();

			$refObj = new ReflectionObject($object);
			foreach ($refObj->getProperties() as $prop) {
				$propName = $prop->getName();
				$propValue = $object->$propName;
				if(!empty($propValue))
				{
					$query .= $propName . "=:" . $propName . ", ";
					$valuesArray[":" . $propName] = $propValue;
				}
			}

			$query = $this->rmLastComma($query) . " WHERE id=:id"; 

			$stmt = $this->DBH->prepare($query);
			$stmt->execute($valuesArray);
		}

		protected function doSimpleCreate(&$object)
		{
			$query = 'INSERT INTO ' . $object->getTableName() . '(';
			$varClause = '';
			$valueClause = '';
			$valuesArray = array();

			$refObj = new ReflectionObject($object);
			foreach ($refObj->getProperties() as $prop) {
				$propName = $prop->getName();
				$propValue = $object->$propName;
				if(!empty($propValue))
				{
					$varClause .= $propName . ", "; 
					$valueClause .= ":" . $propName . ", "; 
					$valuesArray[":" . $propName] = $propValue;
				}
			}

			$query .= $this->rmLastComma($varClause) . ") VALUES(" . $this->rmLastComma($valueClause) . ")"; 

			$stmt = $this->DBH->prepare($query);
			$stmt->execute($valuesArray);
			$object->id = $this->DBH->lastInsertId();
		}

		private function rmLastComma($string)
		{
			return substr($string, 0, strlen($string)-2);
		}
	}
?>
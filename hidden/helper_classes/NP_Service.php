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

		function authorizeSelect($input, $authenticated_user) { throw new UnauthorizedUserException(null); }
		function authorizeInsert($input, $authenticated_user) { throw new UnauthorizedUserException(null); }
		function authorizeUpdate($input, $existing, $authenticated_user) { throw new UnauthorizedUserException(null); }
		
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

		protected function doSimpleUpsert($object, $authenticated_user = null)
		{
			try
			{
				if (empty($object->id))
					$this->doSimpleCreate($object, $authenticated_user);
				else
					$this->doSimpleUpdate($object, $authenticated_user);

				return $object->getArray();
			}
			catch (PDOException $e) { $this->handlePDOError($e); }
		}

		protected function doSimpleUpdate($object, $authenticated_user = null)
		{

			if(str_replace('Service', '', get_class($this)) != str_replace('Model', '', get_class($object)))
				throw new InvalidServiceCall("null");

			$refObj = new ReflectionObject($object);
			
			$lookForId = $refObj->newInstance();
			$lookForId->id = $object->id;
			
			$currentRecords = $this->doSimpleGet($lookForId);
			
			$this->authorizeUpdate($object, $currentRecords[0], $authenticated_user);

			$query = 'UPDATE ' . $object->getTableName() . ' SET ';
			$valuesArray = array();

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

		protected function doSimpleCreate(&$object, $authenticated_user = null)
		{
			if(str_replace('Service', '', get_class($this)) != str_replace('Model', '', get_class($object)))
				throw new InvalidServiceCall(null);

			$this->authorizeInsert($object, $authenticated_user);
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

		protected function getRefRecordById($id, $authenticated_user = null)
		{
			$model_class = str_replace('Service', '', get_class($this)) . 'Model';
			$refObj = new ReflectionClass($model_class);
			$lookForId = $refObj->newInstance();
			$lookForId->id = $id;

			$record;
			try { $record = $this->doSimpleGet($lookForId, $authenticated_user); }
			catch (RecordNotFoundException $e) { throw new InvalidReferenceException('The ' . str_replace('Service', '', get_class($this)) . ' record you referenced was not found'); }
			return $record[0];
		}

		protected function doSimpleGet($object, $authenticated_user = null)
		{
			if(str_replace('Service', '', get_class($this)) != str_replace('Model', '', get_class($object)))
				throw new InvalidServiceCall(null);

			$this->authorizeSelect($object, $authenticated_user);
			$query = 'SELECT * FROM ' . $object->getTableName();
			$valuesArray = array();
			$whereClause = '';

			$refObj = new ReflectionObject($object);
			
			foreach ($refObj->getProperties() as $prop) {
				$propName = $prop->getName();
				$propValue = $object->$propName;
				if(!empty($propValue))
				{
					$whereClause .= $propName . "=:" . $propName . " AND "; 
					$valuesArray[":" . $propName] = $propValue;
				}
			}

			if (!empty($whereClause))
				$query .= " WHERE " . $this->rmLastComma($whereClause, 5);
			
			$stmt = $this->DBH->prepare($query);
			$stmt->execute($valuesArray);

			$response = array();
			$records = $stmt->fetchAll();

			if (count($records) == 0 && count($valuesArray) == 1 && array_key_exists(':id', $valuesArray))
				throw new RecordNotFoundException(null);

			foreach($records as $record) {
				$response[] = SupportingMethods::createObjectFromRequest($record, get_class($object), false);
			}
			return $response;
		}

		private static function rmLastComma($string, $letter_count = 2)
		{
			return substr($string, 0, strlen($string)-$letter_count);
		}
	}
?>
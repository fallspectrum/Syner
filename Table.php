<?php
/*
The Table class is used to simplify MySql Queues.
Make sure mysql_connect and mysql_select_db call is used
before using this class.
*/
class Table {
	private $fields;
	private $tableName;

	
	function __construct($aTableName) 
	{ 
		$this->tableName = $aTableName;
		$this->fields = array();
	}

	//Sets a column/value pair. The value is sanitizied. 
	//Returned is the sanitized value.
	function setField($fieldName,$fieldVal) 
	{
		$tmpVal = htmlspecialchars($fieldVal);
		mysql_real_escape_string($tmpVal);
		$this->fields[$fieldName] = $tmpVal;	
		return $tmpVal;
	}

	//Returns all rows in the table. 
	//colList is a optional argument where it may contain a list of comma delimited 
	//column names used in the select function. By default all columns are selected.
	function getAllRows($colList='*')
	{
		$query = "Select * from " . $this->tableName;	
		return mysql_query($query); 
	}
	
	//This function retreives 0 or more rows from the table based on a WHERE caluse.  
	//colList is a optional argument where it may contain a list of comma delimited 
	//column names used in the select function. By default all columns are selected.
	function getRows($colList='*') {
		$query = "SELECT " . $colList ." from " . $this->tableName . " WHERE ";
		foreach($this->fields as $key=> $value ) {
			$query .= $key .  "='" . $value ."' & " ;
		}
		$query = substr($query,0,-2);
                return mysql_query($query); 
	}

	//This functions adds a row to the mysql table $tableName.
	//All columns that are not specified as a column/key pair in $fields will be set to the 
	//column's default value.
	function insertRow()
	{

		foreach($this->fields as $key => $value) {
			$colNames .= $key . ",";
			$colValues .= "'" . $value . "',";
		}
		$colNames = substr($colNames,0,-1);
		$colValues = substr($colValues,0,-1);
		$query = "INSERT INTO " . $this->tableName . "(" . $colNames . ") VALUES (" . $colValues . ")";
		return mysql_query($query);
	}
	//This function deletes rows from the table based on a WHERE caluse.  
	//The WhereClause is dependent on the elements in $fields
	function deleteRow() {
		$query = "delete from " . $this->tableName . " WHERE ";
		foreach($this->fields as $key=> $value ) {
			$query .= $key .  "='" . $value ."' & " ;
		}
		$query = substr($query,0,-2);
                return mysql_query($query); 
	}

	//This function resets the fields array.
	function reset() 
	{
		$this->fields = array();	
	}
}

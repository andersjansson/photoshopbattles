<?php
//ta bort
ini_set ('display_errors', true);
error_reporting (E_ALL);
require_once("main.php");

class DBHandler
{
	function __construct()
	{

	}

	public function connect()
	{
		$this->mysqli = new mysqli(HOST,USER,PASSWORD,DATABASE);
		if($this->mysqli->connect_errno > 0)
			return false;
		else
			$this->mysqli->set_charset('utf8');
		return true;
	}

	public function close()
	{
		$this->mysqli->close();
	}	

	private function refValues($arr){
    if (strnatcmp(phpversion(),'5.3') >= 0)
    {
        $refs = array();
        foreach($arr as $key => $value)
            $refs[$key] = &$arr[$key];
        return $refs;
    }
    return $arr;
}

	public function rowExists($qry, $variables)
	{	
		$stmt = $this->mysqli->prepare($qry);
		call_user_func_array(array($stmt, 'bind_param'), $this->refValues($variables));
		$stmt->execute();

		$result = $stmt->get_result();
		$stmt->close();

		if($result->num_rows === 0)
			return false;

		return true;
	}

	public function getSingleValue($qry, $variables, $select)
	{
		$stmt = $this->mysqli->prepare($qry);
		call_user_func_array(array($stmt, 'bind_param'), $this->refValues($variables));
		$stmt->execute();

		$result = $stmt->get_result();
		$stmt->close();
		
		if($row = $result->fetch_array(MYSQLI_ASSOC)){
			return $row[$select];
		}

		return false;
	}

	public function getSingleRow($qry, $variables)
	{
		$stmt = $this->mysqli->prepare($qry);
		call_user_func_array(array($stmt, 'bind_param'), $this->refValues($variables));
		$stmt->execute();

		$result = $stmt->get_result();
		$stmt->close();
		
		if($row = $result->fetch_array(MYSQLI_ASSOC)){
			return $row;
		}

		return false;
	}

	public function updateOrInsertRow($qry, $variables)
	{
		$stmt = $this->mysqli->prepare($qry);
		call_user_func_array(array($stmt, 'bind_param'), $this->refValues($variables));
		$stmt->execute();

		if($stmt->affected_rows > 0){
			$stmt->close();
			return true;
		}

		$stmt->close();
		return false;
	}

	public function countRows($qry)
	{
		$stmt = $this->mysqli->prepare($qry);
		$stmt->execute();
		if($result = $stmt->get_result()){
			$row = $result->fetch_assoc();
			return $row['count'];
		}

		return false;
	}

	public function getAssocArray($qry, $variables)
	{
		$stmt = $this->mysqli->prepare($qry);

		call_user_func_array(array($stmt, 'bind_param'), $this->refValues($variables));
		$stmt->execute();

		if($result = $stmt->get_result()){
			$allThePosts = Array();

			while ($row = $result->fetch_array(MYSQLI_ASSOC))
	        {
		        $allThePosts[] = $row;
	    	}
	    	$stmt->close();
	    	return $allThePosts;
		}
		$stmt->close();
		return false;
	}
}
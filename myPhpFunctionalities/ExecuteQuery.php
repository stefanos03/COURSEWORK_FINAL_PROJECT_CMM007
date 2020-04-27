<?php


class ExecuteQuery
{
	public static function customQuery($sqlQuery)
	{

	    $mysql = new DATABASE();
		$conn =  $mysql->connect();			
		$result = $conn->query($sqlQuery);
		
		$conn->close();
		return $result;
		$result->close();
		

	}
}

?>
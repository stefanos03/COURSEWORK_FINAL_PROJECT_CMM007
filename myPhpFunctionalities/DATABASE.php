<?php

class DATABASE{

	private static $_instance=null;
	private $_pdo, 
			$_query,
			$_error = false,
			$_results,
			$_count=0; 

	private $server = 'localhost';
	private $username = 'root';
	private $password = '';
	private $dbname = 'db_research';

	public function connect()
	{
		$mysql = new mysqli($this->server,$this->username,$this->password,$this->dbname);

		return $mysql;
	}

//hi test
}

?>
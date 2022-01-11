<?php
/*
DatabaseWrapper uses mySQL
*/
class DatabaseWrapper{
	//Connection Information
	private $servername;
	private $username;
	private $password;
	private $dbname;
	
	public function __construct($server , $user , $pass , $db){
		$this->servername = $server;
		$this->username = $user;
		$this->password = $pass;
		$this->dbname = $db;
	}
	
	
}
?>

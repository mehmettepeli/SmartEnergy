<?php
/**
* DB classs
*/
class DB
{
	// ---------------- Local Server-------------//
	var $servername = "localhost";
	var $username = "root";
	var $password = "";
	var $dbname = "smart_energy_system";
	var $conn = NULL;
	var $file = NULL;

	function connectDB()
	{
		$this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
		if ($this->conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}
		$this->file = fopen('../sql_log.txt','a');
		return $this->conn;
	}
	function replace($val){
		return str_replace(",",".",$val);
	}
	function execute($sql){
		$res = $this->conn->query($sql);
		if ($res === FALSE)
			echo "Error: " . $sql . "<br>" . $this->conn->error;
	}
	function executeQuery($sql){
		fputs($this->file,$sql);
		$res = $this->conn->query($sql);
		if ($res === FALSE)
			echo "Error: " . $sql . "<br>" . $this->conn->error;
		return $res;
	}
	function userLogin($user, $pass){

		$sql = "SELECT * FROM users 
			WHERE user ='" . $user . "' AND pass ='". $pass ."'";
			
		$res = $this->conn->query($sql);
		if ($res === FALSE)
			echo "Error: " . $sql . "<br>" . $this->conn->error;
		else
			return $res; 
	}
}

?>
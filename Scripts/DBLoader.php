<?php
class Database{
	
	private $host  = 'localhost';
    private $user  = 'root';
    private $password   = "AppDev@2021";
    private $database  = "Tauresium"; 
    
	//MODIFY THIS
    public function getConnection()
	{		
		$conn = new mysqli($this->host, $this->user, $this->password, $this->database);
		if($conn->connect_error)
		{
			die("Could not connect to database");
		} 
		else 
		{
			return $conn;
		}
    }
}
?>
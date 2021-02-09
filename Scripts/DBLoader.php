<?php
class Database{
	
	private $host  = 'localhost';
    private $user  = 'root';
    private $password   = ""; //AppDev@2021 for VMS
    private $database  = "tauresium"; 
    private $connectionData;
	
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
			$this->connectionData = $conn;
			return $conn;
		}
    }
	
	public function getProvinceArray()
	{
		$sqlExec = "SELECT Province_ID,Capital,Region,Climate,Description,City_Population_Total,National_HDI,National_Nominal_GDP_per_capita,Culture_Cost,Economic_Cost,Military_Cost,Coastal,Coastal_Region FROM provinces;";
		$result = $this->connectionData->query($sqlExec);
		$dataSet = $result->fetch_all(MYSQLI_ASSOC);
		return $dataSet;
	}
}
?>
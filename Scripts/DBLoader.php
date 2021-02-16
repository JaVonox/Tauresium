<?php
class Database{
	//Might have to change all of this to use REST API structure
	
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
		$sqlExec = "SELECT Province_ID,Capital,Region,Climate,City_Population_Total,National_HDI,National_Nominal_GDP_per_capita,Coastal,Coastal_Region FROM provinces;";
		$result = $this->connectionData->query($sqlExec);
		$dataSet = $result->fetch_all(MYSQLI_ASSOC);
		return $dataSet;
	}
	
	public function getProvinceDetail($ProvinceIdentity)
	{
		$sqlExec = "SELECT Province_ID,Capital,Region,Climate,Description,City_Population_Total,National_HDI,National_Nominal_GDP_per_capita,Culture_Cost,Economic_Cost,Military_Cost,Coastal,Coastal_Region,Culture_Modifier,Economic_Enviroment_Modifier,Military_Enviroment_Modifier FROM provinces WHERE Province_ID = '" . $ProvinceIdentity . "';";
		$result = $this->connectionData->query($sqlExec);
		$dataSet = $result->fetch_all(MYSQLI_ASSOC);
		return $dataSet;
	}
	
	public function verifyIdentity($PlayerIdentity)
	{
		$sqlExec = "SELECT Player_ID FROM players WHERE Player_ID = '" . $PlayerIdentity . "';";
		$result = $this->connectionData->query($sqlExec);
		$return = $result->fetch_row();
		
		if($return[0] == $PlayerIdentity && $return[0] != "")
		{
			return True;
		}
		else
		{
			return False;
		}
	}
	
		public function getPlayerStats($PlayerIdentity)
	{
		$sqlExec = "SELECT Country_Name,Colour,World_Code,Military_Influence,Culture_Influence,Economic_Influence,Events_Stacked FROM players WHERE Player_ID = '" . $PlayerIdentity . "';";
		$result = $this->connectionData->query($sqlExec);
		$dataSet = $result->fetch_all(MYSQLI_ASSOC);
		return $dataSet;
	}
}
?>
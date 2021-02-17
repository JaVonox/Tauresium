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
		$dataSet = $result->fetch_all(MYSQLI_ASSOC); //fetch all does 2d array
		return $dataSet;
	}
	
	public function getValidWorldCode($WorldCode)
	{
		$sqlExec = "SELECT 1 FROM worlds WHERE World_Code = '" . $WorldCode . "' AND Capacity > 0;";
		$result = $this->connectionData->query($sqlExec);
		$return = $result->fetch_row(); //fetches an array

		if($return[0] == "1")
		{
			return True;
		}
		else
		{
			return False;
		}
	}
	
	public function getPlayersInWorld($WorldCode)
	{
		$sqlExec = "SELECT players.Country_Name FROM players WHERE players.World_Code = '" . $WorldCode . "';";
		$result = $this->connectionData->query($sqlExec);
		$dataSet = $result->fetch_row();
		return $dataSet;
	}
	
	public function getColoursInWorld($WorldCode)
	{
		$sqlExec = "SELECT players.Colour FROM players WHERE players.World_Code = '" . $WorldCode . "';";
		$result = $this->connectionData->query($sqlExec);
		$dataSet = $result->fetch_row();
		return $dataSet;
	}
	
	public function addNewCountry($CountryName,$Government,$Colour,$World_Code)
	{
		//ADD better stuff here
		$ID = "BFDIBFDIBFDIBFDI";
		$Military_Influence = 0;
		$Military_Generation = 0;
		$Culture_Influence = 0;
		$Culture_Generation = 0;
		$Economic_Influence = 0;
		$Economic_Generation = 0;
		$LET = date("Y/m/d h:i:s");
		
		$sqlExec = "INSERT INTO players VALUES('" . $ID . "','" . $CountryName . "','" . $Government . "','" . $Colour . "','" . $World_Code . "'," . $Military_Influence . "," . $Military_Generation . "," . $Culture_Influence . "," . $Culture_Generation . "," . $Economic_Influence . "," . $Economic_Generation . ",'" .$LET . "',0);";
		$this->connectionData->query($sqlExec);
		
		return $this->connectionData->error;
	}
}
?>
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
			header("Location: ../ErrorPage.php"); //redirects to error page in case of error.
		} 
		else 
		{
			$this->connectionData = $conn;
			return $conn;
		}
    }
	
	public function getProvinceArray()
	{
		$result = $this->connectionData->query("SELECT Province_ID,Capital,Region,Climate,City_Population_Total,National_HDI,National_Nominal_GDP_per_capita,Coastal,Coastal_Region FROM provinces;")or die(mysqli_error($this->connectionData));
		$dataSet = $result->fetch_all(MYSQLI_ASSOC);
		return $dataSet;
	}
	
	public function getProvinceDetail($ProvinceIdentity)
	{
		$result = $this->connectionData->query("SELECT Province_ID,Capital,Region,Climate,Description,City_Population_Total,National_HDI,National_Nominal_GDP_per_capita,Culture_Cost,Economic_Cost,Military_Cost,Coastal,Coastal_Region,Culture_Modifier,Economic_Enviroment_Modifier,Military_Enviroment_Modifier FROM provinces WHERE Province_ID = '" . $ProvinceIdentity . "';") or die(mysqli_error($this->connectionData));
		$dataSet = $result->fetch_all(MYSQLI_ASSOC);
		return $dataSet;
	}
	
	public function verifyIdentity($PlayerIdentity,$hashedPassword)
	{
		$result = $this->connectionData->query("SELECT Country_Name FROM players WHERE Country_Name = '" . $PlayerIdentity . "' AND Hashed_Password = '" . $hashedPassword . "';")or die(mysqli_error($this->connectionData));
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
		$result = $this->connectionData->query("SELECT Country_Name,Country_Type,Colour,World_Code,Military_Influence,Culture_Influence,Economic_Influence,Events_Stacked,Last_Event_Time FROM players WHERE Country_Name = '" . $PlayerIdentity . "';") or die(mysqli_error($this->connectionData));
		$dataSet = $result->fetch_assoc();
		
		$result = $this->connectionData->query("SELECT Title FROM governmenttypes WHERE GovernmentForm = '" . $dataSet['Country_Type'] . "';") or die(mysqli_error($this->connectionData));
		$dataSet['Title'] = $result->fetch_assoc()['Title'];
		
		return $dataSet;
	}
	
	public function getValidWorldCode($WorldCode)
	{
		$result = $this->connectionData->query("SELECT 1 FROM worlds WHERE World_Code = '" . $WorldCode . "' AND Capacity > 0;") or die(mysqli_error($this->connectionData));
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
	
	public function getPlayersInWorld($countryName)
	{
		$result = $this->connectionData->query("SELECT players.Country_Name FROM players WHERE players.Country_Name = '" . $countryName . "';")or die(mysqli_error($this->connectionData));
		$dataSet = $result->fetch_row();
		
		if($dataSet[0] == $countryName && $dataSet[0] != "")
		{
			return True;
		}
		else
		{
			return False;
		}
	}
	

	public function getColoursInWorld($worldCode)
	{
		$result = $this->connectionData->query("SELECT players.Colour FROM players WHERE players.World_Code = '" . $worldCode . "';") or die(mysqli_error($this->connectionData));
		$dataSet = $result->fetch_row();
		return $dataSet;
	}
	
	public function addNewCountry($countryName,$passwordPreHash,$government,$colour,$world_Code)
	{
		
		$result = $this->connectionData->query("SELECT Base_Military_Generation,Base_Culture_Generation,Base_Economic_Generation,Base_Military_Influence,Base_Culture_Influence,Base_Economic_Influence FROM governmenttypes WHERE GovernmentForm = '" . $government . "';") or die(mysqli_error($this->connectionData));
		$governmentProperties = $result->fetch_assoc();
		
		$military_Influence = $governmentProperties['Base_Military_Influence'];
		$military_Generation =  $governmentProperties['Base_Military_Generation'];
		$culture_Influence =  $governmentProperties['Base_Culture_Influence'];
		$culture_Generation =  $governmentProperties['Base_Culture_Generation'];
		$economic_Influence =  $governmentProperties['Base_Economic_Influence'];
		$economic_Generation =  $governmentProperties['Base_Economic_Generation'];
		$LET = date("Y/m/d h:i:s");
		
		$passwordHash = hash('sha256',$passwordPreHash,false); // This built in algorithm hashes the password provided using sha256.
		
		
		$sqlExec = "INSERT INTO players VALUES('" . $countryName . "','" . $passwordHash . "','" . $government . "','" . $colour . "','" . $world_Code . "'," . $military_Influence . "," . $military_Generation . "," . $culture_Influence . "," . $culture_Generation . "," . $economic_Influence . "," . $economic_Generation . ",'" .$LET . "',0);" or die(mysqli_error($this->connectionData));
		$this->connectionData->query($sqlExec);
		
		$this->connectionData->query("UPDATE worlds SET Capacity = Capacity - 1 WHERE World_Code = '" . $world_Code . "';") or die(mysqli_error($this->connectionData));
		
		return True;
	}
	
	public function addNewWorld($worldName,$mapType,$gameSpeed)
	{
		$speedMapping = array("Quick"=>10,"Normal"=>20,"Slow"=>40,"VerySlow"=>60);
		$characterArray = ['A','B','C','D','E','F','G','H','J','K','L','M','N','P','Q','R','S','T','U','V','W','X','Y','Z','1','2','3','4','5','6','7','8','9'];
		$worldCode = "";
		
		While(True)
		{

			$ID = "";
			$checksum = 0;
			for($i = 0;$i < 15;$i+=1)
			{
				$nextCharacter = $characterArray[rand(0,count($characterArray)-1)];
				$ID = $ID . $nextCharacter;
				$checksum = $checksum + ord($nextCharacter);
			}
		
			//Simple checksum - add up all ascii values and then modulo by the characterArray.
		
			$checksum = $checksum % 33;
			$ID = $ID . $characterArray[$checksum];
			
			$result = $this->connectionData->query("SELECT 1 FROM worlds WHERE World_Code = '" . $ID . "';") or die(mysqli_error($this->connectionData));
			$return = $result->fetch_row(); //fetches an array

			if($return[0] != "1")
			{
				$worldCode = $ID;
				break;
			}
		}
		
		$this->connectionData->query("INSERT INTO worlds VALUES('" . $worldCode . "','" . $mapType . "'," . $speedMapping[$gameSpeed] . ",5);") or die(mysqli_error($this->connectionData));
		
		return $worldCode;
	}
	
	public function AddNewSession($sessionID,$countryName)
	{
		$this->connectionData->query("INSERT INTO Sessions (SessionID,Country_Login) VALUES('" . $sessionID . "','" . $countryName . "');") or die(mysqli_error($this->connectionData));
	}
	
	public function ReturnLogin($sessionID)
	{
		$result = $this->connectionData->query("SELECT Country_Login FROM Sessions WHERE SessionID = '" . $sessionID . "';") or die(mysqli_error($this->connectionData));
		$dataSet = $result->fetch_row();
		return $dataSet[0];
	}
	
	public function KillSession($sessionID)
	{
		$this->connectionData->query("DELETE FROM Sessions WHERE SessionID = '" . $sessionID . "';") or die(mysqli_error($this->connectionData));
		return True;
	}
	
	public function UpdateEventTimer($sessionID)
	{
		$result = $this->connectionData->query("SELECT Country_Login FROM Sessions WHERE SessionID = '" . $sessionID . "';");
		$userLogin = $result->fetch_row();
		
		$result = $this->connectionData->query("SELECT Last_Event_Time FROM players WHERE Country_Name = '" . $userLogin[0] . "';");
		$lastEvent = $result->fetch_row();
		
		$currentTime = new DateTime(date("Y/m/d h:i:s"));
		$lastTime = new DateTime($lastEvent[0]);
		$formattedLastTime = $lastTime->format("Y/m/d h:i:s");
		$formattedCurTime = $currentTime->format("Y/m/d h:i:s");
		$secondsElapsed =  min(strtotime($formattedCurTime) - strtotime($formattedLastTime),6000); //needs modifying - min caps at 5 events.
		$eventsAdded = $secondsElapsed / 1200; //20 mins time

		$this->connectionData->query("UPDATE players SET Last_Event_Time = '". $formattedCurTime . "', Events_Stacked = Events_Stacked + " . $eventsAdded . " WHERE Country_Name = '" . $userLogin[0] . "';") or die(mysqli_error($this->connectionData));
		
		$this->connectionData->query("UPDATE players SET Events_Stacked = 5 WHERE Country_Name = '" . $userLogin[0] . "' AND Events_Stacked > 5;") or die(mysqli_error($this->connectionData));
	}
}
?>
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
		
		$result = $this->connectionData->query("SELECT World_Name FROM worlds WHERE World_Code = '" . $dataSet['World_Code'] . "';") or die(mysqli_error($this->connectionData));
		$dataSet['World_Name'] = $result->fetch_assoc()['World_Name'];
		
		return $dataSet;
	}
	
	public function GetSessionStats($PlayerIdentity)
	{
		$result = $this->connectionData->query("SELECT World_Code FROM players WHERE Country_Name = '" . $PlayerIdentity . "';") or die(mysqli_error($this->connectionData));
		$worldCode = $result->fetch_row()[0];
		
		$result = $this->connectionData->query("SELECT * FROM worlds WHERE World_Code = '" . $worldCode . "';") or die(mysqli_error($this->connectionData));
		$dataSet = $result->fetch_assoc();
		
		return $dataSet;
	}
	
	public function GetSessionPlayers($worldCode)
	{
		$result = $this->connectionData->query("SELECT Country_Name,Country_Type,Colour,Last_Event_Time FROM players WHERE World_Code = '" . $worldCode . "';") or die(mysqli_error($this->connectionData));
		$dataSet = $result->fetch_all(MYSQLI_ASSOC);
		
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
	
	public function getDuplicatePlayers($countryName)
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
		
		
		$sqlExec = "INSERT INTO players (Country_Name,Hashed_Password,Country_Type,Colour,World_Code,Military_Influence,Military_Generation,Culture_Influence,Culture_Generation,Economic_Influence,Economic_Generation,Last_Event_Time,Events_Stacked) VALUES('" . $countryName . "','" . $passwordHash . "','" . $government . "','" . $colour . "','" . $world_Code . "'," . $military_Influence . "," . $military_Generation . "," . $culture_Influence . "," . $culture_Generation . "," . $economic_Influence . "," . $economic_Generation . ",'" .$LET . "',3);" or die(mysqli_error($this->connectionData));
		$this->connectionData->query($sqlExec);
		
		$this->connectionData->query("UPDATE worlds SET Capacity = Capacity - 1 WHERE World_Code = '" . $world_Code . "';") or die(mysqli_error($this->connectionData));
		
		$result = $this->connectionData->query("SELECT Province_ID FROM provinces WHERE Province_ID NOT IN (SELECT Province_ID FROM Province_Occupation WHERE World_Code = '" . $world_Code . "') ORDER BY RAND() LIMIT 1;") or die(mysqli_error($this->connectionData)); //This needs to be changed to handle when there are no locations left. 
		$randomCapital = $result->fetch_row()[0];
		
		$sqlExec = "INSERT INTO Province_Occupation (World_Code,Province_ID,Country_Name) VALUES('" . $world_Code . "','" . $randomCapital . "','" . $countryName . "');" or die(mysqli_error($this->connectionData));
		$this->connectionData->query($sqlExec);
		
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
		
		$this->connectionData->query("INSERT INTO worlds VALUES('" . $worldCode . "','" . $worldName . "','" . $mapType . "'," . $speedMapping[$gameSpeed] . ",5);") or die(mysqli_error($this->connectionData));
		
		return $worldCode;
	}
	
	public function AddNewSession($sessionID,$countryName)
	{
		$result = $this->connectionData->query("SELECT 1 FROM Sessions WHERE SessionID = '" . $sessionID . "';"); //Check if session exists
		$sessionExists = $result->fetch_row();
		
		if($sessionExists[0] == "1")
		{
			$this->connectionData->query("DELETE FROM Sessions WHERE SessionID = '" . $sessionID . "';") or die(mysqli_error($this->connectionData));
		}
		
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
		$secondsElapsed =  abs(min(strtotime($formattedCurTime) - strtotime($formattedLastTime),6000)); //needs modifying - min caps at 5 events. Also abs is used because ocassionally the value goes negative for an unknown reason. Its not a perfect solution but its better than nothing
		$eventsAdded = $secondsElapsed / 1200; //20 mins time

		$this->connectionData->query("UPDATE players SET Last_Event_Time = '". $formattedCurTime . "', Events_Stacked = Events_Stacked + " . $eventsAdded . " WHERE Country_Name = '" . $userLogin[0] . "';") or die(mysqli_error($this->connectionData));
		
		$this->connectionData->query("UPDATE players SET Events_Stacked = 5 WHERE Country_Name = '" . $userLogin[0] . "' AND Events_Stacked > 5;") or die(mysqli_error($this->connectionData));
	}
	
	public function GetEvent($sessionID)
	{
		$result = $this->connectionData->query("SELECT Country_Login FROM Sessions WHERE SessionID = '" . $sessionID . "';");
		$userLogin = $result->fetch_row();
		
		$result = $this->connectionData->query("SELECT Events_Stacked,Active_Event_ID FROM players WHERE Country_Name = '" . $userLogin[0] . "';");
		$playerEvents = $result->fetch_assoc();
		
		if($playerEvents['Events_Stacked'] >= 1 && $playerEvents['Active_Event_ID'] == "")
		{
			
			$result = $this->connectionData->query("SELECT Count(Event_ID) FROM events;");
			$EventsCount = $result->fetch_row();
			$LoadEvent = rand(1,$EventsCount[0]);
			
			$this->connectionData->query("UPDATE players SET Events_Stacked = Events_Stacked - 1, Active_Event_ID = '" . $LoadEvent . "' WHERE Country_Name = '" . $userLogin[0] . "';") or die(mysqli_error($this->connectionData));
			
			$result = $this->connectionData->query("SELECT Event_ID,Title,Description,Option_1_ID,Option_2_ID,Option_3_ID FROM events WHERE Event_ID = '" . $LoadEvent . "';") or die(mysqli_error($this->connectionData));
			$dataSet = $result->fetch_assoc();
		
			$result = $this->connectionData->query("SELECT Option_Description FROM options WHERE Option_ID = '" . $dataSet['Option_1_ID'] . "';") or die(mysqli_error($this->connectionData));
			$dataSet['Option_1_Desc'] = $result->fetch_assoc()['Option_Description'];
			
			$result = $this->connectionData->query("SELECT Option_Description FROM options WHERE Option_ID = '" . $dataSet['Option_2_ID'] . "';") or die(mysqli_error($this->connectionData));
			$dataSet['Option_2_Desc'] = $result->fetch_assoc()['Option_Description'];
			
			$result = $this->connectionData->query("SELECT Option_Description FROM options WHERE Option_ID = '" . $dataSet['Option_3_ID'] . "';") or die(mysqli_error($this->connectionData));
			$dataSet['Option_3_Desc'] = $result->fetch_assoc()['Option_Description'];
			
			return $dataSet;
			
		}
		else if($playerEvents['Active_Event_ID'] != "")
		{
			$result = $this->connectionData->query("SELECT Event_ID,Title,Description,Option_1_ID,Option_2_ID,Option_3_ID FROM events WHERE Event_ID = '" . $playerEvents['Active_Event_ID'] . "';") or die(mysqli_error($this->connectionData));
			$dataSet = $result->fetch_assoc();
		
			$result = $this->connectionData->query("SELECT Option_Description FROM options WHERE Option_ID = '" . $dataSet['Option_1_ID'] . "';") or die(mysqli_error($this->connectionData));
			$dataSet['Option_1_Desc'] = $result->fetch_assoc()['Option_Description'];
			
			$result = $this->connectionData->query("SELECT Option_Description FROM options WHERE Option_ID = '" . $dataSet['Option_2_ID'] . "';") or die(mysqli_error($this->connectionData));
			$dataSet['Option_2_Desc'] = $result->fetch_assoc()['Option_Description'];
			
			$result = $this->connectionData->query("SELECT Option_Description FROM options WHERE Option_ID = '" . $dataSet['Option_3_ID'] . "';") or die(mysqli_error($this->connectionData));
			$dataSet['Option_3_Desc'] = $result->fetch_assoc()['Option_Description'];
			
			return $dataSet;
		}
		else
		{
			return False;
		}
		
	}
	
	public function GetLoadedEvent($sessionID)
	{
		$result = $this->connectionData->query("SELECT Country_Login FROM Sessions WHERE SessionID = '" . $sessionID . "';") or die(mysqli_error($this->connectionData));
		$userData['Country'] = $result->fetch_row()[0];
		
		$result = $this->connectionData->query("SELECT Active_Event_ID FROM players WHERE Country_Name = '" . $userData['Country'] . "';") or die(mysqli_error($this->connectionData));
		$userData['LoadedEvent'] = $result->fetch_row()[0];
		
		return $userData;
	}
	
	public function EventResults($userName,$eventID,$selectedOption)
	{
		$result = $this->connectionData->query("SELECT Option_1_ID,Option_2_ID,Option_3_ID,Title,Base_Influence_Reward FROM Events WHERE Event_ID = '" . $eventID . "';")  or die(mysqli_error($this->connectionData));
		$optionIDs = $result->fetch_assoc();
		$loadedOption = "";
		
		if($selectedOption == "Option1"){
			$loadedOption = $optionIDs['Option_1_ID'];
		}
		else if($selectedOption == "Option2"){
			$loadedOption = $optionIDs['Option_2_ID'];
		}
		else if($selectedOption == "Option3"){
			$loadedOption = $optionIDs['Option_3_ID'];
		}
		
		$result = $this->connectionData->query("SELECT Option_Description,Culture_Gen_Modifier,Economic_Gen_Modifier,Military_Gen_Modifier FROM Options WHERE Option_ID = '" . $loadedOption . "';")  or die(mysqli_error($this->connectionData));
		$eventParams = $result->fetch_assoc();
		$eventParams['Title'] = $optionIDs['Title'];
		$eventParams['Base_Influence_Reward'] = $optionIDs['Base_Influence_Reward'];
		
		$this->connectionData->query("UPDATE players SET Military_Generation = Military_Generation + " . $eventParams['Military_Gen_Modifier'] . ",Economic_Generation = Economic_Generation +" . $eventParams['Economic_Gen_Modifier'] . ",Culture_Generation = Culture_Generation + ". $eventParams['Culture_Gen_Modifier'] . " WHERE Country_Name = '" . $userName . "';") or die(mysqli_error($this->connectionData));
		$this->connectionData->query("UPDATE players SET Active_Event_ID = NULL WHERE Country_Name = '" . $userName . "';") or die(mysqli_error($this->connectionData));
		
		$result = $this->connectionData->query("SELECT Military_Generation,Economic_Generation,Culture_Generation FROM Players WHERE Country_Name = '" . $userName . "';")  or die(mysqli_error($this->connectionData));
		$playerModifiers = $result->fetch_assoc();
		
		$eventParams['AddMil'] = floor($eventParams['Base_Influence_Reward'] * $playerModifiers['Military_Generation']);
		$eventParams['AddEco'] = floor($eventParams['Base_Influence_Reward'] * $playerModifiers['Economic_Generation']);
		$eventParams['AddCult'] = floor($eventParams['Base_Influence_Reward'] * $playerModifiers['Culture_Generation']);
		$this->connectionData->query("UPDATE players SET Military_Influence = Military_Influence + " . $eventParams['AddMil'] . " WHERE Country_Name = '" . $userName . "';") or die(mysqli_error($this->connectionData));
		$this->connectionData->query("UPDATE players SET Economic_Influence = Economic_Influence + " . $eventParams['AddEco'] . " WHERE Country_Name = '" . $userName . "';") or die(mysqli_error($this->connectionData));
		$this->connectionData->query("UPDATE players SET Culture_Influence = Culture_Influence + " . $eventParams['AddCult'] . " WHERE Country_Name = '" . $userName . "';") or die(mysqli_error($this->connectionData));
		
		return $eventParams;
	}
	
	public function GetPlayerChanges($sessionID)
	{
		$result = $this->connectionData->query("SELECT Country_Login FROM Sessions WHERE SessionID = '" . $sessionID . "';") or die(mysqli_error($this->connectionData));
		$userData['Country'] = $result->fetch_row()[0];
		
		$result = $this->connectionData->query("SELECT Military_Influence,Military_Generation,Economic_Influence,Economic_Generation,Culture_Influence,Culture_Generation,Events_Stacked FROM players WHERE Country_Name = '" . $userData['Country'] . "';") or die(mysqli_error($this->connectionData));
		$newValues = $result->fetch_assoc();
		
		return $newValues;
	}
	
	public function GetOccupation($sessionID)
	{
		$result = $this->connectionData->query("SELECT Country_Login FROM Sessions WHERE SessionID = '" . $sessionID . "';") or die(mysqli_error($this->connectionData));
		$loadedUser = $result->fetch_row()[0];
		
		$result = $this->connectionData->query("SELECT World_Code FROM Players WHERE Country_Name = '" . $loadedUser . "';") or die(mysqli_error($this->connectionData));
		$loadedWorldCode = $result->fetch_row()[0];
		
		$result = $this->connectionData->query("SELECT Country_Name,Colour FROM Players WHERE World_Code = '" . $loadedWorldCode . "';") or die(mysqli_error($this->connectionData));
		$worldPlayers = $result->fetch_all(MYSQLI_ASSOC);
		
		$result = $this->connectionData->query("SELECT Province_occupation.Province_ID,Province_occupation.Country_Name,Players.Colour,GovernmentTypes.Title FROM (Province_occupation INNER JOIN (Players INNER JOIN governmentTypes ON players.Country_Type = governmentTypes.GovernmentForm) ON Province_Occupation.Country_Name = Players.Country_Name) WHERE Province_occupation.World_Code = '" . $loadedWorldCode . "';") or die(mysqli_error($this->connectionData));
		$ownedProvinces = $result->fetch_all(MYSQLI_ASSOC);
		
		return $ownedProvinces;
	}
}
?>
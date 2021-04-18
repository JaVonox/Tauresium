<?php
class Database{
	//Might have to change all of this to use REST API structure
	
	private $host  = 'localhost';
    private $user  = 'root';
    private $password   = "AppDev@2021"; //AppDev@2021 for VMS
    private $database  = "tauresium"; 
    private $connectionData;
	
	private $milProvValue = 15; //Constant
	
    public function getConnection()
	{		
		$conn = new mysqli($this->host, $this->user, $this->password, $this->database);
		if($conn->connect_error) 
		{
			header("Location: ../ErrorPage.php?Error=Connection"); //redirects to error page in case of error.
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
		$stmt = $this->connectionData->prepare("SELECT Province_ID,Capital,Region,Climate,Description,City_Population_Total,National_HDI,National_Nominal_GDP_per_capita,Culture_Cost,Economic_Cost,Military_Cost,Coastal,Coastal_Region,Culture_Modifier,Economic_Enviroment_Modifier,Military_Enviroment_Modifier FROM provinces WHERE Province_ID = ?;");
		$stmt->bind_param('s', $ProvinceIdentity);
		$stmt->execute();
		$result = $stmt->get_result();
		$dataSet = $result->fetch_all(MYSQLI_ASSOC);
		$stmt->close();
		return $dataSet;
	}
	
	public function verifyIdentity($PlayerIdentity,$hashedPassword)
	{		
		$stmt = $this->connectionData->prepare("SELECT Country_Name FROM players WHERE Country_Name = ? AND Hashed_Password = ?;");
		$stmt->bind_param('ss', $PlayerIdentity,$hashedPassword);
		$stmt->execute();
		$result = $stmt->get_result();
		$return = $result->fetch_row();
		$stmt->close();

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
		
		$stmt = $this->connectionData->prepare("SELECT Country_Name,Country_Type,Colour,World_Code,Military_Influence,Culture_Influence,Economic_Influence,Events_Stacked,Last_Event_Time,Active_Event_ID FROM players WHERE Country_Name = ?;");
		$stmt->bind_param('s', $PlayerIdentity);
		$stmt->execute();
		$result = $stmt->get_result();
		$dataSet = $result->fetch_assoc();
		$stmt->close();
		
		if(empty($dataSet))
		{
			return null;
		}
		
		$stmt = $this->connectionData->prepare("SELECT Title FROM governmentTypes WHERE GovernmentForm = ?;");
		$stmt->bind_param('s', $dataSet['Country_Type']);
		$stmt->execute();
		$result = $stmt->get_result();
		$dataSet['Title'] = $result->fetch_assoc()['Title'];
		$stmt->close();
		
		$dataSet['MilitaryCapacity'] = $this->GetPlayerMilCap($PlayerIdentity);
		
		$stmt = $this->connectionData->prepare("SELECT World_Name FROM worlds WHERE World_Code = ?;");
		$stmt->bind_param('s', $dataSet['World_Code']);
		$stmt->execute();
		$result = $stmt->get_result();
		$dataSet['World_Name'] = $result->fetch_assoc()['World_Name'];
		$stmt->close();
		
		if(intval($dataSet['Military_Influence'])>intval($dataSet['MilitaryCapacity']))
		{
			
			$stmt = $this->connectionData->prepare("UPDATE players SET Military_Influence = ? WHERE Country_Name = ?;");
			$stmt->bind_param('is', intval($dataSet['MilitaryCapacity']),$PlayerIdentity);
			$stmt->execute();
			$dataSet['Military_Influence'] = intval($dataSet['MilitaryCapacity']);
			$stmt->close();
		}
		return $dataSet;
	}
	
	public function GetSessionStats($PlayerIdentity)
	{	
		$stmt = $this->connectionData->prepare("SELECT World_Code FROM players WHERE Country_Name = ?;");
		$stmt->bind_param('s', $PlayerIdentity);
		$stmt->execute();
		$result = $stmt->get_result();
		$worldCode = $result->fetch_row()[0];
		$stmt->close();
		
		$stmt = $this->connectionData->prepare("SELECT * FROM worlds WHERE World_Code = ?;");
		$stmt->bind_param('s', $worldCode);
		$stmt->execute();
		$result = $stmt->get_result();
		$dataSet = $result->fetch_assoc();
		$stmt->close();
		
		return $dataSet;
	}
	
	public function GetSessionPlayers($worldCode)
	{
		$stmt = $this->connectionData->prepare("SELECT Country_Name,Colour,Last_Event_Time FROM players WHERE World_Code = ?;");
		$stmt->bind_param('s', $worldCode);
		$stmt->execute();
		$result = $stmt->get_result();
		$dataSet = $result->fetch_all(MYSQLI_ASSOC);
		$stmt->close();
		
		return $dataSet;
	}
	
	public function GetPlayerProvinceCount($countryName)
	{
		$stmt = $this->connectionData->prepare("SELECT Count(Country_Name) FROM province_Occupation WHERE Country_Name = ?;");
		$stmt->bind_param('s', $countryName);
		$stmt->execute();
		$result = $stmt->get_result();
		$dataSet = $result->fetch_row()[0];
		$stmt->close();
		
		return $dataSet;
	}
		
	public function GetPlayerOceanPower($countryName,$oceanName)
	{
		$stmt = $this->connectionData->prepare("SELECT Count(Country_Name) FROM province_Occupation WHERE Country_Name = ? AND Province_ID IN (SELECT Province_ID FROM provinces WHERE Coastal_Region = ? AND Coastal = 1);");
		$stmt->bind_param('ss', $countryName,$oceanName);
		$stmt->execute();
		$result = $stmt->get_result();
		$oceanprovinces = $result->fetch_row();
		$stmt->close();
		
		$stmt = $this->connectionData->prepare("SELECT Minimum_Colony_provinces From coastalRegions WHERE Coastal_Region = ?;");
		$stmt->bind_param('s', $oceanName);
		$stmt->execute();
		$result = $stmt->get_result();
		$requiredOceanprovinces = $result->fetch_row();
		$stmt->close();
		
		return $oceanprovinces[0] . "/" . $requiredOceanprovinces[0];
	}
	
	public function GetPlayerAllOceanCount($countryName)
	{
		$result = $this->connectionData->query("SELECT Coastal_Region,Colonial_Title FROM coastalRegions;") or die(mysqli_error($this->connectionData));
		$allOceans = $result->fetch_all(MYSQLI_NUM);
		$powerPerOcean = array("");
		$counter = 0;
		
		for ($i=0;$i < count($allOceans);$i++)
		{
			$oceanPower = strval($this->GetPlayerOceanPower($countryName,$allOceans[$i][0]));

			$explodedPower = explode("/",$oceanPower);
			if(intval($explodedPower[0]) > 0 && intval($explodedPower[0]) < intval($explodedPower[1]))
			{
				$powerPerOcean[$counter] = strval($allOceans[$i][1] . " (" . $oceanPower . ")");
				$counter = $counter + 1;
			}
			else if(intval($explodedPower[0]) >= intval($explodedPower[1]))
			{
				$powerPerOcean[$counter] = "<b>" . strval($allOceans[$i][1]) . "(Dominant) </b>";
				$counter = $counter + 1;
			}
			
		}
		
		return $powerPerOcean;
		
	}
	
	public function ConvertCoastalTitleToCoastalRegion($colonialTitle)
	{	
		$stmt = $this->connectionData->prepare("SELECT Coastal_Region FROM coastalRegions WHERE Colonial_Title = ?;");
		$stmt->bind_param('s', $colonialTitle);
		$stmt->execute();
		$result = $stmt->get_result();
		$coastalTitle = $result->fetch_row();
		$stmt->close();
		
		return $coastalTitle[0];
	}
	
	public function ReturnOutboundConnections($coastalRegion)
	{
		$stmt = $this->connectionData->prepare("SELECT Outbound_Connection_1,Outbound_Connection_2,Outbound_Connection_3,Outbound_Connection_4,Outbound_Connection_5 FROM coastalRegions WHERE Coastal_Region = ?;");
		$stmt->bind_param('s', $coastalRegion);
		$stmt->execute();
		$result = $stmt->get_result();
		$outboundConnections = $result->fetch_all(MYSQLI_NUM);
		$stmt->close();
		
		return $outboundConnections;
	}
	
	public function ReturnOverseasBonusCost($provinceID,$local) //local (True) = not across oceans, colonial (False) = across oceans
	{		
		$stmt = $this->connectionData->prepare("SELECT Coastal_Region FROM provinces WHERE Province_ID = ?;");
		$stmt->bind_param('s', $provinceID);
		$stmt->execute();
		$result = $stmt->get_result();
		$coastalRegion = $result->fetch_row()[0];
		$stmt->close();
		
		if($local)
		{
			$stmt = $this->connectionData->prepare("SELECT Short_Range_Penalty FROM coastalRegions WHERE Coastal_Region = ?;");
			$stmt->bind_param('s', $coastalRegion);
			$stmt->execute();
			$result = $stmt->get_result();
			$returnPen = $result->fetch_row()[0];
			$stmt->close();
			return $returnPen;
		}
		else
		{	
			$stmt = $this->connectionData->prepare("SELECT Colonial_Penalty FROM coastalRegions WHERE Coastal_Region = ?;");
			$stmt->bind_param('s', $coastalRegion);
			$stmt->execute();
			$result = $stmt->get_result();
			$returnPen = $result->fetch_row()[0];
			$stmt->close();
			return $returnPen;
			
		}
	}
	
	public function getValidWorldCode($WorldCode)
	{
		$stmt = $this->connectionData->prepare("SELECT 1 FROM worlds WHERE World_Code = ? AND Capacity > 0;");
		$stmt->bind_param('s', $WorldCode);
		$stmt->execute();
		$result = $stmt->get_result();
		$return = $result->fetch_row();
		$stmt->close();
		
		if($return[0] == "1")
		{
			return True;
		}
		else
		{
			return False;
		}
	}
	
	public function getDuplicateplayers($countryName)
	{
		$stmt = $this->connectionData->prepare("SELECT 1 FROM players WHERE players.Country_Name = ?;");
		$stmt->bind_param('s', $countryName);
		$stmt->execute();
		$result = $stmt->get_result();
		$dataSet = $result->fetch_row();
		$stmt->close();
		
		if($dataSet[0] == "1")
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
		$stmt = $this->connectionData->prepare("SELECT players.Colour FROM players WHERE players.World_Code = ?;");
		$stmt->bind_param('s', $worldCode);
		$stmt->execute();
		$result = $stmt->get_result();
		$dataSet = $result->fetch_all(MYSQLI_NUM);
		$stmt->close();
		
		$coloursArray = array("DUMMY","DUMMY","DUMMY","DUMMY","DUMMY");
		
		for($i=0;$i<count($dataSet);$i++)
		{
			$coloursArray[$i] = $dataSet[$i][0];
		}
		
		return $coloursArray;
	}
	
	public function addNewCountry($countryName,$passwordPreHash,$government,$colour,$world_Code)
	{
		
		$stmt = $this->connectionData->prepare("SELECT Base_Military_Generation,Base_Culture_Generation,Base_Economic_Generation,Base_Military_Influence,Base_Culture_Influence,Base_Economic_Influence FROM governmentTypes WHERE GovernmentForm = ?;");
		$stmt->bind_param('s', $government);
		$stmt->execute();
		$result = $stmt->get_result();
		$governmentProperties = $result->fetch_assoc();
		$stmt->close();
		
		$military_Influence = $governmentProperties['Base_Military_Influence'];
		$military_Generation =  $governmentProperties['Base_Military_Generation'];
		$culture_Influence =  $governmentProperties['Base_Culture_Influence'];
		$culture_Generation =  $governmentProperties['Base_Culture_Generation'];
		$economic_Influence =  $governmentProperties['Base_Economic_Influence'];
		$economic_Generation =  $governmentProperties['Base_Economic_Generation'];
		$LET = date("Y/m/d H:i:s");
		
		$passwordHash = hash('sha256',$passwordPreHash,false); // This built in algorithm hashes the password provided using sha256.
		$apiKey = $this->NewKey();
		
		$stmt = $this->connectionData->prepare("INSERT INTO players (Country_Name,Hashed_Password,Country_Type,Colour,World_Code,Military_Influence,Military_Generation,Culture_Influence,Culture_Generation,Economic_Influence,Economic_Generation,Last_Event_Time,Events_Stacked,Api_key) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,3,?);");
		$stmt->bind_param('sssssidididss', $countryName,$passwordHash, $government, $colour,$world_Code,$military_Influence,$military_Generation,$culture_Influence,$culture_Generation,$economic_Influence,$economic_Generation,$LET,$apiKey);
		$stmt->execute();
		$stmt->close();
		
		$stmt = $this->connectionData->prepare("UPDATE worlds SET Capacity = Capacity - 1 WHERE World_Code = ?;");
		$stmt->bind_param('s', $world_Code);
		$stmt->execute();
		$stmt->close();
		
		$stmt = $this->connectionData->prepare("SELECT Province_ID FROM provinces WHERE Province_ID NOT IN (SELECT Province_ID FROM province_Occupation WHERE World_Code = ?) ORDER BY RAND() LIMIT 1;");
		$stmt->bind_param('s', $world_Code);
		$stmt->execute();
		$result = $stmt->get_result();
		$randomCapital = $result->fetch_row()[0];
		$stmt->close();
		
		$maxValues = $this->GetProvinceType($randomCapital);
		
		
		$stmt = $this->connectionData->prepare("INSERT INTO province_Occupation (World_Code,Province_ID,Country_Name,Province_Type,Building_Column_1,Building_Column_2) VALUES(?,?,?,?,?,?);");
		$stmt->bind_param('ssssss', $world_Code,$randomCapital,$countryName,$maxValues[0],strval(strval($maxValues[1][0]) . "4"),strval(strval($maxValues[2][0]) . "4"));
		$stmt->execute();
		$stmt->close();
		
		return True;
	}
	
	public function addNewWorld($worldName,$mapType,$gameSpeed)
	{
		$speedMapping = array("VeryQuick"=>30,"Quick"=>60,"Normal"=>120,"Slow"=>240);
		
		$worldCode = $this->NewKey();
		$stmt = $this->connectionData->prepare("INSERT INTO worlds VALUES(?,?,?,?,5);");
		$stmt->bind_param('sssi', $worldCode,$worldName,$mapType,$speedMapping[$gameSpeed]);
		$stmt->execute();
		$stmt->close();
			
		return $worldCode;
	}

	public function NewKey() //Makes a 16 character code for th
	{
		$characterArray = ['A','B','C','D','E','F','G','H','J','K','L','M','N','P','Q','R','S','T','U','V','W','X','Y','Z','1','2','3','4','5','6','7','8','9'];
		$code = "";
		
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
			
			$stmt = $this->connectionData->prepare("SELECT 1 FROM worlds,players WHERE worlds.World_Code = ? OR players.Api_Key = ?;");
			$stmt->bind_param('ss', $ID,$ID);
			$stmt->execute();
			$result = $stmt->get_result();
			$return = $result->fetch_row();
			$stmt->close();

			if($return[0] != "1")
			{
				$code = $ID;
				return $code;
			}
		}
	}
	
	public function ReturnAPIKey($loadedUser) //gets the API key of a player. This information is supposed to be secure so any calls to this method need to be secure.
	{
		$stmt = $this->connectionData->prepare("SELECT Api_Key FROM players WHERE Country_Name = ?;");
		$stmt->bind_param('s', $loadedUser);
		$stmt->execute();
		$result = $stmt->get_result();
		$returnKey = $result->fetch_row()[0];
		$stmt->close();
		return $returnKey;
	}
	
	public function ReturnCountryFromAPIKey($apiKey) //gets the user with the assigned API KEY
	{
		$stmt = $this->connectionData->prepare("SELECT Country_Name FROM players WHERE Api_Key = ?;");
		$stmt->bind_param('s', $apiKey);
		$stmt->execute();
		$result = $stmt->get_result();
		$returnName = $result->fetch_row()[0];
		$stmt->close();
		return $returnName;
	}
	
	public function ReturnWorld($loadedUser)
	{		
		$stmt = $this->connectionData->prepare("SELECT World_Code FROM players WHERE Country_Name = ?;");
		$stmt->bind_param('s', $loadedUser);
		$stmt->execute();
		$result = $stmt->get_result();
		$worldCode = $result->fetch_row()[0];
		$stmt->close();
		return $worldCode;
		
	}

	public function ReturnExists($Province_ID)
	{
		//This function is used to ensure the user has not entered modified values into hidden fields
		
		$stmt = $this->connectionData->prepare("SELECT 1 FROM provinces WHERE Province_ID = ?;");
		$stmt->bind_param('s', $Province_ID);
		$stmt->execute();
		$result = $stmt->get_result();
		$provExists = (($result->fetch_row()[0])==1);
		$stmt->close();
		return ($provExists);
	}
	
	public function ReturnCorrectEvent($eventPage,$playerName)
	{	
		$stmt = $this->connectionData->prepare("SELECT 1 FROM players WHERE Country_Name = ? AND Active_Event_ID = ?;");
		$stmt->bind_param('ss', $playerName,$eventPage);
		$stmt->execute();
		$result = $stmt->get_result();
		$validEvent = (($result->fetch_row()[0])==1);
		$stmt->close();
		
		return $validEvent;
	}
	public function UpdateEventTimer($country)
	{
		
		$stmt = $this->connectionData->prepare("SELECT Last_Event_Time FROM players WHERE Country_Name = ?;");
		$stmt->bind_param('s', $country);
		$stmt->execute();
		$result = $stmt->get_result();
		$lastEvent = $result->fetch_row();
		$stmt->close();
		
		$eventSpeed = $this->GetEventSpeed($country);
		
		$currentTime = new DateTime(date("Y/m/d H:i:s")); //Timezone is automatically set to the server timezone - hence it does not matter where the player is from, the time will be UTC on the server. This could cause issues at BST however.
		$lastTime = new DateTime($lastEvent[0]);
		$formattedLastTime = $lastTime->format("Y/m/d H:i:s");
		$formattedCurTime = $currentTime->format("Y/m/d H:i:s");
		$secondsElapsed =  strtotime($formattedCurTime) - strtotime($formattedLastTime); // int is 64x on this version of php. Should be
		$eventsAdded = $secondsElapsed / ($eventSpeed * 60); 

		$stmt = $this->connectionData->prepare("UPDATE players SET Last_Event_Time = ?, Events_Stacked = Events_Stacked + ? WHERE Country_Name = ?;");
		$stmt->bind_param('sds', $formattedCurTime,$eventsAdded,$country);
		$stmt->execute();
		$stmt->close();
		
		$stmt = $this->connectionData->prepare("UPDATE players SET Events_Stacked = 5 WHERE Country_Name = ? AND Events_Stacked > 5;");
		$stmt->bind_param('s', $country);
		$stmt->execute();
		$stmt->close();
	}
	
	public function GetEventSpeed($userLogin)
	{
		$result = $this->connectionData->query("SELECT Speed FROM worlds WHERE World_Code = '" . $this->ReturnWorld($userLogin) . "';"); //This parameter is uneditable by the user and therefore does not need to be prepared
		$eventSpeed = $result->fetch_row();
		return intval($eventSpeed[0]);
	}
	
	public function GetEvent($country)
	{
		
		$stmt = $this->connectionData->prepare("SELECT Events_Stacked,Active_Event_ID FROM players WHERE Country_Name = ?;");
		$stmt->bind_param('s', $country);
		$stmt->execute();
		$result = $stmt->get_result();
		$playerevents = $result->fetch_assoc();
		$stmt->close();
		
		if($playerevents['Events_Stacked'] >= 1 && $playerevents['Active_Event_ID'] == "")
		{
			
			$result = $this->connectionData->query("SELECT Count(Event_ID) FROM events;"); 
			$eventsCount = $result->fetch_row();
			$LoadEvent = rand(1,$eventsCount[0]); //Safe parameter - no prepared statements needed for interactions with this object.
			
			$stmt = $this->connectionData->prepare("UPDATE players SET Events_Stacked = Events_Stacked - 1, Active_Event_ID = ? WHERE Country_Name = ?");
			$stmt->bind_param('ss', $LoadEvent,$country);
			$stmt->execute();
			$stmt->close();
			
			$result = $this->connectionData->query("SELECT Event_ID,Title,Description,Option_1_ID,Option_2_ID,Option_3_ID FROM events WHERE Event_ID = '" . $LoadEvent . "';") or die(mysqli_error($this->connectionData));
			$dataSet = $result->fetch_assoc(); //Safe parameter by extension
			
			$result = $this->connectionData->query("SELECT Option_Description FROM options WHERE Option_ID = '" . $dataSet['Option_1_ID'] . "';") or die(mysqli_error($this->connectionData));
			$dataSet['Option_1_Desc'] = $result->fetch_assoc()['Option_Description'];
			
			$result = $this->connectionData->query("SELECT Option_Description FROM options WHERE Option_ID = '" . $dataSet['Option_2_ID'] . "';") or die(mysqli_error($this->connectionData));
			$dataSet['Option_2_Desc'] = $result->fetch_assoc()['Option_Description'];
			
			$result = $this->connectionData->query("SELECT Option_Description FROM options WHERE Option_ID = '" . $dataSet['Option_3_ID'] . "';") or die(mysqli_error($this->connectionData));
			$dataSet['Option_3_Desc'] = $result->fetch_assoc()['Option_Description'];
			
			return $dataSet;
			
		}
		else if($playerevents['Active_Event_ID'] != "") 
		{
			//All safe parameters
			
			$result = $this->connectionData->query("SELECT Event_ID,Title,Description,Option_1_ID,Option_2_ID,Option_3_ID FROM events WHERE Event_ID = '" . $playerevents['Active_Event_ID'] . "';") or die(mysqli_error($this->connectionData));
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
	
	public function GetLoadedEvent($country)
	{
		$userData['Country'] = $country;
		
		$stmt = $this->connectionData->prepare("SELECT Active_Event_ID FROM players WHERE Country_Name = ?;");
		$stmt->bind_param('s', $userData['Country']);
		$stmt->execute();
		$result = $stmt->get_result();
		$userData['LoadedEvent'] = $result->fetch_row()[0];
		$stmt->close();
		
		return $userData;
	}
	
	public function EventResults($userName,$eventID,$selectedOption)
	{	
		$stmt = $this->connectionData->prepare("SELECT Option_1_ID,Option_2_ID,Option_3_ID,Title,Base_Influence_Reward FROM events WHERE Event_ID = ?;");
		$stmt->bind_param('i', $eventID);
		$stmt->execute();
		$result = $stmt->get_result();
		$optionIDs = $result->fetch_assoc();
		$stmt->close();
		
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
		
		$stmt = $this->connectionData->prepare("SELECT Option_ID,Option_Description,Culture_Gen_Modifier,Economic_Gen_Modifier,Military_Gen_Modifier FROM options WHERE Option_ID = ?;");
		$stmt->bind_param('s', $loadedOption);
		$stmt->execute();
		$result = $stmt->get_result();
		$eventParams = $result->fetch_assoc();
		$stmt->close();
		
		$eventParams['Title'] = $optionIDs['Title'];
		$eventParams['Base_Influence_Reward'] = $optionIDs['Base_Influence_Reward'];
		
		$stmt = $this->connectionData->prepare("UPDATE players SET Military_Generation = Military_Generation + ?,Economic_Generation = Economic_Generation + ?,Culture_Generation = Culture_Generation + ? WHERE Country_Name = ?;");
		$stmt->bind_param('ddds', $eventParams['Military_Gen_Modifier'],$eventParams['Economic_Gen_Modifier'],$eventParams['Culture_Gen_Modifier'],$userName);
		$stmt->execute();
		$stmt->close();
		
		$stmt = $this->connectionData->prepare("UPDATE players SET Active_Event_ID = NULL WHERE Country_Name = ?;");
		$stmt->bind_param('s',$userName);
		$stmt->execute();
		$stmt->close();
		
		$stmt = $this->connectionData->prepare("SELECT Military_Generation,Economic_Generation,Culture_Generation,Military_Influence FROM players WHERE Country_Name = ?;");
		$stmt->bind_param('s', $userName);
		$stmt->execute();
		$result = $stmt->get_result();
		$playerModifiers = $result->fetch_assoc();
		$stmt->close();
		
		$eventParams['AddMil'] = floor($eventParams['Base_Influence_Reward'] * $playerModifiers['Military_Generation']);
		$eventParams['AddEco'] = floor($eventParams['Base_Influence_Reward'] * $playerModifiers['Economic_Generation']);
		$eventParams['AddCult'] = floor($eventParams['Base_Influence_Reward'] * $playerModifiers['Culture_Generation']);
		
		$currentMilInfluence = $playerModifiers['Military_Influence'];
		$newMilitaryInfluence = min(intval($currentMilInfluence) + intval($eventParams['AddMil']),intval($this->GetPlayerMilCap($userName)));
		
		$stmt = $this->connectionData->prepare("UPDATE players SET Military_Influence = ?,Economic_Influence = Economic_Influence + ?, Culture_Influence = Culture_Influence + ? WHERE Country_Name = ?;");
		$stmt->bind_param('iiis',$newMilitaryInfluence,$eventParams['AddEco'],$eventParams['AddCult'],$userName);
		$stmt->execute();
		$stmt->close();
		
		return $eventParams;
	}
	
	public function GetPlayerChanges($country)
	{
		$userData['Country'] = $country;
		
		$stmt = $this->connectionData->prepare("SELECT Military_Influence,Military_Generation,Economic_Influence,Economic_Generation,Culture_Influence,Culture_Generation,Events_Stacked FROM players WHERE Country_Name = ?;");
		$stmt->bind_param('s', $userData['Country']);
		$stmt->execute();
		$result = $stmt->get_result();
		$newValues = $result->fetch_assoc();
		$stmt->close();
		
		return $newValues;
	}
	
	public function GetOccupation($country)
	{
		$loadedWorldCode = $this->ReturnWorld($country);

		$stmt = $this->connectionData->prepare("SELECT province_Occupation.Province_ID,province_Occupation.Country_Name,players.Colour,governmentTypes.Title FROM (province_Occupation INNER JOIN (players INNER JOIN governmentTypes ON players.Country_Type = governmentTypes.GovernmentForm) ON province_Occupation.Country_Name = players.Country_Name) WHERE province_Occupation.World_Code = ?;");
		$stmt->bind_param('s', $loadedWorldCode);
		$stmt->execute();
		$result = $stmt->get_result();
		$ownedprovinces = $result->fetch_all(MYSQLI_ASSOC);
		$stmt->close();
		
		return $ownedprovinces;
	}
	
	public function GetPlayerMilCap($country) //Excludes buildings
	{
		$stmt = $this->connectionData->prepare("SELECT (200 + (COUNT(Province_ID) * ?)) FROM province_Occupation WHERE province_Occupation.Country_Name = ?;");
		$stmt->bind_param('is', $this->milProvValue,$country);
		$stmt->execute();
		$result = $stmt->get_result();
		$milCap = $result->fetch_row()[0];
		$milCap = $milCap + $this->GetTotalBuildingMilCap($country);
		$stmt->close();
		
		return $milCap;
	}
	
	public function ReturnAllPlayerDominantCoastal($playerName)
	{
		$occupiedLocations = $this->GetPlayerAllOceanCount($playerName);
		$dominantLocations = array();
		$counter = 0;
		foreach($occupiedLocations as $ocean)
		{
			if(strpos($ocean,'(Dominant)')) //Collect dominant tags
			{
				$dominantLocations[$counter] = $this->ConvertCoastalTitleToCoastalRegion(str_replace("</b>","",str_replace("<b>","",str_replace("(Dominant)","",$ocean)))); //remove tags to get just the title.
				$counter++;
			}
		}
		
		return $dominantLocations; //Returns all the locations inwhich the player is dominant
	}
	
	public function ReturnAllVisibleRegions($playerName)
	{
		$allAccessibleCoastal = $this->GetPlayerAllOceanCount($playerName);
		
		$visibleLocations = array();
		$counter = 0;
		
		foreach($allAccessibleCoastal as $ocean)
		{
			if(strpos($ocean,'(Dominant)')) //This is a hacky way of collating all the locations a player is present in.
			{
				$visibleLocations[$counter] = $this->ConvertCoastalTitleToCoastalRegion(str_replace("</b>","",str_replace("<b>","",str_replace("(Dominant)","",$ocean))));
				$counter++;
			}
			else
			{
				$visibleLocations[$counter] = $this->ConvertCoastalTitleToCoastalRegion(preg_replace('/\((.*?)\)/',"",$ocean)); //regex removes all brackets
				$counter++;
			}
		}
		
		$connectedOcean = array();
		
		for($i=0;$i<count($visibleLocations);$i++)
		{
			$outboundConnections = $this->ReturnOutboundConnections($visibleLocations[$i]);
			if($outboundConnections != null)
			{
				$connectedOcean = array_merge($connectedOcean,$this->ReturnOutboundConnections($visibleLocations[$i])[0]);
			}
		}
		
		for($j=0;$j<count($connectedOcean);$j++)
			{
				if(!in_array($connectedOcean[$j],$visibleLocations))
				{
					$visibleLocations[$counter] = $connectedOcean[$j]; //regex removes all brackets
					$counter++;
				}
			}
		
		//$allAccessibleCoastal = array_merge($allAccessibleCoastal,$this->ReturnOutboundConnections($ocean));
		
		return $visibleLocations; //Returns all the locations inwhich the player is dominant
	}
	
	public function GetVisibility($country)
	{
		$loadedWorldCode = $this->ReturnWorld($country);
		
		$accessibleCoastal = $this->ReturnAllVisibleRegions($country);
		$sqlString = "(";
		
		for($i=0;$i<count($accessibleCoastal);$i++)
		{
			$sqlString = $sqlString . "'" . $accessibleCoastal[$i] . "',";
		}
		
		$sqlString = rtrim($sqlString, ",");
		$sqlString = $sqlString . ")";
		
		//The following huge query finds every province that isnt adjacent to or has a colonial link to the coastal provinces a player owns
		//sqlString is generated - therefore no preparation is needed.
		
		$stmt = $this->connectionData->prepare("SELECT Province_ID FROM provinces WHERE Coastal_Region NOT IN " . $sqlString . " AND Province_ID NOT IN(SELECT Province_ID FROM provinces 
		WHERE (Vertex_1 IN (SELECT Vertex_1 FROM provinces INNER JOIN province_Occupation ON provinces.Province_ID = province_Occupation.Province_ID AND province_Occupation.Country_Name = ?) OR Vertex_1 IN (SELECT Vertex_2 FROM provinces INNER JOIN province_Occupation ON provinces.Province_ID = province_Occupation.Province_ID AND province_Occupation.Country_Name = ?) OR Vertex_1 IN (SELECT Vertex_3 FROM provinces INNER JOIN province_Occupation ON provinces.Province_ID = province_Occupation.Province_ID AND province_Occupation.Country_Name = ?)) OR 
		(Vertex_2 IN (SELECT Vertex_1 FROM provinces INNER JOIN province_Occupation ON provinces.Province_ID = province_Occupation.Province_ID AND province_Occupation.Country_Name = ?) OR Vertex_2 IN (SELECT Vertex_2 FROM provinces INNER JOIN province_Occupation ON provinces.Province_ID = province_Occupation.Province_ID AND province_Occupation.Country_Name = ?) OR Vertex_2 IN (SELECT Vertex_3 FROM provinces INNER JOIN province_Occupation ON provinces.Province_ID = province_Occupation.Province_ID AND province_Occupation.Country_Name = ?)) OR 
		(Vertex_3 IN (SELECT Vertex_1 FROM provinces INNER JOIN province_Occupation ON provinces.Province_ID = province_Occupation.Province_ID AND province_Occupation.Country_Name = ?) OR Vertex_3 IN (SELECT Vertex_2 FROM provinces INNER JOIN province_Occupation ON provinces.Province_ID = province_Occupation.Province_ID AND province_Occupation.Country_Name = ?) OR Vertex_3 IN (SELECT Vertex_3 FROM provinces INNER JOIN province_Occupation ON provinces.Province_ID = province_Occupation.Province_ID AND province_Occupation.Country_Name = ?)))");
		$stmt->bind_param('sssssssss',$country,$country,$country,$country,$country,$country,$country,$country,$country);
		$stmt->execute();
		$result = $stmt->get_result();
		$invisibleprovinces = $result->fetch_all(MYSQLI_ASSOC);
		$stmt->close();
		
		return $invisibleprovinces;

	}
	
	public function GetPlayerVertexes($country) 
	{
		
		$stmt = $this->connectionData->prepare("SELECT Vertex_1,Vertex_2,Vertex_3 FROM (provinces INNER JOIN province_Occupation ON provinces.Province_ID = province_Occupation.Province_ID AND province_Occupation.Country_Name = ?);");
		$stmt->bind_param('s', $country);
		$stmt->execute();
		$result = $stmt->get_result();
		$ownedVertexes = $result->fetch_all(MYSQLI_NUM);
		$stmt->close();
		
		return $ownedVertexes;
	}
	
	
	public function GetProvinceVertexes($provinceID)
	{
		$stmt = $this->connectionData->prepare("SELECT Vertex_1,Vertex_2,Vertex_3 FROM provinces WHERE Province_ID = ?;");
		$stmt->bind_param('s', $provinceID);
		$stmt->execute();
		$result = $stmt->get_result();
		$provVertexes = $result->fetch_row();
		$stmt->close();
		
		return $provVertexes;
	}
	
	public function GetProvinceOwner($provinceID,$worldCode)
	{
		$stmt = $this->connectionData->prepare("SELECT Country_Name FROM province_Occupation WHERE Province_ID = ? AND World_Code = ?;");
		$stmt->bind_param('ss', $provinceID,$worldCode);
		$stmt->execute();
		$result = $stmt->get_result();
		$provOwners = $result->fetch_row();
		$stmt->close();

		if(mysqli_num_rows($result) == 0)
		{
			return "NULL";
		}
		else
		{
			return $provOwners[0];
		}
	}
	
	public function GetProvinceType($provinceID)
	{
		$stmt = $this->connectionData->prepare("SELECT Culture_Cost,Economic_Cost,Military_Cost FROM provinces WHERE Province_ID = ?;");
		$stmt->bind_param('s', $provinceID);
		$stmt->execute();
		$result = $stmt->get_result();
		$costs = $result->fetch_assoc();
		$stmt->close();
		
		$maxCosts = array_keys($costs, max($costs))[0];
		$provinceColumn = "";
		$buildingType1 = "";
		$buildingType2 = "";
		
		if($maxCosts=="Culture_Cost")
		{
			$provinceColumn = "Culture";
			$buildingType1 = "C0";
			$buildingType2 = "M0";
		}
		else if($maxCosts=="Economic_Cost")
		{
			$provinceColumn = "Economic";
			$buildingType1 = "E0";
			$buildingType2 = "C0";
		}
		else if($maxCosts=="Military_Cost")
		{
			$provinceColumn = "Military";
			$buildingType1 = "M0";
			$buildingType2 = "E0";
		}
		else
		{
			die("Error");
		}
		
		return array($provinceColumn,$buildingType1,$buildingType2);
		
	}
	
	public function GetCurrentBuilding($provinceID,$worldCode)
	{
		$stmt = $this->connectionData->prepare("SELECT Building_Column_1,Building_Column_2 FROM province_Occupation WHERE Province_ID = ? AND World_Code = ?;");
		$stmt->bind_param('ss', $provinceID,$worldCode);
		$stmt->execute();
		$result = $stmt->get_result();
		$currentBuildings = $result->fetch_row();
		$stmt->close();
		
		return $currentBuildings;
	}
	
	public function GetNextBuilding($provinceID,$worldCode,$buildType) //Returns the type of the building.
	{
		$buildings = $this->GetCurrentBuilding($provinceID,$worldCode);
		$nextBuildID = ($buildings[0][0]==$buildType) ? ($buildings[0][0] . (intval($buildings[0][1]) + 1))  : (($buildings[1][0]==$buildType) ? ($buildings[1][0] . (intval($buildings[1][1]) + 1)) : $nextBuildID = "BAD");
		//This script checks the buildtype and increments the second part of the current build ID to get the next build ID. 
		if($nextBuildID == "BAD")
		{
			return "BAD";
		}
		
		if(intval($nextBuildID[1]) > 4) //This script ensures that the build does not exceed the cap of 4 (There are 5 possible buildings, from 0-4)
		{
			return "BAD";
		}
		else
		{
			return $nextBuildID;
		}
	}
	
	public function GetBuildingCost($provinceID,$worldCode,$buildType)
	{
		$costModifier = 1 - (intval($this->GetConstructedBonuses($provinceID,$worldCode)["Bonus_Build_Cost"]) / 100);
		$nextBuilding = $this->GetNextBuilding($provinceID,$worldCode,$buildType);
		
		if($nextBuilding == "BAD")
		{
			return "BAD";
		}
		
		$stmt = $this->connectionData->prepare("SELECT Base_Cost FROM buildings WHERE BuildingID = ?;");
		$stmt->bind_param('s', $nextBuilding);
		$stmt->execute();
		$result = $stmt->get_result();
		$baseCost = $result->fetch_row()[0];
		$stmt->close();
		
		$newCost = ceil(intval($baseCost) * $costModifier);
		return $newCost;
	}
	
	public function GetTotalBuildingMilCap($player)
	{
		$stmt = $this->connectionData->prepare("SELECT Building_Column_1,Building_Column_2 FROM province_Occupation WHERE Country_Name = ?;");
		$stmt->bind_param('s', $player);
		$stmt->execute();
		$result = $stmt->get_result();
		$unformattedBuildings = $result->fetch_all(MYSQLI_NUM);
		$stmt->close();
		
		$formattedBuildings = array();
		$bonusCapacity = 0;
		$formattedEntries = 0;
		
		for($i=0;$i<count($unformattedBuildings);$i++)
		{
			$formattedBuildings[$formattedEntries] = $unformattedBuildings[$i][0];
			$formattedEntries++;
			$formattedBuildings[$formattedEntries] = $unformattedBuildings[$i][1];
			$formattedEntries++;
			
			for($j=intval($unformattedBuildings[$i][0][1])-1;$j>=0;$j--) 
			{
				$formattedBuildings[$formattedEntries] = $unformattedBuildings[$i][0][0] . $j;
				$formattedEntries++;
			}
			
			for($j=intval($unformattedBuildings[$i][1][1])-1;$j>=0;$j--) 
			{
				$formattedBuildings[$formattedEntries] = $unformattedBuildings[$i][1][0] . $j;
				$formattedEntries++;
			}
		}
		
		for($i=0;$i<count($formattedBuildings);$i++)
		{
			//formattedBuildings is safe - cant be directly accessed by users.
			$result = $this->connectionData->query("SELECT Bonus_Mil_Cap FROM buildings WHERE BuildingID = '" . $formattedBuildings[$i] . "';") or die(mysqli_error($this->connectionData));
			$bonusCapacity += intval($result->fetch_row()[0]);
		}
		
		return $bonusCapacity;
	}
	
	public function GetProvBuildBonuses($provinceID,$worldCode) //Returns all the bonuses for one province.
	{
		$stmt = $this->connectionData->prepare("SELECT Building_Column_1,Building_Column_2 FROM province_Occupation WHERE Province_ID = ? AND World_Code = ?;");
		$stmt->bind_param('ss', $provinceID,$worldCode);
		$stmt->execute();
		$result = $stmt->get_result();
		$unformattedBuildings = $result->fetch_row();
		$stmt->close();
		
		$formattedBuildings = array();
		$bonusCapacity = 0;
		$bonusDef = 0;
		$bonusBuild = 0;
		$formattedEntries = 0;
		
		for($j=intval($unformattedBuildings[0][1]);$j>=0;$j--) 
		{
			$formattedBuildings[$formattedEntries] = $unformattedBuildings[0][0] . $j;
			$formattedEntries++;
		}
		
		for($j=intval($unformattedBuildings[1][1]);$j>=0;$j--) 
		{
			$formattedBuildings[$formattedEntries] = $unformattedBuildings[1][0] . $j;
			$formattedEntries++;
		}
		
		for($i=0;$i<count($formattedBuildings);$i++)
		{
			//formatted buildings is safe
			$result = $this->connectionData->query("SELECT Bonus_Mil_Cap,Bonus_Def_Strength,Bonus_Build_Cost FROM buildings WHERE BuildingID = '" . $formattedBuildings[$i] . "';") or die(mysqli_error($this->connectionData));
			$pulledBonuses = $result->fetch_row();
			$bonusCapacity += intval($pulledBonuses[0]);
			$bonusDef += intval($pulledBonuses[1]);
			$bonusBuild += intval($pulledBonuses[2]);
		}
		
		return array("Mil_Cap" => ($bonusCapacity + $this->milProvValue),"Def_Strength" => $bonusDef, "Bonus_Build" => $bonusBuild);
	}
	
	public function GetBuildingDefensiveStrength($provinceID,$worldCode)
	{
		$stmt = $this->connectionData->prepare("SELECT Building_Column_1,Building_Column_2 FROM province_Occupation WHERE Province_ID = ? AND World_Code = ?;");
		$stmt->bind_param('ss', $provinceID,$worldCode);
		$stmt->execute();
		$result = $stmt->get_result();
		$unformattedBuildings = $result->fetch_row();
		$stmt->close();
		
		$formattedBuildings = array();
		$bonusStrength = 0;
		$formattedEntries = 0;
		
		
		$formattedBuildings[$formattedEntries] = $unformattedBuildings[0];
		$formattedEntries++;
		$formattedBuildings[$formattedEntries] = $unformattedBuildings[1];
		$formattedEntries++;
		
		for($j=intval($unformattedBuildings[0][1])-1;$j>=0;$j--) //Add all buildings before current
		{
			$formattedBuildings[$formattedEntries] = $unformattedBuildings[0][0] . $j;
			$formattedEntries++;
		}
		
		for($j=intval($unformattedBuildings[1][1])-1;$j>=0;$j--) //Add all buildings before current
		{
			$formattedBuildings[$formattedEntries] = $unformattedBuildings[1][0] . $j;
			$formattedEntries++;
		}
		
		for($i=0;$i<count($formattedBuildings);$i++)
		{
			//formatted buildings is safe
			$result = $this->connectionData->query("SELECT Bonus_Def_Strength FROM buildings WHERE BuildingID = '" . $formattedBuildings[$i] . "';") or die(mysqli_error($this->connectionData));
			$bonusStrength += intval($result->fetch_row()[0]);
		}
		
		return strval($bonusStrength);
	}
	
	public function GetBuildingColumn($provinceID,$worldCode,$buildCode)
	{
		//Return column of current building (new build with value - 1)
		$buildColumnConcat = $buildCode[0] . (intval($buildCode[1]) - 1);
		$stmt = $this->connectionData->prepare("SELECT 1 FROM province_Occupation WHERE Province_ID = ? AND World_Code = ? AND Building_Column_1 = ?;");
		$stmt->bind_param('sss', $provinceID,$worldCode,$buildColumnConcat);
		$stmt->execute();
		$result = $stmt->get_result();
		$validColumn = $result->fetch_row()[0];
		$stmt->close();

		if($validColumn == 1)
		{
			return "Building_Column_1";
		}
		else
		{
			$stmt = $this->connectionData->prepare("SELECT 1 FROM province_Occupation WHERE Province_ID = ? AND World_Code = ? AND Building_Column_2 = ?;");
			$stmt->bind_param('sss', $provinceID,$worldCode,$buildColumnConcat);
			$stmt->execute();
			$result = $stmt->get_result();
			$validColumn = $result->fetch_row()[0];
			$stmt->close();
			
			if($validColumn == 1)
			{
				return "Building_Column_2";
			}
			else
			{
				return "NULL";
			}
		}
	}
	
	public function ConstructNewBuilding($playerID,$provinceID,$worldCode,$buildType) //Assumes all checks are valid. 
	{
		$newBuildCost = $this->GetBuildingCost($provinceID,$worldCode,$buildType);
		$typeMapping = array("M"=>"Military_Influence", "E"=>"Economic_Influence", "C"=>"Culture_Influence");
		$nextBuilding = $this->GetNextBuilding($provinceID,$worldCode,$buildType);
		
		if($nextBuilding == "BAD" || $newBuildCost == "BAD")
		{
			return "BAD";
		}
		
		if($buildType != "C" && $buildType != "E" && $buildType != "M")
		{
			return "BAD";
		}
		
		$influenceType = $typeMapping[$buildType];
		
		$buildColumn = $this->GetBuildingColumn($provinceID,$worldCode,$nextBuilding);
		
		$stmt = $this->connectionData->prepare("UPDATE province_Occupation SET " . $buildColumn . " = ? WHERE World_Code = ? AND Province_ID = ?;");
		$stmt->bind_param('sss',$nextBuilding,$worldCode,$provinceID);
		$stmt->execute();
		$stmt->close();
		
		$stmt = $this->connectionData->prepare("UPDATE players SET " . $influenceType . " =  " . $influenceType . " - ? WHERE Country_Name = ?;");
		$stmt->bind_param('is',intval($newBuildCost),$playerID);
		$stmt->execute();
		$stmt->close();
	}
	
	public function CanConstructBuilding($playerID,$provinceID,$worldCode,$buildType)
	{
		$errors = array(False,"");
		($this->GetProvinceOwner($provinceID,$worldCode)!=$playerID) ? $errors=array(True,"You are not the owner of this location"):""; //Check player is owner. Also works as a check to see if the location is actually owned, as well as validifying the worldCode
		
		$newBuildCost = $this->GetBuildingCost($provinceID,$worldCode,$buildType);
		$typeMapping = array("M"=>"Military_Influence", "E"=>"Economic_Influence", "C"=>"Culture_Influence");
		$nextBuilding = $this->GetNextBuilding($provinceID,$worldCode,$buildType); //This checks if the build is valid and redirects to header if its invalid.
		
		if($nextBuilding == "BAD" || $newBuildCost == "BAD")
		{
			$errors = array(True,"Invalid Building");
		}
		
		if($buildType != "C" && $buildType != "E" && $buildType != "M")
		{
			return array(True,"Invalid Building Type");
		}
		
		$influenceType = $typeMapping[$buildType];
		
		$stmt = $this->connectionData->prepare("SELECT " . $influenceType . " FROM players WHERE Country_Name = ?;");
		$stmt->bind_param('s',$playerID);
		$stmt->execute();
		$result = $stmt->get_result();
		$playerInfluenceBalance = intval($result->fetch_row()[0]); //Checks can player afford the building
		$stmt->close();
		
		(intval($newBuildCost)>$playerInfluenceBalance) ? $errors=array(True,"You have too little influence to purchase this building"):"";
		
		return $errors;
	}
	
	public function GetPossibleBuildings($provinceType)
	{
		$buildingIDarray = array();
		$buildingsWithInfo = array();
		
		if($provinceType == "Culture")
		{
			$buildingIDarray = array("C0","C1","C2","C3","C4","M0","M1","M2","M3","M4");
		}
		else if($provinceType == "Economic")
		{
			$buildingIDarray = array("E0","E1","E2","E3","E4","C0","C1","C2","C3","C4");
		}
		else if($provinceType == "Military")
		{
			$buildingIDarray = array("M0","M1","M2","M3","M4","E0","E1","E2","E3","E4");
		}
		
		for($i=0;$i<count($buildingIDarray);$i++)
		{
			$stmt = $this->connectionData->prepare("SELECT BuildingID,Building_Name,Bonus_Mil_Cap,Bonus_Def_Strength,Bonus_Build_Cost,Base_Cost FROM buildings WHERE BuildingID = ?;");
			$stmt->bind_param('s', $buildingIDarray[$i]);
			$stmt->execute();
			$result = $stmt->get_result();
			$buildingsWithInfo[$i] = $result->fetch_assoc();
			$stmt->close();
		}

		return $buildingsWithInfo; //Usage : $buildingsWithInfo[0]['Bonus_Mil_Cap'];
	}
	
	public function GetConstructedBonuses($provinceID,$worldCode)
	{	
		$stmt = $this->connectionData->prepare("SELECT Building_Column_1,Building_Column_2 FROM province_Occupation WHERE Province_ID = ? AND World_Code = ?;");
		$stmt->bind_param('ss', $provinceID,$worldCode);
		$stmt->execute();
		$result = $stmt->get_result();
		$currentBuildings = $result->fetch_row();
		$stmt->close();
		
		$building1 = $currentBuildings[0]; //0 = Type, 1=CurTier
		$building2 = $currentBuildings[1]; //0 = Type, 1=CurTier
		
		$totalBonuses = array("Bonus_Mil_Cap"=>"0", "Bonus_Def_Strength"=>"0", "Bonus_Build_Cost"=>"0");
		
		for($i=intval($building1[1]);$i>=0;$i--)
		{
			$buildingID1Concat = $building1[0] . strval($i);
			$stmt = $this->connectionData->prepare("SELECT Bonus_Mil_Cap,Bonus_Def_Strength,Bonus_Build_Cost FROM buildings WHERE BuildingID = ?;");
			$stmt->bind_param('s', $buildingID1Concat);
			$stmt->execute();
			$result = $stmt->get_result();
			$modifiers = $result->fetch_row();
			$stmt->close();
		
			$totalBonuses["Bonus_Mil_Cap"] += $modifiers[0];
			$totalBonuses["Bonus_Def_Strength"] += $modifiers[1];
			$totalBonuses["Bonus_Build_Cost"] += $modifiers[2];
		}
		
		for($i=intval($building2[1]);$i>=0;$i--)
		{
			$buildingID2Concat = $building2[0] . strval($i);
			$stmt = $this->connectionData->prepare("SELECT Bonus_Mil_Cap,Bonus_Def_Strength,Bonus_Build_Cost FROM buildings WHERE BuildingID = ?;");
			$stmt->bind_param('s', $buildingID2Concat);
			$stmt->execute();
			$result = $stmt->get_result();
			$modifiers = $result->fetch_row();
			$stmt->close();
			
			$totalBonuses["Bonus_Mil_Cap"] += $modifiers[0];
			$totalBonuses["Bonus_Def_Strength"] += $modifiers[1];
			$totalBonuses["Bonus_Build_Cost"] += $modifiers[2];
		}
		
		return $totalBonuses;
	}
	
	public function AnnexLocationPeaceful($playerID,$provinceID,$pointType,$cost) //$pointType can be either Culture_Influence or Economic_Influence or military if the location is unowned
	{
		$worldCode = $this->ReturnWorld($playerID);

		$maxValues = $this->GetProvinceType($provinceID);
		$stmt = $this->connectionData->prepare("INSERT INTO province_Occupation (World_Code,Province_ID,Country_Name,Province_Type,Building_Column_1,Building_Column_2) VALUES(?,?,?,?,?,?);");
		$stmt->bind_param('ssssss',$worldCode,$provinceID,$playerID,$maxValues[0],$maxValues[1],$maxValues[2]);
		$stmt->execute();
		$stmt->close();
		
		//Point type is safe
		$stmt = $this->connectionData->prepare("UPDATE players SET " . $pointType . " = " . $pointType . " - ? WHERE Country_Name = ?;");
		$stmt->bind_param('is',intval($cost),$playerID);
		$stmt->execute();
		$stmt->close();
		
	}
	
	public function AnnexLocationForceful($playerID,$provinceID,$pointType,$cost) //Only used when the province is owned
	{
		$worldCode = $this->ReturnWorld($playerID);
		
		$stmt = $this->connectionData->prepare("UPDATE province_Occupation SET Country_Name = ? WHERE World_Code = ? AND Province_ID = ?;");
		$stmt->bind_param('sss',$playerID,$worldCode,$provinceID);
		$stmt->execute();
		$stmt->close();
		
		//Point type is safe
		$stmt = $this->connectionData->prepare("UPDATE players SET " . $pointType . " = " . $pointType . " - ? WHERE Country_Name = ?;");
		$stmt->bind_param('is',intval($cost),$playerID);
		$stmt->execute();
		$stmt->close();
		
	}
}
?>
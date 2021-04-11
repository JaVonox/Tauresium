<?php
require "dbinfo.php";
require "RestService.php";
require "APIAssets/Classes.php";
require "Scripts/MapConnections.php"; //MapConnections includes database - therefore this loads database
require "APIScripts/NewCountry.php";
require "APIScripts/NewWorld.php";
require "APIScripts/NewBuild.php";
require "APIScripts/AnnexScript.php";

class TauresiumRestService extends RestService 
{
	private $returnArray;
	private $database;
	private $loadedDatabase;
	
	public function __construct() 
	{
		parent::__construct("TaurAPI");
		
		$this->database = new Database();
		$this->loadedDatabase = $this->database->getConnection();
	}
	
	public function PerformGet($url, $parameters, $requestBody, $accept) 
	{
		header('Content-Type: application/json; charset=utf-8');
		header('no-cache,no-store');
		//get api basic usages
		//Province/ProvinceName/WorldCode 
		//View/APIKEY
		//Country/CountryName 
		//World/WorldCode 
		//Building/BuildingName 
		//Government/Government type 
		//CoastalRegion/CoastalRegion 
		//Cost/Province/CountryName
		//Event/APIKEY
		
		switch ($parameters[1])
		{
			case "Province":
				$provinceID = (!empty($parameters[2]) ? $parameters[2] : 'NULL');
				$worldCode = (!empty($parameters[3]) ? $parameters[3] : 'NULL');
				
				if($provinceID == "NULL")
				{
					$this->GetAllJSONProvinces();
					echo json_encode($this->returnArray);
				}
				else
				{	
					if($worldCode == "NULL") //No API key supplied
					{
						$prov = $this->GetJSONProvinceViaID($provinceID);
						
					}
					else
					{
						$prov = $this->GetJSONProvinceViaIDandWorld($provinceID,$worldCode);
					}
					
					if ($prov != null)
					{
						echo json_encode($prov);
					}
					else
					{
						$this->notFoundResponse();
					}
				}
				
				break;
			case "View": //Used to return the visibility + ownership of each location.
				$playerCountry = (!empty($parameters[2]) ? $this->InterpretAPIKey($parameters[2]) : 'BAD');
				
				if($playerCountry == "BAD") 
				{
					$this->notFoundResponse();
					
				}
				else
				{
					$this->GetJSonView($playerCountry);
					echo json_encode($this->returnArray);
				}
				
				break;
			case "Country":
				$id="";
				(!empty($parameters[2]) ? $id = $parameters[2] : $id = "NULL");
				
				if($id=="NULL"){$this->methodNotAllowedResponse(); break;} //Stop users pulling all data
				$country = $this->GetJSONCountryViaID($id);
				
				if ($country != null)
				{
					echo json_encode($country);
				}
				else
				{
					$this->notFoundResponse();
				}
				break;
			case "World":
				$id = "";
				(!empty($parameters[2]) ? $id = $parameters[2] : $id = "NULL");
				
				if($id=="NULL"){$this->methodNotAllowedResponse(); break;} //Stop users pulling all data
				
				$worldInfo = $this->GetJSONWorldInfo($id);
				if ($worldInfo != null)
				{
					echo json_encode($worldInfo);
				}
				else
				{
					$this->notFoundResponse();
				}
				break;
			case "Building":
				!empty($parameters[2]) ? $parameters[2] = str_replace(array("_")," ",$parameters[2]) : null;
				$buildID = (!empty($parameters[2]) ? $parameters[2] : 'NULL');
			
				if($buildID == "NULL")
				{
					$this->GetAllJSONBuildings();
					echo json_encode($this->returnArray);
				}
				else
				{	
					$buildInfo = $this->GetJSONBuildingViaName($buildID);
					
					if ($buildInfo != null)
					{
						echo json_encode($buildInfo);
					}
					else
					{
						$this->notFoundResponse();
					}

				}
				break;
			case "Government":
				!empty($parameters[2]) ? $parameters[2] = str_replace(array("_")," ",$parameters[2]) : null;
				$govID = (!empty($parameters[2]) ? $parameters[2] : 'NULL');
			
				if($govID == "NULL")
				{
					$this->GetAllJSONGov();
					echo json_encode($this->returnArray);
				}
				else
				{	
					$govInfo = $this->GetJSONGovByName($govID);
					
					if ($govInfo != null)
					{
						echo json_encode($govInfo);
					}
					else
					{
						$this->notFoundResponse();
					}

				}
				break;
			case "CoastalRegion":
				!empty($parameters[2]) ? $parameters[2] = str_replace(array("_")," ",$parameters[2]) : null;
				$coastID = (!empty($parameters[2]) ? $parameters[2] : 'NULL');
			
				if($coastID == "NULL")
				{
					$this->GetAllJSONCoast();
					echo json_encode($this->returnArray);
				}
				else
				{	
					$coastInfo = $this->GetJSONCoastViaID($coastID);
					
					if ($coastInfo != null)
					{
						echo json_encode($coastInfo);
					}
					else
					{
						$this->notFoundResponse();
					}

				}
				break;
			case "Cost":
				$provinceID = (!empty($parameters[2]) ? $parameters[2] : 'NULL');
				$countryName = (!empty($parameters[3]) ? $parameters[3] : 'NULL');
				
				if($provinceID == "NULL")
				{
					$this->notFoundResponse();
				}
				else
				{	
					if($countryName == "NULL")
					{
						$this->notFoundResponse();
						
					}
					else
					{
						$costInfo = $this->GetJSONCosts($provinceID,$countryName);
					}
					
					if ($costInfo != null)
					{
						echo json_encode($costInfo);
					}
					else
					{
						$this->notFoundResponse();
					}
				}
				break;
			case "Event":
				$playerCountry = (!empty($parameters[2]) ? $this->InterpretAPIKey($parameters[2]) : 'BAD');
				
				if($playerCountry != "BAD")
				{
					echo json_encode($this->GetJSONEvent($playerCountry));
				}
				else
				{
					header("HTTP/1.1 401 Bad API key supplied");
				}
				break;
			default:	
				$this->methodNotAllowedResponse();
				break;
		}
	}
	
	public function PerformPost($url, $parameters, $requestBody, $accept) 
	{
		header('Content-Type: application/json; charset=utf-8');
		header('no-cache,no-store');
		
		//Country/username/password/worldCode/governmentType/colourHex
		//World/Name/mapType/speed
		//Event/APIKEY/OptionNum{1,2,3} (Answer the event)
		//Building/ProvinceID/APIKEY/buildType{C,E,M}
		//Province/ProvinceID/APIKEY/pointType{C,E,M}
		
		switch ($parameters[1])
		{
			case "Country":
				$username = (!empty($parameters[2]) ? $parameters[2] : '');
				$password = (!empty($parameters[3]) ? $parameters[3] : '');
				$worldCode = (!empty($parameters[4]) ? $parameters[4] : '');
				$governmentType = (!empty($parameters[5]) ? $parameters[5] : '');
				$colour = (!empty($parameters[6]) ? $parameters[6] : '');
				
				echo $this->PostNewCountry($username,$password,$worldCode,$governmentType,$colour);
				break;
			case "World":
				$worldName = (!empty($parameters[2]) ? $parameters[2] : 'NULL');
				$mapType = (!empty($parameters[3]) ? $parameters[3] : 'NULL');
				$speed = (!empty($parameters[4]) ? $parameters[4] : 'NULL');
				
				echo $this->PostNewWorld($worldName,$mapType,$speed);
				break;
			case "Event":
				$playerCountry = (!empty($parameters[2]) ? $this->InterpretAPIKey($parameters[2]) : 'BAD');
				$optionNum = "Option" . (!empty($parameters[3]) ? $parameters[3] : 'NULL'); //Error handling for this is in the answer event script.

				if($playerCountry != "BAD" && $optionNum != "NULL")
				{
					echo json_encode($this->PostAnswerEvent($playerCountry,$optionNum));
				}
				else
				{
					header("HTTP/1.1 401 Bad API key supplied");
				}
				break;
			case "Building":
				$provinceID = (!empty($parameters[2]) ? $parameters[2] : 'NULL');
				$playerCountry = (!empty($parameters[3]) ? $this->InterpretAPIKey($parameters[3]) : 'BAD');
				$buildType = (!empty($parameters[4]) ? $parameters[4] : 'NULL');
				
				if($playerCountry != "BAD")
				{
					$this->PostNewBuild($provinceID,$playerCountry,$buildType);
				}
				else
				{
					header("HTTP/1.1 401 Bad API key supplied");
				}
				break;
			default:
				$this->methodNotAllowedResponse();
				break;
			case "Province":
				$provinceID = (!empty($parameters[2]) ? $parameters[2] : 'NULL');
				$playerCountry = (!empty($parameters[3]) ? $this->InterpretAPIKey($parameters[3]) : 'BAD');
				$pointType = (!empty($parameters[4]) ? $parameters[4] : 'NULL');
				
				if($playerCountry != "BAD" && $pointType != 'NULL' && $provinceID != 'NULL')
				{
					echo json_encode($this->PostAnnex($provinceID,$playerCountry,$pointType));
				}
				else
				{
					header("HTTP/1.1 401 Bad Parameters");
					echo json_encode("INVALID");
				}
				
				break;
		}
	}
	
	public function PerformPut($url, $parameters, $requestBody, $accept) 
	{
		header('Content-Type: application/json; charset=utf-8');
		header('no-cache,no-store');

		//Event/APIKEY (Refreshes the event timer for a player and loads event if not already loaded)
		switch ($parameters[1])
		{
			case "Event":
				$playerCountry = (!empty($parameters[2]) ? $this->InterpretAPIKey($parameters[2]) : 'BAD');
				
				if($playerCountry != "BAD")
				{
					$this->PutEventTimer($playerCountry);
				}
				else
				{
					header("HTTP/1.1 401 Bad API key supplied");
				}
				break;
			default:
				$this->methodNotAllowedResponse();
				break;
		}
	}
	
	public function PerformDelete($url, $parameters, $requestBody, $accept) 
	{
		header('Content-Type: application/json; charset=utf-8');
		header('no-cache,no-store');

		//Event/APIKEY (Skips current active event. API only feature.)
		switch ($parameters[1])
		{
			case "Event":
				$playerCountry = (!empty($parameters[2]) ? $this->InterpretAPIKey($parameters[2]) : 'BAD');
				
				if($playerCountry != "BAD")
				{
					$this->DeleteCurrentEvent($playerCountry);
				}
				else
				{
					header("HTTP/1.1 401 Bad API key supplied");
				}
				break;
			default:
				$this->methodNotAllowedResponse();
				break;
		}
	}

    private function GetAllJSONProvinces()
    {
		global $dbserver, $dbusername, $dbpassword, $dbdatabase;
	
		$connection = new mysqli($dbserver, $dbusername, $dbpassword, $dbdatabase);
		if (!$connection->connect_error)
		{
			$query = "SELECT Province_ID,Capital,Region,Vertex_1,Vertex_2,Vertex_3,Climate,City_Population_Total,National_HDI,National_Nominal_GDP_per_capita,Coastal,Coastal_Region,Culture_Cost,Economic_Cost,Military_Cost,Description,Culture_Modifier,Economic_Enviroment_Modifier,Military_Enviroment_Modifier FROM provinces;";
			if ($result = $connection->query($query))
			{
				while ($row = $result->fetch_assoc())
				{
					$this->returnArray[$row["Province_ID"]] = new ProvinceLowDetail($row["Province_ID"], $row["Capital"], $row["Region"],$row['Vertex_1'],$row['Vertex_2'],$row['Vertex_3'], $row["Climate"], $row["City_Population_Total"], $row["National_HDI"], $row["National_Nominal_GDP_per_capita"], $row["Coastal"], $row["Coastal_Region"],$row['Culture_Cost'],$row['Economic_Cost'],$row['Military_Cost'],$row['Description'],$row['Culture_Modifier'],$row['Economic_Enviroment_Modifier'],$row['Military_Enviroment_Modifier']);
				}
				$result->close();
			}
			$connection->close();
		}
	}	 

    private function GetJSONProvinceViaID($id)
    {
		global $dbserver, $dbusername, $dbpassword, $dbdatabase;
		
		$connection = new mysqli($dbserver, $dbusername, $dbpassword, $dbdatabase);
		if (!$connection->connect_error)
		{
			$query = "SELECT Province_ID,Capital,Region,Vertex_1,Vertex_2,Vertex_3,Climate,City_Population_Total,National_HDI,National_Nominal_GDP_per_capita,Coastal,Coastal_Region,Culture_Cost,Economic_Cost,Military_Cost,Description,Culture_Modifier,Economic_Enviroment_Modifier,Military_Enviroment_Modifier FROM provinces WHERE Province_ID = ? OR Capital = ? OR Region = ?;";
			$statement = $connection->prepare($query);
			$statement->bind_param('sss', $id,$id,$id);
			$statement->execute();
			$statement->store_result();
			$statement->bind_result($Province_ID, $Capital, $Region,$Vertex_1,$Vertex_2,$Vertex_3, $Climate, $City_Population_Total,$National_HDI,$National_Nominal_GDP_per_capita,$Coastal,$Coastal_Region,$Culture_Cost,$Economic_Cost,$Military_Cost,$Description,$Culture_Modifier,$Economic_Enviroment_Modifier,$Military_Enviroment_Modifier);
			
			if ($statement->fetch())
			{
				return new ProvinceLowDetail($Province_ID, $Capital, $Region,$Vertex_1,$Vertex_2,$Vertex_3, $Climate, $City_Population_Total,$National_HDI,$National_Nominal_GDP_per_capita,$Coastal,$Coastal_Region,$Culture_Cost,$Economic_Cost,$Military_Cost,$Description,$Culture_Modifier,$Economic_Enviroment_Modifier,$Military_Enviroment_Modifier);
			}
			else
			{
				return null;
			}
			
			$statement->close();
			$connection->close();
		}
	}	
	
	private function GetAllJSONBuildings()
    {
		global $dbserver, $dbusername, $dbpassword, $dbdatabase;
	
		$connection = new mysqli($dbserver, $dbusername, $dbpassword, $dbdatabase);
		if (!$connection->connect_error)
		{
			$query = "SELECT BuildingID,Building_Name,Bonus_Mil_Cap,Bonus_Def_Strength,Bonus_Build_Cost,Base_Cost FROM buildings;";
			if ($result = $connection->query($query))
			{
				while ($row = $result->fetch_assoc())
				{
					$this->returnArray[$row["BuildingID"]] = new BuildDetail($row["BuildingID"], $row["Building_Name"], $row["Bonus_Mil_Cap"],$row['Bonus_Def_Strength'],$row['Bonus_Build_Cost'],$row['Base_Cost']);
				}
				$result->close();
			}
			$connection->close();
		}
	}
	
	private function GetJSONBuildingViaName($buildName)
    {
		global $dbserver, $dbusername, $dbpassword, $dbdatabase;
		
		$connection = new mysqli($dbserver, $dbusername, $dbpassword, $dbdatabase);
		if (!$connection->connect_error)
		{
			$query = "SELECT BuildingID,Building_Name,Bonus_Mil_Cap,Bonus_Def_Strength,Bonus_Build_Cost,Base_Cost FROM buildings WHERE Building_Name = ?;";
			$statement = $connection->prepare($query);
			$statement->bind_param('s', $buildName);
			$statement->execute();
			$statement->store_result();
			$statement->bind_result($BuildingID,$Building_Name,$Bonus_Mil_Cap,$Bonus_Def_Strength,$Bonus_Build_Cost,$Base_Cost);
			
			if ($statement->fetch())
			{
				return new BuildDetail($BuildingID,$Building_Name,$Bonus_Mil_Cap,$Bonus_Def_Strength,$Bonus_Build_Cost,$Base_Cost);
			}
			else
			{
				return null;
			}
			$statement->close();
			$connection->close();
		}
	}	
	
	private function GetAllJSONGov()
    {
		global $dbserver, $dbusername, $dbpassword, $dbdatabase;
	
		$connection = new mysqli($dbserver, $dbusername, $dbpassword, $dbdatabase);
		if (!$connection->connect_error)
		{
			$query = "SELECT GovernmentForm,Title,Base_Military_Generation,Base_Culture_Generation,Base_Economic_Generation,Base_Military_Influence,Base_Culture_Influence,Base_Economic_Influence FROM governmenttypes;";
			if ($result = $connection->query($query))
			{
				while ($row = $result->fetch_assoc())
				{
					$this->returnArray[$row["GovernmentForm"]] = new GovDetail($row["GovernmentForm"], $row["Title"], $row["Base_Military_Generation"],$row['Base_Culture_Generation'],$row['Base_Economic_Generation'],$row['Base_Military_Influence'],$row['Base_Culture_Influence'],$row['Base_Economic_Influence']);
				}
				$result->close();
			}
			$connection->close();
		}
	}
	
	private function GetJSONGovByName($govName)
    {
		global $dbserver, $dbusername, $dbpassword, $dbdatabase;
		
		$connection = new mysqli($dbserver, $dbusername, $dbpassword, $dbdatabase);
		if (!$connection->connect_error)
		{
			$query = "SELECT GovernmentForm,Title,Base_Military_Generation,Base_Culture_Generation,Base_Economic_Generation,Base_Military_Influence,Base_Culture_Influence,Base_Economic_Influence FROM governmenttypes WHERE GovernmentForm = ?;";
			$statement = $connection->prepare($query);
			$statement->bind_param('s', $govName);
			$statement->execute();
			$statement->store_result();
			$statement->bind_result($GovernmentForm,$Title,$Base_Military_Generation,$Base_Culture_Generation,$Base_Economic_Generation,$Base_Military_Influence,$Base_Culture_Influence,$Base_Economic_Influence);
			
			if ($statement->fetch())
			{
				return new GovDetail($GovernmentForm,$Title,$Base_Military_Generation,$Base_Culture_Generation,$Base_Economic_Generation,$Base_Military_Influence,$Base_Culture_Influence,$Base_Economic_Influence);
			}
			else
			{
				return null;
			}
			$statement->close();
			$connection->close();
		}
	}	
	
	private function GetAllJSONCoast()
    {
		global $dbserver, $dbusername, $dbpassword, $dbdatabase;
	
		$connection = new mysqli($dbserver, $dbusername, $dbpassword, $dbdatabase);
		if (!$connection->connect_error)
		{
			$query = "SELECT Coastal_Region,Colonial_Penalty,Minimum_Colony_provinces,Short_Range_Penalty,Colonial_Title,Outbound_Connection_1,Outbound_Connection_2,Outbound_Connection_3,Outbound_Connection_4,Outbound_Connection_5 FROM coastalregions";
			if ($result = $connection->query($query))
			{
				while ($row = $result->fetch_assoc())
				{
					$this->returnArray[$row["Coastal_Region"]] = new CoastDetail($row["Coastal_Region"], $row["Colonial_Penalty"], $row["Minimum_Colony_provinces"],$row['Short_Range_Penalty'],$row['Colonial_Title'],$row['Outbound_Connection_1'],$row['Outbound_Connection_2'],$row['Outbound_Connection_3'],$row['Outbound_Connection_4'],$row['Outbound_Connection_5']);
				}
				$result->close();
			}
			$connection->close();
		}
	}
	
	private function GetJSONCoastViaID($coastName)
    {
		global $dbserver, $dbusername, $dbpassword, $dbdatabase;
		
		$connection = new mysqli($dbserver, $dbusername, $dbpassword, $dbdatabase);
		if (!$connection->connect_error)
		{
			$query = "SELECT Coastal_Region,Colonial_Penalty,Minimum_Colony_provinces,Short_Range_Penalty,Colonial_Title,Outbound_Connection_1,Outbound_Connection_2,Outbound_Connection_3,Outbound_Connection_4,Outbound_Connection_5 FROM coastalregions WHERE Coastal_Region = ?;";
			$statement = $connection->prepare($query);
			$statement->bind_param('s', $coastName);
			$statement->execute();
			$statement->store_result();
			$statement->bind_result($Coastal_Region,$Colonial_Penalty,$Minimum_Colony_provinces,$Short_Range_Penalty,$Colonial_Title,$Outbound_Connection_1,$Outbound_Connection_2,$Outbound_Connection_3,$Outbound_Connection_4,$Outbound_Connection_5);
			
			if ($statement->fetch())
			{
				return new CoastDetail($Coastal_Region,$Colonial_Penalty,$Minimum_Colony_provinces,$Short_Range_Penalty,$Colonial_Title,$Outbound_Connection_1,$Outbound_Connection_2,$Outbound_Connection_3,$Outbound_Connection_4,$Outbound_Connection_5);
			}
			else
			{
				return null;
			}
			$statement->close();
			$connection->close();
		}
	}	
	
	private function GetJSONWorldInfo($worldParam) //SQL UNSAFE TODO fix this
    {
		global $dbserver, $dbusername, $dbpassword, $dbdatabase;
		
		$connection = new mysqli($dbserver, $dbusername, $dbpassword, $dbdatabase);
		if (!$connection->connect_error)
		{
			$query = "SELECT World_Code,World_Name,MapType,Speed,Capacity FROM worlds WHERE World_Code = ? OR World_Name = ?;";
			$statement = $connection->prepare($query);
			$statement->bind_param('ss', $worldParam,$worldParam);
			$statement->execute();
			$statement->store_result();
			$statement->bind_result($World_Code,$World_Name,$MapType,$Speed,$Capacity);
			
			$worldQuery = $connection->query("SELECT World_Code FROM worlds WHERE World_Code = '" . $worldParam . "' OR World_Name = '" . $worldParam . "';"); 
			$worldCode = $worldQuery->fetch_row()[0];
			
			$playerQuery = $connection->query("SELECT DISTINCT Country_Name FROM players WHERE World_Code = '" . $worldCode . "';"); //Calls to World_Code multiple times are unneccesary - might be worth changing?
			$ownedPlayers = $playerQuery->fetch_all(MYSQLI_NUM);
			$playerDetails = array();
			
			for($i=0;$i < count($ownedPlayers);$i++)
			{
				array_push($playerDetails,$this->GetJSONCountryViaID($ownedPlayers[$i][0])); //Appends the province details of each province this player owns.
			}
			
			if ($statement->fetch())
			{
				return new WorldDetail($World_Code,$World_Name,$MapType,$Speed,$Capacity,$playerDetails);
			}
			else
			{
				return null;
			}
			$statement->close();
			$connection->close();
		}
	}	
	
	private function GetJSONCountryViaID($id)
    {
		global $dbserver, $dbusername, $dbpassword, $dbdatabase;
		
		$connection = new mysqli($dbserver, $dbusername, $dbpassword, $dbdatabase);
		if (!$connection->connect_error)
		{
			$query = "SELECT Country_Name,Country_Type,Colour,World_Code,Military_Influence,Military_Generation,Culture_Influence,Culture_Generation,Economic_Influence,Economic_Generation,Events_Stacked,Last_Event_Time,Active_Event_ID FROM players WHERE Country_Name = ?;";
			$statement = $connection->prepare($query);
			$statement->bind_param('s', $id);
			$statement->execute();
			$statement->store_result();
			$statement->bind_result($Country_Name,$Country_Type,$Colour,$World_Code,$Military_Influence,$Military_Generation,$Culture_Influence,$Culture_Generation,$Economic_Influence,$Economic_Generation,$Events_Stacked,$Last_Event_Time,$Active_Event_ID);
			$playerWorld = $World_Code;
			
			$stateOcc = $connection->prepare("SELECT DISTINCT Province_ID,World_Code FROM province_Occupation WHERE Country_Name = ?;");
			$stateOcc->bind_param('s', $id);
			$stateOcc->execute();
			$result = $stateOcc->get_result();
			$ownedProvinces = $result->fetch_all(MYSQLI_NUM);

			$playerWorld = (!empty($ownedProvinces) ? $ownedProvinces[0][1] : "NULL");
			$provinceDetails = array();
			$oceanPowersArray = array();
			
			for($i=0;$i<count($ownedProvinces);$i++)
			{
				array_push($provinceDetails,$this->GetJSONProvinceViaIDandWorld($ownedProvinces[$i][0],$playerWorld)); //Appends the province details of each province this player owns.
			}
			
			$playerOceanPowers = $this->database->GetPlayerAllOceanCount($id);
			
			foreach($playerOceanPowers as $oceanPower) //This was originally designed for use directly into the HTML - so it still includes tags.
			{
				array_push($oceanPowersArray,$oceanPower);
			}

			if ($statement->fetch())
			{
				$PlayerTitle = $this->database->getPlayerStats($Country_Name)['Title'];
				$PlayerMilCap = $this->database->GetPlayerMilCap($Country_Name);
				return new PlayerDetail($Country_Name,$PlayerTitle,$Country_Type,$Colour,$World_Code,$PlayerMilCap,$Military_Influence,$Military_Generation,$Culture_Influence,$Culture_Generation,$Economic_Influence,$Economic_Generation,$Events_Stacked,$Last_Event_Time,$Active_Event_ID,$oceanPowersArray,$provinceDetails);
			}
			else
			{
				return null;
			}
			$statement->close();
			$stateOcc->close();
			$connection->close();
		}
	}	
	
	private function GetJSONProvinceViaIDandWorld($id,$worldCode)
    {
		global $dbserver, $dbusername, $dbpassword, $dbdatabase;
		
		$connection = new mysqli($dbserver, $dbusername, $dbpassword, $dbdatabase);
		if (!$connection->connect_error)
		{
			$provinceQuery = "SELECT DISTINCT provinces.Province_ID,provinces.Capital,provinces.Region,provinces.Vertex_1,provinces.Vertex_2,provinces.Vertex_3,provinces.Climate,
			provinces.City_Population_Total,provinces.National_HDI,provinces.National_Nominal_GDP_per_capita,provinces.Coastal,provinces.Coastal_Region,province_occupation.Country_Name,
			(SELECT buildings.Building_Name FROM province_occupation,buildings WHERE province_occupation.Building_Column_1 = buildings.BuildingID AND province_occupation.Province_ID = ? AND province_occupation.World_Code = ?) AS Building1,
			(SELECT buildings.Building_Name FROM province_occupation,buildings WHERE province_occupation.Building_Column_2 = buildings.BuildingID AND province_occupation.Province_ID = ? AND province_occupation.World_Code = ?) AS Building2,
			provinces.Culture_Cost,provinces.Economic_Cost,provinces.Military_Cost,provinces.Description,provinces.Culture_Modifier,provinces.Economic_Enviroment_Modifier,provinces.Military_Enviroment_Modifier
			FROM provinces,province_occupation WHERE province_occupation.Province_ID = ? AND province_occupation.World_Code = ? AND provinces.Province_ID = ?";
			
			$statement = $connection->prepare($provinceQuery);
			$statement->bind_param('sssssss', $id,$worldCode,$id,$worldCode,$id,$worldCode,$id);
			$statement->execute();
			$statement->store_result();
			$statement->bind_result($Province_ID, $Capital, $Region,$Vertex_1,$Vertex_2,$Vertex_3, $Climate, $City_Population_Total,$National_HDI,$National_Nominal_GDP_per_capita,$Coastal,$Coastal_Region,$Owner,$Building1,$Building2,$CultCost,$EcoCost,$MilCost,$Description,$Culture_Modifier,$Economic_Enviroment_Modifier,$Military_Enviroment_Modifier);
	
			$buildParams = $this->database->GetProvBuildBonuses($id,$worldCode);
			
			if ($statement->fetch())
			{
				return new ProvinceHighDetail($Province_ID, $Capital, $Region,$Vertex_1 ,$Vertex_2 ,$Vertex_3, $Climate, $City_Population_Total,$National_HDI,$National_Nominal_GDP_per_capita,$Coastal,$Coastal_Region,$Owner,$Building1,$Building2,$CultCost,$EcoCost,$MilCost,$Description,$Culture_Modifier,$Economic_Enviroment_Modifier,$Military_Enviroment_Modifier,$buildParams['Mil_Cap'],$buildParams['Def_Strength'],$buildParams['Bonus_Build']);
			}
			else
			{
				return $this->GetJSONProvinceViaID($id);
			}
			
			$statement->close();
			$connection->close();
		}
	}
	
	private function GetJSONView($countryName) //Gets visibility + owner
	{
		global $dbserver, $dbusername, $dbpassword, $dbdatabase;
		
		$playerWorldCode = $this->database->ReturnWorld($countryName);
		$connection = new mysqli($dbserver, $dbusername, $dbpassword, $dbdatabase);
				
		$query = "SELECT Province_ID,Capital,Region,Vertex_1,Vertex_2,Vertex_3,Climate,City_Population_Total,National_HDI,National_Nominal_GDP_per_capita,Coastal,Coastal_Region,Culture_Cost,Economic_Cost,Military_Cost,Description,Culture_Modifier,Economic_Enviroment_Modifier,Military_Enviroment_Modifier FROM provinces;";
		$occupiedSet = $this->database->GetOccupation($countryName); //Stores all the provinces owned on the map.
		$visibilitySet = $this->database->GetVisibility($countryName); //Stores all provinces that should be hidden
		
		if ($result = $connection->query($query))
		{
			while ($selectedInfo = $result->fetch_assoc())
			{	
				$colourVal = "NULL";
				$visible = true;
				$ownerVal = "NULL";
				
				foreach($occupiedSet as $occupiedLocation)
				{
					if($occupiedLocation['Province_ID'] == $selectedInfo['Province_ID'])
					{
						$colourVal = $occupiedLocation['Colour'];
						$ownerVal = array("Country_Name" => $occupiedLocation['Country_Name'],"Title" => $occupiedLocation['Title']);
					}
				}
				
				foreach($visibilitySet as $visibleLocation)
				{
					if($visibleLocation['Province_ID'] == $selectedInfo['Province_ID'])
					{
						$visible = false;
					}
				}

				$this->returnArray[$selectedInfo['Province_ID']] = new ProvinceViewMode($selectedInfo["Province_ID"], $selectedInfo["Capital"], $selectedInfo["Region"],$selectedInfo['Vertex_1'],$selectedInfo['Vertex_2'],$selectedInfo['Vertex_3'], $selectedInfo["Climate"], $selectedInfo["City_Population_Total"], $selectedInfo["National_HDI"], $selectedInfo["National_Nominal_GDP_per_capita"], $selectedInfo["Coastal"], $selectedInfo["Coastal_Region"],$selectedInfo['Culture_Cost'],$selectedInfo['Economic_Cost'],$selectedInfo['Military_Cost'],$selectedInfo['Description'],$selectedInfo['Culture_Modifier'],$selectedInfo['Economic_Enviroment_Modifier'],$selectedInfo['Military_Enviroment_Modifier'],$colourVal,$visible,$ownerVal);
			}
			
		}
			
		$connection->close();
	}
	
	private function GetJSONCosts($user,$provinceID) //This returns the costs of each province, which is player dependent. This can later be implemented for the POST call for taking provinces
	{
		
		if($this->GetJSONCountryViaID($user) == null || $this->GetJSONProvinceViaID($provinceID) == null) //checks both parameters are valid
		{
			return null; //If invalid parameters are provided, cut execution.
		}
		
		$mapConnect = new MapConnections();
		$mapConnect->init($user);
		$provInfo = $this->GetJSONProvinceViaID($provinceID);
		$valueInfo = array("Culture" => "", "Economic" => "","Military" => "");
		
		
		$valueInfo["Culture"] = $mapConnect->CheckCulture($provinceID);
		$valueInfo["Economic"] = $mapConnect->CheckEconomic($provinceID);
		$valueInfo["Military"] = $mapConnect->CheckMilitary($provinceID);
		$owner = $mapConnect->CheckOwner($provinceID);
		
		$cultDesc = $valueInfo['Culture'][1];
		$ecoDesc = $valueInfo['Economic'][1];
		$milDesc = $valueInfo['Military'][1];
		$cultCost = "Infinite";
		$ecoCost = $valueInfo['Economic'][2];
		$milCost = $valueInfo['Military'][2];
		
		$cultPos = $valueInfo['Culture'][0]; //checks if its possible for the player to annex this province (using their current points cost)
		$ecoPos = $valueInfo['Economic'][0]; 
		$milPos = $valueInfo['Military'][0]; 
		
		if($valueInfo['Culture'][2])
		{
			$cultCost = $provInfo->Base_Culture_Cost; //Culture cost is never different from base cost, so its value should just be loaded from the province Info
		}
		
		if($ecoCost >= 9999) //9999 is the eco value for an impossible Cost;
		{
			$ecoCost = "Infinite";
		}
		else
		{
			$ecoDesc = $valueInfo['Economic'][1] . " + " . $valueInfo['Economic'][2];
			$ecoCost += $provInfo->Base_Economic_Cost; //The pulled ecoCost is the addition value.
		}
		
		//Infinite means not possible.
		return new ProvinceCost($provinceID,$user,$owner,$cultDesc,$cultCost,$cultPos,$ecoDesc,$ecoCost,$ecoPos,$milDesc,$milCost,$milPos);
	}
	
	private function GetJSONEvent($countryName)
	{
		$activeEventID = $this->database->GetLoadedEvent($countryName); //The get event method can make modifications to the database. To stop this from occuring we can check if the player has an event active at the moment
		

		if($activeEventID['LoadedEvent'] == "")
		{
			header("HTTP/1.1 404 Player has no active event"); //TODO - Maybe add verification for this step? like make sure it actually goes through
			return "null";
		}
		else
		{
			$eventInfo = $this->database->GetEvent($countryName);
			return new EventDetail($eventInfo['Event_ID'],$eventInfo['Title'],$eventInfo['Description'],$eventInfo['Option_1_ID'],$eventInfo['Option_1_Desc'],$eventInfo['Option_2_ID'],$eventInfo['Option_2_Desc'],$eventInfo['Option_3_ID'],$eventInfo['Option_3_Desc']);
		}

	}
	
	private function PostNewCountry($username,$password,$worldCode,$governmentType,$colour) //Creates new country via POST request. Might be insecure due to sending of password.
	{
		$parameters = _CreateNewCountry($worldCode,$username,$password,$governmentType,$colour);
		
		//Responses
		if($parameters[0]) //Occurs when errors occured
		{
			header("HTTP/1.1 400 Error occured. Code: " . $parameters[1]); //TODO - interpret error string.
			return json_encode($parameters);
		}
		else
		{
			header("HTTP/1.1 200 Successfully made country");
			return json_encode($parameters);
		}
	}
	
	private function PostNewWorld($worldName,$mapType,$speed) //Creates new world via POST request.
	{
		$parameters = _CreateNewWorld($worldName,$mapType,$speed);
		
		//Responses
		if($parameters[0]) //Occurs when errors occured
		{
			header("HTTP/1.1 400 Error occured. See JSON for details."); //TODO - interpret error string.
			return json_encode($parameters);
		}
		else
		{
			header("HTTP/1.1 200 Successfully made new world. See JSON for World Code");
			return json_encode($parameters);
		}
	}
	
	private function PostAnswerEvent($countryName,$optionType)
	{
		$eventLoad = $this->GetJSONEvent($countryName);
		
		if($eventLoad == "null")
		{
			header("HTTP/1.1 400 Player event ID is invalid. Is there an event loaded?"); 
			return "null";
		}
		else
		{
			$eventIDLoaded = $eventLoad->Event_ID;
			
			$selectedOption = "";
			if($optionType == 'Option1'){
				$selectedOption = "Option1";
			}
			else if($optionType == 'Option2'){
				$selectedOption = "Option2";
			}
			else if($optionType == 'Option3'){
				$selectedOption = "Option3";
			}
			else{
				header("HTTP/1.1 400 Invalid Event Option"); 
				return "null";
			}	
			
			$eventChanges = $this->database->EventResults($countryName,$eventIDLoaded,$selectedOption);
			return new EventResults(strval($eventIDLoaded),$eventChanges['Title'],$eventChanges['Option_ID'],$eventChanges['Option_Description'],$eventChanges['Military_Gen_Modifier'],$eventChanges['Economic_Gen_Modifier'],$eventChanges['Culture_Gen_Modifier'],$eventChanges['AddMil'],$eventChanges['AddEco'],$eventChanges['AddCult']);
		}
	}
	
	private function PostNewBuild($provinceID,$countryName,$buildType)
	{
		$parameters = _CreateNewBuild($countryName,$provinceID,$buildType);
		
		//Responses
		if($parameters[0]) //Occurs when errors occured
		{
			header("HTTP/1.1 400 " . $parameters[1]); //TODO - interpret error string.
		}
		else
		{
			header("HTTP/1.1 200 Sucessfully constructed building");
		}
	}
	
	private function PostAnnex($provinceID,$playerCountry,$pointType)
	{
		$returnArg = _AnnexLocation($provinceID,$playerCountry,$pointType);
		
		//Responses
		if($returnArg == "SUCCESS") //Occurs when errors occured
		{
			header("HTTP/1.1 200 Sucessfully annexed location");
			return "SUCCESS";
		}
		else if($returnArg == "INVALID")
		{
			header("HTTP/1.1 401 Not enough points or no access to this location"); 
			return "INVALID";
		}
		else if($returnArg == "BAD")
		{
			header("HTTP/1.1 400 Bad arguments supplied"); 
			RETURN "BAD";
		}
	}
	
	private function InterpretAPIKey($apiKey)
	{
		$country = $this->database->ReturnCountryFromAPIKey($apiKey);
		
		if(empty($country))
		{
			return "BAD"; //Tells program that bad API is supplied
		}
		else
		{
			return $country;
		}
	}
	
	private function PutEventTimer($countryName)
	{
		$this->database->UpdateEventTimer($countryName);
		$eventInfo = $this->database->GetEvent($countryName);
		
		if($eventInfo == False)
		{
			header("HTTP/1.1 200 Updated last online time. No event could be loaded."); //TODO - Maybe add verification for this step? like make sure it actually goes through
		}
		else
		{
			header("HTTP/1.1 201 Updated last online time. Loaded new event.");
		}
	}
	
	private function DeleteCurrentEvent($countryName)
	{
		//This should only set event to null, loading the event is what removes the event stack.
		global $dbserver, $dbusername, $dbpassword, $dbdatabase;
		
		$connection = new mysqli($dbserver, $dbusername, $dbpassword, $dbdatabase);
		
		if (!$connection->connect_error)
		{
			$stmt = $connection->prepare("UPDATE players SET Active_Event_ID = null WHERE Country_Name = ?;"); 
			$stmt->bind_param('s', $countryName);
			$stmt->execute();
			$stmt->close();
			
			header("HTTP/1.1 200 Skipped event if applicable");
		}
	}
	

}
?>

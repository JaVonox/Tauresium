<?php
    require "dbinfo.php";
    require "RestService.php";
    require "APIAssets/Classes.php";
 
class TauresiumRestService extends RestService 
{
	private $returnArray;
	public function __construct() 
	{
		parent::__construct("TaurAPI");
	}
	
	public function PerformGet($url, $parameters, $requestBody, $accept) 
	{
		header('Content-Type: application/json; charset=utf-8');
		header('no-cache,no-store');
		//api basic usages
		//Province/ProvinceName/WorldCode 
		//Country/CountryName 
		//World/WorldCode 
		//Building/BuildingName 
		//Government/Government type 
		//CoastalRegion/CoastalRegion 
		
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
					if($worldCode == "NULL")
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

			case "Country": //add no pull all
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
			case "World": //add no pull all
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
			default:	
				$this->methodNotAllowedResponse();
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
	
	private function GetJSONWorldInfo($worldParam) //SQL UNSAFE
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
			
			$provQuery = $connection->query("SELECT DISTINCT Province_ID,World_Code FROM province_Occupation WHERE Country_Name = '" . $id . "';"); //Calls to World_Code multiple times are unneccesary - might be worth changing?
			$ownedProvinces = $provQuery->fetch_all(MYSQLI_NUM);
			$playerWorld = (!empty($ownedProvinces) ? $ownedProvinces[0][1] : "NULL");
			$provinceDetails = array();
			
			for($i=0;$i<count($ownedProvinces);$i++)
			{
				array_push($provinceDetails,$this->GetJSONProvinceViaIDandWorld($ownedProvinces[$i][0],$playerWorld)); //Appends the province details of each province this player owns.
			}

			if ($statement->fetch())
			{
				return new PlayerDetail($Country_Name,$Country_Type,$Colour,$World_Code,$Military_Influence,$Military_Generation,$Culture_Influence,$Culture_Generation,$Economic_Influence,$Economic_Generation,$Events_Stacked,$Last_Event_Time,$Active_Event_ID,$provinceDetails);
			}
			else
			{
				return null;
			}
			$statement->close();
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
	
			if ($statement->fetch())
			{
				return new ProvinceHighDetail($Province_ID, $Capital, $Region,$Vertex_1,$Vertex_2,$Vertex_3, $Climate, $City_Population_Total,$National_HDI,$National_Nominal_GDP_per_capita,$Coastal,$Coastal_Region,$Owner,$Building1,$Building2,$CultCost,$EcoCost,$MilCost,$Description,$Culture_Modifier,$Economic_Enviroment_Modifier,$Military_Enviroment_Modifier);
			}
			else
			{
				return null;
			}
			
			$statement->close();
			$connection->close();
		}
	}
}
?>

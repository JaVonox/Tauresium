<?php
    require "dbinfo.php";
    require "RestService.php";
    require "APIAssets/Classes.php";
 
class TauresiumRestService extends RestService 
{
	private $provinces;
    
	public function __construct() 
	{
		parent::__construct("API");
	}

	public function performGet($url, $parameters, $requestBody, $accept) 
	{
		header('Content-Type: application/json; charset=utf-8');
		header('no-cache,no-store');
		//api basic usages
		//Province/ProvinceName/WorldCode(Code/Null)
		//Country/CountryName
		//Worlds/WorldCode
		//Buildings/BuildingName
		switch ($parameters[1])
		{
			case "Province":
				$provinceID = (!empty($parameters[2]) ? $parameters[2] : 'NULL');
				$worldCode = (!empty($parameters[3]) ? $parameters[3] : 'NULL');
			
				if($provinceID == "NULL")
				{
					$this->GetAllJSONProvinces();
					echo json_encode($this->provinces);
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
					
					echo json_encode($prov);
				}
				
				break;

			case "Country": //TBC
				$id = $parameters[2];
				$prov = $this->GetJSONProvinceViaID($id);
				if ($prov != null)
				{
					echo json_encode($prov);
				}
				else
				{
					$this->notFoundResponse();
				}
				break;

			case "CountryOLD":
				$id = $parameters[2];
				$prov = $this->GetJSONProvinceViaID($id);
				if ($prov != null)
				{
					echo json_encode($prov);
				}
				else
				{
					$this->notFoundResponse();
				}
				break;
			case "Country":
				die("A");
			case "Worlds":
				die("A");
			case "Buildings":
				die("A");
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
			$query = "SELECT Province_ID,Capital,Region,Vertex_1,Vertex_2,Vertex_3,Climate,City_Population_Total,National_HDI,National_Nominal_GDP_per_capita,Coastal,Coastal_Region FROM provinces;";
			if ($result = $connection->query($query))
			{
				while ($row = $result->fetch_assoc())
				{
					$this->provinces[] = new ProvinceLowDetail($row["Province_ID"], $row["Capital"], $row["Region"],$row['Vertex_1'],$row['Vertex_2'],$row['Vertex_3'], $row["Climate"], $row["City_Population_Total"], $row["National_HDI"], $row["National_Nominal_GDP_per_capita"], $row["Coastal"], $row["Coastal_Region"]);
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
			$query = "SELECT Province_ID,Capital,Region,Vertex_1,Vertex_2,Vertex_3,Climate,City_Population_Total,National_HDI,National_Nominal_GDP_per_capita,Coastal,Coastal_Region FROM provinces WHERE Province_ID = ?;";
			$statement = $connection->prepare($query);
			$statement->bind_param('s', $id);
			$statement->execute();
			$statement->store_result();
			$statement->bind_result($Province_ID, $Capital, $Region,$Vertex_1,$Vertex_2,$Vertex_3, $Climate, $City_Population_Total,$National_HDI,$National_Nominal_GDP_per_capita,$Coastal,$Coastal_Region);
			
			if ($statement->fetch())
			{
				return new ProvinceLowDetail($Province_ID, $Capital, $Region,$Vertex_1,$Vertex_2,$Vertex_3, $Climate, $City_Population_Total,$National_HDI,$National_Nominal_GDP_per_capita,$Coastal,$Coastal_Region);
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
			(SELECT buildings.Building_Name FROM province_occupation,buildings WHERE province_occupation.Building_Column_2 = buildings.BuildingID AND province_occupation.Province_ID = ? AND province_occupation.World_Code = ?) AS Building2 
			FROM provinces,province_occupation WHERE province_occupation.Province_ID = ? AND province_occupation.World_Code = ?";
			
			$statement = $connection->prepare($provinceQuery);
			$statement->bind_param('ssssss', $id,$worldCode,$id,$worldCode,$id,$worldCode);
			$statement->execute();
			$statement->store_result();
			$statement->bind_result($Province_ID, $Capital, $Region,$Vertex_1,$Vertex_2,$Vertex_3, $Climate, $City_Population_Total,$National_HDI,$National_Nominal_GDP_per_capita,$Coastal,$Coastal_Region,$Owner,$Building1,$Building2);
	
			if ($statement->fetch())
			{
				return new ProvinceHighDetail($Province_ID, $Capital, $Region,$Vertex_1,$Vertex_2,$Vertex_3, $Climate, $City_Population_Total,$National_HDI,$National_Nominal_GDP_per_capita,$Coastal,$Coastal_Region,$Owner,$Building1,$Building2);
			}
			else
			{
				return null;
			}
			
			$statement->close();
			$connection->close();
		}
	}
	
    private function ExtractFromJSON($requestBody)
    {
		// This function is needed because of the perculiar way json_decode works. 
		// By default, it will decode an object into a object of type stdClass.  There is no
		// way in PHP of casting a stdClass object to another object type.  So we use the
		// approach of decoding the JSON into an associative array (that's what the second
		// parameter set to true means in the call to json_decode). Then we create a new
		// Book object using the elements of the associative array.  Note that we are not
		// doing any error checking here to ensure that all of the items needed to create a new
		// book object are provided in the JSON - we really should be.
		$provArray = json_decode($requestBody, true);
		$book = new ProvinceLowDetail($provArray['Province_ID'],
						 $provArray['Capital'],
						 $provArray['Region'],
						 $provArray['Climate'],
						 $provArray['City_Population_Total'],
						 $provArray['National_HDI'],
						 $provArray['National_Nominal_GDP_per_capita'],
						 $provArray['Coastal'],
						 $provArray['Coastal_Region']);
		unset($provArray);
		return $ProvinceLowDetail;
	}
}
?>

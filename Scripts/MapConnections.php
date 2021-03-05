<?php
include_once "DBLoader.php";

class MapConnections
{
	private $_nationVertexes = ["0","0","0"];
	private $_subjectName = "";
	private $database;
	private $db;
	
	private function FlattenArray($mdArray,$length)
	{
		$arrayLength = 0;
		foreach ($mdArray as $tmp) 
		{
			$arrayLength+= 1;
		}
		
		$flatArray = [];
		for($i = 0;$i < $arrayLength;$i++)
		{	
			for($j = 0;$j < $length;$j++)
			{
				array_push($flatArray,$mdArray[$i][$j]);
			}
		}
		
		return $flatArray;
	}
	
	public function init($sessionID)
	{
		
		$this->database = new Database();
		$this->db = $this->database->getConnection();
		$tmpVert = $this->database->GetPlayerVertexes($sessionID);
		$this->_subjectName = $this->database->ReturnLogin($sessionID);
		$this->_nationVertexes = $this->FlattenArray($tmpVert,3); 
		return $this->_nationVertexes;
	}
	
	public function CheckAdjacent($provinceID) //This verifies if the loaded province is adjacent to a province within the nation
	{
		$provinceVertexes = $this->database->GetProvinceVertexes($provinceID); 
		$exists = 0;
		
		for($i=0;$i<3;$i++)
		{
			if(in_array($provinceVertexes[$i],$this->_nationVertexes))
			{
				$exists += 1;
			}
			else
			{
			}
		}
		
		if($exists >= 2)
		{
			return True;
		}
		else
		{
			return False;
		}
	}
	
	public function ReturnAllPlayerDominantCoastal()
	{
		$occupiedLocations = $this->database->GetPlayerAllOceanCount($this->_subjectName);
		$dominantLocations = array();
		$counter = 0;
		foreach($occupiedLocations as $ocean)
		{
			if(strpos($ocean,'(Dominant)')) //This is a hacky way of collating all the locations a player is present in.
			{
				$dominantLocations[$counter] = $this->database->ConvertCoastalTitleToCoastalRegion(str_replace("</b>","",str_replace("<b>","",str_replace("(Dominant)","",$ocean))));
				$counter++;
			}
		}
		
		return $dominantLocations; //Returns all the locations inwhich the player is dominant
	}
	
	public function CheckIfCoastalInSameCoastalRegion($provinceID,$coastalRegion)
	{
		$playerCoastalPower = $this->database->GetPlayerOceanPower($this->_subjectName,$coastalRegion);
		
		$explodedPower = explode("/",$playerCoastalPower);
		if($explodedPower[0] > 0 && ($this->database->getProvinceDetail($provinceID)[0]['Coastal']) == 1)
		{
			return True;
		}
		else
		{
			return False;
		}
	}
	
	public function CheckOwner($provinceID)
	{
		$owner = $this->database->GetProvinceOwner($provinceID,$this->database->getPlayerStats($this->_subjectName)['World_Code']);
		
		if($owner != "NULL")
		{
			return $owner;
		}
		else
		{
			return "No Owner";
		}
	}
	
	public function CheckCulture($provinceID) //Any Adjacent non owned
	{
		if($this->CheckAdjacent($provinceID) && $this->CheckOwner($provinceID) == "No Owner") 
		{
			if($this->database->getPlayerStats($this->_subjectName)['Culture_Influence'] >= $this->database->getProvinceDetail($provinceID)[0]['Culture_Cost'])
			{
				return array(True,"Province is adjacent to one of our cities",True); //Cult = Can be annexed, desc, Display cost
			}
			else
			{
				return array(False,"Province is adjacent to one of our cities",True);
			}
		}
		else
		{
			if($this->CheckOwner($provinceID) == "No Owner")
			{
				return array(False,"Province is not adjacent to one of our cities",False);
			}
			else
			{
				return array(False,"Province is occupied by another player",False);
			}
		}
	}
	
	public function CheckColonial($provinceID,$dominantLocations) //Any unowned coastal with connected colonial region
	{
		$outboundConnectionsCollated = array();
		
		foreach($dominantLocations as $ocean)
		{
			$outboundConnectionsCollated = array_merge($outboundConnectionsCollated,$this->database->ReturnOutboundConnections($ocean));
		}
		
		if(count($outboundConnectionsCollated) == 0)
		{
			return array(False,"Province is inland or too far away to reach",9999);
		}
		
		for($i=0;$i < count($outboundConnectionsCollated);$i++)
		{
			for($j=0;$j < count($outboundConnectionsCollated[$i]);$j++)
			{
				if($outboundConnectionsCollated[$i][$j] == $this->database->getProvinceDetail($provinceID)[0]['Coastal_Region'] && $this->database->getProvinceDetail($provinceID)[0]['Coastal'] == 1 && $this->CheckOwner($provinceID) == "No Owner")
				{
					if($this->database->getPlayerStats($this->_subjectName)['Economic_Influence'] >= $this->database->getProvinceDetail($provinceID)[0]['Economic_Cost'] + $this->database->ReturnOverseasBonusCost($provinceID,False))
					{
						return array(True,"Province is in a far away region",$this->database->ReturnOverseasBonusCost($provinceID,False));
					}
					else
					{
						return array(False,"Province is in a far away region",$this->database->ReturnOverseasBonusCost($provinceID,False));
					}
				}
			}
		}
		
		if($this->CheckOwner($provinceID) == "No Owner")
		{
			return array(False,"Province is inland or too far away to reach",9999);
		}
		else
		{
			return array(False,"Province is occupied by another player",9999);
		}
	}
	
	public function CheckEconomic($provinceID) //Any unowned coastal within the same coastal region. Also add additional cost via table
	{
		if($this->CheckIfCoastalInSameCoastalRegion($provinceID,$this->database->getProvinceDetail($provinceID)[0]['Coastal_Region']) && $this->CheckOwner($provinceID) == "No Owner") 
		{
			if($this->database->getPlayerStats($this->_subjectName)['Economic_Influence'] >= $this->database->getProvinceDetail($provinceID)[0]['Economic_Cost'] + $this->database->ReturnOverseasBonusCost($provinceID,True))
			{
				return array(True,"Province is in a local region",$this->database->ReturnOverseasBonusCost($provinceID,True));
			}
			else
			{
				return array(False,"Province is in a local region",$this->database->ReturnOverseasBonusCost($provinceID,True));
			}
		}
		else
		{
			return $this->CheckColonial($provinceID,$this->ReturnAllPlayerDominantCoastal($this->_subjectName));
		}
	}
	
	public function CheckMilitary($provinceID) //this can occur over land or ocean using the same conditions as the other checks. It can be used to take over owned land and unowned land, but has penalties for unowned and coastal invasions.
	{
		//Chose the cheaper military cost
		$landCost = $this->database->getProvinceDetail($provinceID)[0]['Military_Cost'];
		$seaCost = $this->database->getProvinceDetail($provinceID)[0]['Military_Cost'];
		$landModifier = 1.5;
		$seaModifier = 1.5;
		$peaceful = True;
		$description = "<br> Base military modifier: +50%";
		
		if($this->CheckOwner($provinceID) == "No Owner")
		{
			$description .= "<br> Province is unowned: +20%";
			$landModifier += 0.2;
			$seaModifier += 0.2;
		}
		else if($this->CheckOwner($provinceID) == $this->_subjectName)
		{
			$landCost = 9999;
			$seaCost = 9999;
		}
		else
		{
			$peaceful = False;
		}
		
		if($this->CheckAdjacent($provinceID)) 
		{
			$landModifier -= 0.05;
			$description .= "<br> Province is adjacent: -5%";
		}
		else
		{
			$landCost = 9999; //unavailable
		}
		
		if($this->CheckIfCoastalInSameCoastalRegion($provinceID,$this->database->getProvinceDetail($provinceID)[0]['Coastal_Region'])) 
		{
			$description .= "<br> Province is available by local oceans: +20%";
			$seaModifier += 0.2;
		}
		else
		{
			$dominantLocations = $this->ReturnAllPlayerDominantCoastal($this->_subjectName);
			
			$outboundConnectionsCollated = array();
		
			foreach($dominantLocations as $ocean)
			{
				$outboundConnectionsCollated = array_merge($outboundConnectionsCollated,$this->database->ReturnOutboundConnections($ocean));
			}
			
			if(count($outboundConnectionsCollated) == 0)
			{
				$seaCost = 9999; //unavailable
			}
			
			$numOfConnections = 0;
			for($i=0;$i < count($outboundConnectionsCollated);$i++)
			{
				for($j=0;$j < count($outboundConnectionsCollated[$i]);$j++)
				{
					if($outboundConnectionsCollated[$i][$j] == $this->database->getProvinceDetail($provinceID)[0]['Coastal_Region'] && $this->database->getProvinceDetail($provinceID)[0]['Coastal'] == 1)
					{
						$numOfConnections +=1;
						break 2;
					}
				}
			}
			
			if($numOfConnections == 0)
			{
				$seaCost = 9999; //unavailable
			}
			else
			{
				$seaModifier +=1;
				$description .= "<br> Province is available by faraway oceans: +100%";
			}
			
		}
		
		$landCost = $landCost * $landModifier;
		$seaCost = $seaCost * $seaModifier;
		
		
		if($landCost < $seaCost && $landCost < 9999)
		{
			$description .= "<br><br> Total: +" . strval(($landModifier-1)*100) . "%";
			
			return array(($this->database->getPlayerStats($this->_subjectName)['Military_Influence'] >= $landCost),$description,floor($landCost),$peaceful);

		}
		else if($seaCost < $landCost && $seaCost < 9999)
		{	
			$description .= "<br><br> Total: +" . strval(($seaModifier-1)*100 . "%");
			
			
			return array(($this->database->getPlayerStats($this->_subjectName)['Military_Influence'] >= $seaCost),$description,floor($seaCost),$peaceful);

		}
		else
		{
			if($this->CheckOwner($provinceID) == $this->_subjectName)
			{
				return array(False,"This is your own province","Infinite");
			}
			else
			{
				return array(False,"No possible route","Infinite");
			}
		}
		
	}

}
?>
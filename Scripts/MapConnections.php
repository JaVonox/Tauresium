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
		$this->_nationVertexes = $this->FlattenArray($tmpVert,3); 
		return $this->_nationVertexes;
	}
	
	public function CheckAdjacent($provinceID) //This verifies if the loaded province is adjacent to a province within the nation
	{
		$provinceVertexes = $this->database->GetProvinceVertexes($provinceID); 
		$exists = False;
		
		for($i=0;$i<3;$i++)
		{
			if(in_array($provinceVertexes[$i],$this->_nationVertexes))
			{
				$exists = True;
			}
			else
			{
			}
		}
		
		if($exists)
		{
			return True;
		}
		else
		{
			return False;
		}
	}
	
	public function CheckCulture($provinceID)
	{
		if($this->CheckAdjacent($provinceID))
		{
			return True;
		}
		else
		{
			return False;
		}
	}
}
?>
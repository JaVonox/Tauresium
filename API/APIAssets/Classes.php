<?php
class ProvinceLowDetail
{
	public $Province_ID;
	public $Capital;
	public $Region;
	public $Vertex1;
	public $Vertex2;
	public $Vertex3;
	public $Climate;
	public $City_Population_Total;
	public $National_HDI;
	public $National_Nominal_GDP_per_capita;
	public $Coastal;
	public $Coastal_Region;
	public $Base_Culture_Cost;
	public $Base_Economic_Cost;
	public $Base_Military_Cost;
	public $Description;
	public $Culture_Modifier;
	public $Economic_Enviroment_Modifier;
	public $Military_Enviroment_Modifier;
	
    public function __construct($Province_ID, $Capital, $Region,$Vert1,$Vert2,$Vert3, $Climate, $City_Population_Total,$National_HDI,$National_Nominal_GDP_per_capita,$Coastal,$Coastal_Region,$Culture_Cost,$Economic_Cost,$Military_Cost,$Description,$Culture_Modifier,$Economic_Enviroment_Modifier,$Military_Enviroment_Modifier)
    {
        $this->Province_ID = $Province_ID;
        $this->Capital = $Capital;
        $this->Region = $Region;
		$this->Vertex1 = $Vert1;
		$this->Vertex2 = $Vert2;
		$this->Vertex3 = $Vert3;
        $this->Climate = $Climate;
        $this->City_Population_Total = $City_Population_Total;
        $this->National_HDI = $National_HDI;
        $this->National_Nominal_GDP_per_capita = $National_Nominal_GDP_per_capita;
		$this->Coastal = $Coastal;
		$this->Coastal_Region = $Coastal_Region;
		$this->Base_Culture_Cost = $Culture_Cost;
		$this->Base_Economic_Cost = $Economic_Cost;
		$this->Base_Military_Cost = $Military_Cost;
		$this->Description = $Description;
		$this->Culture_Modifier = $Culture_Modifier;
		$this->Economic_Enviroment_Modifier = $Economic_Enviroment_Modifier;
		$this->Military_Enviroment_Modifier = $Military_Enviroment_Modifier;
	}
}

class ProvinceHighDetail //Includes Building and Owner - World dependent.
{
	public $Province_ID;
	public $Capital;
	public $Region;
	public $Vertex1;
	public $Vertex2;
	public $Vertex3;
	public $Climate;
	public $City_Population_Total;
	public $National_HDI;
	public $National_Nominal_GDP_per_capita;
	public $Coastal;
	public $Coastal_Region;
	public $Owner;
	public $Build1;
	public $Build2;
	public $Base_Culture_Cost;
	public $Base_Economic_Cost;
	public $Base_Military_Cost;
	public $Description;
	public $Culture_Modifier;
	public $Economic_Enviroment_Modifier;
	public $Military_Enviroment_Modifier;
	public $MilCap;
	public $Defensive_Strength;
	public $Build_Cost;
	
    public function __construct($Province_ID, $Capital, $Region,$Vert1,$Vert2,$Vert3, $Climate, $City_Population_Total,$National_HDI,$National_Nominal_GDP_per_capita,$Coastal,$Coastal_Region,$Owner,$Build1,$Build2,$Culture_Cost,$Economic_Cost,$Military_Cost,$Description,$Culture_Modifier,$Economic_Enviroment_Modifier,$Military_Enviroment_Modifier,$MilCap,$Defensive_Strength,$Build_Cost)
    {
        $this->Province_ID = $Province_ID;
        $this->Capital = $Capital;
        $this->Region = $Region;
		$this->Vertex1 = $Vert1;
		$this->Vertex2 = $Vert2;
		$this->Vertex3 = $Vert3;
        $this->Climate = $Climate;
        $this->City_Population_Total = $City_Population_Total;
        $this->National_HDI = $National_HDI;
        $this->National_Nominal_GDP_per_capita = $National_Nominal_GDP_per_capita;
		$this->Coastal = $Coastal;
		$this->Coastal_Region = $Coastal_Region;
		$this->Owner = $Owner;
		$this->Build1 = $Build1;
		$this->Build2 = $Build2;
		$this->Base_Culture_Cost = $Culture_Cost;
		$this->Base_Economic_Cost = $Economic_Cost;
		$this->Base_Military_Cost = $Military_Cost;
		$this->Description = $Description;
		$this->Culture_Modifier = $Culture_Modifier;
		$this->Economic_Enviroment_Modifier = $Economic_Enviroment_Modifier;
		$this->Military_Enviroment_Modifier = $Military_Enviroment_Modifier;
		$this->MilCap = $MilCap;
		$this->Defensive_Strength = $Defensive_Strength;
		$this->Build_Cost = $Build_Cost;
	}
}

class ProvinceViewMode //Values to be rendered. Player dependent.
{
	public $Province_ID;
	public $Capital;
	public $Region;
	public $Vertex1;
	public $Vertex2;
	public $Vertex3;
	public $Climate;
	public $City_Population_Total;
	public $National_HDI;
	public $National_Nominal_GDP_per_capita;
	public $Coastal;
	public $Coastal_Region;
	public $Base_Culture_Cost;
	public $Base_Economic_Cost;
	public $Base_Military_Cost;
	public $Description;
	public $Culture_Modifier;
	public $Economic_Enviroment_Modifier;
	public $Military_Enviroment_Modifier;
	public $Colour;
	public $Visible;
	public $Owner;
	
    public function __construct($Province_ID, $Capital, $Region,$Vert1,$Vert2,$Vert3, $Climate, $City_Population_Total,$National_HDI,$National_Nominal_GDP_per_capita,$Coastal,$Coastal_Region,$Culture_Cost,$Economic_Cost,$Military_Cost,$Description,$Culture_Modifier,$Economic_Enviroment_Modifier,$Military_Enviroment_Modifier,$Colour,$Visible,$Owner)
    {
        $this->Province_ID = $Province_ID;
        $this->Capital = $Capital;
        $this->Region = $Region;
		$this->Vertex1 = $Vert1;
		$this->Vertex2 = $Vert2;
		$this->Vertex3 = $Vert3;
        $this->Climate = $Climate;
        $this->City_Population_Total = $City_Population_Total;
        $this->National_HDI = $National_HDI;
        $this->National_Nominal_GDP_per_capita = $National_Nominal_GDP_per_capita;
		$this->Coastal = $Coastal;
		$this->Coastal_Region = $Coastal_Region;
		$this->Base_Culture_Cost = $Culture_Cost;
		$this->Base_Economic_Cost = $Economic_Cost;
		$this->Base_Military_Cost = $Military_Cost;
		$this->Description = $Description;
		$this->Culture_Modifier = $Culture_Modifier;
		$this->Economic_Enviroment_Modifier = $Economic_Enviroment_Modifier;
		$this->Military_Enviroment_Modifier = $Military_Enviroment_Modifier;
		$this->Colour = $Colour;
		$this->Visible = $Visible;
		$this->Owner = $Owner;
	}
}


class PlayerDetail
{
	public $Country_Name;
	public $Title;
	public $Country_Type;
	public $Colour;
	public $World_Code;
	public $Mil_Cap;
	public $Military_Influence;
	public $Military_Generation;
	public $Culture_Influence;
	public $Culture_Generation;
	public $Economic_Influence;
	public $Economic_Generation;
	public $Events_Stacked;
	public $Last_Event_Time;
	public $Active_Event_ID;
	public $Ocean_Powers;
	public $OwnedProvinces;
	
    public function __construct($Country_Name,$Title,$Country_Type,$Colour,$World_Code,$Mil_Cap,$Military_Influence,$Military_Generation,$Culture_Influence,$Culture_Generation,$Economic_Influence,$Economic_Generation,$Events_Stacked,$Last_Event_Time,$Active_Event_ID,$OceanPowers,$Provinces)
    {
		$this->Country_Name = $Country_Name;
		$this->Title = $Title;
		$this->Country_Type = $Country_Type;
		$this->Colour = $Colour;
		$this->World_Code = $World_Code;
		$this->Mil_Cap = $Mil_Cap;
		$this->Military_Influence = $Military_Influence;
		$this->Military_Generation = $Military_Generation;
		$this->Culture_Influence = $Culture_Influence;
		$this->Culture_Generation = $Culture_Generation;
		$this->Economic_Influence = $Economic_Influence;
		$this->Economic_Generation = $Economic_Generation;
		$this->Events_Stacked = $Events_Stacked;
		$this->Last_Event_Time = $Last_Event_Time;
		$this->Active_Event_ID = $Active_Event_ID;
		$this->Ocean_Powers = $OceanPowers;
		$this->OwnedProvinces = $Provinces;
	}
}

class WorldDetail
{
	public $World_Code;
	public $World_Name;
	public $MapType;
	public $EventSpeed;
	public $SlotsLeft;
	public $Players;
	
    public function __construct($World_Code,$World_Name,$MapType,$Speed,$Capacity,$Players)
    {
		$this->World_Code = $World_Code;
		$this->World_Name = $World_Name;
		$this->MapType = $MapType;
		$this->EventSpeed = $Speed;
		$this->SlotsLeft = $Capacity;
		$this->Players = $Players;
	}
}

class BuildDetail
{
	public $BuildingID;
	public $Building_Name;
	public $Bonus_Mil_Cap;
	public $Bonus_Def_Strength;
	public $Bonus_Build_Cost;
	public $Base_Cost;
	
    public function __construct($BuildingID,$Building_Name,$Bonus_Mil_Cap,$Bonus_Def_Strength,$Bonus_Build_Cost,$Base_Cost)
    {
		$this->BuildingID = $BuildingID;
		$this->Building_Name = $Building_Name;
		$this->Bonus_Mil_Cap = $Bonus_Mil_Cap;
		$this->Bonus_Def_Strength = $Bonus_Def_Strength;
		$this->Bonus_Build_Cost = $Bonus_Build_Cost;
		$this->Base_Cost = $Base_Cost;
	}
}

class GovDetail
{
	public $GovernmentForm;
	public $Title;
	public $Base_Military_Generation;
	public $Base_Culture_Generation;
	public $Base_Economic_Generation;
	public $Base_Military_Influence;
	public $Base_Culture_Influence;
	public $Base_Economic_Influence;
	
    public function __construct($GovernmentForm,$Title,$Base_Military_Generation,$Base_Culture_Generation,$Base_Economic_Generation,$Base_Military_Influence,$Base_Culture_Influence,$Base_Economic_Influence)
    {
		$this->GovernmentForm = $GovernmentForm;
		$this->Title = $Title;
		$this->Base_Military_Generation = $Base_Military_Generation;
		$this->Base_Culture_Generation = $Base_Culture_Generation;
		$this->Base_Economic_Generation = $Base_Economic_Generation;
		$this->Base_Military_Influence = $Base_Military_Influence;
		$this->Base_Culture_Influence = $Base_Culture_Influence;
		$this->Base_Economic_Influence = $Base_Economic_Influence;
	}
}

class CoastDetail
{
	public $Coastal_Region;
	public $Colonial_Penalty;
	public $Minimum_Colony_provinces;
	public $Short_Range_Penalty;
	public $Colonial_Title;
	public $Outbound_Connection_1;
	public $Outbound_Connection_2;
	public $Outbound_Connection_3;
	public $Outbound_Connection_4;
	public $Outbound_Connection_5;
	
    public function __construct($Coastal_Region,$Colonial_Penalty,$Minimum_Colony_provinces,$Short_Range_Penalty,$Colonial_Title,$Outbound_Connection_1,$Outbound_Connection_2,$Outbound_Connection_3,$Outbound_Connection_4,$Outbound_Connection_5)
    {
		$this->Coastal_Region = $Coastal_Region;
		$this->Colonial_Penalty = $Colonial_Penalty;
		$this->Minimum_Colony_provinces = $Minimum_Colony_provinces;
		$this->Short_Range_Penalty = $Short_Range_Penalty;
		$this->Colonial_Title = $Colonial_Title;
		$this->Outbound_Connection_1 = $Outbound_Connection_1;
		$this->Outbound_Connection_2 = $Outbound_Connection_2;
		$this->Outbound_Connection_3 = $Outbound_Connection_3;
		$this->Outbound_Connection_4 = $Outbound_Connection_4;
		$this->Outbound_Connection_5 = $Outbound_Connection_5;
	}
}

class ProvinceCost
{
	public $Province_ID;
	public $Player_ID;
	public $Province_Owner_ID;
	public $Culture_Desc;
	public $Culture_Cost;
	public $Culture_Possible;
	public $Economic_Desc;
	public $Economic_Cost;
	public $Economic_Possible;
	public $Military_Desc;
	public $Military_Cost;
	public $Military_Possible;
	
	public function __construct($provID,$playerID,$ProvOwn,$cDesc,$cCost,$cPos,$eDesc,$eCost,$ePos,$mDesc,$mCost,$mPos)
	{
		$this->Province_ID = $provID;
		$this->Player_ID = $playerID;
		$this->Province_Owner_ID = $ProvOwn;
		$this->Culture_Desc = $cDesc;
		$this->Culture_Cost = $cCost;
		$this->Culture_Possible = $cPos;
		$this->Economic_Desc = $eDesc;
		$this->Economic_Cost = $eCost;
		$this->Economic_Possible = $ePos;
		$this->Military_Desc = $mDesc;
		$this->Military_Cost = $mCost;
		$this->Military_Possible = $mPos;
	}
}

class EventDetail
{
	public $Event_ID;
	public $Event_Title;
	public $Event_Description;
	public $Option1ID;
	public $Option1Desc;
	public $Option2ID;
	public $Option2Desc;
	public $Option3ID;
	public $Option3Desc;
	
	public function __construct($eventID,$title,$desc,$op1,$op1D,$op2,$op2D,$op3,$op3D)
	{
		$this->Event_ID = $eventID;
		$this->Event_Title = $title;
		$this->Event_Description = $desc;
		$this->Option1ID = $op1;
		$this->Option1Desc = $op1D;
		$this->Option2ID = $op2;
		$this->Option2Desc = $op2D;
		$this->Option3ID = $op3;
		$this->Option3Desc = $op3D;
	}
}

class EventResults
{
	public $Event_ID;
	public $Event_Title;
	public $Option_ID;
	public $Option_Desc;
	public $Military_Gen_Modifier;
	public $Economic_Gen_Modifier;
	public $Culture_Gen_Modifier;
	public $Added_Military_Influence;
	public $Added_Economic_Influence;
	public $Added_Culture_Influence;
	
	public function __construct($eventID,$eventTitle,$optionID,$optionDesc,$milGenMod,$ecoGenMod,$cultGenMod,$addMil,$addEco,$addCult)
	{
		$this->Event_ID = $eventID;
		$this->Event_Title = $eventTitle;
		$this->Option_ID = $optionID;
		$this->Option_Desc = $optionDesc;
		$this->Military_Gen_Modifier = $milGenMod;
		$this->Economic_Gen_Modifier = $ecoGenMod;
		$this->Culture_Gen_Modifier = $cultGenMod;
		$this->Added_Military_Influence = $addMil;
		$this->Added_Economic_Influence = $addEco;
		$this->Added_Culture_Influence = $addCult;
	}
}
?>

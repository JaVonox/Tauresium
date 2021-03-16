<?php
class ProvinceLowDetail
{
	public $_Province_ID;
	public $_Capital;
	public $_Region;
	public $_Vertex1;
	public $_Vertex2;
	public $_Vertex3;
	public $_Climate;
	public $_City_Population_Total;
	public $_National_HDI;
	public $_National_Nominal_GDP_per_capita;
	public $_Coastal;
	public $_Coastal_Region;

    public function __construct($Province_ID, $Capital, $Region,$Vert1,$Vert2,$Vert3, $Climate, $City_Population_Total,$National_HDI,$National_Nominal_GDP_per_capita,$Coastal,$Coastal_Region)
    {
        $this->_Province_ID = $Province_ID;
        $this->_Capital = $Capital;
        $this->_Region = $Region;
		$this->_Vertex1 = $Vert1;
		$this->_Vertex2 = $Vert2;
		$this->_Vertex3 = $Vert3;
        $this->_Climate = $Climate;
        $this->_City_Population_Total = $City_Population_Total;
        $this->_National_HDI = $National_HDI;
        $this->_National_Nominal_GDP_per_capita = $National_Nominal_GDP_per_capita;
		$this->_Coastal = $Coastal;
		$this->_Coastal_Region = $Coastal_Region;
	}
}

class ProvinceHighDetail
{
	public $_Province_ID;
	public $_Capital;
	public $_Region;
	public $_Vertex1;
	public $_Vertex2;
	public $_Vertex3;
	public $_Climate;
	public $_City_Population_Total;
	public $_National_HDI;
	public $_National_Nominal_GDP_per_capita;
	public $_Coastal;
	public $_Coastal_Region;
	public $_Owner;
	public $_Build1;
	public $_Build2;

    public function __construct($Province_ID, $Capital, $Region,$Vert1,$Vert2,$Vert3, $Climate, $City_Population_Total,$National_HDI,$National_Nominal_GDP_per_capita,$Coastal,$Coastal_Region,$Owner,$Build1,$Build2)
    {
        $this->_Province_ID = $Province_ID;
        $this->_Capital = $Capital;
        $this->_Region = $Region;
		$this->_Vertex1 = $Vert1;
		$this->_Vertex2 = $Vert2;
		$this->_Vertex3 = $Vert3;
        $this->_Climate = $Climate;
        $this->_City_Population_Total = $City_Population_Total;
        $this->_National_HDI = $National_HDI;
        $this->_National_Nominal_GDP_per_capita = $National_Nominal_GDP_per_capita;
		$this->_Coastal = $Coastal;
		$this->_Coastal_Region = $Coastal_Region;
		$this->_Owner = $Owner;
		$this->_Build1 = $Build1;
		$this->_Build2 = $Build2;
	}
}

?>

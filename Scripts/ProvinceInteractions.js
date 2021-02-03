var selectedRegion = "Ocean" 
	
function _clickEvent(evt) 
{
	if (selectedRegion != "Ocean")
	{
		document.getElementById(selectedRegion).style.fill = "#FFE7AB";
	}
	
	if(event.srcElement.id == "")
	{
		selectedRegion = "Ocean";
		document.getElementById("SelectedRegionID").textContent = selectedRegion;
		document.getElementById("ProvinceImage").src = "Assets/OceanProvince.png";
	}
	else
	{
		selectedRegion = event.srcElement.id;
		document.getElementById(event.srcElement.id).style.fill = "#abc3ff";
		document.getElementById("SelectedRegionID").textContent = selectedRegion;
		document.getElementById("ProvinceImage").src = "Assets/Field.png";
	}
}
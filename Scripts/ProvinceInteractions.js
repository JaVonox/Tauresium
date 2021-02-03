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
		document.getElementById("MapBack").style.backgroundImage = "linear-gradient(to bottom, rgba(255, 255, 255, 0.70), rgba(255, 255, 255, 0.70)),url('Backgroundimages/OceanBackdrop.png')";
	}
	else
	{
		selectedRegion = event.srcElement.id;
		document.getElementById(event.srcElement.id).style.fill = "#abc3ff";
		document.getElementById("SelectedRegionID").textContent = selectedRegion;
		document.getElementById("ProvinceImage").src = "Assets/Field.png";
		document.getElementById("MapBack").style.backgroundImage = "linear-gradient(to bottom, rgba(255, 255, 255, 0.70), rgba(255, 255, 255, 0.70)),url('Backgroundimages/GrasslandBackdrop.png')";
	}
}
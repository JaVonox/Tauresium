function BIGetProvViaID(provID)
{
	//Gets the info for a province for the province page
    return $.ajax({
        url: 'TaurAPI/Province/' + provID,
        type: 'GET',
        cache: false,
        dataType: 'json'
	});
}

function BIGetAllProvs(ApiKey)
{
	//Gets the province map for the mainpage
    return $.ajax({
        url: 'TaurAPI/View/' + ApiKey,
        type: 'GET',
        cache: false,
        dataType: 'json'
	});
}

function BIGetAllProvsInfo()
{
	//Gets all the province info for the main page
    return $.ajax({
        url: 'TaurAPI/Province/',
        type: 'GET',
        cache: false,
        dataType: 'json'
	});
}

function BIGetPlayerStats(countryName)
{
	//Gets player info for session stats page
	  return $.ajax({
        url: 'TaurAPI/Country/' + countryName,
        type: 'GET',
        cache: false,
        dataType: 'json'
	});
}

function BIGetWorldStats(worldName)
{
	//Gets world info for session stats page
	  return $.ajax({
        url: 'TaurAPI/World/' + worldName,
        type: 'GET',
        cache: false,
        dataType: 'json'
	});
}

function BIGetProvCosts(provID,countryName)
{
	//Gets province costs
	  return $.ajax({
        url: 'TaurAPI/Cost/' + countryName + "/" + provID,
        type: 'GET',
        cache: false,
        dataType: 'json'
	});
}

function BIGetPlayerEvent(ApiKey)
{
	//Gets province costs
	  return $.ajax({
        url: 'TaurAPI/Event/' + ApiKey,
        type: 'GET',
        cache: false,
        dataType: 'json'
	});
}

function BIPostBuild(provID,apiKey,buildType)
{
	//Sends the build request
	  return $.ajax({
        url: 'TaurAPI/Building/' + provID + "/" + apiKey + "/" + buildType,
        type: 'POST',
        cache: false,
        dataType: 'json'
	});
}

function BIPutEvent(ApiKey)
{
	//Gets province costs
	  return $.ajax({
		url: 'TaurAPI/Event/' + ApiKey,
        type: 'PUT',
        cache: false,
        dataType: 'json'
	});
}
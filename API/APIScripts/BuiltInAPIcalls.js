﻿function BIGetProvViaID(provID)
{
	//Gets the info for a province for the province page
    return $.ajax({
        url: 'TaurAPI/Province/' + provID,
        type: 'GET',
        cache: false,
        dataType: 'json'
	});
}

function BIGetAllProvs()
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
	//Gets world info for session stats page
	  return $.ajax({
        url: 'TaurAPI/Cost/' + countryName + "/" + provID,
        type: 'GET',
        cache: false,
        dataType: 'json'
	});
}
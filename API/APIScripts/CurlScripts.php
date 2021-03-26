<?php
//Currently unused.

//Usage example:
//$curlResponse = json_decode(CurlCustGETRequest("Province/" . $selectedProvince)); 
//echo $curlResponse->_Province_ID;
function CurlCustGETRequest($parameters) //uses curl to submit a custom request based on passed parameters
{

	$curl = curl_init();

	curl_setopt_array($curl, [
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => $_SERVER['SERVER_NAME'] . '/Tauresium/TaurAPI/' . $parameters
	]);
	
	$curlOutput = curl_exec($curl);
	curl_close($curl);
	
	return $curlOutput;
}
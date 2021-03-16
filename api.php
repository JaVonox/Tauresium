<?php
	require "API/TauresiumRestHandler.php";

	// All requests to the web service are routed through this script.
	// See the explanation in RestService.php for how the requests are 
	// mapped. 

	$service = new TauresiumRestService();
	$service->handleRawRequest();
?>

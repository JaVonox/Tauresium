<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta name="author" content="100505349">
<link rel="stylesheet" href="MainStyle.css">
<style>
polygon{
		fill:#FFE7AB;stroke:black;stroke-width:1;
}
</style>

<title>
Tauresium - Game Page
</title>
</head>
<body style="background-color:white;margin:0px;">

<?php include_once 'PageElements/TopBar.php';?>
<?php include_once "Scripts/DBLoader.php";?>
<?php
$database = new Database();
$db = $database->getConnection();
$provinceSet = json_encode($database->getProvinceArray());
?>

<div id="MenuBar" style="background-color:#E4E4E4;width:100%;height:40px;border-bottom:4px solid black;"> 
	<button style="float:right;margin-right:20px;" class="menuButton" onclick="document.location='index.php'">Logout</button>
	<button style="margin-left:20px;" class="menuButton" onclick="document.location='Main.php'">The World</button>
	<button class="menuButton">My Country</button>
	<button class="menuButton">Events</button>
</div>

<div id="MapBack" style="background-color:lightgrey;min-height:600px;overflow:auto;background-color:white;background-image:linear-gradient(to bottom, rgba(255, 255, 255, 0.70), rgba(255, 255, 255, 0.70)),url('Backgroundimages/Ocean.png');background-repeat: no-repeat;background-position:center;background-size:120%;position:relative;">
	<table style="width:100%;height:100%;table-layout:fixed;overflow:auto;">
	<tr>
	<td style="width:400px;;background-color:lightgrey;text-align:center;margin-left:auto;margin-right:auto;border: 5px solid grey;border-radius:15px;vertical-align:top;position:relative;left:30px;">
	<h1 id="ProvCapital" style="font-family: Romanus;font-size:32px;"> Ocean </h2>
	<i id="ProvRegion" style="font-family: Romanus;font-size:20px;">Ocean</i>
	<br>
	<img id="ProvinceImage" src="Assets/Ocean.png" style="border: solid 5px black;margin-left:auto;margin-right:auto;">
	<br>
	<font id="ProvClimate">Marine</font>
	<br><br>
	<font id="ProvPopulation">City Population: Zero</font>
	<br>
	<font id="ProvHDI">HDI: Zero</font>
	<br>
	<font id="ProvGDP">Nominal GDP per Capita: Zero</font>
	<br><br>
	<button id="ProvExamine" style="visibility:hidden;background-color:#4CAF50;color: white;text-align: center;display: inline-block;font-size: 16px;margin: 4px 2px;cursor: pointer;width:200px;height:30px;border:none;font-family:'Helvetica';float:center;" onclick="document.location='Main.php'">View/Annex Province</button>
	</td>
	<td style="width:100%;height:100%;"> 
		<svg class="Provinces" onclick="_clickEvent()" style="background-color:#E6BF83;width:950px;height:562px;display:block;margin:auto;border:5px solid #966F33;">
		
			<!-- Plotted by 100505349 (Assignment requires anonymous marking). Regions included in this document are not to be taken as real borders, they are simply triangles
			named after major constituents within the region --->
			
			<polygon id="Alaska_BristolBay" points="5,100 31,68 43,87"/>
			<polygon id="Alaska_Calista" points="31,68 56,67 52,50"/>
			<polygon id="Alaska_WestDoyon" points="43,87 31,68 56,67"/>
			<polygon id="Alaska_Chugach" points="43,87 74,89 56,67"/>
			<polygon id="Alaska_ArticSlope" points="76,44 52,50 56,67"/>
			<polygon id="Alaska_Doyon" points="56,67 77,44 74,89"/>

			<polygon id="Canada_Yukon" points="74,89 77,44 98,91"/>
			<polygon id="Canada_NorthWestTerritoriesWest" points="77,44 98,91 121,50"/>
			<polygon id="Canada_NorthWestTerritoriesCenter" points="151,91 98,91 121,50"/>
			<polygon id="Canada_NunavutWest" points="121,50 161,55 151,91"/>
			<polygon id="Canada_Nunavut" points="221,57 161,55 151,91"/>
			<polygon id="Canada_BritishColumbiaWest" points="76,130 74,89 98,91"/>
			<polygon id="Canada_BritishColumbiaEast" points="76,130 113,129 98,91"/>
			<polygon id="Canada_Alberta" points="151,91 113,129 98,91"/>
			<polygon id="Canada_Saskatchewan" points="151,91 113,129 132,128"/> 
			<polygon id="Canada_ManitobaNorth" points="132,128 151,91 186,75"/>
			<polygon id="Canada_ManitobaSouth" points="132,128 183,125 186,75"/>
			<polygon id="Canada_ManitobaEast" points="202,101 183,125 186,75"/>
			<polygon id="Canada_OntarioWest" points="202,101 183,125 198,124"/>
			<polygon id="Canada_OntarioEast" points="202,101 234,130 198,124"/>
			<polygon id="Canada_QuebecSouthWest" points="202,101 234,130 233,104"/>
			<polygon id="Canada_QuebecNorthWest" points="202,101 232,73 233,104"/>
			<polygon id="Canada_QuebecNorthEast" points="265,105 232,73 233,104"/>
			<polygon id="Canada_NewBrunswick" points="234,130 249,120 233,104"/>
			<polygon id="Canada_NoviaScotiaNorth" points="265,105 249,120 233,104"/>
			<polygon id="Canada_NoviaScotiaSouth" points="265,105 249,120 261,131"/>
			
			<polygon id="America_PacificNorthwest" points="76,130 113,129 60,157"/>
			<polygon id="America_RockiesWest" points="100,157 113,129 60,157"/>
			<polygon id="America_Rockies" points="100,157 113,129 128,175"/>
			<polygon id="America_WestSouthwest" points="60,157 100,157 77,192"/>
			<polygon id="America_EastSouthwest" points="128,175 100,157 77,192"/>
			<polygon id="America_California" points="60,157 65,192 77,192"/>
			<polygon id="America_WestMidwest" points="113,129 128,175 147,145"/>
			<polygon id="America_NorthWestMidwest" points="113,129 132,128 147,145"/>
			<polygon id="America_NorthMidwest" points="183,125 132,128 147,145"/>
			<polygon id="America_EastNorthMidwest" points="183,125 180,143 147,145"/>
			<polygon id="America_SouthNorthMidwest" points="128,175 147,145 180,143"/>
			<polygon id="America_TexasRegion" points="128,175 77,192 124,204"/>
			<polygon id="America_WestMidatlantic" points="183,125 180,143 198,124"/>		
			<polygon id="America_EastNorthMidatlantic" points="234,130 180,143 198,124"/>		
			<polygon id="America_EastSouthMidatlantic" points="234,130 180,143 231,144"/>	
			<polygon id="America_SouthCoast" points="128,175 161,198 124,204"/>
			<polygon id="America_Florida" points="167,216 161,198 173,188"/>
			<polygon id="America_EastInterior" points="128,175 161,198 180,143"/>
			<polygon id="America_SouthEastInterior" points="173,188 161,198 180,143"/>
			<polygon id="America_NorthEastCoast" points="198,164 231,144 180,143"/>
			<polygon id="America_SouthEastCoast" points="198,164 173,188 180,143"/>
			
			<polygon id="Mexico_BajaCalifornia" points="79,225 65,192 77,192"/>
			<polygon id="Mexico_NorthernMexico" points="77,192 124,204 104,223"/>
			<polygon id="Mexico_EastNorthernMexico" points="77,192 100,245 104,223"/>
			<polygon id="Mexico_WestNorthernMexico" points="122,243 124,204 104,223"/>
			<polygon id="Mexico_Bajio" points="100,245 122,243 104,223"/>
			<polygon id="Mexico_PacificCoast" points="100,245 122,243 133,262"/>
			<polygon id="Mexico_Yucatan" points="145,230 122,243 133,262"/>
			<polygon id="Mexico_Chiapas" points="139,248 155,255 133,262"/>
			
			<polygon id="CentralAmerica_CentralAmerica" points="155,255 161,283 133,262"/>
			<polygon id="CentralAmerica_Panama" points="176,276 161,283 171,290"/>
			<polygon id="CemtralAmerica_Cuba" points="157,225 181,238 185,234"/>
			<polygon id="CemtralAmerica_Dominican" points="190,245 193,236 201,244"/>
			
			<polygon id="SouthAmerica_NorthColumbia" points="176,276 195,296 171,290"/>
			<polygon id="SouthAmerica_SouthColumbia" points="167,305 195,296 171,290"/>
			<polygon id="SouthAmerica_NorthVenezuela" points="176,276 190,266 208,276"/>
			<polygon id="SouthAmerica_SouthVenezuela" points="176,276 195,296 208,276"/>
			<polygon id="SouthAmerica_EastVenezuela" points="228,284 195,296 208,276"/>
			<polygon id="SouthAmerica_Guiana" points="228,284 195,296 250,299"/>
			<polygon id="SouthAmerica_Amazonas" points="204,325 195,296 250,299"/>
			<polygon id="SouthAmerica_Ecuador" points="167,305 195,296 160,329"/>
			<polygon id="SouthAmerica_NorthPeru" points="204,325 195,296 160,329"/>
			<polygon id="SouthAmerica_CentralPeru" points="204,325 185,378 160,329"/>
			<polygon id="SouthAmerica_SouthPeru" points="204,325 185,378 208,374"/>
			<polygon id="SouthAmerica_Bolivia" points="236,355 235,397 208,374"/>
			<polygon id="SouthAmerica_WestBrazil" points="236,355 204,325 208,374"/>
			<polygon id="SouthAmerica_NorthBrazil" points="250,299 204,325 289,311"/>
			<polygon id="SouthAmerica_WestCentralBrazil" points="236,355 204,325 289,311"/>
			<polygon id="SouthAmerica_CentralBrazil" points="236,355 299,365 289,311"/>
			<polygon id="SouthAmerica_EastCentralBrazil" points="306,342 299,365 289,311"/>
			<polygon id="SouthAmerica_SouthCentralBrazil" points="236,355 299,365 256,376"/>
			<polygon id="SouthAmerica_SouthBrazil" points="280,403 299,365 256,376"/>
			<polygon id="SouthAmerica_Paraguay" points="236,355 235,397 256,376"/>
			<polygon id="SouthAmerica_SouthParaguay" points="235,397 280,403 256,376"/>
			<polygon id="SouthAmerica_Uruguay" points="280,403 235,397 262,420"/>
			<polygon id="SouthAmerica_Andean" points="200,446 235,397 197,408"/>
			<polygon id="SouthAmerica_NorthChile" points="185,378 208,374 197,408"/>
			<polygon id="SouthAmerica_NorthArgentina" points="235,397 208,374 197,408"/>
			<polygon id="SouthAmerica_NorthCentralArgentina" points="200,446 262,420 235,397"/>
			<polygon id="SouthAmerica_SouthCentralArgentina" points="200,446 262,420 247,460"/>
			<polygon id="SouthAmerica_SouthArgentina" points="200,446 220,486 247,460"/>
			<polygon id="SouthAmerica_SouthChile" points="200,446 220,486 214,511"/>
			<polygon id="SouthAmerica_Chubut" points="247,460 220,486 232,510"/>
			<polygon id="SouthAmerica_SantaCruz" points="214,511 232,510 220,486"/>
			<polygon id="SouthAmerica_Magallanes" points="214,511 232,510 238,528"/>
			
			<polygon id="Greenland_Kujalleq" points="305,83 299,50 330,59"/>
			<polygon id="Greenland_Qeqqata" points="305,83 299,50 289,68"/>
			<polygon id="Greenland_SouthSermersooq" points="331,23 299,50 330,59"/>
			<polygon id="Greenland_Sermersooq" points="331,23 379,27 330,59"/>
			<polygon id="Greenland_SouthQaasuitsup" points="331,23 299,50 281,26"/>
			<polygon id="Greenland_NorthQaasuitsup" points="331,23 331,7 281,26"/>
			<polygon id="Greenland_NorthEastGreenland" points="331,23 331,7 379,26"/>
			<polygon id="Greenland_Iceland" points="359,62 371,72 379,61"/>
			
			<polygon id="Britain_IrelandNorth" points="395,101 385,104 394,110"/>
			<polygon id="Britain_IrelandSouth" points="385,114 385,104 394,110"/>
			<polygon id="Britain_Scotland" points="396,95 401,88 406,97"/>
			<polygon id="Britain_Northumberland" points="396,95 406,97 404,106"/>
			<polygon id="Britain_Yorkshire" points="411,106 406,97 404,106"/>
			<polygon id="Britain_SouthEnglandAndWales" points="411,106 397,114 404,106"/>
			
			<polygon id="Europe_FranceBritanny" points="397,125 409,122 406,132"/>
			<polygon id="Europe_FrancePaysDeLaLoire" points="422,132 409,122 406,132"/>
			<polygon id="Europe_FranceNormandy" points="422,132 409,122 421,114"/>
			<polygon id="Europe_FranceAquitane" points="422,132 406,132 407,145"/>
			<polygon id="Europe_FranceOccitanie" points="422,132 425,146 407,145"/>
			<polygon id="Europe_FranceAlpes" points="422,132 425,146 435,141"/>
			<polygon id="Europe_FranceStrasbourg" points="422,132 434,128 421,114"/>
			<polygon id="Europe_Switzerland" points="422,132 434,128 435,141"/>
			<polygon id="Europe_DutchRegions" points="421,114 434,128 432,105"/>
			<polygon id="Europe_ItalyMilan" points="445,139 434,128 435,141"/>
			<polygon id="Europe_ItalyTuscany" points="445,139 444,152 435,141"/>
			<polygon id="Europe_ItalyNaples" points="445,139 444,152 456,158"/>
			<polygon id="Europe_ItalySicily" points="443,166 452,172 456,158"/>
			<polygon id="Europe_SpainCatalonia" points="407,145 425,146 408,161"/>
			<polygon id="Europe_SpainValencia" points="401,172 408,161 397,162"/>
			<polygon id="Europe_SpainLaMancha" points="408,161 394,153 397,162"/>
			<polygon id="Europe_SpainBurgos" points="407,145 394,153 408,161"/>
			<polygon id="Europe_SpainLeon" points="407,145 394,153 394,145"/>
			<polygon id="Europe_SpainGalicia" points="384,145 394,153 394,145"/>
			<polygon id="Europe_SpainExtremadura" points="384,165 394,153 397,162"/>
			<polygon id="Europe_SpainNorthAndalusia" points="397,162 384,165 401,172"/>
			<polygon id="Europe_SpainSouthAndalusia" points="389,173 384,165 401,172"/>
			<polygon id="Europe_Portugal" points="384,165 394,153 385,145"/>
			<polygon id="Europe_GermanyBavaria" points="434,128 445,139 449,118"/>
			<polygon id="Europe_GermanySaxony" points="434,128 432,105 449,118"/>
			<polygon id="Europe_GermanyBrandenberg" points="447,105 432,105 449,118"/>
			<polygon id="Europe_GermanySchleswig" points="447,105 432,100 432,105"/>
			<polygon id="Europe_GermanyPomerania" points="449,118 447,105 463,102"/>
			<polygon id="Europe_PolandSilesia" points="449,118 463,123 462,103"/>
			<polygon id="Europe_CzechRepublic" points="449,118 463,123 457,131"/>
			<polygon id="Europe_Austria" points="449,118 445,139 457,131"/>
			<polygon id="Europe_Croatia" points="457,145 445,139 457,131"/>
			<polygon id="Europe_Hungary" points="457,131 463,123 470,135"/>
			<polygon id="Europe_Bosnia" points="457,131 457,145 470,135"/>
			<polygon id="Europe_Albania" points="464,155 457,145 470,135"/>
			<polygon id="Europe_Serbia" points="470,135 477,144 464,155"/>
			<polygon id="Europe_Bulgaria" points="470,135 477,144 491,140"/>
			<polygon id="Europe_Romania" points="470,135 463,123 494,121"/>
			<polygon id="Europe_UkraineWest" points="470,135 494,121 491,140"/>
			<polygon id="Europe_UkraineCenter" points="505,136 494,121 491,140"/>
			<polygon id="Europe_UkraineEast" points="505,136 494,121 518,121"/>
			<polygon id="Europe_GreeceMacedonia" points="485,155 477,144 464,155"/>
			<polygon id="Europe_GreecePeloponnese" points="485,155 464,155 472,171"/>
			<polygon id="Europe_BelarusSouth" points="463,123 462,103 494,121"/>
			<polygon id="Europe_BelarusNorth" points="478,101 462,103 494,121"/>
			<polygon id="Europe_BalticStates" points="478,101 462,103 470,89"/>
			
			<polygon id="Scandinavia_Denmark" points="435,92 432,100 436,100"/>
			<polygon id="Scandinavia_SwedenSkane" points="440,100 444,95 448,98"/>
			<polygon id="Scandinavia_SwedenSmaland" points="453,89 444,95 448,98"/>
			<polygon id="Scandinavia_SwedenUppland" points="453,89 453,79 459,84"/>
			<polygon id="Scandinavia_SwedenVastergotland" points="453,89 453,79 438,87"/>
			<polygon id="Scandinavia_SwedenHalland" points="453,89 444,95 438,87"/>
			<polygon id="Scandinavia_SwedenVarmland" points="438,87 453,79 441,73"/>
			<polygon id="Scandinavia_SwedenVasterbotten" points="462,64 453,79 441,73"/> <!-- I may have a bias towards this province. -->
			<polygon id="Scandinavia_SwedenLappland" points="462,64 453,53 441,73"/> 
			<polygon id="Scandinavia_NorwayNordland" points="429,73 453,53 441,73"/> 
			<polygon id="Scandinavia_NorwayTrondelag" points="429,73 432,80 441,73"/> 
			<polygon id="Scandinavia_NorwayNorthWestern" points="429,73 432,80 422,82"/> 
			<polygon id="Scandinavia_NorwaySouthWestern" points="429,89 432,80 422,82"/> 
			<polygon id="Scandinavia_NorwayNorthEastern" points="438,87 432,80 441,73"/> 
			<polygon id="Scandinavia_NorwaySouthEastern" points="438,87 432,80 429,89"/> 
			<polygon id="Scandinavia_NorwayFinnmark" points="453,53 462,64 473,45"/> 
			<polygon id="Scandinavia_FinlandFinnishLapland" points="477,65 462,64 473,45"/> 
			<polygon id="Scandinavia_FinlandNorthOstrobothnia" points="477,65 464,72 477,77"/> 
			<polygon id="Scandinavia_FinlandSouthOstrobothnia" points="465,81 464,72 477,77"/> 
			<polygon id="Scandinavia_FinlandSatakunta" points="465,81 470,89 477,77"/> 
			
			<!--- It pains me to write this part because historically anatolia was culturally european, and it makes no sense to reclassify it as middle eastern
			after the rise of islamic conquerers like the ottomans. Turkey absolutely should be classified as a european nation --->
			<polygon id="MiddleEast_TurkeyAnatoliaEast" points="525,157 503,154 512,174"/>
			<polygon id="MiddleEast_TurkeyAnatoliaCentral" points="512,174 503,154 493,173"/>
			<polygon id="MiddleEast_TurkeyMarmara" points="485,155 503,154 493,173"/>
			<polygon id="MiddleEast_TurkeyAegean" points="485,155 484,167 493,173"/>
			<polygon id="MiddleEast_TurkeyIstanbul" points="485,155 477,144 491,140"/>
			
			<polygon id="MiddleEast_Georgia" points="514,140 519,132 525,149"/>
			<polygon id="MiddleEast_AzerbaijanNorth" points="525,149 544,136 519,132"/>
			<polygon id="MiddleEast_AzerbaijanCentral" points="525,149 544,136 548,152"/>
			<polygon id="MiddleEast_AzerbaijanSouth" points="549,167 548,152 539,172"/>
			<polygon id="MiddleEast_ArmeniaNorth" points="525,149 525,157 548,152"/>
			<polygon id="MiddleEast_ArmeniaSouth" points="539,172 548,152 525,157"/>
			<polygon id="MiddleEast_IranKhorasan" points="588,202 579,201 579,181"/>
			<polygon id="MiddleEast_IranBaluchistan" points="588,202 579,201 581,216"/>
			<polygon id="MiddleEast_IranGulf" points="553,197 579,201 581,216"/>
			<polygon id="MiddleEast_IranSouthCentral" points="553,197 579,201 579,181"/>
			<polygon id="MiddleEast_IranNorthCentral" points="553,197 555,178 579,181"/>
			<polygon id="MiddleEast_IranSemnan" points="562,173 555,178 579,181"/>
			<polygon id="MiddleEast_IranCaspian" points="549,167 555,178 562,173"/>
			<polygon id="MiddleEast_IranAzerbaijan" points="549,167 555,178 539,172"/>
			<polygon id="MiddleEast_IranKurdistan" points="553,197 555,178 539,172"/>
			<polygon id="MiddleEast_SyriaNorth" points="525,157 539,172 512,174"/>
			<polygon id="MiddleEast_SyriaSouth" points="510,186 539,172 512,174"/>
			<polygon id="MiddleEast_IraqWest" points="510,186 539,172 533,192"/>
			<polygon id="MiddleEast_IraqEast" points="553,197 539,172 533,192"/>
			<polygon id="MiddleEast_IraqSouth" points="553,197 535,192 519,200"/>
			<polygon id="MiddleEast_Kuwait" points="553,197 553,207 519,200"/>
			<polygon id="MiddleEast_Jordan" points="510,186 533,192 519,200"/>
			<polygon id="MiddleEast_Jerusalem" points="510,186 510,201 519,200"/>
			<polygon id="MiddleEast_ArabiaMadinah" points="524,226 510,201 519,200"/>
			<polygon id="MiddleEast_ArabiaMakkah" points="551,247 529,239 536,233"/>
			<polygon id="MiddleEast_ArabiaMecca" points="524,226 529,239 536,233"/>
			<polygon id="MiddleEast_ArabiaAsir" points="538,256 529,239 551,247"/>
			<polygon id="MiddleEast_ArabiaTabuk" points="524,226 536,233 519,200"/>
			<polygon id="MiddleEast_ArabiaRiyadh" points="553,220 536,233 551,247"/>
			<polygon id="MiddleEast_ArabiaHayil" points="536,233 519,200 553,220"/>
			<polygon id="MiddleEast_ArabiaAlHodud" points="553,220 519,200 553,207"/>
			<polygon id="MiddleEast_ArabiaAsSharqiyahNorth" points="584,225 553,220 553,207"/>
			<polygon id="MiddleEast_ArabiaDesertEast" points="573,237 584,225 553,220"/>
			<polygon id="MiddleEast_ArabiaDesertWest" points="573,237 551,247 553,220"/>
			<polygon id="MiddleEast_OmanEast" points="584,225 582,241 573,237"/>
			<polygon id="MiddleEast_OmanNorth" points="551,247 582,241 573,237"/>
			<polygon id="MiddleEast_OmanSouth" points="551,247 582,241 558,258"/>
			<polygon id="MiddleEast_YemenNorth" points="551,247 538,256 558,258"/>
			<polygon id="MiddleEast_YemenSouth" points="543,265 538,256 558,258"/>
			
			<polygon id="Africa_EgyptSuez" points="510,201 499,203 498,191"/>
			<polygon id="Africa_EgyptRedSea" points="510,201 499,203 514,224"/>
			<polygon id="Africa_EgyptCairo" points="473,204 499,203 498,191"/>
			<polygon id="Africa_EgyptMatruh" points="473,204 476,187 498,191"/>
			<polygon id="Africa_EgyptNewValleyWest" points="476,224 499,203 473,204"/>
			<polygon id="Africa_EgyptNewValleyEast" points="476,224 499,203 514,224"/>
			<polygon id="Africa_LibyaDerna" points="476,187 473,204 464,188"/>
			<polygon id="Africa_LibyaEdjabia" points="440,204 473,204 464,188"/>
			<polygon id="Africa_LibyaSirt" points="440,204 439,182 464,188"/>
			<polygon id="Africa_LibyaAlkufra" points="476,224 473,204 440,204"/>
			<polygon id="Africa_Tunisia" points="423,171 439,182 438,169"/>
			<polygon id="Africa_AlgeriaAlgiers" points="423,171 439,182 405,175"/>
			<polygon id="Africa_AlgeriaTamanghasset" points="440,204 439,182 405,175"/>
			<polygon id="Africa_AlgeriaAdrar" points="440,204 406,192 405,175"/>
			<polygon id="Africa_AlgeriaBechar" points="379,191 406,192 405,175"/>
			<polygon id="Africa_Morocco" points="379,191 385,177 405,175"/>
			<polygon id="Africa_SaharaSouth" points="476,224 366,241 440,204"/>
			<polygon id="Africa_SaharaNorth" points="369,205 366,241 440,204"/>
			<polygon id="Africa_MauritaniaEast" points="369,205 406,192 440,204"/>
			<polygon id="Africa_MauritaniaWest" points="369,205 366,241 358,242"/>
			<polygon id="Africa_WestSaharaState" points="369,205 406,192 379,191"/>
			<polygon id="Africa_SudanPort" points="524,245 476,224 514,224"/>
			<polygon id="Africa_SudanKordofanNorth" points="524,245 476,224 480,252"/>
			<polygon id="Africa_SudanKordofanSouth" points="524,245 517,267 480,252"/>
			<polygon id="Africa_SouthSudan" points="508,279 517,267 480,252"/>
			<polygon id="Africa_Eritrea" points="524,245 517,267 539,271"/>
			<polygon id="Africa_EthiopiaAmhara" points="508,279 517,267 539,271"/>
			<polygon id="Africa_EthiopiaOromiya" points="508,279 539,296 539,271"/>
			<polygon id="Africa_EthiopiaSomali" points="560,282 539,296 539,271"/>
			<polygon id="Africa_Somalia" points="543,309 539,296 560,282"/>
			<polygon id="Africa_SomaliaHorn" points="561,266 539,271 560,282"/>
			<polygon id="Africa_KenyaEast" points="543,309 539,296 529,323"/>
			<polygon id="Africa_KenyaWest" points="508,279 539,296 529,323"/>
			<polygon id="Africa_TanzaniaSouth" points="527,356 498,343 529,323"/>
			<polygon id="Africa_TanzaniaNorth" points="501,311 498,343 529,323"/>
			<polygon id="Africa_Uganda" points="501,311 508,279 529,323"/>
			<polygon id="Africa_MozambiqueNorth" points="527,356 498,343 519,385"/>
			<polygon id="Africa_MozambiqueSouth" points="511,411 494,403 519,385"/>
			<polygon id="Africa_Zambia" points="486,371 498,343 519,385"/>
			<polygon id="Africa_Zimbabwe" points="486,371 494,403 519,385"/>
			<polygon id="Africa_SouthAfricaLimpopo" points="479,418 494,403 511,411"/>
			<polygon id="Africa_SouthAfricaKwazulu-Natal" points="479,418 486,446 511,411"/>
			<polygon id="Africa_SouthAfricaCape" points="479,418 486,446 462,450"/>
			<polygon id="Africa_SouthAfricaCapeWest" points="479,418 453,422 462,450"/>
			<polygon id="Africa_SouthAfricaNorth" points="479,418 494,403 446,391"/>
			<polygon id="Africa_Namibia" points="479,418 453,422 446,391"/>
			<polygon id="Africa_Angola" points="448,359 486,371 446,391"/>
			<polygon id="Africa_Botswana" points="494,403 486,371 446,391"/>
			<polygon id="Africa_DRCKatanga" points="448,359 486,371 498,343"/>
			<polygon id="Africa_DRCBandundu" points="448,359 435,317 498,343"/>
			<polygon id="Africa_DRCManiema" points="501,311 435,317 498,343"/>
			<polygon id="Africa_DRCEquateur" points="501,311 435,317 508,279"/>
			<polygon id="Africa_CentralAfricanRepublic" points="453,274 435,317 508,279"/>
			<polygon id="Africa_ChadSouth" points="453,274 480,252 508,279"/>
			<polygon id="Africa_ChadNorth" points="423,249 480,252 476,224"/>
			<polygon id="Africa_ChadWest" points="453,274 480,252 423,249"/>
			<polygon id="Africa_Nigeria" points="453,274 417,290 423,249"/>
			<polygon id="Africa_Cameroon" points="435,317 453,274 417,290"/>
			<polygon id="Africa_NigerEast" points="423,249 366,241 476,224"/>
			<polygon id="Africa_NigerWest" points="423,249 417,290 394,269"/>
			<polygon id="Africa_Ghana" points="394,294 417,290 394,269"/>
			<polygon id="Africa_IvoryCoastNorth" points="394,294 379,282 394,269"/>
			<polygon id="Africa_IvoryCoastSouth" points="394,294 379,282 383,298"/>
			<polygon id="Africa_Liberia" points="365,277 379,282 383,298"/>
			<polygon id="Africa_EastGuinea" points="365,277 379,282 394,269"/>
			<polygon id="Africa_WestGuinea" points="365,277 354,261 394,269"/>
			<polygon id="Africa_Senegal" points="358,242 354,261 366,241"/>
			<polygon id="Africa_MaliWest" points="394,269 354,261 366,241"/>
			<polygon id="Africa_MaliEast" points="394,269 423,249 366,241"/>
			
			<polygon id="Madagascar_Boeny" points="540,392 540,379 556,363"/>
			<polygon id="Madagascar_Sava" points="540,392 560,377 556,363"/>
			<polygon id="Madagascar_Androy" points="540,392 560,377 544,414"/>
			<polygon id="Madagascar_Menabe" points="540,392 536,407 544,414"/>
			
			<polygon id="Russia_KrasnodarKrai" points="505,136 519,132 518,121"/>
			<polygon id="Russia_Kola" points="473,45 477,65 492,51"/>
			<polygon id="Russia_Karelia" points="477,65 477,77 501,53"/>
			<polygon id="Russia_Leningrad" points="478,101 477,77 470,89"/>
			<polygon id="Russia_Novgorod" points="478,101 477,77 502,99"/>
			<polygon id="Russia_Arkhangelsk" points="502,99 477,77 501,53"/>
			<polygon id="Russia_Smolensk" points="478,101 494,121 502,99"/>
			<polygon id="Russia_Moscow" points="518,121 494,121 502,99"/>
			<polygon id="Russia_Krasnodar" points="519,132 518,121 544,136"/>
			<polygon id="Russia_Volgograd" points="563,131 518,121 544,136"/>
			<polygon id="Russia_Voronezh" points="502,99 529,98 518,121"/>
			<polygon id="Russia_Saratov" points="563,131 529,98 518,121"/>
			<polygon id="Russia_Komi" points="502,99 501,53 552,75"/>
			<polygon id="Russia_Nenetsia" points="548,51 501,53 552,75"/>
			<polygon id="Russia_Kirov" points="502,99 529,98 552,75"/>
			<polygon id="Russia_Perm" points="563,131 529,98 552,75"/>
			<polygon id="Russia_Aktau" points="563,131 586,134 555,144"/>
			<polygon id="Russia_Yugra" points="563,131 586,134 552,75"/>
			<polygon id="Russia_WestYamalia" points="599,33 548,51 552,75"/>
			<polygon id="Russia_Samara" points="586,134 592,83 552,75"/>
			<polygon id="Russia_EastYamalia" points="599,33 592,83 552,75"/>
			<polygon id="Russia_NorthKrasoyarsk" points="599,33 592,83 648,30"/>
			<polygon id="Russia_CentralKrasoyarsk" points="649,99 592,83 648,30"/>
			<polygon id="Russia_SouthKrasoyarsk" points="649,99 592,83 646,141"/>
			<polygon id="Russia_Irkustk" points="649,99 726,120 646,141"/>
			<polygon id="Russia_SouthSakha" points="649,99 726,120 648,30"/>
			<polygon id="Russia_NorthSakha" points="733,41 726,120 648,30"/>
			<polygon id="Russia_EastSakha" points="733,41 726,120 759,99"/>
			<polygon id="Russia_Khabarovsk" points="759,99 726,120 786,125"/>
			<polygon id="Russia_Magadan" points="733,41 791,86 759,99"/>
			<polygon id="Russia_Chukotka" points="733,41 791,86 851,62"/>
			<polygon id="Russia_Kamchatka" points="815,114 791,86 851,62"/>

			<polygon id="CentralAsia_Kazakhstan" points="586,134 592,83 646,141"/>
			<polygon id="CentralAsia_KazakhstanMangystau" points="586,134 567,157 555,144"/>
			<polygon id="CentralAsia_Mongolia" points="717,162 726,120 646,141"/>
			<polygon id="CentralAsia_SouthAfghanistan" points="588,202 608,183 579,181"/>
			<polygon id="CentralAsia_NorthAfghanistan" points="633,172 608,183 579,181"/>
			<polygon id="CentralAsia_Turkmenistan" points="567,157 562,173 579,181"/>
			<polygon id="CentralAsia_NorthTurkmenistan" points="567,157 596,158 579,181"/>
			<polygon id="CentralAsia_Uzbekistan" points="586,134 567,157 596,158"/>
			<polygon id="CentralAsia_Tajikistan" points="579,181 633,172 596,158"/>
			<polygon id="CentralAsia_Kyrgyzstan" points="586,134 646,141 596,158"/>
			
			<polygon id="China_Jilin" points="726,120 786,125 770,156"/>
			<polygon id="China_Liaoning" points="726,120 770,156 746,159"/>
			<polygon id="China_NorthInnerMongolia" points="726,120 717,162 746,159"/>
			<polygon id="China_Beijing" points="753,175 717,162 746,159"/>
			<polygon id="China_Shandong" points="753,175 717,162 732,189"/>
			<polygon id="China_Jiangsu" points="753,175 765,201 732,189"/>
			<polygon id="China_Zhejiang" points="762,211 765,201 732,189"/>
			<polygon id="China_Fujian" points="762,211 752,226 743,220"/>
			<polygon id="China_EastGuangdong" points="738,235 752,226 743,220"/>
			<polygon id="China_WestGuangdong" points="738,235 729,231 743,220"/>
			<polygon id="China_Jiangxi" points="741,209 762,211 743,220"/>
			<polygon id="China_Anhui" points="741,209 762,211 732,189"/>
			<polygon id="China_NorthHeinan" points="710,187 718,199 732,189"/>
			<polygon id="China_SouthHeinan" points="741,209 718,199 732,189"/>
			<polygon id="China_Hubei" points="741,209 718,199 720,218"/>
			<polygon id="China_Hunan" points="741,209 743,220 720,218"/>
			<polygon id="China_Heibei" points="717,162 732,189 710,187"/>
			<polygon id="China_EastGuangxi" points="729,231 743,220 720,218"/>
			<polygon id="China_WestGuangxi" points="729,231 698,232 720,218"/>
			<polygon id="China_Yunnan" points="698,232 673,206 674,229"/>
			<polygon id="China_Guizhou" points="698,232 673,206 720,218"/>
			<polygon id="China_SouthChongqing" points="718,199 673,206 720,218"/>
			<polygon id="China_NorthChongqing" points="718,199 673,206 710,187"/>
			<polygon id="China_Shaanxi" points="693,178 673,206 710,187"/>
			<polygon id="China_Shanxi" points="693,178 717,162 710,187"/>
			<polygon id="China_SouthInnerMongolia" points="693,178 717,162 646,141"/>
			<polygon id="China_EastQinghai" points="693,178 673,206 646,141"/>
			<polygon id="China_WestQinghai" points="673,206 649,185 646,141"/>
			<polygon id="China_SouthTibet" points="673,206 632,200 649,185"/>
			<polygon id="China_CentralTibet" points="633,172 632,200 608,183"/>
			<polygon id="China_WestTibet" points="633,172 632,200 649,185"/>
			<polygon id="China_EastXinjiang" points="633,172 649,185 646,141"/>
			<polygon id="China_WestXinjiang" points="633,172 596,158 646,141"/>
			
			<polygon id="EastAsia_NorthKorea" points="769,169 770,156 746,159"/>
			<polygon id="EastAsia_EastKorea" points="769,169 770,156 780,177"/>
			<polygon id="EastAsia_SouthKorea" points="769,169 780,177 773,181"/>
			<polygon id="EastAsia_JapanHokkaido" points="797,138 802,155 811,146"/>
			<polygon id="EastAsia_JapanTohoku" points="812,178 802,155 803,166"/>
			<polygon id="EastAsia_JapanChubu" points="812,178 802,181 803,166"/>
			<polygon id="EastAsia_JapanKansai" points="788,178 802,181 803,166"/>
			<polygon id="EastAsia_JapanKyushu" points="788,178 802,181 785,187"/>
			
			<polygon id="India_Bangladesh" points="674,229 659,215 673,206"/>
			<polygon id="India_Nepal" points="632,200 659,215 673,206"/>
			<polygon id="India_Odisha" points="674,229 659,215 656,246"/>
			<polygon id="India_AndhraPradesh" points="651,264 642,259 656,246"/>
			<polygon id="India_TamilNadu" points="651,264 642,259 643,282"/>
			<polygon id="India_Kerala" points="630,256 642,259 643,282"/>
			<polygon id="India_Telangana" points="630,256 642,259 656,246"/>
			<polygon id="India_Maharashtra" points="630,256 625,241 656,246"/>
			<polygon id="India_MadhyaPradesh" points="645,226 625,241 656,246"/>
			<polygon id="India_Chhattisgarh" points="645,226 659,215 656,246"/>
			<polygon id="India_UttarPradesh" points="645,226 659,215 632,200"/>
			<polygon id="India_Gujarat" points="645,226 625,241 613,225"/>
			<polygon id="India_Rajasthan" points="645,226 632,200 613,225"/>
			<polygon id="India_PakistanBaluchistan" points="599,216 588,202 608,183"/>
			<polygon id="India_PakistanMakran" points="599,216 588,202 581,216"/>
			<polygon id="India_PakistanPunjab" points="599,216 632,200 608,183"/>
			<polygon id="India_PakistanSindh" points="599,216 632,200 613,225"/>
			<polygon id="India_SriLanka" points="656,280 651,287 660,289"/>
			
			<polygon id="SEAsia_BurmaNorth" points="698,232 692,254 674,229"/>
			<polygon id="SEAsia_BurmaSouth" points="698,232 692,254 706,262"/>
			<polygon id="SEAsia_ThailandCentral" points="721,271 715,241 706,262"/>
			<polygon id="SEAsia_ThailandNorth" points="698,232 715,241 706,262"/>
			<polygon id="SEAsia_ThailandGulf" points="707,262 705,284 710,278"/>
			<polygon id="SEAsia_ThailandSouth" points="705,284 710,278 720,292"/>
			<polygon id="SEAsia_Laos" points="698,232 715,241 729,231"/>
			<polygon id="SEAsia_Cambodia" points="730,249 715,241 721,271"/>
			<polygon id="SEAsia_VietnamNorth" points="730,249 715,241 729,231"/>
			<polygon id="SEAsia_VietnamCentral" points="730,249 721,272 739,272"/>
			<polygon id="SEAsia_VietnamSouth" points="727,282 721,272 739,272"/>
			<polygon id="SEAsia_Malaysia" points="705,284 722,308 720,292"/>
			<polygon id="SEAsia_IndonesiaSumatraNorth" points="698,293 713,322 725,315"/>
			<polygon id="SEAsia_IndonesiaSumatraSouth" points="729,338 713,322 725,315"/>
			<polygon id="SEAsia_IndonesiaJavaWest" points="733,343 748,340 759,350"/>
			<polygon id="SEAsia_IndonesiaJavaEast" points="780,351 748,340 759,350"/>
			<polygon id="SEAsia_IndonesiaKalimantanWest" points="739,311 754,313 744,328"/>
			<polygon id="SEAsia_IndonesiaKalimantanCentral" points="762,330 754,313 744,328"/>
			<polygon id="SEAsia_IndonesiaKalimantanEast" points="762,330 754,313 766,300"/>
			<polygon id="SEAsia_IndonesiaKalimantanNorth" points="739,311 754,313 766,300"/>
			<polygon id="SEAsia_IndonesiaSulawesi" points="771,337 777,309 782,335"/>
			<polygon id="SEAsia_IndonesiaPapauWest" points="805,319 835,324 828,337"/>
			<polygon id="SEAsia_IndonesiaPapauEast" points="838,352 835,324 828,337"/>
			<polygon id="SEAsia_PapauNewGuinea" points="838,352 835,324 865,356"/>
			<polygon id="SEAsia_PhillipinesManila" points="770,242 772,260 784,262"/>
			<polygon id="SEAsia_PhillipinesDavao" points="787,280 796,273 801,283"/>
			<polygon id="SEAsia_Brunei" points="739,311 763,288 766,300"/>
			
			<polygon id="Australia_QueenslandNorth" points="830,382 838,359 862,416"/>
			<polygon id="Australia_QueenslandSouth" points="830,382 827,413 862,416"/>
			<polygon id="Australia_NewSouthWales" points="846,446 827,413 862,416"/>
			<polygon id="Australia_Victoria" points="846,446 798,444 812,468"/>
			<polygon id="Australia_SouthAustraliaEast" points="846,446 798,444 827,413"/>
			<polygon id="Australia_SouthAustraliaCentral" points="775,415 798,444 827,413"/>
			<polygon id="Australia_SouthAustraliaWest" points="775,415 798,444 769,441"/>
			<polygon id="Australia_WesternAustraliaSouth" points="748,455 744,440 769,441"/>
			<polygon id="Australia_WesternAustraliaWest" points="745,400 744,440 769,441"/>
			<polygon id="Australia_WesternAustraliaCentral" points="745,400 775,415 769,441"/>
			<polygon id="Australia_WesternAustraliaNorth" points="745,400 775,415 791,369"/>
			<polygon id="Australia_AliceSprings" points="827,413 775,415 830,382"/>
			<polygon id="Australia_NorthernAustraliaSouth" points="791,369 775,415 830,382"/>
			<polygon id="Australia_NorthernAustraliaNorth" points="791,369 807,359 830,382"/>
			
			<polygon id="Australia_NewZealandWellington" points="895,453 917,460 906,473"/>
			<polygon id="Australia_NewZealandWestcoast" points="904,476 893,470 876,482"/>
			<polygon id="Australia_NewZealandCanterbury" points="904,476 874,495 876,482"/>
			<polygon id="Australia_NewZealandFiordland" points="859,496 874,495 876,482"/>
		</svg>
	</td>
	</tr>
	</table>
</div>

<script>
var selectedRegion = "Ocean";
var phpArray = <?php echo $provinceSet ?>;

function _clickEvent(evt) 
{
	if (selectedRegion != "Ocean")
	{
		document.getElementById(selectedRegion).style.fill = "#FFE7AB";
	}
	
	if(event.srcElement.id == "")
	{
		selectedRegion = "Ocean";
		document.getElementById("ProvCapital").textContent = "Ocean";
		document.getElementById("ProvRegion").textContent = "Ocean";
		document.getElementById("ProvClimate").textContent = "Marine";
		document.getElementById("ProvPopulation").textContent = "City Population: Zero";
		document.getElementById("ProvHDI").textContent = "HDI: Zero";
		document.getElementById("ProvGDP").textContent = "Nominal GDP per Capita: Zero";
		document.getElementById("ProvExamine").onclick = "";
		document.getElementById("ProvExamine").style.visibility = "hidden";
		
		document.getElementById("ProvinceImage").src = "Assets/Ocean.png";
		document.getElementById("MapBack").style.backgroundImage = "linear-gradient(to bottom, rgba(255, 255, 255, 0.70), rgba(255, 255, 255, 0.70)),url('Backgroundimages/Ocean.png')";
	}
	else
	{
		selectedRegion = event.srcElement.id;
		var selectedProvince = phpArray.find(element => element.Province_ID == selectedRegion);
		
		document.getElementById("ProvCapital").textContent = selectedProvince.Capital;
		document.getElementById("ProvRegion").textContent = selectedProvince.Region;
		document.getElementById("ProvClimate").textContent = selectedProvince.Climate + " - " + (selectedProvince.Coastal == 1 ? "Coastal - " + selectedProvince.Coastal_Region : "Landlocked");
		document.getElementById("ProvPopulation").textContent = "City Population: " + selectedProvince.City_Population_Total;
		document.getElementById("ProvHDI").textContent = "HDI: " + selectedProvince.National_HDI;
		document.getElementById("ProvGDP").textContent = "Nominal GDP per Capita: " +selectedProvince.National_Nominal_GDP_per_capita;
		
		document.getElementById("ProvExamine").onclick = function() { document.location='provinces.php?ProvinceView=' + selectedProvince.Province_ID; } //change from index
		document.getElementById("ProvExamine").style.visibility = "visible";
		
		document.getElementById(event.srcElement.id).style.fill = "#abc3ff";
		document.getElementById("ProvinceImage").src = "Assets/" + selectedProvince.Climate + ".png";
		document.getElementById("MapBack").style.backgroundImage = "linear-gradient(to bottom, rgba(255, 255, 255, 0.70), rgba(255, 255, 255, 0.70)),url('Backgroundimages/" + selectedProvince.Climate + ".png')";
	}
}
</script>

<div class="Disclaimer">
	<p style="margin-left:10%;margin-right:10%;"> Program by 100505349.
	This web application is not intended to be an accurate representation of political borders or cultural boundaries. The map shown in this production is a rough triangulated map meant to serve as a
	representation - with regions being represented by relevant locations (which may not be placed properly).
	The map constructed in this application was made by hand by 100505349 - using image references to properly plot the coordinates </p>
		
</div>

</body>
</html>
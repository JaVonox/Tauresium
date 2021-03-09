<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" href="MainStyle.css">
</head>
<table style="width:25%;margin-left:auto;margin-right:auto;">
<tr style="border-bottom:1px solid black;">
<td ></td>
<td align="center"><img src="Assets/CultureIcon.png" id="CultureIcon" /> </td>
<td align="center"><img src="Assets/EconomicIcon.png" id="EconomicIcon" /> </td>
<td align="center"><img src="Assets/MilitaryIcon.png" id="MilitaryIcon" /> </td>
</tr>
<tr id="EnviromentalModifier" style="text-align:center;">
<td>Enviroment:</td>
<td><font id="CultureModEnv"> 0% </font></td>
<td><font id="EconomicModEnv"> 0% </font></td>
<td><font id="MilitaryModEnv"> 0% </font></td>
</tr>
<tr id="SignificanceModifer" style="text-align:center;">
<td>Significance:</td>
<td> <font id="CultureModSig"> 0% </font></td>
<td><font id="EconomicModSig"> 0% </font></td>
<td><font id="MilitaryModSig"> 0% </font></td>
</tr>
<tr id="DynamicModifier" style="text-align:center;">
<td>Other Effects:</td>
<td><font id="CultureModDyn"> </font></td>
<td><font id="EconomicModDyn"> </font></td>
<td><font id="MilitaryModDyn"> </font></td>
</tr>
<tr style="border-top:1px solid black;">
<td></td>
<td align="center"><b id="ProvCulture" style="font-size:42px"> Infinite</b></td>
<td align="center"><b id="ProvEconomic" style="font-size:42px"> Infinite</b></td>
<td align="center"><b id="ProvMilitary" style="font-size:42px">Infinite</b></td>
</tr>
<tr>
<td></td>
<td> <button type="submit" name="CultureAnnex" id="CultureAnnex" >Annex Diplomatically</button> </td>
<td> <button type="submit" name="EcoAnnex" id="EconomicAnnex" >Annex Economically</button>  </td>
<td><button type="submit" name="MilAnnex" id="MilitaryAnnex" >Annex Militarily</button> </td>
<input type="hidden" style="display:none"  id="invisible-provID" name="invisible-provID">
</tr>
</table>
<html>
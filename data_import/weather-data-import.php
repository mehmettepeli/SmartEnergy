<?php

	include '../db_script/db-connection.php';
	include '../weather/weather.php';

	$db = new DB();
	$db->connectDB();

	$photovoltaic = new photovoltaic();
	$photovoltaic->init();
	$windturbine = new windturbine();
	$windturbine->init();
	$battery = new Battery();

	//$datetime = new DateTime('tomorrow');
	
 
	$dateToday = date("Y-m-d H:i:s");
	$tempToday = $windturbine->temCel;
	$energyToday = $windturbine-> WindTurbineCurrentEnergy();
	$energySolarToday = $photovoltaic->CurrentSoloarEnergy();
	WindDataLoad($dateToday, $tempToday, $energyToday, "today");
	SolarDataLoad($dateToday, $tempToday, $energySolarToday, "today");

	$dateNextDay = $windturbine->dateFcast; //$datetime->format('Y-m-d H:i:s');
	$tempNextDay = $windturbine->temCelFcast;
	$energyNextDay = $windturbine-> WindTurbineForecastEnergy();
	$energySolarNextDay = $photovoltaic->ForecastSoloarEnergy();
	WindDataLoad($dateNextDay, $tempNextDay, $energyNextDay, "tomorrow");
	SolarDataLoad($dateNextDay, $tempNextDay, $energySolarNextDay, "tomorrow");
	
	function WindDataLoad($date, $temp, $energy, $track)
	{
		global $db;
		 $sql = "INSERT INTO `winddb` (Date, Temp,ProducedEnergy, track) 
	 		   VALUES ('".$date ."',". $temp .",". $energy .",'". $track ."') 
	 		 ";
	 	$db->executeQuery($sql);
	}
	function SolarDataLoad($date, $temp, $energy, $track)
	{
		global $db;
		 $sql = "INSERT INTO `solardb` (Date, Temp, ProducedEnergy, track) 
	 		   VALUES ('". $date ."',". $temp .",". $energy .",'". $track ."') 
	 		 ";
	 	$db->executeQuery($sql);
	}

	echo "Success";

?>
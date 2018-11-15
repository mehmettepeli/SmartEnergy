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
	
 	$dateTime = explode(" ", date("Y-m-d H"));
	$dateToday = $dateTime[0];
	$timeToday = $dateTime[1];
	$tempToday = $windturbine->temCel;
	$energyToday = $windturbine-> WindTurbineCurrentEnergy();
	$energySolarToday = $photovoltaic->CurrentSoloarEnergy();
	WindDataLoad($dateToday, $timeToday, $tempToday, $energyToday, "today");
	SolarDataLoad($dateToday, $timeToday, $tempToday, $energySolarToday, "today");

	$dateTimeNextDay= explode(" ", $windturbine->dateFcast);
	$dateNextDay = $dateTimeNextDay[0];
	$timeNextDay = (int)explode(":", $dateTimeNextDay[1])[0]; 
	$tempNextDay = $windturbine->temCelFcast;
	$energyNextDay = $windturbine-> WindTurbineForecastEnergy();
	$energySolarNextDay = $photovoltaic->ForecastSoloarEnergy();
	WindDataLoad($dateNextDay, $timeNextDay, $tempNextDay,  $energyNextDay, "tomorrow");
	SolarDataLoad($dateNextDay, $timeNextDay, $tempNextDay, $energySolarNextDay, "tomorrow");
	
	function WindDataLoad($date, $time, $temp, $energy, $track)
	{
		global $db;
		 $sql = "INSERT INTO `winddb` (Date, hour, Temp, ProducedEnergy, track) 
	 		   VALUES ('".$date ."',". $time .",". $temp .",". $energy .",'". $track ."') 
	 		 ";
	 	$db->executeQuery($sql);
	}
	function SolarDataLoad($date, $time, $temp, $energy, $track)
	{
		global $db;
		 $sql = "INSERT INTO `solardb` (Date, hour, Temp, ProducedEnergy, track) 
	 		   VALUES ('". $date ."',". $time .",". $temp .",". $energy .",'". $track ."') 
	 		 ";
	 	$db->executeQuery($sql);
	}

	echo "Success";

?>
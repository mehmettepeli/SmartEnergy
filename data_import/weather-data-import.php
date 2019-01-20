<?php

	include '../db_script/db-connection.php';
	include '../weather/weather.php';

	$db = new DB();
	$db->connectDB();

	$sql = "SELECT * FROM setupdb WHERE user_id = 1";
	$res = $db->executeQuery($sql);

	$photovoltaic = new photovoltaic();
	$photovoltaic->init();
	$windturbine = new windturbine();
	$windturbine->init();
	$battery = new Battery();

	if (mysqli_num_rows($res) > 0) {
		$row = $res->fetch_assoc();
		$photovoltaic->PhotovoltaicSetup($row["panel_area"],$row["panel_yield"],$row["panel_angle"],$row["sHorizon"]);
		$windturbine->WindturbineSetup($row["wind_roter"]);
		$battery->BatterySetup($row["bat_max_cap"],$row["bat_max_charging"],$row["bat_max_discharging"],$row["bat_eff_charging"],$row["bat_eff_discharging"]);
	}

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
	$timeNextDay = $timeToday;//(int)explode(":", $dateTimeNextDay[1])[0]; 
	$tempNextDay = $windturbine->temCelFcast;
	$energyNextDay = $windturbine-> WindTurbineForecastEnergy();
	$energySolarNextDay = $photovoltaic->ForecastSoloarEnergy();
	WindDataLoad($dateNextDay, $timeNextDay, $tempNextDay,  $energyNextDay, "tomorrow");
	SolarDataLoad($dateNextDay, $timeNextDay, $tempNextDay, $energySolarNextDay, "tomorrow");
	
	function WindDataLoad($date, $time, $temp, $energy, $track)
	{
		global $db;

		$sql = "SELECT * FROM winddb WHERE Date ='". $date ."' and hour =". $time ."";
		$res = $db->executeQuery($sql);

		if (mysqli_num_rows($res) > 0) {
			$sql = " UPDATE winddb SET Temp =". $temp .", ProducedEnergy =". $energy .", track ='". $track ."' WHERE Date ='". $date ."' and hour =". $time ."";
			$db->executeQuery($sql);
		}
		else {
			 $sql = "INSERT INTO `winddb` (Date, hour, Temp, ProducedEnergy, track) 
		 		   VALUES ('".$date ."',". $time .",". $temp .",". $energy .",'". $track ."') 
		 		 ";
		 	$db->executeQuery($sql);
		}
	}
	function SolarDataLoad($date, $time, $temp, $energy, $track)
	{
		global $db;

		$sql = "SELECT * FROM solardb WHERE Date ='". $date ."' and hour =". $time ."";
		$res = $db->executeQuery($sql);

		if (mysqli_num_rows($res) > 0) {
			$sql = " UPDATE solardb SET Temp =". $temp .", ProducedEnergy =". $energy .", track ='". $track ."' WHERE Date ='". $date ."' and hour =". $time ."";
			$db->executeQuery($sql);
		}
		else {
			 $sql = "INSERT INTO `solardb` (Date, hour, Temp, ProducedEnergy, track) 
		 		   VALUES ('". $date ."',". $time .",". $temp .",". $energy .",'". $track ."') 
		 		 ";
		 	$db->executeQuery($sql);
	    }
	}

	echo "Success";

?>
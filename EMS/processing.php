
<?php
	header('Content-Type: application/json; charset=utf-8');
	include '../db_script/db-connection.php';
	include '../weather/weather.php';

	$db = new DB();
	$db->connectDB();

 	$operation = $_POST["operation"];

 	if ($operation == "WindSetup" ) {
 		$wind_roter_txt = $_POST["wind_roter_txt"];
 		$sql = "SELECT * FROM setupdb where user_id = 1";
 		$res = $db->executeQuery($sql);
 		if (mysqli_num_rows($res) > 0) {
 			
 			$sql = " UPDATE  setupdb SET wind_roter = ". $wind_roter_txt ." WHERE user_id = 1 ";
 			$db->execute($sql);
 		}
 		else {

 			$sql = " INSERT INTO  setupdb (wind_roter) VALUES (". $wind_roter_txt .")";
 			$db->execute($sql);
 		}
 		$response ="success";
 	}


 	if ($operation == "SolarSetup" ) {
 		$solar_panel_area = $_POST["solar_panel_txt"];
 		$solar_panel_yield = $_POST["solar_panel_yield"];
 		$solar_panel_angle = $_POST["solar_panel_angle"];
 		$sHorizon = $_POST["sHorizon"];
 		$sql = "SELECT * FROM setupdb where user_id = 1";
 		$res = $db->executeQuery($sql);
 		if (mysqli_num_rows($res) > 0) {
 			
 			$sql = " UPDATE  setupdb SET panel_area = ". $solar_panel_area .", panel_yield = ". $solar_panel_yield .", panel_angle = ". $solar_panel_angle .",sHorizon = ". $sHorizon ." WHERE user_id = 1 ";
 			$db->execute($sql);
 		}
 		else {

 			$sql = " INSERT INTO  setupdb (panel_area, panel_yield, panel_angle, sHorizon ) VALUES (". $solar_panel_area .",". $solar_panel_yield .", ". $solar_panel_angle .", ". $sHorizon .")";
 			$db->execute($sql);
 		}

 		$response ="success";
 	}

 	if ($operation == "BatterySetup" ) {
 		$bat_max_cap = $_POST["bat_max_cap"];
 		$bat_max_charging = $_POST["bat_max_charging"];
 		$bat_max_discharging = $_POST["bat_max_discharging"];
 		$bat_eff_charging = $_POST["bat_eff_charging"];
 		$bat_eff_discharging = $_POST["bat_eff_discharging"];
 		$sql = "SELECT * FROM setupdb where user_id = 1";
 		$res = $db->executeQuery($sql);
 		if (mysqli_num_rows($res) > 0) {
 			
 			$sql = " UPDATE  setupdb SET bat_max_cap = ". $bat_max_cap .", bat_max_charging = ". $bat_max_charging .", bat_max_discharging = ". $bat_max_discharging .", bat_eff_charging = ". $bat_eff_charging .", bat_eff_discharging = ". $bat_eff_discharging ." WHERE user_id = 1 ";
 			$db->execute($sql);
 		}
 		else {

 			$sql = " INSERT INTO  setupdb (bat_max_cap, bat_max_charging, bat_max_discharging, bat_eff_charging, bat_eff_discharging ) VALUES (". $bat_max_cap .",". $bat_max_charging .", ". $bat_max_discharging .", ". $bat_eff_charging .", ". $bat_eff_discharging .")";
 			$db->execute($sql);
 		}
 		$response ="success";
 	}

 	if ($operation == "priceList" ) {

 		$sql = "SELECT * FROM dynamic_pricing";
 		$result = $db->executeQuery($sql);
 		$hourList = ["x"];
 		$priceList = ["Price(€)"];
 		while($row = $result->fetch_assoc()) {
			array_push($hourList, $row["hour"]);
			array_push($priceList, $row["price"]);
		}
 		$response["data_price_list"] = [$hourList, $priceList];
 	}
 	if ($operation == "dateDDL" ) {

 		$sql = "
 			SELECT * FROM `winddb` 
			GROUP BY `Date`
			ORDER BY Date ASC
 		";
 		$result = $db->executeQuery($sql);
 		$list = [];
 		$currentDay = date('Y-m-d');
 		while($row = $result->fetch_assoc()) {
 			if ($currentDay == $row["Date"])
 				break;
			array_push($list, $row["Date"]);
		}
 		$response["dateDDL"] = $list;
 	}

 	if ($operation == "chart_wind_history" ) {
 		$date = $_POST["date"];
 		if ($date == 0) {
 			$date = "(SELECT MIN(Date) FROM `winddb`)";
 		}
 		else
 			$date = "'". $date ."'";

 		$sql = "
 			SELECT * FROM `winddb` WHERE `Date` = ". $date ."
 		";
 		$result = $db->executeQuery($sql);
 		$list = ["Historical Data",0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
 		while($row = $result->fetch_assoc()) {
 			$list[$row["Hour"]+1] = $row["ProducedEnergy"];
			//array_push($list, $row["ProducedEnergy"]);
		}
 		$response["chart_wind_history"] = $list;
 	}

 	if ($operation == "chart_wind_current" ) {
 	
 		$date = "'". date('Y-m-d') ."'";

 		$sql = "
 			SELECT * FROM `winddb` WHERE `Date` = ". $date ."
 		";
 		$result = $db->executeQuery($sql);
 		$list = ["Current Data",0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
 		while($row = $result->fetch_assoc()) {
 			$list[$row["Hour"]+1] = $row["ProducedEnergy"];
			//array_push($list, $row["ProducedEnergy"]);
		}
 		$response["chart_wind_current"] = $list;
 	}

 	if ($operation == "chart_wind_forecast" ) {
 	
 		$nextDay = date('Y-m-d');
        $date = "'". date("Y-m-d", strtotime('+1 days', strtotime($nextDay))). "'";

 		$sql = "
 			SELECT * FROM `winddb` WHERE `Date` = ". $date ."
 		";
 		$result = $db->executeQuery($sql);
 		$list = ["Forecast Data",0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
 		while($row = $result->fetch_assoc()) {
 			$list[$row["Hour"]+1] = $row["ProducedEnergy"];
			//array_push($list, $row["ProducedEnergy"]);
		}
 		$response["chart_wind_forecast"] = $list;
 	}

 	if ($operation == "chart_solar_history" ) {
 		$date = $_POST["date"];
 		if ($date == 0) {
 			$date = "(SELECT MIN(Date) FROM `solardb`)";
 		}
 		else
 			$date = "'". $date ."'";

 		$sql = "
 			SELECT * FROM `solardb` WHERE `Date` = ". $date ."
 		";
 		$result = $db->executeQuery($sql);
 		$list = ["Historical Data",0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
 		while($row = $result->fetch_assoc()) {
 			$list[$row["Hour"]+1] = $row["ProducedEnergy"];
			//array_push($list, $row["ProducedEnergy"]);
		}
 		$response["chart_solar_history"] = $list;
 	}

 	if ($operation == "chart_solar_current" ) {
 	
 		$date = "'". date('Y-m-d') ."'";

 		$sql = "
 			SELECT * FROM `solardb` WHERE `Date` = ". $date ."
 		";
 		$result = $db->executeQuery($sql);
 		$list = ["Current Data",0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
 		while($row = $result->fetch_assoc()) {
 			$list[$row["Hour"]+1] = $row["ProducedEnergy"];
			//array_push($list, $row["ProducedEnergy"]);
		}
 		$response["chart_solar_current"] = $list;
 	}

 	if ($operation == "chart_solar_forecast" ) {
 	
 		$nextDay = date('Y-m-d');
        $date = "'". date("Y-m-d", strtotime('+1 days', strtotime($nextDay))). "'";

 		$sql = "
 			SELECT * FROM `solardb` WHERE `Date` = ". $date ."
 		";
 		$result = $db->executeQuery($sql);
 		$list = ["Forecast Data",0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
 		while($row = $result->fetch_assoc()) {
 			$list[$row["Hour"]+1] = $row["ProducedEnergy"];
			//array_push($list, $row["ProducedEnergy"]);
		}
 		$response["chart_solar_forecast"] = $list;
 	}

 	if ($operation == "chart_battery_data" ) {
 	
 		$sql = "
 			SELECT * FROM `setupdb` WHERE user_id = 1
 		";
 		$result = $db->executeQuery($sql);
 		$row = $result->fetch_assoc();
 		$list = [ "bat_max_cap" => $row["bat_max_cap"], "battery_storage" => $row["battery_storage"]];
 		$response["chart_battery_data"] = $list;
 	}


	$response_json = json_encode($response);
	echo $response_json;

?>


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
 	
 		$response["chart_battery_data"] = TotalBattery();
 	}
 	if ($operation == "chart_total_supply" ) {

 		$toDay = date('Y-m-d');
        $hour = (int)date('H');
 		$response["chart_total_supply"] =  TotalSpply($toDay, $hour);
 	}

 	if ($operation == "chart_total_demand" ) {

 		$toDay = date('Y-m-d');
        $hour = (int)date('H');
 		$response["chart_total_demand"] = TotalDemand($toDay, $hour);
 	}

 	if ($operation == "chart_total_view" ) {

 		$toDay = date('Y-m-d');
        $hour = (int)date('H');
        $demand = TotalDemand($toDay, $hour);
        $supply = TotalSpply($toDay, $hour);
        $battery = TotalBattery();
        $cal = round($supply["total_supply"] - $demand["total_demand"],2);

        $list[] = ["Supply[".round( $supply["total_supply"],2) ."]", round($supply["total_supply"],2)];
        $list[] = ["Demand[". round($demand["total_demand"],2) ."]", round($demand["total_demand"],2)];

        if ($cal > 0) {
        	$batVal =  round($battery["bat_max_cap"] - $battery["battery_storage"], 2); 
        	if ($cal <= $batVal ) {
        		$list[] = ["Battery[". $batVal ."]", $batVal];
        		$list[] = ["Grid[0]", 0];
        	}
        	else {
        		$net  =  $cal - $batVal;
        		$list[] = ["Battery[". $batVal ."]", $batVal];
        		$list[] = ["Sell To Grid[". $net ."]", $net];
        	}
        	
        }
        else{
        	$list[] = ["Battery[0]", 0];
        	$list[] = ["Borrow From Grid[". -$cal ."]", -$cal];
        }
 		$response["chart_total_view"] = $list;
 	}

	$response_json = json_encode($response);
	echo $response_json;




	function TotalSpply($toDay, $hour)
	{
		global $db;
		$sql = "
 			SELECT (t1.ProducedEnergy + t2.ProducedEnergy + t3.battery_storage) total_supply FROM
				(SELECT IFNULL(`ProducedEnergy`, 0) AS ProducedEnergy FROM `winddb` WHERE `Date`  = '". $toDay ."' AND Hour = ". $hour .") t1,
				(SELECT IFNULL(`ProducedEnergy`, 0) AS ProducedEnergy FROM `solardb` WHERE `Date`  = '". $toDay ."' AND Hour = ". $hour .") t2,
				(SELECT IFNULL(`battery_storage`, 0) AS battery_storage FROM `setupdb` WHERE user_id = 1) t3
 		";
 		$result = $db->executeQuery($sql);
 		$row = $result->fetch_assoc();
 		$list = [ "max_supply" => 400, "total_supply" => $row["total_supply"]];

 		return $list;

	}
	function TotalDemand($toDay, $hour){
		global $db;

 		$sql = "
 			SELECT tt1.shifted_energy + tt2.house_energy + tt2.commercial_energy - tt1.actual_energy AS total_demand, tt2.house_energy + tt2.commercial_energy + tt.avg_house_eng + tt.avg_commercial_eng AS max_demand   FROM

			(SELECT t1.shifted_energy + t3.shifted_energy AS shifted_energy, t2.shifted_energy + t4.shifted_energy AS actual_energy FROM 
			(SELECT  IFNULL(SUM(shifted_energy), 0) AS shifted_energy FROM `shifted_energydb` WHERE `shifted_hour` =  ". $hour ." AND `sender` = 'H') t1,
			(SELECT IFNULL(SUM(shifted_energy), 0) AS shifted_energy FROM `shifted_energydb` WHERE `actual_hour` = ". $hour ." AND `sender` = 'H')t2,
			(SELECT IFNULL(SUM(shifted_energy), 0) AS shifted_energy FROM `shifted_energydb` WHERE `shifted_hour` = ". $hour ." AND `sender` = 'F') t3,
			(SELECT IFNULL(SUM(shifted_energy), 0) AS shifted_energy FROM `shifted_energydb` WHERE `actual_hour` = ". $hour ." AND `sender` = 'F')t4)tt1,

			(SELECT  h.energy AS house_energy, c.energy AS commercial_energy FROM householddb h, commercialdb c
			WHERE h.hour = c.hour AND c.hour = ". $hour .") tt2,

			(SELECT  AVG(h.energy) AS avg_house_eng, AVG(c.energy) AS avg_commercial_eng FROM householddb h, commercialdb c
			WHERE h.hour = c.hour)tt
 		";
 		$result = $db->executeQuery($sql);
 		$row = $result->fetch_assoc();
 		$list = [ "max_demand" => $row["max_demand"], "total_demand" => $row["total_demand"]];
 		return $list;
	}
	function TotalBattery() {

		global $db;
 		$sql = "
 			SELECT * FROM `setupdb` WHERE user_id = 1
 		";
 		$result = $db->executeQuery($sql);
 		$row = $result->fetch_assoc();
 		$list = [ "bat_max_cap" => $row["bat_max_cap"], "battery_storage" => $row["battery_storage"]];
 		return $list;
	}

?>

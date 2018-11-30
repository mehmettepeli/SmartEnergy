<?php

	include '../db_script/db-connection.php';
	include '../weather/weather.php';
/**
 * 
 */
class ems 
{
	public $cost = 29.13; // per kwh
	public $mainGridPower = 0;
	public $battery = NULL;
	public $db = NULL;
	
	function __construct()
	{
		$this->battery = new Battery();
		$this->db = new DB();
	 	$this->db->connectDB();
	}
	public function SupplerPower($date, $time)
	{
		$sql1 = "
				SELECT `ProducedEnergy` 
				FROM `solardb` 
				WHERE `Date` = '". $date ."' AND `Hour` =". $time ."
		";
		$result1 = $db->executeQuery($sql1);
		$row = $result1->fetch_array(MYSQLI_NUM);
		$solar = $row["ProducedEnergy"];
		$sql2 = "
				SELECT `ProducedEnergy` 
				FROM `winddb` 
				WHERE `Date` = '". $date ."' AND `Hour` =". $time ."
		";
		$result2 = $db->executeQuery($sql2);
		$row = $result2->fetch_array(MYSQLI_NUM);
		$wind = $row["ProducedEnergy"];

		return $solar + $wind;
	}
	public function DemandPower($time){
		$sql1 = "
				SELECT `energy` 
				FROM `householddb` 
				WHERE `Hour` =". $time ."
		";
		$result1 = $db->executeQuery($sql1);
		$row = $result1->fetch_array(MYSQLI_NUM);
		$house = $row["energy"];
		$sql2 = "
				SELECT `energy` 
				FROM `commercialdb` 
				WHERE `Hour` =". $time ."
		";
		$result2 = $db->executeQuery($sql2);
		$row = $result2->fetch_array(MYSQLI_NUM);
		$commercial = $row["energy"];

		$sql_shift_energy = 0;
		$sql_shiftHour ="
			SELECT SUM(shifted_energy)
			FROM `shifted_energydb` 
			WHERE `shifted_hour` =". $time ."
			AND `sender` = 'H'
		"; 
		$sql_shiftHour_res = $db->executeQuery($sql_shiftHour);
		if(mysqli_num_rows($sql_shiftHour_res) >= 1){
			$row_shifted = $sql_shiftHour_res->fetch_array(MYSQLI_NUM);
			$sql_shift_energy =  $row_shifted["shifted_energy"];
		}

		$sql_actual_energy = 0;
		$sql_actualHour ="
			SELECT SUM(shifted_energy)
			FROM `shifted_energydb` 
			WHERE `actual_hour` =". $time ."
			AND `sender` = 'F'
		"; 
		$sql_actualtHour_res = $db->executeQuery($sql_actualHour);
		if(mysqli_num_rows($sql_actualtHour_res) >= 1){
			$row_actual = $sql_actualtHour_res->fetch_array(MYSQLI_NUM);
			$sql_actual_energy =  $row_actual["shifted_energy"];
		} 

		return round($house + $commercial + $sql_shift_energy - $sql_actual_energy,4);
	}
	public function StorageStatus()
	{
		return $this->battery->CurrentState();
	}
	public function BatteryCharging()
	{
		$this->battery->Charging();
		$this->StorageStatus();
	}
	public function BatteryDisCharging()
	{
		$this->battery->Discharging
		$this->StorageStatus;
	}
	public function MainGridPower()
	{
		return $this->mainGridPower;
	}
	public function Profilt($date, $time)
	{
		$demand = $this->DemandPower($time);
		$supply = $this->SupplerPower($date, $time);
		$bat = $this->StorageStatus();
		$this->mainGridPower = round($demand - ( $supply + $bat),4);
		$profilt = $this->mainGridPower * $this->cost;
		return $profilt;
	}
	public function PowerShifting($actualHour, $shiftedHour, $energy, $sender)
	{
		$sql = "
			SELECT * 
			FROM `shifted_energydb` 
			WHERE `shifted_hour` =". $shiftedHour ." 
			AND `actual_hour` = ". $actualHour ."
			AND `sender` = ". $sender ."
		";
		$result = $db->executeQuery($sql);
		if(mysqli_num_rows($result) == 1){
			$sql = "
				UPDATE `shifted_energydb` 
				SET `shifted_energy` = ".  $energy ."
				WHERE `shifted_hour` =". $shiftedHour ." 
				AND `actual_hour` = ". $actualHour ."
				AND `sender` = ". $sender ." 
			";
			$db->executeQuery($sql);
		}
		else{
			$sql = "
				INSERT INTO `shifted_energydb` (`shifted_hour`, `shifted_energy`,  `actual_hour`,) 
				VALUES ( ". $shiftedHour .", ". $energy .",". $actualHour ." )";
			$db->executeQuery($sql);
		}
	}

}
?>
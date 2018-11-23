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
	
	function __construct(argument)
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

		return $house + $commercial;
	}
	public function StorageStatus()
	{
		$this->battery->CurrentState();
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
}
?>
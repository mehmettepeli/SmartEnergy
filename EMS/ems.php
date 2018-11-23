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
	public function SupplerPower($hour)
	{
		# to be implemented soon...
	}
	public function DemandPower($hour){
		# to be implemented soon...
	}
	public function StorageStatus()
	{
		$this->battery->CurrentState();
	}
	public function MainGridPower()
	{
		return $this->mainGridPower;
	}
	public function Profilt($hour)
	{
		$deman = $this->DemandPower($hour);
		$supply = $this->SupplerPower($hour);
		$bat = $this->StorageStatus();
		$this->mainGridPower = $deman - ( $supply + $bat);
		$profilt = $this->mainGridPower * $this->cost;
		return $profilt;
	}
}
?>
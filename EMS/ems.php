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
		$result1 = $this->db->executeQuery($sql1);
		$row = $result1->fetch_assoc();
		$solar = $row["ProducedEnergy"];
		$sql2 = "
				SELECT `ProducedEnergy` 
				FROM `winddb` 
				WHERE `Date` = '". $date ."' AND `Hour` =". $time ."
		";
		$result2 = $this->db->executeQuery($sql2);
		$row = $result2->fetch_assoc();
		$wind = $row["ProducedEnergy"];

		return $solar + $wind;
	}
	public function DemandPower($time){

		$household = 0;
		$commercial = 0;
		
		$household = $this->DemandPowerHousehold($time);
		$commercial = $this->DemandPowerCommercial($time);

		return $household + $commercial;

	}
	public function DemandPowerHousehold($time){
		$sql1 = "
				SELECT `energy` 
				FROM `householddb` 
				WHERE `Hour` =". $time ."
		";
		$result1 = $this->db->executeQuery($sql1);
		$row = $result1->fetch_assoc();
		$house = $row["energy"];

		$sql_shift_energy = 0;
		$sql_shiftHour ="
			SELECT SUM(shifted_energy) AS shifted_energy
			FROM `shifted_energydb` 
			WHERE `shifted_hour` =". $time ."
			AND `sender` = 'H'
		"; 
		$sql_shiftHour_res = $this->db->executeQuery($sql_shiftHour);
		if(mysqli_num_rows($sql_shiftHour_res) >= 1){
			$row_shifted = $sql_shiftHour_res->fetch_assoc();
			$sql_shift_energy =  $row_shifted["shifted_energy"];
		}

		$sql_actual_energy = 0;
		$sql_actualHour ="
			SELECT SUM(shifted_energy) AS shifted_energy
			FROM `shifted_energydb` 
			WHERE `actual_hour` =". $time ."
			AND `sender` = 'H'
		"; 
		$sql_actualtHour_res = $this->db->executeQuery($sql_actualHour);
		if(mysqli_num_rows($sql_actualtHour_res) >= 1){
			$row_actual = $sql_actualtHour_res->fetch_assoc();
			$sql_actual_energy =  $row_actual["shifted_energy"];
		}
		return round($house + $sql_shift_energy - $sql_actual_energy,4);

	}
	public function DemandPowerCommercial($time){

		$sql2 = "
				SELECT `energy` 
				FROM `commercialdb` 
				WHERE `Hour` =". $time ."
		";
		$result2 = $this->db->executeQuery($sql2);
		$row = $result2->fetch_assoc();
		$commercial = $row["energy"];

		$sql_shift_energy = 0;
		$sql_shiftHour ="
			SELECT SUM(shifted_energy) AS shifted_energy
			FROM `shifted_energydb` 
			WHERE `shifted_hour` =". $time ."
			AND `sender` = 'F'
		"; 
		$sql_shiftHour_res = $this->db->executeQuery($sql_shiftHour);
		if(mysqli_num_rows($sql_shiftHour_res) >= 1){
			$row_shifted = $sql_shiftHour_res->fetch_assoc();
			$sql_shift_energy =  $row_shifted["shifted_energy"];
		}

		$sql_actual_energy = 0;
		$sql_actualHour ="
			SELECT SUM(shifted_energy) AS shifted_energy
			FROM `shifted_energydb` 
			WHERE `actual_hour` =". $time ."
			AND `sender` = 'F'
		"; 
		$sql_actualtHour_res = $this->db->executeQuery($sql_actualHour);
		if(mysqli_num_rows($sql_actualtHour_res) >= 1){
			$row_actual = $sql_actualtHour_res->fetch_assoc();
			$sql_actual_energy =  $row_actual["shifted_energy"];
		}
		return round($commercial + $sql_shift_energy - $sql_actual_energy,4);

	}
	public function StorageStatus()
	{
		return $this->battery->CurrentState();
	}
	public function BatteryCharging()
	{
		$this->battery->Charging();
		return $this->StorageStatus();
	}
	public function BatteryDisCharging()
	{
		$this->battery->Discharging();
		return $this->StorageStatus();
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
		$profilt = round($this->mainGridPower * $this->cost, 4);
		return $profilt;
	}
	public function PowerShifting($actualHour, $shiftedHour, $energy, $sender)
	{
		$sql = "
			SELECT * 
			FROM `shifted_energydb` 
			WHERE `shifted_hour` =". $shiftedHour ." 
			AND `actual_hour` = ". $actualHour ."
			AND `sender` = '". $sender ."'
		";
		$result = $this->db->executeQuery($sql);
		if(mysqli_num_rows($result) == 1){
			$sql = "
				UPDATE `shifted_energydb` 
				SET `shifted_energy` = ".  $energy ."
				WHERE `shifted_hour` =". $shiftedHour ." 
				AND `actual_hour` = ". $actualHour ."
				AND `sender` = '". $sender ."'
			";
			$this->db->executeQuery($sql);
		}
		else{
			$sql = "
				INSERT INTO `shifted_energydb` (`shifted_hour`, `shifted_energy`, `actual_hour`, `sender`)
				VALUES ( '". $shiftedHour ."', '". $energy ."', '". $actualHour ."', '". $sender ."')";
			$this->db->executeQuery($sql);
		}
	}
	//$sender = "F", "H"
	public function UserFlexibility ($value, $sender)
	{
		$energyList =[
			"energy"=>[],
			"hour"=>[],
		];
		$sql = "
			SELECT 
				hour,
			    MAX(`energy`) AS peak_energy,
			    ROUND(AVG(`energy`),4) AS avg_engery
			    
			FROM
				 `householddb` 
		";
		$res = $this->db->executeQuery($sql);
		$row = $res->fetch_assoc();

		$peak_hour = $row["hour"];
		$map_energy = round(($row["peak_energy"] * $value ) / 100, 4);
		$avg_engery = $row["avg_engery"];

		$sql = "
			SELECT *
			FROM
				 `householddb`
			WHERE energy < (SELECT
			    				ROUND(AVG(`energy`),4) 
							FROM
			    				`householddb`
			               )
			ORDER BY energy ASC 
		";
		$res = $this->db->executeQuery($sql);
		while($row = $res->fetch_assoc()) 
	    {
	    	array_push($energyList["energy"],  round($avg_engery - $row["energy"],4));
	    	array_push($energyList["hour"],  $row["hour"]);
	    }
	    $avg = round($map_energy / count($energyList["energy"]),4);
	    for ($i=0; $i <count($energyList["energy"]) ; $i++) { 
	    	if ($avg <= $energyList["energy"][$i]) {
	    		$map_energy = $map_energy - $avg;
	    		$this->PowerShifting($peak_hour, $energyList["hour"][$i], $avg, $sender);
	    	}
	    	else{
	    		$map_energy = round($map_energy - $energyList["energy"][$i],4);
	    		$this->PowerShifting($peak_hour, $energyList["hour"][$i], $energyList["energy"][$i], $sender);
	    		$avg = round($map_energy / (count($energyList["energy"]- ($i+1))),4);
	    	}
	    }
	}

}
/*$obj = new ems();
echo "Profilt : ". $obj->Profilt('2018-12-07', 9) . "<br>";
echo "20% Felexibilty". "<br>";
$obj->UserFlexibility(20, "H");
echo "Profilt : ". $obj->Profilt('2018-12-07', 9). "<br>";
echo "40% Felexibilty". "<br>";
$obj->UserFlexibility(40, "H");
echo "Profilt : ". $obj->Profilt('2018-12-07', 9). "<br>";
*/
?>
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

		$totHouse = round($house + $sql_shift_energy - $sql_actual_energy,4);

		return $totHouse;

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

		$totCommercial = round($commercial + $sql_shift_energy - $sql_actual_energy,4);

		return $totCommercial;

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
		$this->mainGridPower = round(( $supply + $bat) - $demand,4);
		$price = $this->GetPrcie($time);
		$profilt = round($this->mainGridPower * $price, 4);
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
		$dbTable = "householddb";
		if ($sender == "H")
			$dbTable = $dbTable;
		else
			$dbTable = "commercialdb";
		
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
				 ". $dbTable ." 
		";
		$res = $this->db->executeQuery($sql);
		$row = $res->fetch_assoc();

		$peak_hour = $row["hour"];
		$map_energy = round(($row["peak_energy"] * $value ) / 100, 4);
		$avg_engery = $row["avg_engery"];

		/*$sql_old = "
			SELECT *
			FROM
				 ". $dbTable ." 
			WHERE energy < (SELECT
			    				ROUND(AVG(`energy`),4) 
							FROM
			    				". $dbTable ." 
			               )
			ORDER BY energy ASC 
		";*/
		$sql = "
			SELECT 			db.*
			FROM
				 		   ". $dbTable ." db 
            INNER JOIN     dynamic_pricing dp
            ON dp.hour = db.hour
			WHERE db.energy < (SELECT
			    				ROUND(AVG(`energy`),4) 
							FROM
			    				". $dbTable ." 
			               )
			ORDER BY dp.price ASC
		";
		$res = $this->db->executeQuery($sql);
		while($row = $res->fetch_assoc()) 
	    {
	    	array_push($energyList["energy"],  round($avg_engery - $row["energy"],4));
	    	array_push($energyList["hour"],  $row["hour"]);
	    }
	    //$avg = round($map_energy / count($energyList["energy"]),4);
	    for ($i=0; $i <count($energyList["energy"]) ; $i++) { 
	    	if ($map_energy >= $energyList["energy"][$i]) {
	    		$map_energy = $map_energy - $energyList["energy"][$i];
	    		$this->PowerShifting($peak_hour, $energyList["hour"][$i], $energyList["energy"][$i], $sender);
	    	}
	    	elseif ($map_energy < $energyList["energy"][$i]) {
	    		$this->PowerShifting($peak_hour, $energyList["hour"][$i], $map_energy, $sender);
	    		break;
	    	}
	    	/*if ($avg <= $energyList["energy"][$i]) {
	    		$map_energy = $map_energy - $avg;
	    		$this->PowerShifting($peak_hour, $energyList["hour"][$i], $avg, $sender);
	    	}
	    	else{
	    		$map_energy = round($map_energy - $energyList["energy"][$i],4);
	    		$this->PowerShifting($peak_hour, $energyList["hour"][$i], $energyList["energy"][$i], $sender);
	    		$div = (count($energyList["energy"]) - ($i+1)) == 0 ? 1 : count($energyList["energy"]) - ($i+1);
	    		$avg = round($map_energy /$div,4);
	    	}*/
	    }
	}
	public function DynamicPricingOld()
	{
		$file = "../data/priceNew.csv";
		$handle = fopen($file, "r");
		$priceList = [];
		$dayCounter = 1;
		$hour = 0;
		for ($i=0; $i < 24 ; $i++)
			$priceList[$i] = 0;
		
		while (($data = fgetcsv($handle, 0, ',')) !== FALSE) {
			
			$priceList[$hour] += (float)$data[1];

			if($hour == 23){
				$dayCounter++;
			 	$hour = 0;
			}
			$hour++;
		}

		for ($i=0; $i < 24 ; $i++){
			$priceList[$i] = round($priceList[$i] / $dayCounter, 4) * 1000;
			$sql = "
					INSERT INTO `dynamic_pricing` (hour, price) VALUES (". $i .",". $priceList[$i] .")
				";
			$result = $this->db->execute($sql);
		}
		fclose($handle);
	}
	public function DynamicPricing()
	{
		$todayDay = date('Ymd');
		$nextDay = date("Ymd", strtotime('+1 days', strtotime($todayDay)));

		//$data = file_get_contents('https://www.epexspot.com/en/market-data/dayaheadauction/auction-table/'. $nextDay .'/DE_LU/24');
		$data = file_get_contents('https://transparency.entsoe.eu/api?securityToken=7932b44c-19d7-4cc3-9d7c-57a7773e11da&documentType=A44&in_Domain=10Y1001A1001A82H&out_Domain=10Y1001A1001A82H&periodStart='. $todayDay .'0000&periodEnd='. $nextDay .'0000');


		$xml = simplexml_load_string($data);
		$tdlist = $xml->TimeSeries[count($xml->TimeSeries)-1]->Period->Point;
		//echo '<pre>'; print_r($tdlist); echo '</pre>';

		
		//$dom = new domDocument;
		//@$dom->loadHTML($data);
		//$dom->preserveWhiteSpace = false;
		//$xpath = new DOMXpath($dom);
		//$tdlist = $xpath->query('//div[@id="tab_de_lu"]/table[3]//tr//td[9]');
		//$counter = 1;

		$hour = 0;
		$sql = " TRUNCATE TABLE `dynamic_pricing` ";
		$this->db->execute($sql);

		foreach ($tdlist as $td) {
			/*if ($counter % 2 == 0){
				$counter++;
				continue;
			}*/
			
			$td = (array)$td;

			$price = round((float)$td["price.amount"] / 1000, 4);
			$sql = "INSERT INTO `dynamic_pricing` (hour, price) VALUES (". $hour .",". $price .") ";
			$result = $this->db->execute($sql);

			//echo $price . "<br>";
			//$counter++;
			$hour++;
			
		}
	}
	public function GetPrcie($hour)
	{
		$sql = "
			SELECT `price` 
			FROM `dynamic_pricing` 
			WHERE `hour` =". $hour ."
		";
		$result = $this->db->executeQuery($sql);
		$row = $result->fetch_assoc();
		$price = $row["price"];
		return $price;
	}
	public function GetPrcieList()
	{
		$priceList = [];
		$sql = "
			SELECT *
			FROM `dynamic_pricing` 
		";
		
		$result = $this->db->executeQuery($sql);
	    while($row = $result->fetch_assoc()){
			
	    	array_push($priceList,$row["price"]);
		}
		return $priceList;
	}

}
$obj = new ems();
$obj->DynamicPricing();
//$prices = $obj->GetPrcieList();
//print_r($prices);
$priceList = $obj-> GetPrcieList();
echo '<pre>'; print_r($priceList); echo '</pre>';
//print_r( $priceList);
//echo $obj->Profilt('2018-12-11', 18) . "<br>";
//echo "---------------------------------------<br>";
//echo "20% Felexibilty". "<br>";
//$obj->UserFlexibility(50, "H");
//$obj->UserFlexibility(50, "F");


?>
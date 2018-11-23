<?php

	include '../db_script/db-connection.php';

	 $db = new DB();
	 $db->connectDB();

	function importFile(){
		
		$file = "../data/household_data_60min_singleindex_filtered.csv";
        $sql1 = "INSERT INTO `householddb` (hour, energy) VALUES ";
        $sql2 = "INSERT INTO `commercialdb` (hour, energy) VALUES ";
        dataBinding($file, $sql1, $sql2);
	}
	function dataBinding($file, $sqlString1, $sqlString2){
		ini_set('max_execution_time', 600); // 10 min
		global $db;

		$row = 1;
		$hour = 0;
		$sql_data_office = "";
		$sql_data_house = "";
		$handle = fopen($file, "r");
		while (($data = fgetcsv($handle, 0, ',')) !== FALSE) {
			if($row == 1){ $row++; continue;}

			$officeEnergy = $data[3] +$data[4] +$data[5] +$data[6] +$data[7] +$data[8] +$data[9] +$data[10] +$data[11] +$data[12] +$data[13] +$data[14] +$data[15] +$data[16] +$data[17];

			$houseEnergy = $data[18] +$data[19] +$data[20] +$data[21] +$data[22];

			$csv_data_office =  "(".$hour .",". round($officeEnergy, 4) ."),"; 
			$sql_data_office = $sql_data_office. $csv_data_office;

			$csv_data_house =  "(".$hour .",". round($houseEnergy, 4) ."),"; 
			$sql_data_house = $sql_data_house. $csv_data_house;
			
			if($row > 26){
				$sql_office = $sqlString2 . rtrim($sql_data_office, ",");
				$sql_house = $sqlString1 . rtrim($sql_data_house, ",");
				$db->execute($sql_office);
				$db->execute($sql_house);
				$sql_data_office = ""; $sql_data_house = ""; $row = 1;
			}
			$row++; $hour++;
		}
		if($row <= 26 && $sql_data_office !=""){
			$sql_office = $sqlString2 . rtrim($sql_data_office, ",");
			$sql_house = $sqlString1 . rtrim($sql_data_house, ",");
			$db->execute($sql_office);
			$db->execute($sql_house);

			//echo $sql_house ."<br>";
			//echo $sql_office ."<br>";
		}
		fclose($handle);
		UpdateTable("householddb");
		UpdateTable("commercialdb");
	}
	function UpdateTable($tabeName)
	{
		global $db;
		$tab =[
			"hour" => [],
			"eng"  => [],
			"newEng" => []
		];
		$sql = "SELECT * FROM ". $tabeName;
		$result = $db->executeQuery($sql);
	    while($row = $result->fetch_assoc()) 
	    {
	      array_push($tab["eng"],$row["energy"]);
	      array_push($tab["hour"],$row["hour"]);
	    }
	    for ($i=0; $i < count($tab["eng"]) ; $i++) { 
	    	if ($i == count($tab["eng"])-1) {
	    		$locRes = round($tab["eng"][$i] - $tab["eng"][0], 4);
	    		array_push($tab["newEng"],$locRes);
	    	}
	    	else {
	    		$locRes = round($tab["eng"][$i+1] - $tab["eng"][$i],4);
	    		array_push($tab["newEng"],$locRes);
	    	}
	    }
	    for ($i=0; $i < count($tab["hour"]) ; $i++) { 
	    	$sql = "UPDATE ". $tabeName ." SET energy =". $tab["newEng"][$i]. "WHERE hour = ".$i;
	    	$db->execute($sql);
	    }

	}
	//importFile();

?>
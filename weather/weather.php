<?php
/**
*
*/

class weather 
{
    public $jsonurl = "http://api.openweathermap.org/data/2.5/weather?APPID=87edff00832715a2e419b5184ce0b243&q=Stuttgart,de";
    public $forcastUrl = "http://api.openweathermap.org/data/2.5/forecast?q=Stuttgart,de&appid=c0c4a4b4047b97ebc5948ac9c48c0559";

    public $dateFcast;   
    public $temCelFcast;
    public $kelvinFcast;
    public $windSpeedFcast;
    public $airPressureFcast;
    public $humidityFcast;

    public $kelvin;
    public $temCel;
    public $windSpeed;
    public $airPressure;
    public $humidity;
    
    public function init ()
    {
        
        $jsonFcast = file_get_contents($this->forcastUrl);
        $weatherFcast = json_decode($jsonFcast);
        //echo '<pre>'; print_r($weatherFcast); echo '</pre>';
        $this->kelvinFcast = $weatherFcast->list[0]->main->temp;
        $this->temCelFcast = $this->kelvinFcast - 273.15;
        $this->windSpeedFcast = $weatherFcast->list[0]->wind->speed;
        $this->airPressureFcast = $weatherFcast->list[0]->main->pressure;
        $this->humidityFcast = $weatherFcast->list[0]->main->humidity;
        $this->dateFcast = $weatherFcast->list[0]->dt_txt;



        $json = file_get_contents($this->jsonurl);
        $weathers = json_decode($json);
        //echo '<pre>'; print_r($weathers); echo '</pre>';
        $this->kelvin = $weathers->main->temp;
        $this->temCel = $this->kelvin - 273.15;
        $this->windSpeed = $weathers->wind->speed;
        $this->airPressure = $weathers->main->pressure;
        $this->humidity = $weathers->main->humidity;
    }
}

/**
 * 
 */
class windturbine extends weather
{
    public $sweptArea;
    function __construct()
    {
        $this->sweptArea = round((3.14159 * 1.8 *1.8), 4);
    }
    public function DryAirDensity($air, $tempKelvin){
        $dryAirDen = round(($air*100)/(287.05*$tempKelvin),4);
        return $dryAirDen;
    }
    public function Pressure2Density($pressure,$tempKelvin){
        return round(($pressure*100)/(287.05*$tempKelvin),4);
    }
    public function SaturatedVaporPressure($h,$t){
        $c0 = 6.1078; $c1 = 7.5; $c2 = 237.3; 
        $sVapor = $c0*pow(10,($c1*$t)/($c2+$t));
        //$res = $h * $sVapor;
        return round($sVapor,4);
    }
   
    public function MoistAirDensity3($dryAirDen, $stAirDen){
        return round($dryAirDen + $stAirDen, 4);
    }
    public function ActualVaporPressure($x,$stPressure){
        return round(($stPressure*($x/100)),4); 
    }
    public function WindTurbineEnergy($moistAirDen, $sweptArea, $windSpeed){
        $p = 0.5 * $moistAirDen * $sweptArea * ($windSpeed * $windSpeed * $windSpeed);
        $p = $p/1000;
        return(round($p, 4)); // kw
    }
    public function WindTurbineCurrentEnergy()
    {
        //$dryAirDen = $this->DryAirDensity($this->airPressure,$this->kelvin);
        $stPressure= $this->SaturatedVaporPressure($this->humidity,$this->temCel);
        $stAirDen = $this->Pressure2Density($stPressure,$this->kelvin);
        $actualPressure = $this->ActualVaporPressure($this->humidity,$stPressure);
        $dryAirPressure = $this->airPressure - $actualPressure;
        $dryAirDen = $this->Pressure2Density($dryAirPressure,$this->kelvin);
        $moistAirDen = $this->MoistAirDensity3($dryAirDen,$stAirDen);
        $windEnergy = $this->WindTurbineEnergy($moistAirDen, $this->sweptArea, $this->windSpeed);

        //$this->DisplayCurrentWeather();

        /*echo "Swept Area: ". $this->sweptArea . " m2"."<br>";
        echo "Dry Air Density: ". $dryAirDen . " kg/m3"."<br>";
        echo "Saturated Vapor Pressure: ". $stPressure . " mb"."<br>";
        echo "Actual Vapor Pressure: ". $actualPressure . " mb"."<br>";
        echo "Moist Air Density: ". $moistAirDen . " Kg/m3"."<br>";
        echo"<hr>";
        */
        
        return $windEnergy;

    }

    public function WindTurbineForecastEnergy()
    {
        //$dryAirDen = $this->DryAirDensity($this->airPressureFcast,$this->kelvinFcast);
        $stPressure= $this->SaturatedVaporPressure($this->humidityFcast,$this->temCelFcast);
        $stAirDen = $this->Pressure2Density($stPressure,$this->kelvinFcast);
        $actualPressure = $this->ActualVaporPressure($this->humidityFcast,$stPressure);
        $dryAirPressure = $this->airPressureFcast - $actualPressure;
        $dryAirDen = $this->Pressure2Density($dryAirPressure,$this->kelvinFcast);
        
        $moistAirDen = $this->MoistAirDensity3($dryAirDen,$stAirDen);
        $windEnergy = $this->WindTurbineEnergy($moistAirDen, $this->sweptArea, $this->windSpeedFcast);

        //$this->DisplayForecastWeather();

        return $windEnergy;
    }
    public function DisplayCurrentWeather()
    {
        echo"<hr>";
        echo "Date: ". date("Y-m-d H:i:s") ."<br>" ;
        echo "Temp: ". $this->temCel . " &deg;C"."<br>";
        echo "Wind speed: ". $this->windSpeed . " m/s"."<br>";
        echo "Air Pressure: ". $this->airPressure . " mb"."<br>";
        echo "Humidity: ". $this->humidity . " %"."<br>";
        echo"<hr>";
    }

    public function DisplayForecastWeather()
    {
        echo"<hr>";
        $datetime = new DateTime('tomorrow');
        echo "Date: ". $datetime->format('Y-m-d H:i:s') ."<br>" ;
        echo "Temp: ". $this->temCelFcast . " &deg;C"."<br>";
        echo "Wind speed: ". $this->windSpeedFcast . " m/s"."<br>";
        echo "Air Pressure: ". $this->airPressureFcast . " mb"."<br>";
        echo "Humidity: ". $this->humidityFcast . " %"."<br>";
        echo"<hr>";
    }
}

/**
 * 
 */
class photovoltaic extends weather{

    public function TempLoss($currentTemp){
        $stTemp = 25;
        $res = 0;
        if ($currentTemp > $stTemp) {
            $lossTemp = ($currentTemp - $stTemp) * 0.005;
            $res =  round($lossTemp, 4);
        }
        return $res;
    }
    public function TotalLoss($currentTemp){
        $lo = 0.14;
        $tempLoss = $this->TempLoss($currentTemp);
        $totaLoss = 1 - ($lo + $tempLoss);
        //echo "Total loss".$totaLoss. "<br>";
        return round($totaLoss, 4);
    }
    public function SModule(){
        $day = date('z') + 1;
        $beta = 33; // degree
        $fi = 33; // degree
        $sigma = 23.45 * sin(deg2rad(360/365)*(284+$day));
        $alpha = round((90 - $fi + $sigma), 2);
        $sHorizon = 3.48; // for 33 yearly value in tilted surface
        $sIncident = round(($sHorizon / sin(deg2rad($alpha))), 4);
        $teta = $alpha + $beta;
        $sModule = round(($sIncident * sin(deg2rad($teta))), 4);
        return $sModule;
    }
    public function SolarPanelEnergy($currentTemp){
        //E = A * r * PR *S
        $sp = 1.3 * 0.20 * $this->TotalLoss($currentTemp) * $this->SModule();
        return round($sp, 4);
    }
    public function CurrentSoloarEnergy()
    {
        return $this->SolarPanelEnergy($this->temCel);
    }
    public function ForecastSoloarEnergy()
    {
        return $this->SolarPanelEnergy($this->temCelFcast);
    }
}
/**
 * 
 */
class Battery
{
    public $eMax = 200; // kw
    public $chMax = 20; //kw
    public $disMax = 20; // kw
    public $effOfCharging = 0.95; 
    public $effOfDischarging = 0.95;
    //public $initialState = 20; //kw
    public $stateOfBattey = 50;

    public function CurrentState(){
        return $this->stateOfBattey;
    }
    public function Charging()
    {
      $energy = round($this->chMax * 1 * $this->effOfCharging, 4);
      $this->stateOfBattey = $this->stateOfBattey + $energy;
      if ($this->stateOfBattey >= $this->eMax) {
          $this->stateOfBattey = $this->eMax;
      }

    }
    public function Discharging()
    {
      $energy = round((($this->disMax * 1) / ($this->effOfDischarging)), 4);
      $this->stateOfBattey = $this->stateOfBattey - $energy;
      if ($this->stateOfBattey <= 0) {
          $this->stateOfBattey = 0;
      }

    }
}
/*$photovoltaic = new photovoltaic();
$photovoltaic->init();
$windturbine = new windturbine();
$windturbine->init();

$battery = new Battery();

echo "Current Wind Turbine Energy: ". $windturbine->WindTurbineCurrentEnergy() . " kw"."<br>";
echo "Forecast Wind Turbine Energy: ". $windturbine->WindTurbineForecastEnergy() . " kw"."<br>";
echo "<hr>";
echo "Solar Panel Current Energy : ". $photovoltaic->CurrentSoloarEnergy(). " kw"."<br>";
echo "Solar Panel Forecast Energy : ". $photovoltaic->ForecastSoloarEnergy(). " kw"."<br>";

echo "<hr>";
echo "Current State Of Battery : ". $battery->CurrentState(). " kw"."<br>";
$battery->Charging();
$battery->Charging();
echo "Charging....". "<br>";
echo "Charging....". "<br>";
echo "Current State Of Battery : ". $battery->CurrentState(). " kw"."<br>";
$battery->Discharging();
echo "Discharging...". "<br>";;
echo "Current State Of Battery : ". $battery->CurrentState(). " kw"."<br>";
*/
?>
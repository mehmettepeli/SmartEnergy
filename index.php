<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Manager Dashboard</title>
  <!-- css file-->
  <link href="lib/bootstrap/css/bootstrap.v4.min.css" rel="stylesheet" type="text/css">
  <link href="lib/chart/css/billboard.css" rel="stylesheet" type="text/css">
  <link href="lib/datatable/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
  <link href="lib/fontawesome-free-5.0.13/css/fontawesome-all.min.css" rel="stylesheet" type="text/css">

  <!-- js file-->
  <script src="lib/jquery/js/jquery.v3.1.min.js"></script>
  <script src="lib/jquery/js/popper.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.v4.0.min.js"></script>
  <script src="lib/chart/js/d3.v5.min.js" charset="utf-8"></script>
  <script src="lib/chart/js/billboard.js"></script>
  <script src="lib/datatable/js/jquery.dataTables.min.js"></script>

  <!-- custom css and js file-->
  <link href="custom/css/custom.css" rel="stylesheet" type="text/css">
  <script src="custom/js/custom.js"></script>
</head>

<body>

    <div class="container" style="margin-top: 10px">

      <!-- Overview -->
      <div style="text-align: right;"><a href="user.php" type="button" class="btn btn-info">User View</a></div>
      <div class="card row">
        <div class="col mgr_sty dt_padding">
          <h4 class="">System Overview</h4>
          <div id="" class="flex-dis">
            <div class="col-6">
              <div id="chart_price_list" class=""></div>
            </div>
            <div class="col-6" style="border: 1px solid #8080803b;">
              <div class="row" style=" text-align: center;"> <h3 style="width: 100%"> General Info </h3></div>
              <div class="row flex-dis">
                <div class="col-6 txt-rt"><b>Date: </b></div>
                <div class="col-6 date"> <?php  echo  date('Y-m-d H:m:s');?></div>
              </div>
              <div class="row flex-dis">
                <div class="col-6 txt-rt"><b>Windspeed:</b> </div>
                <div class="col-6 windSpeed"></div>
              </div>
              <div class="row flex-dis">
                <div class="col-6 txt-rt"><b>Temperature: </b></div>
                <div class="col-6 temperature"></div>
              </div>
              <div class="row flex-dis">
                <div class="col-6 txt-rt"><b>Humidity: </b></div>
                <div class="col-6 humidity"></div>
              </div>
              <div class="row flex-dis">
                <div class="col-6 txt-rt"><b>Air pressure: </b></div>
                <div class="col-6 airPressure"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- middle part -->
      <div class="card row">
        <div class="col mgr_sty dt_padding">
          <h4 class="">Energy Overview</h4>
          <div id="" class="flex-dis mgr_top_40">
            <div class="col-4">
              <div id="chart_total_supply"></div>
            </div>
            <div class="col-4">
              <div id="chart_total_demand"></div>
            </div>
            <div class="col-4">
              <div id="chart_total_view"></div>
            </div>
          </div>
        </div>
      </div>

      <!-- tab for solar, wind, battery data -->
      <div class="card row">
        <div class="main-box-normal">
          <!-- Tab Items Start -->
          <ul class="nav nav-tabs" id="temp" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#windTurbineData" role="tab" aria-controls="windTurbineData">Wind Turbine Data</a>
            </li>
            <li class="nav-item">
              <a class="nav-link solar_panel_content" data-toggle="tab" href="#solarPanelData" role="tab" aria-controls="solarPanelData">Solar Panel Data</a>
            </li>
            <li class="nav-item">
              <a class="nav-link batteryDataClick" data-toggle="tab" href="#batteryData" role="tab" aria-controls="batteryData">Battery Data</a>
            </li>
          </ul>
          <!-- Tab Items End-->
          <!-- Tab Body Start-->
          <div class="tab-content">
            <div class="tab-pane active" id="windTurbineData" role="tabpanel">
              <div class="col mgr_sty">
                <div class="pd_top_10">
                  <div id="" class="flex-dis" style="max-height: auto !important; padding-bottom: 20px;">
                    <div class="col-4" >
                      <select id="" class="dateDDL form-control">
                      </select>
                      <div id="chart_wind_history" class=""></div>
                    </div>
                    <div class="col-4" style="margin-top: 43px" >
                      <div id="chart_wind_current" class=""></div>
                    </div>
                    <div class="col-4" style="margin-top: 43px" >
                      <div id="chart_wind_forecast" class=""></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="solarPanelData" role="tabpanel">
              <div class="col mgr_sty">
                <div class="pd_top_10">
                  <div id="" class=" flex-dis" style=" padding-bottom: 20px;">
                    <div class="col-4">
                      <select id="" class="dateDDL_solar form-control">
                      </select>
                      <div id="chart_solar_history" class=""></div>
                    </div>
                    <div class="col-4" style="margin-top: 43px">
                      <div id="chart_solar_current" class=""></div>
                    </div>
                    <div class="col-4" style="margin-top: 43px">
                      <div id="chart_solar_forecast" class=""></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="batteryData" role="tabpanel">
              <div class="col mgr_sty">
                <div class="pd_top_10"> 
                  <div id="" class="flex-dis" style="padding-bottom: 20px;">
                    <div class="col-12" style=" border: 1px solid #dad5d5;">
                      <div id="chart_battery_data"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- last part -->
      <div class="card row">
        <div class="main-box-normal">
          <!-- Tab Items Start -->
          <ul class="nav nav-tabs" id="temp" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#windTurbine" role="tab" aria-controls="windTurbine">Wind Turbine</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#solarPanel" role="tab" aria-controls="solarPanel">Solar Panel</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#battery" role="tab" aria-controls="battery">Battery</a>
            </li>
          </ul>
          <!-- Tab Items End-->
          <!-- Tab Body Start-->
          <div class="tab-content">
            <div class="tab-pane active" id="windTurbine" role="tabpanel">
              <div class="col mgr_sty">
                <div class="pd_top_20">
                  <h5 id="" class="mgr_left_20"> Wind Turbine Setup </h5>
                  <span class="loading loading_sty"> </span> 
                  <div id="" class="mgr_left_20 flex-dis" style="max-height: auto !important; padding-bottom: 20px;">
                    <div class="col-6" style=" border: 1px solid #dad5d5;">
                      <p style="padding-top: 20px; padding-left: 20px;"> 
                        <span> Roter Size: </span>
                        <input type="text" name="" id="wind_roter_txt" value="1.8">
                        <span> Meter </span>
                      </p>
                      <p style="width: 54%; text-align: right;"><button id="wind_set_btn" type="button" class="btn btn-secondary">Setup</button></p>
                    </div>
                    <div class="col-6" style="text-align: center; border: 1px solid #dad5d5;">
                      <img src="resource/images/windturbine.jpeg" style="width: 68%">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="solarPanel" role="tabpanel">
              <div class="col mgr_sty">
                <div class="pd_top_20">
                  <h5 id="" class="mgr_left_20"> Solar Panel Setup  </h5>
                  <span class="loading loading_sty"> </span> 
                  <div id="" class="mgr_left_20 flex-dis" style=" padding-bottom: 20px;">
                    <div class="col-6" style=" border: 1px solid #dad5d5;">
                      <p style="padding-top: 20px; padding-left: 20px;"> 
                        <span style=" margin-right: 8px;"> Panel Area:</span>
                        <input type="text" name="" id="solar_panel_txt" value="1.3">
                        <span> M <sup> 2 </sup> </span>
                      </p>
                      <p style="padding-left: 20px;"> 
                        <span style="margin-right: 6px;"> Panel Yield:</span>
                        <select id="solar_panel_yield" style=" width: 36%">
                          <option  value="0.05"> 5%</option>
                          <option  value="0.10"> 10%</option>
                          <option  value="0.15"> 15%</option>
                          <option  value="0.20" selected> 20%</option>
                          <option  value="0.25"> 25%</option>
                        </select>
                      </p>
                      <p style="padding-left: 20px;">
                        <span> Panel Angle:</span>
                        <select id="solar_panel_angle" style=" width: 36%">
                          <option  value="3.11#0"> 0&deg;</option>
                          <option  value="3.47#33" selected> 33&deg;</option>
                          <option  value="3.38#48"> 48&deg;</option>
                          <option  value="3.40#63"> 63&deg;</option>
                          <option  value="2.38#90"> 90&deg;</option>
                        </select>
                      </p>
                      <p style="width: 54%; text-align: right;"><button id="solar_set_btn" type="button" class="btn btn-secondary">Setup</button></p>
                    </div>
                    <div class="col-6" style="text-align: center; border: 1px solid #dad5d5;">
                      <img src="resource/images/solarpanel.jpeg" style="width: 68%">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="battery" role="tabpanel">
              <div class="col mgr_sty">
                <div class="pd_top_20">
                  <h5 id="" class="mgr_left_20">  Battery Setup   </h5>
                  <span class="loading loading_sty"></span> 
                  <div id="" class="mgr_left_20 flex-dis" style="padding-bottom: 20px;">
                    <div class="col-6" style=" border: 1px solid #dad5d5;">
                      <p style="padding-top: 20px; padding-left: 20px;"> 
                        <span style="margin-right: 87px;"> Max Capcity: </span>
                        <input type="number" name="" id="bat_max_cap" value="200">
                        <span> KWH </span>
                      </p>
                      <p style="padding-left: 20px;"> 
                        <span style="margin-right: 73px;"> Charging Rate: </span>
                        <input type="number" name="" id="bat_max_charging" value="20">
                        <span> KWH </span>
                      </p>
                      <p style="padding-left: 20px;"> 
                        <span style="margin-right: 55px;"> Discharging Rate: </span>
                        <input type="number" name="" id="bat_max_discharging" value="20">
                        <span> KWH </span>
                      </p>
                      <p style="padding-left: 20px;"> 
                        <span style="margin-right: 20px;"> Efficiency Of Charging: </span>
                        <select id="bat_eff_charging" style=" width: 36%">
                          <option  value="0.60"> 60%</option>
                          <option  value="0.70">70% </option>
                          <option  value="0.80"> 80%</option>
                          <option  value="0.90" selected> 90%</option>
                          <option  value="1"> 100%</option>
                        </select>
                      </p>
                      <p style="padding-left: 20px;"> 
                        <span> Efficiency Of Discharging: </span>
                        <select id="bat_eff_discharging" style=" width: 36%">
                          <option  value="0.60"> 60%</option>
                          <option  value="0.70">70% </option>
                          <option  value="0.80"> 80%</option>
                          <option  value="0.90" selected> 90%</option>
                          <option  value="1"> 100%</option>
                        </select>
                      </p>
                      <p style="width: 54%; text-align: right;"><button id="battery_set_btn" type="button" class="btn btn-secondary">Setup</button></p>
                    </div>
                    <div class="col-6" style="text-align: center; border: 1px solid #dad5d5;">
                      <img src="resource/images/battery.jpg" style="width: 68%">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Tab Body End -->


      <div class="row">
        <div class="col" style="height: 25px;"></div>
      </div>
    </div>
</body>
</html>


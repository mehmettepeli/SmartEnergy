<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>User Dashboard</title>
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
  <script src="custom/js/user-custom.js"></script>
</head>

<body>

    <div class="container" style="margin-top: 10px">

      <div><a href="index.php" type="button" class="btn btn-info">Manager View</a></div>
      <!-- Overview -->
      <div class="card row">
        <div class="col mgr_sty dt_padding">
          <h4 class="">System Overview</h4>
          <div id="" class="flex-dis">
            <div class="col-6">
              <div id="user_price_list" class=""></div>
            </div>
            <div class="col-6" style="border: 1px solid #8080803b;">
              <div class="row" style=" text-align: center;"> <h3 style="width: 100%">User Flexibilty</h3></div>
              <div class="row flex-dis form-inline">
                <div class="col-6"><b>Household Flexibilty Rate: </b></div>
                <div class="col-3"> 
                  <select id="houseFlexibility" style="width: 100%">
                    <option value="10">10%</option>
                    <option value="20">20%</option>
                    <option value="30">30%</option>
                    <option value="40">40%</option>
                    <option value="50">50%</option>
                    <option value="60">60%</option>
                    <option value="70">70%</option>
                    <option value="80">80%</option>
                    <option value="90">90%</option>
                    <option value="100">100%</option>
                  </select>
                </div>
                <div class="col-3"><button id="btn_house_flexi" type="button" class="btn btn-secondary">Submit</button></div>
              </div>
              <div class="row flex-dis form-inline" style="margin-top: 30px;">
                <div class="col-6"><b>Commercial Flexibilty Rate: </b></div>
                <div class="col-3"> 
                  <select id="firmaFlexibility" style="width: 100%">
                    <option value="10">10%</option>
                    <option value="20">20%</option>
                    <option value="30">30%</option>
                    <option value="40">40%</option>
                    <option value="50">50%</option>
                    <option value="60">60%</option>
                    <option value="70">70%</option>
                    <option value="80">80%</option>
                    <option value="90">90%</option>
                    <option value="100">100%</option>
                  </select>
                </div>
                <div class="col-3"><button id="btn_firma_flexi" type="button" class="btn btn-secondary">Submit</button></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- middle part -->
      <div class="card row">
        <div class="col mgr_sty dt_padding">
          <h4 class="">Household Demand</h4>
          <div id="" class="flex-dis mgr_top_40">
            <div class="col-6">
              <div id="user_house_list"></div>
            </div>
            <div class="col-6">
              <div id="user_house_list_shifted"></div>
            </div>
          </div>
        </div>
      </div>      
      <div class="card row">
        <div class="col mgr_sty dt_padding">
          <h4 class="">Commercial Demand</h4>
          <div id="" class="flex-dis mgr_top_40">
            <div class="col-6">
              <div id="user_commercial_list"></div>
            </div>
            <div class="col-6">
              <div id="user_commercial_list_shifted"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col" style="height: 25px;"></div>
      </div>
    </div>
</body>
</html>


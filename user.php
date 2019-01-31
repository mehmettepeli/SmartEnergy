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

    <div class="container" style="margin-top: 60px">

      <!-- Overview -->
      <div class="card row">
        <div class="col mgr_sty dt_padding">
          <h4 class="">System Overview</h4>
          <div id="" class="flex-dis">
            <div class="col-6">
              <div id="user_price_list" class=""></div>
            </div>
            <div class="col-6" style="border: 1px solid #8080803b;">
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


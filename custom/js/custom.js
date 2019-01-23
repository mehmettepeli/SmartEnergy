$(document).ready(function(){
  eventListener();
  loadPriceList();

  var i = 0;
  function LoadDataEveryHour() {
      /*$.post("data_import/weather-data-import.php",{},
      function(data, status){
          console.log("Data: " + data + "\nStatus: " + status);
      });*/
      i++;
      //console.log("call "+ i);
      setInterval(LoadDataEveryHour, 1000 * 60 * 60);
  }
LoadDataEveryHour();
/************ Toggle icon *************/
    $( "#iconToggle" ).click(function(){
      if($(this).children().hasClass('fa-caret-square-down'))
        $(this).children().removeClass('fa-caret-square-down').addClass('fa-caret-square-up');
      else
        $(this).children().removeClass('fa-caret-square-up').addClass('fa-caret-square-down');
    });
});

/* start -- event handler for setup*/

function loadPriceList() {
  priceList = bb.generate({
            bindto : '#chart_price_list',
            data: {
                //x : 'x',
                columns: [],
                type: 'bar',
                
                //onclick: common,
            },
            axis: {
              x: {
                  label:{
                    text: "Hour",
                    position: "outer-center"
                }
              },
              y: {
                label:{
                  text: "KWh",
                  position: "outer-middle"
                }
              }
            },
            legend: {
              show: true
            },
            title: { 
              text: 'Price List'
            },
            /*axis: {
                x: {
                    type: 'category',
                    tick: {
                        rotate: 0,
                        multiline: true
                    },
                }
            },*/
            padding: {
              bottom: 10
            }
        });
    $.post("ems/processing.php", { "operation" : "priceList"}, function(result){
      console.log(result["data_price_list"]);
      priceList.load({
        unload: true,
        columns: [result["data_price_list"][1]]
      });
  });
}

function eventListener() {

  $("#wind_set_btn").click(function () {
    var wind_roter_txt = $("#wind_roter_txt").val();
    if (confirm("Do you want to setup Wind Roter: " + wind_roter_txt + "?" )) {
      $.post("ems/processing.php", { "operation" : "WindSetup", "wind_roter_txt" : wind_roter_txt},
        function(data, status){
          alert("Successfully setup");
          console.log("Data: " + data + "\nStatus: " + status);
      }); 
    }
  });

  $("#solar_set_btn").click(function () {
    var solar_panel_txt = $("#solar_panel_txt").val();
    var solar_panel_yield = $("#solar_panel_yield").val();
    var solar_panel_display = $("#solar_panel_angle option:selected").text();
    var val  = $("#solar_panel_angle").val();
    var sHorizon = val.split("#")[0];
    var solar_panel_angle = val.split("#")[1];
    if (confirm("Do you want to setup \n Panel area: " + solar_panel_txt + "\n Panel yield: " + $("#solar_panel_yield option:selected").text() + "\n Panel angle: " + solar_panel_display + "?"  )) {
      $.post("ems/processing.php", { "operation" : "SolarSetup", "solar_panel_txt" : solar_panel_txt, "solar_panel_yield" : solar_panel_yield, "solar_panel_angle" : solar_panel_angle, "sHorizon" : sHorizon},
        function(data, status){
          alert("Successfully setup");
          console.log("Data: " + data + "\nStatus: " + status);
      }); 
    }
  });

  $("#battery_set_btn").click(function () {
    var bat_max_cap = $("#bat_max_cap").val();
    var bat_max_charging = $("#bat_max_charging").val();
    var bat_max_discharging = $("#bat_max_discharging").val();
    var bat_eff_charging = $("#bat_eff_charging").val();
    var bat_eff_discharging = $("#bat_eff_discharging").val();
    if (confirm("Do you want to setup \n Max Capcity:  " + bat_max_cap + "\n Charging Rate: " + bat_max_charging+ "\n Discharging Rate:  " + bat_max_discharging +  "\n Efficiency Of Charging:  " + $("#bat_eff_charging option:selected").text() +"\n Efficiency Of Discharging:  " + $("#bat_eff_discharging option:selected").text() + "?"  )) {
      $.post("ems/processing.php", { "operation" : "BatterySetup", "bat_max_cap" : bat_max_cap, "bat_max_charging" : bat_max_charging, "bat_max_discharging" : bat_max_discharging, "bat_eff_charging" : bat_eff_charging, "bat_eff_discharging" : bat_eff_discharging},
        function(data, status){
          alert("Successfully setup");
          console.log("Data: " + data + "\nStatus: " + status);
      }); 
    }
  });
}

/* end --  event handler for setup*/
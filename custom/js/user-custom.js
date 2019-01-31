$(document).ready(function(){
  eventListener();
  loadPriceList();
  loadHouseHoldList();
  loadCommercialList();
  loadHouseShiftedList();
  loadCommercialShiftedList();

/************ Toggle icon *************/
    $( "#iconToggle" ).click(function(){
      if($(this).children().hasClass('fa-caret-square-down'))
        $(this).children().removeClass('fa-caret-square-down').addClass('fa-caret-square-up');
      else
        $(this).children().removeClass('fa-caret-square-up').addClass('fa-caret-square-down');
    });
});


function loadPriceList() {
  priceList = bb.generate({
            bindto : '#user_price_list',
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
      //console.log(result["data_price_list"]);
      priceList.load({
        unload: true,
        columns: [result["data_price_list"][1]]
      });
    });
}
function loadHouseHoldList() {
  user_house_list = bb.generate({
            bindto : '#user_house_list',
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
            title: { 
              text: 'Household Energy'
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
    $.post("ems/processing.php", { "operation" : "user_house_list"}, function(result){
      //console.log(result["data_price_list"]);
      user_house_list.load({
        unload: true,
        columns: result["user_house_list"]
      });
    });
}

function loadHouseShiftedList() {
  user_house_list_shifted = bb.generate({
            bindto : '#user_house_list_shifted',
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
            title: { 
              text: 'Household Shifted Energy'
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
    $.post("ems/processing.php", { "operation" : "user_house_list_shifted"}, function(result){
      //console.log(result["data_price_list"]);
      user_house_list_shifted.load({
        unload: true,
        columns: result["user_house_list_shifted"]
      });
    });
}
function loadCommercialList() {
  user_commercial_list = bb.generate({
            bindto : '#user_commercial_list',
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
            title: { 
              text: 'Commercial Energy'
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
    $.post("ems/processing.php", { "operation" : "user_commercial_list"}, function(result){
      //console.log(result["data_price_list"]);
      user_commercial_list.load({
        unload: true,
        columns: result["user_commercial_list"]
      });
    });
}
function loadCommercialShiftedList() {
  user_commercial_list_shifted = bb.generate({
            bindto : '#user_commercial_list_shifted',
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
            title: { 
              text: 'Commercial Shifted Energy'
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
    $.post("ems/processing.php", { "operation" : "user_commercial_list_shifted"}, function(result){
      //console.log(result["data_price_list"]);
      user_commercial_list_shifted.load({
        unload: true,
        columns: result["user_commercial_list_shifted"]
      });
    });
}
/* start -- event handler for setup*/

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
}

/* end --  event handler for setup*/
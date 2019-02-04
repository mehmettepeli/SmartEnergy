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
                  text: "Price(€)",
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

  $("#btn_house_flexi").click(function () {
    var houseFlexibility = $("#houseFlexibility").val();
    if (confirm("Do you want to " + houseFlexibility + "% flexibility?" )) {
      $.post("ems/processing.php", { "operation" : "house_flexi", "rate" : houseFlexibility, "indicator" : "H"},
        function(data, status){
          loadHouseShiftedList();
          alert("Successfully submitted");
      });
    }
  });
  $("#btn_firma_flexi").click(function () {
    var firmaFlexibility = $("#firmaFlexibility").val();
    if (confirm("Do you want to " + firmaFlexibility + "% flexibility?" )) {
      $.post("ems/processing.php", { "operation" : "firma_flexi", "rate" : firmaFlexibility, "indicator" : "F"},
        function(data, status){
          loadCommercialShiftedList();
          alert("Successfully submitted");
      }); 
    }
  });
}

/* end --  event handler for setup*/
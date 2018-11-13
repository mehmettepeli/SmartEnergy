$(document).ready(function(){

  var i = 0;
  function LoadDataEveryHour() {
      $.post("data_import/weather-data-import.php",{},
      function(data, status){
          console.log("Data: " + data + "\nStatus: " + status);
      });
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
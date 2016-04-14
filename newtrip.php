<!DOCTYPE html>
<html lang="en" ng-app="myApp">
<?php
include 'connection.php';
session_start();
if(isset($_SESSION["uname"]))
{

}
else
{

  header("Location:index.php");
}
$link=mysqli_connect($db_host,$db_username,$db_password,$db_name) or die("cannot connect");
file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Handler.php') ? require_once __DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Handler.php' : die('There is no such a file: Handler.php');
file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Config.php') ? require_once __DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Config.php' : die('There is no such a file: Config.php');

use AjaxLiveSearch\core\Config;
use AjaxLiveSearch\core\Handler;
Handler::getJavascriptAntiBot();
$token = Handler::getToken();
$time = time();
$maxInputLength = Config::getConfig('maxInputLength');
session_start();
if(isset($_SESSION["uname"]))
{
}
else
{
    header("Location:index.php");
}
$uname=$_SESSION["uname"];
$ar=array('uname' => $uname );
?>
<head>
      <link href='http://fonts.googleapis.com/css?family=Quattrocento+Sans:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta charset="utf-8">
     
      <!-- Live Search Styles -->
      <link rel="stylesheet" href="css/fontello.css">
      <link rel="stylesheet" href="css/animation.css">
      <!--[if IE 7]>
      <link rel="stylesheet" href="css/fontello-ie7.css">
      <![endif]-->
      <link rel="stylesheet" type="text/css" href="css/ajaxlivesearch.min.css">


      <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Welcome!</title>
    <!-- Bootstrap core CSS -->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/navbar-fixed-top.css" rel="stylesheet">
    <link href="css/spage.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
     <script type="text/javascript" src="js/ajaxlivesearch.js"></script>
</head>

<body>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Travel Planner</a>
        </div>
    </nav>
    <!-- /container -->
    <div class="wide" style="background:background: #0099cc; background: -webkit-linear-gradient(left, #0099cc, #006080); background: -moz-linear-gradient(left, #0099cc, #006080); background: -ms-linear-gradient(left, #0099cc, #006080); background: -o-linear-gradient(left, #0099cc, #006080); background: linear-gradient(to right, #0099cc, #006080);">
        <div class="row">
            <div class="col-md-4 col-xs-1 line" style="padding-top: 30px">
                <hr>
            </div>
            <div class="col-md-4 col-xs-10 logo">
                <font color="white" size="6">Welcome</font>
            </div>
            <div class="col-md-4 col-xs-1 line" style="padding-top: 30px">
                <hr>
            </div>
        </div>
        <div class="row vertical-align">
            <div class="col-md-2 col-xs-1" align="center"></div>
            <div class="col-md-8 col-xs-10" align="center">
                <span style="color: white;font-size: 4vh;"></span>
            </div>
            <div class="col-md-2 col-xs-1" align="center"></div>
        </div>
    </div>
    <div align="center" style="position: relative;top: -12vh;">
        <div class="row" align="center">
            <div class="col-md-2"></div>
            <div class="col-md-8 col-xs-10 col-xs-offset-1 col-md-offset-0">
                <div class="jumbotron" style="box-shadow: 1px 1px 5px #888888;">
                    <div style="width:100%">
                    <div>
                    <ul class="nav nav-tabs" style="margin-left:30%;">
                      <li class="active take-all-space" style="width:30%;"><a href="#search" data-toggle="tab">
                          Create New Trip</a></li>
                      <li class="take-all-space" style="width:30%;"><a href="#open" data-toggle="tab">Open Current Trip</a></li>
                    </ul>
                    </div>
                    <div class="tab-content" style="width:100%;">
                        <div class="tab-pane active" id="search">
                            <p style="font-size: 3vh;margin-top:3%;margin-bottom:3%;">Search for a Place</p>
                            <br/>
                            <div class="row">
                                <div class="col-xs-1"></div>
                                <div class="col-xs-10">
                                    <input id="pac-input" class="form-control" type="text" placeholder="Start Searching for a palce">
                                    <input id="day" class="form-control" type="number" placeholder="`days" style="margin-top:2%;" min="1" max="5">
                                    <input type="date" id="date" placeholder="mm/dd/yy" class="form-control" style="margin-top: 2%">
                                    <br/>
                                    <button class="btn btn-primary btn-block" onclick="createnew()" type="button">Begin</button>

                                </div>
                                <div class="col-xs-1"></div>
                            </div>
                            <br/>
                        </div>
                        <div class="tab-pane" id="open">
                            <p style="font-size: 3vh;margin-top:3%;margin-bottom:3%;">Search for a Place</p>
                            <br/>
                            <div class="row">
                                <div class="col-xs-1"></div>
                                <div class="col-xs-10">
                                    <!-- <input type="text" class='mySearch' id="ls_query"> -->
                                    <input id="ls_query" class='mySearch' type="text" placeholder="Start Searching for a old trip">
                                    <input id="id_old" hidden></id>
                                    <input id="lat_old" hidden></id>
                                    <input id="lng_old" hidden></id>
                                    <input id="month_old" hidden></id>
                                    <br/>
                                    <button class="btn btn-primary btn-block" onclick="oldtrip()" type="button">Begin</button>

                                </div>
                                <div class="col-xs-1"></div>
                            </div>
                            <br/>
                        </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
    <script>

        var place;
        function initMap()
        {
            var defaultBounds = new google.maps.LatLngBounds(
            new google.maps.LatLng(39.5899447,97.0556699),
            new google.maps.LatLng(3.3596552,66.2570438));
            var options = {
                bounds: defaultBounds,
                types: ['(regions)']
            };

            var input = document.getElementById('pac-input');
            //map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            var autocomplete = new google.maps.places.Autocomplete(input, options);
            //autocomplete.bindTo('bounds', map);
            autocomplete.addListener('place_changed', function()
            {
                //deleteMarkers();
                place = autocomplete.getPlace();
                //weather(place.name);
                //map.setCenter(place.geometry.location);
                //map.setZoom(14);
                console.log("this"+place.place_id);
                //search_restaurants(place.geometry.location);
                //find_Photos(place);
            });
        }
        function createnew()
        {
            console.log(place.geometry.location.lat());
            console.log(place.geometry.location.lng());
            //var url="photos.php?lat="+place.geometry.location.lat()+"&lng="+place.geometry.location.lng()+"&name="+place.name;
            var name=place.name;
            var lat=place.geometry.location.lat();
            var lng=place.geometry.location.lng();
            var user_name=<?php echo json_encode($ar) ?>;
            var days=document.getElementById("day").value;
            var date=document.getElementById("date").value;
            var d=new Date(date);
            console.log("Month="+d.getMonth());
            console.log(date);
            console.log(user_name.uname);
            console.log(days);
             $.ajax(
              {
                url: "addnewtrip.php",
                type:"post",
                dataType:"json",
                async: false,
                data:
                {
                    name:name,
                    uname:user_name.uname,
                    lat:lat,
                    lng:lng,
                    day:days,
                    date:date
                },

                success: function(json)
                {
                    console.log(json.status);
                    if(json.status>0)
                    {
                        var url="photos.php?lat="+place.geometry.location.lat()+"&lng="+place.geometry.location.lng()+"&name="+place.name+"&id="+json.status+"&month="+(d.getMonth()+1);
                        location.href=url;
                    }
                    
                },

                error : function()
                {
                  alert("ERROR");
                  //console.log("something went wrong");
                }
              });
            //location.href=url;
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7Kb6lhE3dA4201a82tu9CNGkvsOuaI3M&libraries=places&callback=initMap">
    </script>
    

    

      <script>
       jQuery(document).ready(function(){
        jQuery(".mySearch").ajaxlivesearch({
          loaded_at: <?php echo $time; ?>,
          token: <?php echo "'" . $token . "'"; ?>,
          maxInput: <?php echo $maxInputLength; ?>,
          onResultClick: function(e, data) {
            // get the index 1 (second column) value
            var selectedOne = jQuery(data.selected).find('td').eq('0').text();
            var selecteddate=  jQuery(data.selected).find('td').eq('1').text();
            var selectedid=  jQuery(data.selected).find('td').eq('2').text();
            var selectedlat=  jQuery(data.selected).find('td').eq('3').text();
            var selectedlng=  jQuery(data.selected).find('td').eq('4').text();

            // set the input value
            jQuery('.mySearch').val(selectedOne);
            jQuery('#lat_old').val(selectedlat);
            jQuery('#lng_old').val(selectedlng);
            jQuery('#id_old').val(selectedid);
            var d=new Date(selecteddate);
            //console.log("Month="+d.getMonth());
            jQuery('#month_old').val(d.getMonth());
            // console.log("Lat="+document.getElementById("lat_old").value);
            // console.log("Lng="+document.getElementById("lng_old").value);
            // console.log("ID="+document.getElementById("id_old").value);
            // hide the result
            jQuery(".mySearch").trigger('ajaxlivesearch:hide_result');
          },
          onResultEnter: function(e, data) {
            // do whatever you want
            // jQuery(".mySearch").trigger('ajaxlivesearch:search', {query: 'test'});
          },
          onAjaxComplete: function(e, data) {

          }
        });
      })


       function oldtrip()
       {
            var place_name=document.getElementById("ls_query").value;
            var id=document.getElementById("id_old").value;
            var lat=document.getElementById("lat_old").value;
            var lng=document.getElementById("lng_old").value;
            var month=document.getElementById("month_old").value;
            console.log(place_name);
            console.log(id);
            console.log(lat);
            console.log(lng);
            console.log(month);
            var url="photos.php?lat="+lat+"&lng="+lng+"&name="+place_name+"&id="+id+"&month="+month;
            location.href=url;
           // console.log(id);


       }
      </script>
</body>

</html>

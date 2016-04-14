<!DOCTYPE html>
<html lang="en" ng-app="myApp">

<head>
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
    <link href="css/index.css" rel="stylesheet">
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
                      <li class="active take-all-space" style="width:30%;"><a href="#search" data-toggle="tab" >
                          Create New Trip</a></li>
                      <li class="take-all-space" style="width:30%;"><a href="#open" data-toggle="tab" >Open Current Trip</a></li>
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
                                    <input id="day" class="form-control" type="number" placeholder="Number of days" style="margin-top:2%;" min="1" max="5">
                                    <br/>
                                    <button class="btn btn-primary btn-block" onclick="send()" type="button">Begin</button>

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
                                    <input id="pac-input" class="form-control" type="text" placeholder="Start Searching for a palce">
                                    <br/>
                                    <button class="btn btn-primary btn-block" onclick="send()" type="button">Begin</button>

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
        function send()
        {
            console.log(place.geometry.location.lat());
            console.log(place.geometry.location.lng());
            var url="photos.php?lat="+place.geometry.location.lat()+"&lng="+place.geometry.location.lng()+"&name="+place.name;
            location.href=url;
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7Kb6lhE3dA4201a82tu9CNGkvsOuaI3M&libraries=places&callback=initMap">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <script src="js/bootstrap.min.js"></script>

</body>

</html>

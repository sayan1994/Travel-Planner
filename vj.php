
<!DOCTYPE html>
<html>
<head>
      <title>Simple Map</title>
      <meta name="viewport" content="initial-scale=1.0">
      <meta charset="utf-8">
      <style>
      html, body {
            height: 100%;
            margin: 0;
            padding: 0;
      }
      #map {
            height: 65%;
            width: 50%;
            margin-left: 25%;
            margin-right: 25%;
            padding-left: 15px;
            padding-right: 15px;
      }
      </style>
      <!--Import Google Icon Font-->
      <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

      <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
      <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
      <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
      <link href="maps.css" rel="stylesheet">

      <!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDuxFcGAqDhylkrC-QB0cV3usJ5izuXFho&libraries=places&callback=initMap"></script> -->
</head>
<body>



      <div class="row">
            <div class="col-sm-3"> </div>
            <div class="col-sm-6">
                  <div class="selection">
                    		Hotels<input type="checkbox" id="showHotels" onclick="showHotels();"/>
                    		Photos<input type="checkbox" id="showPhotos" onclick="showPhotos();"/>
                  </div>
            </div>
            <div class="col-sm-3"> </div>
      </div>
      <div  id="map"></div>
      <input id = "pac-input" size="75" class="autocomplete" type = "text" placeholder="Start typing here">
      <script>
      var hotel_marker = [];
      var markers=[];
      var map;
      function initMap() {

            var geolocation= {
                  lat: 23.402765,
                  lng: 78.662109
            };
            map = new google.maps.Map(document.getElementById('map'), {
                  center: geolocation,
                  zoom: 4,
                  zoomControl: false,
                  mapTypeControl: true,
                  mapTypeControlOptions: {
                        style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
                  },
                  fullscreenControl: true
            });
            var defaultBounds = new google.maps.LatLngBounds(
                  new google.maps.LatLng(39.5899447,97.0556699),
                  new google.maps.LatLng(3.3596552,66.2570438));
                  var options = {
                        bounds: defaultBounds,
                        types: ['(regions)']
                  };

                  var input = document.getElementById('pac-input');
                  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

                  var autocomplete = new google.maps.places.Autocomplete(input, options);
                  autocomplete.bindTo('bounds', map);
                  autocomplete.addListener('place_changed', function() {
                        deleteMarkers();
                        var place = autocomplete.getPlace();
                        weather(place.name);
                        map.setCenter(place.geometry.location);
                        map.setZoom(14);
                        console.log("this"+place.place_id);
                        search_restaurants(place.geometry.location);
                        find_Photos(place);
                  });
            }

            function search_restaurants(geolocation){
                  var pyrmont =geolocation;

                  var service = new google.maps.places.PlacesService(map);
                  service.nearbySearch({
                        location: pyrmont,
                        radius: 20000,
                        type: ['lodging']
                  }, callback);
            }

            function callback(results, status) {
                  if (status == google.maps.places.PlacesServiceStatus.OK) {
                      alert(results.length);
                        for (var i = 0; i < results.length; i++) {

                              var place_id = results[i].place_id;
                              var request = {
                                    placeId: place_id
                              };
                              var service = new google.maps.places.PlacesService(map);
                              service.getDetails(request,callback_id);
                        }
                  }
            }

            function callback_id(place, status){
                console.log(status);
                  if(status == google.maps.places.PlacesServiceStatus.OK){
                        //console.log("print in");
                        createMarker(place);
                  }
            }

            function createMarker(place) {
                  var placeLoc = place.geometry.location;
                  var marker = new google.maps.Marker({
                        map: null,
                        position: place.geometry.location
                  });
                  hotel_marker.push(marker);
                  var infowindow = new google.maps.InfoWindow({
                        content: ""
                  });

                  google.maps.event.addListener(marker, 'click', function() {
                        infowindow.setContent(place.name);
                        infowindow.open(map, this);
                  });
            }

            function setMapOnAll(map){
                  for (var i = 0; i < hotel_marker.length; i++) {
                        hotel_marker[i].setMap(map);
                  }
                //   for (var i = 0; i < markers.length; i++) {
                //         markers[i].setMap(map);
                //   }
            }

            function deleteMarkers(){
                  setMapOnAll(null);
                  hotel_marker = [];
            }

            function showHotels(){
                  if(document.getElementById('showHotels').checked){
                        alert("checked");
                        setMapOnAll(map);
                  }
                  else{
                        alert("not-checked");
                        setMapOnAll(null);
                  }
            }

            function find_Photos(place){
                  alert(place.geometry.location.lat());
                  alert("Asdfghhhhh");
                  $.getJSON("https://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=d8dd5db1ed7bc9c7e973ad037b6376de&min_upload_date=01-01-2013&max_upload_date=01-03-2016&accuracy=6&has_geo=1&lat="+place.geometry.location.lat()+"&lon="+place.geometry.location.lng()+"&radius=8&radius_units=mi&has_geo=1&extras=geo&format=json&jsoncallback=?", displayImages3);
                        function displayImages3(data){
                                                            alert("asdff");
                                                            //alert(data.len);
                      //Loop through the results in the JSON array. The 'data.photos.photo' bit is what you are trying to 'get at'. i.e. this loop looks at each photo in turn.
                    $.each(data.photos.photo, function(i,item){
                                    //alert("Asdfgf");
                              //Read in the lat and long of each photo and stores it in a variable.
                              //alert(item.ispublic);
                    lat = item.latitude;
                              long1 = item.longitude;
                              var photo_id=item.id;

                              //alert(lat);
                              //alert(long1);
                              //Get the url for the image.
                              var photoURL = 'https://farm' + item.farm + '.static.flickr.com/' + item.server + '/' + item.id + '_' + item.secret + '_m.jpg';
                              htmlString = '<img src="' + photoURL + '">';
                              var contentString = '<div id="content">' + htmlString + '</div>';
                    var image = {
                        url:photoURL,
                        // This marker is 20 pixels wide by 32 pixels high.
                        size: new google.maps.Size(40, 40),
                        // The origin for this image is (0, 0).
                        //origin: new google.maps.Point(0, 0),
                        // The anchor for this image is the base of the flagpole at (0, 32).
                        //anchor: new google.maps.Point(0, 32)
                      };
                              //Create a new info window using the Google Maps API
                              var infowindow = new google.maps.InfoWindow({
                                     //Adds the content, which includes the html to display the image from Flickr, to the info window.
                                     content: contentString
                              });
                              //Create a new marker position using the Google Maps API.
                              var myLatlngMarker = new google.maps.LatLng(lat,long1);
                              //Create a new marker using the Google Maps API, and assigns the marker to the map created below.
                              var marker = new google.maps.Marker({
                              position: myLatlngMarker,
                        map: null,
                        title:"Photo",
                    icon : image
                              });
                    markers.push(marker);
                    //infowindow.open(map,marker);
                              //Uses the Google Maps API to add an event listener that triggers the info window to open if a marker is clicked.
                              google.maps.event.addListener(marker, 'mouseover', function() {
                              infowindow.open(map,marker);
                              });
                    google.maps.event.addListener(infowindow, 'mouseout', function() {
                              infowindow.close(map,marker);
                              });
            });
}

            }

            function showPhotos()
            {
                  if(document.getElementById('showPhotos').checked){
                        alert("checked");
                        for (var i = 0; i < markers.length; i++) {
                        markers[i].setMap(map);
                  }
                  }
                  else{
                        alert("not-checked");
                        setMapOnAll(null);
                  }
            }
            </script>

            <script>
            function weather(place_name){

                  console.log("lol");

                  $url = "http://api.openweathermap.org/data/2.5/weather?q=" + place_name;
                  $url1= "&appid=b1b15e88fa797225412429c1c50c122a&units=metric&cnt=16";
                  $url = $url + $url1;
                  console.log($url);

                  $.getJSON($url, function(data) {
                        console.log(data);
                        // var txt1 = document.createElement("p");
                        // txt1.innerHTML = "Longitude of "+place_name+" is " + data.coord.lon;
                        //
                        // var txt2 = document.createElement("p");
                        // txt2.innerHTML = "Latitude of "+place_name+" is " + data.coord.lat;
                        //
                        // var txt3 = document.createElement("p");
                        // txt3.innerHTML = "Temperature of "+place_name+" is " + data.main.temp;
                        //
                        // var txt4 = document.createElement("p");
                        // txt4.innerHTML = "Max. Temperature of "+place_name+" is " + data.main.temp_max;
                        //
                        // var txt5 = document.createElement("p");
                        // txt5.innerHTML = "Min. Temperature of "+place_name+" is " + data.main.temp_min;
                        //
                        // var txt6 = document.createElement("p");
                        // txt6.innerHTML = "Humidity of "+place_name+" is " + data.main.humidity +"%";
                        //
                        // var txt7 = document.createElement("p");
                        // txt7.innerHTML = "Cloudiness of "+place_name+" is " + data.clouds.all +"%";
                        //
                        //
                        // $('#first').append(txt1,txt2,txt3,txt4,txt5,txt6,txt7);


                  });

            }
            </script>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDD6mu4eu4VokL-tMlJDuajSnG1kKrubSs&libraries=places&callback=initMap"
            async defer></script>
      </body>
      </html>
      <!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDuxFcGAqDhylkrC-QB0cV3usJ5izuXFho&libraries=places"></script>

      <body>
      <input id = "pac-input" size="50" class="controls" type = "text" placeholder="Start typing here">
      <div id = "map-canvas"></div>
</body>
<script>
var defaultBounds = new google.maps.LatLngBounds(
new google.maps.LatLng(39.5899447,97.0556699),
new google.maps.LatLng(3.3596552,66.2570438));
var options = {
bounds: defaultBounds,
types: ['(regions)']
};

var input = document.getElementById('pac-input');
map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

var autocomplete = new google.maps.places.Autocomplete(input, options);
</script> -->

function initMap(){
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


    var client_id = 'YLFF5TRSVDMGX0512KRIHJLWQZIN1P2ABKUL0YDBQT5CM1GJ';
    var client_secret = '0G2DNLD0A2L0FDQA5QPR2IJZNEW3Q5CRUY3FFS4P3XHTDUQS';
    var base_url = 'https://api.foursquare.com/v2/';
    var endpoint = 'venues/explore?';

    var params;
    var key = '&client_id=' + client_id + '&client_secret=' + client_secret + '&v=' + '20140626';
    var url = base_url + endpoint + "ll=28.6,76.8&radius=50000&query=attractions" + key;
    var x = [];
    var markers = [];
    var contents = [];
    var k = 0;
    var new_url=[];
    var venuek=[];
    var start_dest=new google.maps.LatLng(28.6,76.8);
    //var directionsService = [];
    //set up map
    $.get(url, function(result) {
        //$('#msg pre').text(JSON.stringify(url));
        $('#msg pre').text(JSON.stringify(result));
        //alert(result.response.groups.type);
        var groups = result.response.groups;
        alert(groups.length);
        for (var j in groups) {
            var venues = groups[j].items;
            alert(venues.length);
            //printVenues(venues);
            //alert("out");
            for (var i in venues) {
                var venue = venues[i];
                venuek[k]=venue;
                // alert(venue.venue.id);
                // place the a marker on the map

                var place_id = venue.venue.id;
                var new_key = 'client_id=' + client_id + '&client_secret=' + client_secret + '&v=' + '20160401';
                new_url[k] = 'https://api.foursquare.com/v2/venues/'+place_id+'/photos?'+new_key;
                new_url[k].index=k;
                (function retr_photo(k){
                console.log("name = "+venue.venue.name+"\nrating = "+venue.venue.rating);
                console.log("new_url = "+new_url[k]);
                $.get(new_url[k], function(new_result){
                      var photos=new_result.response.photos.items;
                      var photo_url=photos[0].prefix+"original"+photos[0].suffix;
                      console.log(photo_url);
                      console.log(venuek[k].venue.name);
                });
            })(k);

                markers[k] = new google.maps.Marker({
                    position: new google.maps.LatLng(venue.venue.location.lat, venue.venue.location.lng),
                    map: map
                });
                //markers.push(marker);
                markers[k].index = k;
                contents[k] = venue.venue.name;
                x[k] = new google.maps.InfoWindow({
                    content: contents[k],
                    maxWidth: 300
                });
                google.maps.event.addListener(markers[k], 'click', function() {
                    //x[this.index].setContent(this.html);
                    x[this.index].open(map, this);
                });
                //start_dest=markers[k].getPosition();
                k = k + 1;

            }
        }
    });


}

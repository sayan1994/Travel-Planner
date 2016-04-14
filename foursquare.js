// There are lots of ways to search. See: https://developer.foursquare.com/docs/venues/search
// Try stuff out with the API Exporer: https://developer.foursquare.com/docs/explore
/*
https://api.foursquare.com/v2/venues/search?near=NYU
&oauth_token=3FFPGFHJDBSIFINX045
&v=20140626

*/
var client_id = 'YLFF5TRSVDMGX0512KRIHJLWQZIN1P2ABKUL0YDBQT5CM1GJ';
var client_secret = '0G2DNLD0A2L0FDQA5QPR2IJZNEW3Q5CRUY3FFS4P3XHTDUQS';
var base_url = 'https://api.foursquare.com/v2/';
var endpoint = 'venues/explore?';

var params;
var key = '&client_id=' + client_id + '&client_secret=' + client_secret + '&v=' + '20140626';
var url = base_url+endpoint+"ll=40.7058316,-74.2581962&radius=50000&query=attractions"+key;
 var x=[];
 var markers=[];
 var contents=[];
 var k=0;
//set up map
var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 8,
      center: new google.maps.LatLng(40.7058316,-74.2581962),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
$.get(url, function (result) {
    //$('#msg pre').text(JSON.stringify(url));
    $('#msg pre').text(JSON.stringify(result));
    //alert(result.response.groups.type);
    var groups=result.response.groups;
    alert(groups.length);
    for(var j in groups)
    {
    var venues = groups[j].items;
    alert(venues.length);
    //printVenues(venues);
    //alert("out");
    for (var i in venues){
        var venue = venues[i];
       // alert(venue.venue.id);
        // place the a marker on the map
        markers[k] = new google.maps.Marker({
            position: new google.maps.LatLng(venue.venue.location.lat,venue.venue.location.lng),
            map: map
          });
          //markers.push(marker);
          markers[k].index=k;
          contents[k]=venue.venue.name;
          x[k]=new google.maps.InfoWindow({
        content: contents[k],
        maxWidth: 300
    });
                  google.maps.event.addListener(markers[k], 'click', function() {
                        //x[this.index].setContent(this.html);
                        x[this.index].open(map, this);
                  });
    k=k+1;
    }
    }
    });


function printVenues(venuesArr){
    for (var i in venuesArr){
        var venue = venuesArr[i];
        var str = '<p><strong>' + venue.name + '</strong> ';
        str += venue.location.lat + ',';
        str += venue.location.lng;
        str += '</p>';
        $('#display').append(str);
        $('#display').append("\n");
    }
}

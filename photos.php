<!DOCTYPE html>
<html>
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
$lat=$_GET['lat'];
$lng=$_GET['lng'];
$place_name=$_GET['name'];
$id=$_GET['id'];
$query="Select no_of_days from Mapping where id=$id";
$res=mysqli_query($link,$query);
$no_of_days=mysqli_fetch_array($res)[0];
$month=$_GET['month'];
$ar=array('lat'=> $lat , 'lng'=>$lng);
$query="Select photo_url,day,lat,lng,place_name from Trip where id=$id";
$res=mysqli_query($link,$query);
$pr=array();
$dr=array();
$display=array();
while($row=mysqli_fetch_array($res))
{
    $pr[]=$row[0];
    $dr[]=$row[1];
    $display[]=array('lat'=>$row[2],'lng'=>$row[3],'name'=>$row[4],'day'=>$row[1]);
}
$query="Select place_name,day from Trip where id=$id order by day";
$res=mysqli_query($link,$query);
$already_sch=array();
while($row=mysqli_fetch_array($res))
{
    $already_sch[]=array('name'=>$row[0],'day'=>$row[1]);
}
?>
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
    <link href="css/maps.css" rel="stylesheet">
    <link href="css/spage.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- <script src="js/photos.js"></script> -->
    <link href="css/photos.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/circle.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">

</head>

<body style="padding:0;overflow:hidden;">

    <div>
        <nav class="navbar navbar-inverse" style="margin-bottom:0">
            <div>

                <button align="center" style="width:10%;margin-top:0%;margin-left:75%;float:left;" id="create" class="btn btn-warning btn-block" onclick="newtrip()" type="button">Create New Trip</button>


                <button style="width:8%;margin-top:1%;margin-left:90%" class="btn btn-warning btn-block" onclick="logout()" type="button">LOG OUT</button>

            </div>
        </nav>
    </div>
    <!-- <nav class="navbar navbar-inverse navbar-fixed-top">

    <div >
    <button align="center" style="width:10%;margin-top:1%;margin-left:80%;background-color:orange;"   id="create" class="btn btn-warning btn-block" onclick="send(this)" type="button">Create New Trip</button>
</div>

</nav> -->


<div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Schedule on</h4>
            </div>
            <div class="modal-body">
                <p id="hid"></p>
                <p id="hidden" hidden></p>
                <?php

                $i=0;
                while($i<$no_of_days)
                {
                    echo  "<button  id=\"day".$i."\" class=\"btn btn-primary btn-block\" onclick=\"send(this)\" type=\"button\">Day ".$i."</button>";
                    $i=$i+1;
                }

                ?>
                <!-- <input type="time" class="form-control" placeholder="Enter time of visit"> -->

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<div class="modal fade " id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Schedule on</h4>
            </div>
            <div class="modal-body"  style="width:100%;height:500px;overflow-y:scroll;">
                <div class="sched_day">
                    <?php


                    $i=0;
                    while($i<$no_of_days)
                    {
                        echo "<p id=\"daytag".$i."\" class=\"day_tag\">Day ".$i."</p>";
                        echo "<ul id=\"ullist".$i."\" style=\"list-style-type:circle\" class=\"list\">";
                        $j=0;
                        $lim=count($already_sch);
                       // echo $lim;
                        while($j <$lim)
                        {
                            if($i==intval($already_sch[$j]['day']))
                            {
                                echo "<li id=\"".$already_sch[$j]['name']."\">";
                                echo $already_sch[$j]['name'];
                                echo "</li>";
                            }
                            $j=$j+1;
                        }
                        echo "</ul>";
                        $i=$i+1;
                    }
                    ?>

                </div>
                    <div id="map2">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<!--  <div class="content" style="background-color:white;margin-top:1%;"> -->

<div class="col-md-3" style="margin-right:-1px;height:80%;padding-right:0px;background-color:#e6e6e6;">
    <div id="test_wiki">
        <div class="back" id="back_wiki" onclick="back_wiki()">
            <span class="glyphicon glyphicon-arrow-left" style="color:black;font-size:30px;"></span>
        </div>
        <div class="details">
            <p class="wiki_name" style="font-align:center;" ><?php echo $place_name; ?></p>
            <img src="<?php

               $aContext = array(
                    'http' => array(
                     'proxy' => '10.3.100.207:8080',
                     'request_fulluri' => true,
                    ),
                    );
                $cxContext = stream_context_create($aContext);
                $url="https://en.wikipedia.org/w/api.php?format=xml&action=query&prop=pageimages&pithumbsize=2000&titles=".urlencode($place_name);
                   // echo $url;
                    $sFile = file_get_contents($url, False, $cxContext);
                    $xml=simplexml_load_string($sFile) or die("Error: Cannot create object");
                    $image=$xml->query[0]->pages[0]->page[0]->thumbnail['source'];
                    echo $image;
             ?>" style="width: 300px;height: 220px;margin-left:4%"/>

            <p style="margin-left:2%;" ><?php
                $aContext = array(
                    'http' => array(
                     'proxy' => '10.3.100.207:8080',
                     'request_fulluri' => true,
                    ),
                    );
                    $cxContext = stream_context_create($aContext);
                    $url="https://en.wikipedia.org/w/api.php?format=xml&action=query&prop=extracts&exintro=&explaintext=&titles=".urlencode($place_name);
                    $sFile = file_get_contents($url, False, $cxContext);
                    $xml=simplexml_load_string($sFile) or die("Error: Cannot create object");
                    $ext=$xml->query[0]->pages[0]->page[0]->extract[0];
                    echo $ext;

            ?></p>

        </div>
    </div>
    <div class="row" style="padding-bottom:0px;" onclick="display_wiki()">
            <p class="city_name" style="font-align:center;"><?php echo $place_name;?></p>
    </div>
    <div class="row">
        <div class="col-md-8" style="width:80%;">
            <button data-toggle="modal" data-target="#myModal"  id="view_trip" class="btn btn-primary btn-block"  type="button">View Trip</button>
        </div>
    </div>
    <div class="container" style="margin:0;margin-bottom:1%; padding:0; width:100%;height:5%;">
        <ul class="nav nav-tabs">
            <li class="active" style="width:15%;"><a style="padding-left:0;" href="#travel" id="Travel" data-toggle="tab">Travel</a></li>
            <li style="width:30%;"><a style="padding-left:0" href="#restaurants" id="Restaurants" data-toggle="tab">Restaurants</a></li>
            <li ><a style="padding-left:0" href="#hotels" id="Hotels" data-toggle="tab">Hotels</a></li>
            <li ><a style="padding-left:0" href="#weather" id="Weather"  data-toggle="tab">Weather</a></li>
            <li><a style="padding-left:0" href="#gallery" id="Gallery"  data-toggle="tab">Gallery</a></li>
        </ul>
    </div>




<hr style="height:5%;padding:0;margin:0px;">
<div class="tab-content" style="width:100%;height:85%;overflow:scroll;">
    <div class="tab-pane active" id="travel">
        <div id="test">
            <div class="back" id="back" onclick="back()">
                <p id="back_data" hidden></p>
                <span class="glyphicon glyphicon-arrow-left" style="color:black;font-size:30px;"></span>
            </div>
            <div class="image" style="overflow:hidden;height:36%;">
                <img id="slide_img" src="https://irs2.4sqi.net/img/general/original/VdaUSeUzNNF6lPHUgIgj09cAxxToi2UE_gdkn8XyAF0.jpg">
            </div>
            <div class="details">
                <p class="place_name" id="slide_name">Rashtrapati Bhawan</p>
                <p class="place_details" id="slide_details">sdkfhbsdkjf nseofhzosfjzsepfi sOEIFJZsoepifjdsiz fpsiefjzodiksjzn osierfhzjzspigfsrgzj szfijsrpigfj prwizjgpsrijgrsp
                    srzlgihzsrogfhrsog rozgorsijgsr rposijgrpsijgisr</p>
            </div>
        </div>
        <div id="photos"  class="places" style="height:80%;width:100%;background-color:#e6e6e6">

        </div>
    </div>
    <div class="tab-pane" id="restaurants">
        <div id="test_rest">
            <div class="back"  onclick="back_rest()">
                <span class="glyphicon glyphicon-arrow-left" style="color:black;font-size:30px;"></span>
            </div>
            <div class="image" style="overflow:hidden;height:36%;">
                <img id="slide_img_rest" src="https://irs2.4sqi.net/img/general/original/VdaUSeUzNNF6lPHUgIgj09cAxxToi2UE_gdkn8XyAF0.jpg">
            </div>
            <div class="details">
                <p class="place_name" id="slide_name_rest">Rashtrapati Bhawan</p>
                <p class="place_details" id="slide_details_rest">sdkfhbsdkjf nseofhzosfjzsepfi sOEIFJZsoepifjdsiz fpsiefjzodiksjzn osierfhzjzspigfsrgzj szfijsrpigfj prwizjgpsrijgrsp
                    srzlgihzsrogfhrsog rozgorsijgsr rposijgrpsijgisr</p>

            </div>
        </div>
        <div id="photos_rest"  class="places" style="height:80%;width:100%;background-color:#e6e6e6">

        </div>
    </div>
    <div class="tab-pane" id="hotels">
        <div id="test_hot" style="height:85%;">
            <div class="back"  onclick="back_hot()">
                <span class="glyphicon glyphicon-arrow-left" style="color:black;font-size:30px;"></span>
            </div>
            <div class="image" style="overflow:hidden;height:36%;">
                <img id="slide_img_hot" src="https://irs2.4sqi.net/img/general/original/VdaUSeUzNNF6lPHUgIgj09cAxxToi2UE_gdkn8XyAF0.jpg">
            </div>
            <div class="details">
                <p class="place_name" id="slide_name_hot">Rashtrapati Bhawan</p>
                <p class="place_details" id="slide_details_hot">sdkfhbsdkjf nseofhzosfjzsepfi sOEIFJZsoepifjdsiz fpsiefjzodiksjzn osierfhzjzspigfsrgzj szfijsrpigfj prwizjgpsrijgrsp
                    srzlgihzsrogfhrsog rozgorsijgsr rposijgrpsijgisr</p>
                    <p class="tag">Address</p>
                    <p class="place_details data" id="slide_address_hot"></p>
                    <p class="tag">Rating</p>
                    <p class="place_details data" id="slide_rating_hot"></p>
                    <p class="tag">Contact No.</p>
                    <p class="place_details data" id="slide_phone_hot"></p>
                    <p class="tag">Hotel Webiste</p>
                    <p class="place_details data" href id="slide_url_hot"></p>
            </div>
        </div>
        <div id="photos_hotel"  class="places" style="height:80%;width:100%;background-color:#e6e6e6">

        </div>
    </div>
    <div class="tab-pane" id="gallery">

        <div id="photos_gallery"  class="places" style="height:80%;width:100%;background-color:#e6e6e6">

        </div>
    </div>
    <div class="tab-pane" id="weather" style="overflow-x:hidden;">
        <?php
                            include 'connection.php';
                            $link=mysqli_connect($db_host,$db_username,$db_password,$db_name) or die("cannot connect");
                            $query="Select * from weather where name = '$place_name' and month =$month";
                            $result = mysqli_query($link,$query);
                            $num = mysqli_num_rows($result);
                            if($num == 0)
                            {
                                $yes = 0;
                            }
                            else
                            {
                                $yes = 1;
                                $row = mysqli_fetch_row($result);
                                $name = $row[0];
                                $average_humidity = $row[1];
                                $average_humidity = number_format($average_humidity,2);
                                $average_precipitation = $row[2];
                                $average_precipitation = number_format($average_precipitation,4);
                                $windspeed = $row[3];
                                $windspeed = number_format($windspeed,2);
                                $max_temp = $row[4];
                                $min_temp = $row[5];
                                $month = $row[6];
                                $average_temp = $row[7];
                                $average_temp = number_format($average_temp,2);
                            }


                            if($yes == 1)
                            {
                                echo "<div class=\"jumbotron\" style=\"box-shadow: 1px 1px 5px #888888;background-color:white;\"><div class=\"row\">
                                <div class=\"col-sm-3\" style=\"padding-right:0px;\">
                                <img src=\"temp.jpg\">
                                </div>
                                <div class=\"col-sm-8\"  style=\"padding-left:0px;font-size:10%;\"><p>The max. temp for $place_name = $max_temp<sup>o</sup>C</p>
                                <p>The min. temp for $place_name = $min_temp<sup>o</sup>C</p>
                                <p>The avg. temp for $place_name = $average_temp<sup>o</sup>C</p></div>
                                </div>
                                </div>
                                <div class=\"jumbotron\" style=\"box-shadow: 1px 1px 5px #888888;background-color:white;\"><div class=\"row\">
                                <div class=\"col-sm-3\" style=\"padding-right:0px;\">
                                <img src=\"umbrella-rain.svg\">
                                </div>
                                <div class=\"col-sm-8\"  style=\"padding-left:0px;font-size:10%;\">
                                <p>The avg. precipitation for $place_name = $average_precipitation mm</p>
                                </div>
                                </div>
                                </div>
                                <div class=\"jumbotron\" style=\"box-shadow: 1px 1px 5px #888888;background-color:white;\"><div class=\"row\">
                                <div class=\"col-sm-3\" style=\"padding-right:0px;\">
                                <img src=\"wind.png\">
                                </div>
                                <div class=\"col-sm-8\"  style=\"padding-left:0px;font-size:10%;\">
                                <p>The windspeed for $place_name = $windspeed kmph</p>
                                </div>
                                </div>
                                </div>
                                <div class=\"jumbotron\" style=\"box-shadow: 1px 1px 5px #888888;background-color:white;\"><div class=\"row\">
                                <div class=\"col-sm-3\" style=\"padding-right:0px;\">
                                <img src=\"humid.png\">
                                </div>
                                <div class=\"col-sm-8\"  style=\"padding-left:0px;font-size:10%;\">
                                <p>The avg. humidity for $place_name = $average_humidity %</p>
                                </div>
                                </div>
                                </div>";
                            }
                            else
                            {
                               echo "<p>The weather for $place_name is not available</p>";
                            }
                        ?>
    </div>
</div>
</div>
    <div class="col-md-9 nopadding" style="margin-top:1%:padding:0px">
        <div id="map" style="height:100%; width:100%;">
        </div>
    </div>
    <!--  </div> -->

    <script>
    var pre_sch=<?php echo json_encode($display);?>;
    console.log("Fetched"+pre_sch);
    var set_lat=[];
    var set_lng=[];
    var set_content=[];
    var set_name=[];
    for(i=0;i<pre_sch.length;i++)
    {
        set_lat.push(pre_sch[i].lat);
        set_lng.push(pre_sch[i].lng);
        set_content.push("Scheduled on " + pre_sch[i].day);
        set_name.push(pre_sch[i].name);
    }
    console.log("Init "+set_lat.length);
    function schedulue(element)
    {
        console.log("Clicked");
        console.log(element.id);

    }
    function initialize(myCenter) {
        ////alert("here");
        var geolocation=new google.maps.LatLng(loc.lat,loc.lng);
      var mapProp = {
            center: geolocation,
            zoom: 13,
            zoomControl: false,
            mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
            },
            fullscreenControl: true
        };
        map2 = new google.maps.Map(document.getElementById("map2"), mapProp);
        var display_markers=[];
        var infoo=[];
        for(i=0;i<set_lat.length;i++)
        {
            ////alert("adljnsdfv");
            display_markers[i] = new google.maps.Marker({
                position: new google.maps.LatLng(set_lat[i], set_lng[i]),
                map: map2
            });
            //markers.push(marker);
            display_markers[i].index = i;
            infoo[i] = new google.maps.InfoWindow({
                content: set_name[i]+"\n"+set_content[i],
                maxWidth: 300
            });
            google.maps.event.addListener(display_markers[i], 'click', function() {
                //x[this.index].setContent(this.html);
                infoo[this.index].open(map2, this);
                // console.log("Clicked="+"img"+this.index);
                // display("img"+this.index);
            });
        }
    };
    $('#myModal').on('shown.bs.modal', function () {
        initialize(new google.maps.LatLng(20,30));
        resize()
    });
    function resize()
    {
        var h = $(window).height(),
        offsetTop = 60; // Calculate the top offset

        $('#map2').css('height', (h - offsetTop));
    }
    $('#myModal2').on('show.bs.modal', function (e) {
        //console.log("HIII");
        var invoker = $(e.relatedTarget);
        //console.log(invoker);
        var button_id=invoker.attr("id");
        console.log(button_id);
        var x=document.getElementById("hidden");
        x.innerHTML=button_id;
    });
    function newtrip()
    {
      location.href="newtrip.php";
    }
    var loc=<?php echo json_encode($ar) ?>;
    var venuek=[];
    var hotelk=[];
    var restk=[];
    var map2;
    var details=[];
    var details_hot=[];
    var photo_url=[];
    var photo_url_gallery=[];
    var gallery=[];
    var lat=[];
    var lng=[];
    var lat_hot=[];
    var rating=[];
    var hotel_url=[];
    var contact=[];
    var address=[];
    var lng_hot=[];
    var lat_rest=[];
    var lng_rest=[];
    var photo_url_rest=[];
    var details_rest=[];
    var markers = [];
    var photo_url_hot=[];
    var purl=<?php echo json_encode($pr);?>;
    var dpurl=<?php echo json_encode($dr);?>;
    var already_sch=<?php echo json_encode($already_sch);?>;

    console.log(dpurl);
    function send(element)
    {

        var x=document.getElementById("hidden").innerHTML;
        // place = new google.maps.Marker({
        //     position: new google.maps.LatLng(lat[x], lng[x]),
        //     map: map2
        // });
        // new_info = new google.maps.InfoWindow({
        //     content: "Scheduled on " + element.id,
        //     maxWidth: 300
        // });
        // google.maps.event.addListener(place, 'click', function() {
        //     //x[this.index].setContent(this.html);
        //     new_info.open(map2, this);
        // });
        console.log("Sending data to server");
        console.log(element.id);
        document.getElementById(x).innerHTML="Scheduled on " + element.id;
        document.getElementById(x).disabled=true;
        document.getElementById("d"+x).style.visibility='visible';
        console.log(x);
        console.log(venuek[x]);
        set_name.push(venuek[x]);
        console.log(details[x]);
        set_content.push("Scheduled on " + element.id);
        set_lat.push(lat[x]);
        set_lng.push(lng[x]);
        console.log(photo_url[x]);
        console.log(lat[x]);
        console.log(lng[x]);
        var day_id=element.id;
        var day=day_id.substring(3);
        var id=<?php $ar=array('id'=>$id) ;
        echo json_encode($ar);?>;
        console.log("day"+day);
        console.log("id="+id.id);
        var li= document.createElement("li");
        li.setAttribute("id",venuek[x]);
        li.innerHTML=venuek[x];
        console.log("ullist"+day);
        var parent=document.getElementById("ullist"+day);
        parent.appendChild(li);
        $.ajax(
        {
            url: "schedule.php",
            type:"post",
            dataType:"json",
            data:
            {
                id:id.id,
                place_name:venuek[x],
                photo_url:photo_url[x],
                details:details[x],
                lat:lat[x],
                lng:lng[x],
                day: day
            },

            success: function(json)
            {
                //////alert("SUCCESS");
                //////alert(json.status);
                console.log(json.status);

            },

            error : function()
            {
                ////alert("ERROR");
                //console.log("something went wrong");
            }
        });
        $('#myModal2').modal('hide');
    }
    function toggleBounce(mark) {
        //alert("here");
        //alert(mark);
      if (mark.getAnimation() !== null) {
        mark.setAnimation(null);
      } else {
        mark.setAnimation(google.maps.Animation.BOUNCE);
      }
  }
    $(window).resize(function () {
        var h = $(window).height(),
        offsetTop = 60; // Calculate the top offset

        $('#map').css('height', (h - offsetTop));
    }).resize();
    // (function() {

    //     var img = document.getElementById('container').firstChild;
    //     img.onload = function() {
    //         if(img.height > img.width) {
    //             img.height = '100%';
    //             img.width = 'auto';
    //         }
    //     };
    // }());
    var tt=0;
    function display(elem)
    {
        document.getElementById("back_data").innerHTML=elem;
        console.log(tt);
        console.log("HIII");
        console.log("ELEM="+elem);
        if(tt==0)
        {
            document.getElementById("test").style.transition="0.75s";
            document.getElementById("test").style.left=0;
             console.log(elem.substring(3));
            // console.log(photo_url[0]);
            document.getElementById("slide_img").setAttribute("src",photo_url[elem.substring(3)]);
            document.getElementById("slide_name").innerHTML=venuek[elem.substring(3)];
            document.getElementById("slide_details").innerHTML=details[elem.substring(3)];
            markers[elem.substring(3)].setAnimation(google.maps.Animation.BOUNCE);
          tt=1;
        }
        else {
            tt=0;
        }
    }
    var tt_wiki=0;
    function display_wiki()
    {
        //document.getElementById("back_data").innerHTML=elem;
        // console.log(tt);
        // console.log("HIII");
        // console.log("ELEM="+elem);
        if(tt==0)
        {
            document.getElementById("test_wiki").style.transition="0.75s";
             document.getElementById("test_wiki").style.left=0;
            //  console.log(elem.substring(3));
            // // console.log(photo_url[0]);
            // document.getElementById("slide_img_wiki").setAttribute("src",photo_url[elem.substring(3)]);
            // document.getElementById("slide_name_wiki").innerHTML=venuek[elem.substring(3)];
            // document.getElementById("slide_details_wiki").innerHTML=details[elem.substring(3)];
            // markers[elem.substring(3)].setAnimation(google.maps.Animation.BOUNCE);
          tt_wiki=1;
        }
        else {
            tt_wiki=0;
        }
    }
    var tt_rest=0;
    function display_rest(elem)
    {
        document.getElementById("back_data").innerHTML=elem;
        // console.log(tt);
        // console.log("HIII");
        // console.log("ELEM="+elem);
        if(tt_rest==0)
        {
            document.getElementById("test_rest").style.transition="0.75s";
            document.getElementById("test_rest").style.left=0;
             console.log(elem.substring(3));
            // console.log(photo_url[0]);
            document.getElementById("slide_img_rest").setAttribute("src",photo_url_rest[elem.substring(3)]);
            document.getElementById("slide_name_rest").innerHTML=restk[elem.substring(3)];
            document.getElementById("slide_details_rest").innerHTML=details_rest[elem.substring(3)];
            restaurant_marker[elem.substring(3)].setAnimation(google.maps.Animation.BOUNCE);
          tt_rest=1;
        }
        else {
            tt_rest=0;
        }
    }
    var tt_hot=0;
    function display_hot(elem)
    {
        document.getElementById("back_data").innerHTML=elem;
        // console.log(tt);
        // console.log("HIII");
        // console.log("ELEM="+elem);
        if(tt_hot==0)
        {
            ////alert("jere");
            document.getElementById("test_hot").style.transition="0.75s";
            document.getElementById("test_hot").style.left=0;
             console.log(elem.substring(3));
            // console.log(photo_url[0]);
            document.getElementById("slide_img_hot").setAttribute("src",photo_url_hot[elem.substring(3)]);
            document.getElementById("slide_name_hot").innerHTML=hotelk[elem.substring(3)];
            document.getElementById("slide_details_hot").innerHTML=details_hot[elem.substring(3)];
            document.getElementById("slide_rating_hot").innerHTML=rating[elem.substring(3)];
            document.getElementById("slide_url_hot").innerHTML=hotel_url[elem.substring(3)];
            document.getElementById("slide_address_hot").innerHTML=address[elem.substring(3)];
            document.getElementById("slide_phone_hot").innerHTML=contact[elem.substring(3)];
            hotel_marker[elem.substring(3)].setAnimation(google.maps.Animation.BOUNCE);
          tt_hot=1;
        }
        else {
            tt_hot=0;
        }
    }
    function selected(elem)
    {
        ////alert(elem.id);
        var div=document.getElementById(elem.id);
        div.style.backgroundColor="White";
        tt=0;
    }
    function back()
    {
        var elem=document.getElementById("back_data");
        ////alert(elem.innerHTML);
        document.getElementById("test").style.transition="0.75s";
        document.getElementById("test").style.left="-100%";
        markers[elem.innerHTML.substring(3)].setAnimation(null);
        tt=0;
    }
    function back_wiki()
    {
        //var elem=document.getElementById("back_data");
        ////alert(elem.innerHTML);
        document.getElementById("test_wiki").style.transition="0.75s";
        document.getElementById("test_wiki").style.left="-100%";
        //markers[elem.innerHTML.substring(3)].setAnimation(null);
        tt=0;
    }
    function back_rest()
    {
        ////alert(tt);
        var elem=document.getElementById("back_data");
        document.getElementById("test_rest").style.transition="0.75s";
        document.getElementById("test_rest").style.left="-100%";
        restaurant_marker[elem.innerHTML.substring(3)].setAnimation(null);
        tt_rest=0;
    }
    function back_hot()
    {
        ////alert(tt);
        var elem=document.getElementById("back_data");
        document.getElementById("test_hot").style.transition="0.75s";
        document.getElementById("test_hot").style.left="-100%";
        hotel_marker[elem.innerHTML.substring(3)].setAnimation(null);
        tt_hot=0;
    }
    function initMap(){
        // var geolocation= {
        //     lat: loc.lat,
        //     lng: loc.lng
        // };
        var geolocation=new google.maps.LatLng(loc.lat,loc.lng);
        map = new google.maps.Map(document.getElementById('map'), {
            center: geolocation,
            zoom: 13,
            zoomControl: false,
            mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
            },
            fullscreenControl: true
        });
        // map2 = new google.maps.Map(document.getElementById('map'), {
        //     center: geolocation,
        //     zoom: 13,
        //     zoomControl: false,
        //     mapTypeControl: true,
        //     mapTypeControlOptions: {
        //         style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
        //     },
        //     fullscreenControl: true
        // });

        var client_id = 'YLFF5TRSVDMGX0512KRIHJLWQZIN1P2ABKUL0YDBQT5CM1GJ';
        var client_secret = '0G2DNLD0A2L0FDQA5QPR2IJZNEW3Q5CRUY3FFS4P3XHTDUQS';
        var base_url = 'https://api.foursquare.com/v2/';
        var endpoint = 'venues/explore?';

        var params;
        var key = '&client_id=' + client_id + '&client_secret=' + client_secret + '&v=' + '20140626';
        var url = base_url + endpoint + "ll="+loc.lat+","+loc.lng+"&radius=50000&query=tourist" + key;
        var x = [];

        var contents = [];
        var k = 0;
        var new_url=[];

        var start_dest=new google.maps.LatLng(loc.lat,loc.lng);
        //var directionsService = [];
        //set up map
        console.log(url+"\ninit url\n");
        $.get(url, function(result) {
            //$('#msg pre').text(JSON.stringify(url));
            $('#msg pre').text(JSON.stringify(result));
            //////alert(result.response.groups.type);
            var groups = result.response.groups;
            // ////alert(groups.length);
            for (var j in groups) {
                var venues = groups[j].items;
                // ////alert(venues.length);
                //printVenues(venues);
                //////alert("out");
                for (var i in venues) {
                    var venue = venues[i];
                    venuek[k]=venue.venue.name;
                    details[k]=venue.venue.categories[0].name;
                    lat[k]=venue.venue.location.lat;
                    //  //alert(lat[k]);
                    lng[k]=venue.venue.location.lng;
                    // ////alert(venue.venue.id);
                    // place the a marker on the map

                    var place_id = venue.venue.id;
                    var new_key = 'client_id=' + client_id + '&client_secret=' + client_secret + '&v=' + '20160401';
                    new_url[k] = 'https://api.foursquare.com/v2/venues/'+place_id+'/photos?'+new_key;
                    new_url[k].index=k;
                    (function retr_photo(k){
                        $.get(new_url[k], function(new_result){
                            var photos=new_result.response.photos.items;
                            photo_url[k]=photos[0].prefix+"original"+photos[0].suffix;

                            var node = document.createElement("div");
                            node.setAttribute("class","named");
                            node.setAttribute("id","con");
                            node.setAttribute("style","box-shadow: 1px 1px 5px #888888;margin-bottom:1%;padding:0px;background-color:white;");
                            // console.log(photo_url[k]);
                            var node_img = document.createElement("img");
                            node_img.setAttribute("src",photo_url[k]);
                            node_img.setAttribute("style","width: 300px;height: 150px;");
                            node_img.setAttribute("id","img"+k);
                            node_img.setAttribute("onclick","display(this.id)");
                            var p1 = document.createElement("p");
                            //  console.log("p1=")
                            p1.setAttribute("style","margin:0px;");
                            //   p1.style.backgroundImage="url("+photo_url[k]+")";
                            //   p1.style.backgroundSize="100% 100%";

                            p1.innerHTML = venuek[k];
                            //
                            var p2 = document.createElement("p");
                            p2.setAttribute("style","font-size:100%;");
                            p2.innerHTML = details[k];

                            var but=document.createElement("button")
                            but.setAttribute("class","btn btn-primary btn-block");
                            but.setAttribute("id",k);
                            but.setAttribute("onlcick","schedule(this)");
                            but.setAttribute("type","button");
                            but.setAttribute("style","margin-bottom:0.5%;");
                            but.setAttribute("data-toggle","modal");
                            but.setAttribute("data-target","#myModal2");
                            but.innerHTML="Schedule";

                            var but1=document.createElement("button");
                            but1.setAttribute("class","btn btn-primary btn-block");
                            var hihi = "d"+k;
                            but1.setAttribute("id",hihi);
                            but1.setAttribute("type","button");
                            but1.setAttribute("onclick","reschedule(this)");
                            but1.setAttribute("style","visibility:hidden;margin-top:0%;margin-bottom:3%");
                            but1.innerHTML="Re-Schedule";

                            node.appendChild(node_img);
                            node.appendChild(p1);
                            node.appendChild(p2);
                            node.appendChild(but);
                            node.appendChild(but1);
                            document.getElementById("photos").appendChild(node);
                            for(i=0;i<purl.length;i++)
                            {
                                //console.log(purl[i]);
                                if(purl[i]===photo_url[k])
                                {
                                    console.log("HII"+i);
                                    document.getElementById(k).disabled=true;
                                    document.getElementById(k).innerHTML="Scheduled on Day "+dpurl[i];
                                    document.getElementById("d"+k).style.visibility='visible';
                                }
                            }
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
                    x[k].index=k;
                    // markers[k].addListener('click',toggleBounce);
                    google.maps.event.addListener(markers[k], 'click', function() {
                        //x[this.index].setContent(this.html);
                        x[this.index].open(map, this);
                        console.log("Clicked="+"img"+this.index);
                        display("img"+this.index);

                        // this.setAnimation(google.maps.Animation.BOUNCE);
                        //toggleBounce(this);
                    });
                    google.maps.event.addListener(x[k],'closeclick',function(){
                    //    markers[this.index].setAnimation(null);
                        back();
                    });
                    //start_dest=markers[k].getPosition();
                    k = k + 1;

                }
            }
        });
        search_hotels(geolocation);
        search_restaurants(geolocation);
        find_Photos();
    }
    var Tourist = document.getElementById('Travel');
    var Restaurants = document.getElementById('Restaurants');
    var Hotels = document.getElementById('Hotels');
    var Weather = document.getElementById('Weather');
    var Gallery = document.getElementById('Gallery');
    Tourist.onclick = showTourist;
    Restaurants.onclick = showRestaurants;
    Hotels.onclick = showHotels;
    Gallery.onclick = showGallery;

    var hotel_marker = [];
    var restaurant_marker = [];

    function showGallery() {
        ////alert("lol123");
       // //alert("hereeee");
        setMapOnAllHotels(null);
        setMapOnAllTourist(null);
        setMapOnAllRestaurants(null);
        setMaponAllGallery(map);
        return true;
    }
    function showHotels() {
        ////alert("lol123");
        setMapOnAllHotels(map);
        setMapOnAllTourist(null);
        setMapOnAllRestaurants(null);
        setMaponAllGallery(null);
        return true;
    }
    function showRestaurants() {

        setMapOnAllHotels(null);
        setMapOnAllTourist(null);
        setMapOnAllRestaurants(map);
        setMaponAllGallery(null);
        return true;
    }
    function showTourist() {
        ////alert("lol123");
        setMapOnAllHotels(null);
        setMapOnAllTourist(map);
        setMapOnAllRestaurants(null);
        setMaponAllGallery(null);
        return true;
    }

    function search_hotels(geolocation){
        // var pyrmont =geolocation;
        var client_id = 'YLFF5TRSVDMGX0512KRIHJLWQZIN1P2ABKUL0YDBQT5CM1GJ';
        var client_secret = '0G2DNLD0A2L0FDQA5QPR2IJZNEW3Q5CRUY3FFS4P3XHTDUQS';
        var base_url = 'https://api.foursquare.com/v2/';
        var endpoint = 'venues/explore?';

        var params;
        var key = '&client_id=' + client_id + '&client_secret=' + client_secret + '&v=' + '20140626';
        var url = base_url + endpoint + "ll="+loc.lat+","+loc.lng+"&radius=50000&query=hotels" + key;
        var x = [];

        var contents = [];
        var k = 0;
        var new_url=[];

        var start_dest=new google.maps.LatLng(loc.lat,loc.lng);
        //var directionsService = [];
        //set up map
        console.log(url+"\ninit url\n");
        $.get(url, function(result) {
            //$('#msg pre').text(JSON.stringify(url));
            $('#msg pre').text(JSON.stringify(result));
            //////alert(result.response.groups.type);
            var groups = result.response.groups;
            // ////alert(groups.length);
            for (var j in groups) {
                var venues = groups[j].items;
                // ////alert(venues.length);
                //printVenues(venues);
                //////alert("out");
                for (var i in venues) {
                    var venue = venues[i];
                    hotelk[k]=venue.venue.name;
                    console.log(hotelk[k]);
                    details_hot[k]=venue.venue.categories[0].name;
                    lat_hot[k]=venue.venue.location.lat;
                    lng_hot[k]=venue.venue.location.lng;
                    // ////alert(venue.venue.id);
                    // place the a marker on the map
                    contact[k]=venue.venue.contact.phone;
                    console.log(contact[k]);
                    address[k]=venue.venue.location.formattedAddress;
                    console.log(address[k]);
                    hotel_url[k]=venue.venue.url;
                    rating[k]=venue.venue.rating;
                    var place_id = venue.venue.id;
                    var new_key = 'client_id=' + client_id + '&client_secret=' + client_secret + '&v=' + '20160401';
                    new_url[k] = 'https://api.foursquare.com/v2/venues/'+place_id+'/photos?'+new_key;
                    new_url[k].index=k;
                    (function retr_photos(k){
                        $.get(new_url[k], function(new_result){
                            var photos=new_result.response.photos.items;
                            photo_url_hot[k]=photos[0].prefix+"original"+photos[0].suffix;

                            var node = document.createElement("div");
                            node.setAttribute("class","named");
                            node.setAttribute("id","con");
                            node.setAttribute("style","box-shadow: 1px 1px 5px #888888;margin-bottom:1%;padding:0px;background-color:white;");
                            // console.log(photo_url[k]);
                            var node_img = document.createElement("img");
                            node_img.setAttribute("src",photo_url_hot[k]);
                            node_img.setAttribute("style","width: 300px;height: 150px;");
                            node_img.setAttribute("id","img"+k);
                            node_img.setAttribute("onclick","display_hot(this.id)");
                            var p1 = document.createElement("p");
                            //  console.log("p1=")
                            p1.setAttribute("style","margin:0px;");
                            //   p1.style.backgroundImage="url("+photo_url[k]+")";
                            //   p1.style.backgroundSize="100% 100%";

                            p1.innerHTML = hotelk[k];
                            //
                            var p2 = document.createElement("p");
                            p2.setAttribute("style","font-size:100%;");
                            p2.innerHTML = details_hot[k];

                            // var but=document.createElement("button")
                            // but.setAttribute("class","btn btn-primary btn-block");
                            // but.setAttribute("id",k);
                            // but.setAttribute("onlcick","schedule(this)");
                            // but.setAttribute("type","button");
                            // but.setAttribute("style","margin-bottom:5%;");
                            // but.setAttribute("data-toggle","modal");
                            // but.setAttribute("data-target","#myModal2");
                            // but.innerHTML="Schedule";

                            node.appendChild(node_img);
                            node.appendChild(p1);
                            node.appendChild(p2);
                            // node.appendChild(but);
                            document.getElementById("photos_hotel").appendChild(node);
                            // for(i=0;i<purl.length;i++)
                            // {
                            //     //console.log(purl[i]);
                            //     if(purl[i]===photo_url[k])
                            //     {
                            //         console.log("HII"+i);
                            //         document.getElementById(k).disabled=true;
                            //         document.getElementById(k).innerHTML="Scheduled on Day "+dpurl[i];
                            //     }
                            // }
                        });
                    })(k);

                    hotel_marker[k] = new google.maps.Marker({
                        position: new google.maps.LatLng(venue.venue.location.lat, venue.venue.location.lng),
                        map: null
                    });
                    //markers.push(marker);
                    hotel_marker[k].index = k;
                    contents[k] = venue.venue.name;
                    x[k] = new google.maps.InfoWindow({
                        content: contents[k],
                        maxWidth: 300
                    });
                    google.maps.event.addListener(hotel_marker[k], 'click', function() {
                        //x[this.index].setContent(this.html);
                        x[this.index].open(map, this);
                        console.log("Clicked="+"img"+this.index);
                        display_hot("img"+this.index);
                    });
                    google.maps.event.addListener(x[k],'closeclick',function(){
                    //    markers[this.index].setAnimation(null);
                        back();
                    });
                    //start_dest=markers[k].getPosition();
                    k = k + 1;

                }
            }
        });
}
    function search_restaurants(geolocation){
        var client_id = 'YLFF5TRSVDMGX0512KRIHJLWQZIN1P2ABKUL0YDBQT5CM1GJ';
        var client_secret = '0G2DNLD0A2L0FDQA5QPR2IJZNEW3Q5CRUY3FFS4P3XHTDUQS';
        var base_url = 'https://api.foursquare.com/v2/';
        var endpoint = 'venues/explore?';

        var params;
        var key = '&client_id=' + client_id + '&client_secret=' + client_secret + '&v=' + '20140626';
        var url = base_url + endpoint + "ll="+loc.lat+","+loc.lng+"&radius=50000&query=restaurants" + key;
        var x = [];

        var contents = [];
        var k = 0;
        var new_url=[];

        var start_dest=new google.maps.LatLng(loc.lat,loc.lng);
        //var directionsService = [];
        //set up map
        console.log(url+"\ninit url\n");
        $.get(url, function(result) {
            //$('#msg pre').text(JSON.stringify(url));
            $('#msg pre').text(JSON.stringify(result));
            //////alert(result.response.groups.type);
            var groups = result.response.groups;
            // ////alert(groups.length);
            for (var j in groups) {
                var venues = groups[j].items;
                // ////alert(venues.length);
                //printVenues(venues);
                //////alert("out");
                for (var i in venues) {
                    var venue = venues[i];
                    restk[k]=venue.venue.name;
                    console.log(hotelk[k]);
                    details_rest[k]=venue.venue.categories[0].name;
                    lat_rest[k]=venue.venue.location.lat;
                    lng_rest[k]=venue.venue.location.lng;
                    // ////alert(venue.venue.id);
                    // place the a marker on the map

                    var place_id = venue.venue.id;
                    var new_key = 'client_id=' + client_id + '&client_secret=' + client_secret + '&v=' + '20160401';
                    new_url[k] = 'https://api.foursquare.com/v2/venues/'+place_id+'/photos?'+new_key;
                    new_url[k].index=k;
                    (function retr_photos(k){
                        $.get(new_url[k], function(new_result){
                            var photos=new_result.response.photos.items;
                            photo_url_rest[k]=photos[0].prefix+"original"+photos[0].suffix;

                            var node = document.createElement("div");
                            node.setAttribute("class","named");
                            node.setAttribute("id","con");
                            node.setAttribute("style","box-shadow: 1px 1px 5px #888888;margin-bottom:1%;padding:0px;background-color:white;");
                            // console.log(photo_url[k]);
                            var node_img = document.createElement("img");
                            node_img.setAttribute("src",photo_url_rest[k]);
                            node_img.setAttribute("style","width: 300px;height: 150px;");
                            node_img.setAttribute("id","img"+k);
                            node_img.setAttribute("onclick","display_rest(this.id)");
                            var p1 = document.createElement("p");
                            //  console.log("p1=")
                            p1.setAttribute("style","margin:0px;");
                            //   p1.style.backgroundImage="url("+photo_url[k]+")";
                            //   p1.style.backgroundSize="100% 100%";

                            p1.innerHTML = restk[k];
                            //
                            var p2 = document.createElement("p");
                            p2.setAttribute("style","font-size:100%;");
                            p2.innerHTML = details_rest[k];

                            // var but=document.createElement("button")
                            // but.setAttribute("class","btn btn-primary btn-block");
                            // but.setAttribute("id",k);
                            // but.setAttribute("onlcick","schedule(this)");
                            // but.setAttribute("type","button");
                            // but.setAttribute("style","margin-bottom:5%;");
                            // but.setAttribute("data-toggle","modal");
                            // but.setAttribute("data-target","#myModal2");
                            // but.innerHTML="Schedule";

                            node.appendChild(node_img);
                            node.appendChild(p1);
                            node.appendChild(p2);
                            // node.appendChild(but);
                            document.getElementById("photos_rest").appendChild(node);
                            // for(i=0;i<purl.length;i++)
                            // {
                            //     //console.log(purl[i]);
                            //     if(purl[i]===photo_url[k])
                            //     {
                            //         console.log("HII"+i);
                            //         document.getElementById(k).disabled=true;
                            //         document.getElementById(k).innerHTML="Scheduled on Day "+dpurl[i];
                            //     }
                            // }
                        });
                    })(k);

                    restaurant_marker[k] = new google.maps.Marker({
                        position: new google.maps.LatLng(venue.venue.location.lat, venue.venue.location.lng),
                        map: null
                    });
                    //markers.push(marker);
                    restaurant_marker[k].index = k;
                    contents[k] = venue.venue.name;
                    x[k] = new google.maps.InfoWindow({
                        content: contents[k],
                        maxWidth: 300
                    });
                    google.maps.event.addListener(restaurant_marker[k], 'click', function() {
                        //x[this.index].setContent(this.html);
                        x[this.index].open(map, this);
                        console.log("Clicked="+"img"+this.index);
                        display_rest("img"+this.index);
                        toggleBounce(this);
                    });
                    google.maps.event.addListener(x[k],'closeclick',function(){
                    //    markers[this.index].setAnimation(null);
                        back();
                    });
                    //start_dest=markers[k].getPosition();
                    k = k + 1;

                }
            }
        });
    }
    function find_Photos(){
        //  //alert(place.geometry.location.lat());
        //  //alert("Asdfghhhhh");
          $.getJSON("https://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=d8dd5db1ed7bc9c7e973ad037b6376de&min_upload_date=01-01-2013&max_upload_date=01-03-2016&accuracy=6&has_geo=1&lat="+loc.lat+"&lon="+loc.lng+"&radius=20&radius_units=mi&has_geo=1&per_page=20&page=1&extras=geo&format=json&jsoncallback=?", displayImages3);
                function displayImages3(data){
                                                    ////alert("asdff");
                                                    ////alert(data.len);
              //Loop through the results in the JSON array. The 'data.photos.photo' bit is what you are trying to 'get at'. i.e. this loop looks at each photo in turn.
            $.each(data.photos.photo, function(i,item){
                            ////alert("Asdfgf");
                      //Read in the lat and long of each photo and stores it in a variable.
                      ////alert(item.ispublic);
            lati = item.latitude;
                      long1 = item.longitude;
                      var photo_id=item.id;

                      ////alert(lat);
                      ////alert(long1);
                      //Get the url for the image.
                      var photoURL = 'https://farm' + item.farm + '.static.flickr.com/' + item.server + '/' + item.id + '_' + item.secret + '_m.jpg';
                      htmlString = '<img src="' + photoURL + '">';
                      var contentString = '<div id="content">' + htmlString + '</div>';
                      photo_url_gallery.push(photoURL);
            var image = {
                url:photoURL,
                // This marker is 20 pixels wide by 32 pixels high.
                size: new google.maps.Size(40, 40),
                // The origin for this image is (0, 0).
                origin: new google.maps.Point(0, 0),
                // The anchor for this image is the base of the flagpole at (0, 32).
                anchor: new google.maps.Point(0, 32)
              };
                      //Create a new info window using the Google Maps API
                      var infowindow = new google.maps.InfoWindow({
                             //Adds the content, which includes the html to display the image from Flickr, to the info window.
                             content: contentString
                      });
                      //Create a new marker position using the Google Maps API.
                      var myLatlngMarker = new google.maps.LatLng(lati,long1);
                      //Create a new marker using the Google Maps API, and assigns the marker to the map created below.
                      var marker = new google.maps.Marker({
                      position: myLatlngMarker,
                map: null,
                title:"Photo",
                      });
            gallery.push(marker);
            var node = document.createElement("div");
            node.setAttribute("class","named");
            node.setAttribute("id","con");
            node.setAttribute("style","box-shadow: 1px 1px 5px #888888;margin-bottom:1%;padding:0px;background-color:white;");
            // console.log(photo_url[k]);
            var node_img = document.createElement("img");
            node_img.setAttribute("src",photoURL);
            node_img.setAttribute("style","width: 300px;height: 150px;");
            //node_img.setAttribute("id","img");
            //node_img.setAttribute("onclick","display(this.id)");
            // var p1 = document.createElement("p");
            // //  console.log("p1=")
            // p1.setAttribute("style","margin:0px;");
            // //   p1.style.backgroundImage="url("+photo_url[k]+")";
            // //   p1.style.backgroundSize="100% 100%";
            //
            // p1.innerHTML = venuek[k];
            // //
            // var p2 = document.createElement("p");
            // p2.setAttribute("style","font-size:100%;");
            // p2.innerHTML = details[k];
            //
            // var but=document.createElement("button")
            // but.setAttribute("class","btn btn-primary btn-block");
            // but.setAttribute("id",k);
            // but.setAttribute("onlcick","schedule(this)");
            // but.setAttribute("type","button");
            // but.setAttribute("style","margin-bottom:5%;");
            // but.setAttribute("data-toggle","modal");
            // but.setAttribute("data-target","#myModal2");
            // but.innerHTML="Schedule";
            //
            node.appendChild(node_img);
            // node.appendChild(p1);
            // node.appendChild(p2);
            // node.appendChild(but);
            document.getElementById("photos_gallery").appendChild(node);
            //infowindow.open(map,marker);
                      //Uses the Google Maps API to add an event listener that triggers the info window to open if a marker is clicked.
                      google.maps.event.addListener(marker, 'click', function() {
                      infowindow.open(map,marker);
                      //display_gallery()
                      });

    });
}

    }
    function callback(results, status) {
        ////alert("status="+status+"  "+results.length);
        if (status == google.maps.places.PlacesServiceStatus.OK) {
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
    function callback_restaurants(results, status) {
        ////alert("status="+status+"  "+results.length);
        if (status == google.maps.places.PlacesServiceStatus.OK) {
            for (var i = 0; i < results.length; i++) {
                var place_id = results[i].place_id;
                var request = {
                    placeId: place_id
                };
                var service = new google.maps.places.PlacesService(map);
                service.getDetails(request,callback_id_restaurants);
            }
        }
    }


    function callback_id(place, status){
        ////alert("status="+status);
        if(status == google.maps.places.PlacesServiceStatus.OK){
            createMarker(place);
        }
    }
    function callback_id_restaurants(place, status){
        //   ////alert("status="+status);
        if(status == google.maps.places.PlacesServiceStatus.OK){
            createMarker_restaurants(place);
        }
    }
    function createMarker_restaurants(place) {
        ///WRITE HERE
        var placeLoc = place.geometry.location;
        var marker = new google.maps.Marker({
            map: null,
            position: place.geometry.location
        });
        var node = document.createElement("div");
        node.setAttribute("class","jumbotron");
        node.setAttribute("style","box-shadow: 1px 1px 5px #888888;background-color:white;");
        var p1 = document.createElement("p");
        p1.innerHTML = place.name;
        var p2 = document.createElement("p");
        p2.innerHTML = place.rating;
        var p3 = document.createElement("p");
        p3.innerHTML = place.formatted_address;
        var p4 = document.createElement("p");
        p4.innerHTML = place.formatted_phone_number;
        node.appendChild(p1);
        node.appendChild(p2);
        node.appendChild(p3);
        node.appendChild(p4);
        document.getElementById("restaurants").appendChild(node);
        restaurant_marker.push(marker);
        var infowindow = new google.maps.InfoWindow({
            content: ""
        });

        google.maps.event.addListener(marker, 'click', function() {
            infowindow.setContent(place.name);
            infowindow.open(map, this);

        });
    }
    function createMarker(place) {
        ////alert("adding_hotel")
        var placeLoc = place.geometry.location;

        if(place.hasOwnProperty('opening_hours'))
        {
          console.log(place.opening_hours.weekday_text);
        }

        // var len=place.reviews.length;
        // console.log(len);
        // if(len>0)
        // {
        //   console.log(place.reviews[0].text);
        // }
        //////HTOEL WALE
        var node = document.createElement("div");
        node.setAttribute("class","jumbotron");
        node.setAttribute("style","box-shadow: 1px 1px 5px #888888;background-color:white;");
        var p1 = document.createElement("p");
        p1.innerHTML = place.name;
        var p2 = document.createElement("p");
        p2.innerHTML = place.rating;
        var p3 = document.createElement("p");
        p3.innerHTML = place.formatted_address;
        var p4 = document.createElement("p");
        p4.innerHTML = place.formatted_phone_number;
        node.appendChild(p1);
        node.appendChild(p2);
        node.appendChild(p3);
        node.appendChild(p4);
        document.getElementById("hotels").appendChild(node);
        // console.log(place.name);
        // console.log(place.rating);
        // console.log(place.formatted_address);
        // console.log(place.formatted_phone_number);
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
    function setMapOnAllHotels(map){
        ////alert(hotel_marker.length);
        for (var i = 0; i < hotel_marker.length; i++) {

            hotel_marker[i].setMap(map);
        }
    }
    function setMapOnAllTourist(map){
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(map);
        }
    }
    function setMapOnAllRestaurants(map){
        ////alert(restaurant_marker.length);
        for (var i = 0; i < restaurant_marker.length; i++) {
            restaurant_marker[i].setMap(map);
        }
    }
    function setMaponAllGallery(map){
        ////alert(gallery.length);
        ////alert(restaurant_marker.length);
        for (var i = 0; i < gallery.length; i++) {
            gallery[i].setMap(map);
        }
    }

    function deleteMarkers(){
        setMapOnAllHotels(null);
        setMapOnAllTourist(null);
        setMapOnAllRestaurants(null);
        hotel_marker = [];
        markers = [];
        restaurant_marker = [];
    }

    function reschedule(ele)
    {
        console.log("reschedule"+ele.id);
        var id=<?php $ar=array('id'=>$id);
        echo json_encode($ar);
        ?>;
        var item=ele.id.substring(1);
        console.log("item="+item);
        var del_place=venuek[item];
        console.log("DEL PLACE="+del_place);
        document.getElementById(del_place).remove();
        console.log("place_name="+del_place);
        console.log("id="+id.id);
        $.ajax(
        {
            url: "reschedule.php",
            type:"post",
            dataType:"json",
            data:
            {
                id:id.id,
                place_name:del_place
            },

            success: function(json)
            {
                //////alert("SUCCESS");
                //////alert(json.status);
                console.log(json.status);
                document.getElementById('d'+item).style.visibility='hidden';
                document.getElementById(item).disabled=false;
                document.getElementById(item).innerHTML="Schedule";
            },

            error : function()
            {
                ////alert("ERROR");
                //console.log("something went wrong");
            }
        });
    }
    function logout()
    {
        location.href="logout.php";
    }
    </script>
    <script type="text/javascript">



        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7Kb6lhE3dA4201a82tu9CNGkvsOuaI3M&libraries=places&callback=initMap"
        async defer></script>



    </body>

    </html>

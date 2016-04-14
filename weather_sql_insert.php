<?php
include 'connection.php';

$link=mysqli_connect($db_host,$db_username,$db_password,$db_name) or die("cannot connect");

$name=$_POST['name'];
$month=$_POST['month'];
$max_temp=$_POST['max_temp'];
$min_temp=$_POST['min_temp'];
$average_temp=$_POST['average_temp'];
$average_humidity=$_POST['average_humidity'];
$average_precipitation=$_POST['average_precipitation'];
$windspeed=$_POST['windspeed'];
$query="Insert into weather values('$name',$average_humidity,$average_precipitation,$windspeed,$max_temp,$min_temp,$month,$average_temp)";
mysqli_query($link,$query);
$ar=array("status"=>$query);
echo json_encode($ar);

?>
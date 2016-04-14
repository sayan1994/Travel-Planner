<?php
include 'connection.php';
// session_start();

$link=mysqli_connect($db_host,$db_username,$db_password,$db_name) or die("cannot connect");
$place_name=$_POST['name'];
$uname=$_POST['uname'];
$lat=$_POST['lat'];
$lng=$_POST['lng'];
$days=$_POST['day'];
$date=$_POST['date'];

$query="insert into Mapping(uname,city_name,no_of_days,lat,lng,date) values('$uname','$place_name',$days,$lat,$lng,'$date')";
mysqli_query($link,$query);
$query="Select id from Mapping";
$res=mysqli_query($link,$query);
$resar=array();
while($row=mysqli_fetch_row($res))
{
	$resar[]=$row[0];
}
$num=end($resar);
$ar=array('status'=>$num);
echo json_encode($ar);
?>
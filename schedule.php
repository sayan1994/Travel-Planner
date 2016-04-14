<?php
include 'connection.php';

$link=mysqli_connect($db_host,$db_username,$db_password,$db_name) or die("cannot connect");
$id=$_POST['id'];
$place_name=$_POST['place_name'];
$place_name=strtok($place_name,'|');
$photo_url=$_POST['photo_url'];
$photo_url=addslashes($photo_url);
$details=$_POST['details'];
$details=addslashes($details);
$lat=$_POST['lat'];
$lng=$_POST['lng'];
$day=$_POST['day'];
$query="insert into Trip values($id,'$place_name','$photo_url','$details',$lat,$lng,$day)";
mysqli_query($link,$query);
$ar=array('status'=>$query);
echo json_encode($ar);

?>
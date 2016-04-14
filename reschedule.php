<?php
include 'connection.php';

$link=mysqli_connect($db_host,$db_username,$db_password,$db_name) or die("cannot connect");
$id=$_POST['id'];
$place_name=$_POST['place_name'];
$place_name=strtok($place_name,'|');
$query="Delete from Trip where id=$id and place_name='$place_name'";
mysqli_query($link,$query);
$ar=array('status'=>$query);
echo json_encode($ar);

?>
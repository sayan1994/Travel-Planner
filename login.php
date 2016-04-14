<?php
include 'connection.php';
session_start();

$link=mysqli_connect($db_host,$db_username,$db_password,$db_name) or die("cannot connect");

$uname=$_POST['uname'];
$uname=mysqli_real_escape_string($link,$uname);
$pwd=$_POST['pwd'];
$pwd=mysqli_real_escape_string($link,$pwd);

$query="Select * from Login where uname='$uname' AND pass='$pwd'";
$result=mysqli_query($link,$query);
$num_rows=mysqli_num_rows($result);
if($num_rows>0)
{
	session_start();
	$_SESSION["uname"] = $uname;
	$res=array('status'=>1);
	echo json_encode($res);
}
else
{
	$res=array('status'=>2);
	echo json_encode($res);
}
?>
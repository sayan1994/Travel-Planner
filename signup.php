<?php
include 'connection.php';

$link=mysqli_connect($db_host,$db_username,$db_password,$db_name) or die("cannot connect");
//mysqli_select_db($db_name);
//echo $db_host;
$name=$_POST['name'];
 // $name=stripslashes($name);
 $name=mysqli_real_escape_string($link,$name);
// //echo $name;
$email=$_POST['email'];
//$emailid=stripslashes($emailid);
$email=mysqli_real_escape_string($link,$email);

$uname=$_POST['uname'];
//$uname=stripslashes($uname);
$uname=mysqli_real_escape_string($link,$uname);
//echo $uname;
$pass=$_POST['pass'];
//$pwd=stripslashes($pwd);
$pwd=mysqli_real_escape_string($link,$pwd);


$query="Select * from Login where uname='$uname' ";
$result=mysqli_query($link,$query);
$num_rows=mysqli_num_rows($result);


//echo $num_rows;
// $res=array('status'=>$num_rowsa);
// echo json_encode($res);

if($num_rows>0)
{
	$res=array('status'=>0);
	echo json_encode($res);
}
else
{


	$query="Select * from Login  where email_id='$email' ";
	$result=mysqli_query($link,$query);
	$num_rows=mysqli_num_rows($result);
	if($num_rows>0)
	{
		$res=array('status'=>1);
		echo json_encode($res);
	}
	else
	{

		$query="insert into Login values('$uname','$name','$pass','$email')";
		$result=mysqli_query($link,$query);
		
		$res=array('status'=>2 );
		echo json_encode($res);
		
	}
}

?>
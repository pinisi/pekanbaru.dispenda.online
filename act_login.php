<?php
	if(!isset($_SESSION))
	{
		session_start();
	}  
	include "init_dbconnection.php";
	

	$sql="SELECT * FROM login WHERE username='".$_POST['txtUser']."' and password='".md5($_POST['txtPassword'])."'";
	//echo $sql;
	$query=mysql_query($sql);
	$num=mysql_num_rows($query);
	$hasil=mysql_fetch_array($query);
	
	if($num==1)
	{
		$_SESSION['level']=$hasil['level'];
		$_SESSION['user']=$hasil['username'];
		$_SESSION['status']="";

		

		header("location: main.php");
	}else
	{
		header("location:index.php");
	}
	
?>	
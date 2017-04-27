<?php
	//session_start();
	if(!isset($_SESSION))
	{
	session_start();
	}  
	if(empty ($_SESSION['level']))
	{

     
    if (strpos($_SERVER["HTTP_HOST"],'simpoda') !== false) {
       header("location: ../");
    } else {
       header("location: ../../papua");
    }


	}
?>

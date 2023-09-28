<?php
	$servername = "localhost";
	$userName   = "root";
	$password   = "";
	$dbname     = "wt_tut_7";

	$conn = mysqli_connect($servername, $userName, $password, $dbname);

	if($conn){
		// echo "connectioin OK";
	}
	else{
		echo "connection failed".mysqli_connect_error();
	}
?>
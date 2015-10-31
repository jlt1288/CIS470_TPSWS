<?php
	$databaseHost = "";
	$databaseName = "";
	$databaseUsername = "";
	$databasePassword = "";
	
	$connection = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName) or die('Could not connect to MySQL: ' . mysqli_error($connection));
?>
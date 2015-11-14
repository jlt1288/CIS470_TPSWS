<?php
	$databaseHost = "localhost";
	$databaseName = "jthomps4_cis470";
	$databaseUsername = "jthomps4_470rdo";
	$databasePassword = "readonly";
	
	$connection = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName) or die('Could not connect to MySQL: ' . mysqli_error($connection));
?>
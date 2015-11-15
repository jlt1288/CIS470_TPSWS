<?php
	$databaseHost = "localhost";
	$databaseName = "coliverm_cis470";
	$databaseUsername = "coliverm_470rdo";
	$databasePassword = "readonly";
	
	$connection = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName) or die('Could not connect to MySQL: ' . mysqli_error($connection));
?>
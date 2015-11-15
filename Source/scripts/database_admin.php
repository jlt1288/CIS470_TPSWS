<?php
	$databaseHost = "localhost";
	$databaseName = "coliverm_cis470";
	$databaseUsername = "coliverm_470wrt";
	$databasePassword = "readwrite";
	
	$connection = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName) or die('Could not connect to MySQL: ' . mysqli_error($connection));
?>
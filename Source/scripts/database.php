<?php
/*	Database connection script. View only.
*----------------------------------------------------------------------------
*	Original Author: Joshua Thompson
*	Creation Date: 11/03/2015
*
*	Modification Author: Joshua Thompson
*	Modification Date: 11/16/2015
*----------------------------------------------------------------------------
*/
	require( 'scripts/student_info.php' );
	$databaseHost = "localhost";
	$databaseName = $student . "_cis470";
	$databaseUsername = $student . "_470rdo";
	$databasePassword = "readonly";
	
	$connection = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName) or die('Could not connect to MySQL: ' . mysqli_error($connection));
?>
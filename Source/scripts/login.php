<?php
/*	Login script used by the login page.
*----------------------------------------------------------------------------
*	Original Author: Joshua Thompson
*	Creation Date: 11/03/2015
*
*	Modification Author: Joshua Thompson
*	Modification Date: 11/03/2015
*----------------------------------------------------------------------------
*/

//===============================================================================
//	SESSION INFORMATION
//===============================================================================
require_once( 'session.php' );

//===============================================================================
//	INCOMING INFORMATION
//===============================================================================
if (isset($_POST['Submit_Login'])){
	// Get information submitted to the page.
	$email = trim($_POST['email']);
	$pwd = md5(trim($_POST['pwd']));

	// Connect to the database for further use.
	require_once( '../includes/database.php' );

	// Run query to find if the username/password combination exists.
	// TODO: Change table, values, and variables to be in line with the database.
	$sql = "SELECT * FROM users WHERE email = '$email' AND password = '$pwd'";
	$result = $connection->query($sql) or die('Error: ' . mysqli_error());
	
	if (mysqli_num_rows($result)===0){
		$msg = '<h2 style="color:red;">Invalid Credentials!</h2>';
	} else {
		$_SESSION['user'] = $email;
		
		// TODO: Push the area which we want to goto as the header:location.
		//header("Location:page.php");
	}
}	

?>

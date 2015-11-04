<?php
/*	Register script used by the register page.
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
if(isset($_POST['submit_register'])) {
    // Get information submitted to the page.
	$email = $_POST['email'];
    $pwd = md5($_POST['password']);
        
	// Connect to the database for further use.
	require_once( '../includes/database_admin.php' );

	// Run query to find if the username/password combination exists.
	// TODO: Change table, values, and variables to be in line with the database.
	$sql = "INSERT INTO users (email, password) VALUES ('$email', '$pwd')";
    $result = $connection->query($sql) or die('Error: ' . mysqli_error());

    if($result) {
        $msg = "<p><strong>New user successfully inserted!</strong>";
        $msg .= "<br><a href='login.php'>Login Page</a></p>";
    }
}

?>
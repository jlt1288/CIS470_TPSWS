<?php
/*	Client script used by members_area.php.
*----------------------------------------------------------------------------
*	Original Author: Joshua Thompson
*	Creation Date: 11/16/2015
*
*	Modification Author: Joshua Thompson
*	Modification Date: 11/16/2015
*----------------------------------------------------------------------------
*/
require_once( 'scripts/classes.php' );

if ((isset($_POST['request']) || isset($_GET['request'])) && isset($_POST['submit']))
{
	if (!$app_code = Client::createRequest($_SESSION['id'], $_POST['workType'], $_POST['experience'], $_POST['education'], $_POST['salary'], $_POST['zip'], $_POST['distance'], $_POST['candidates']))
	{
		$message = "Error processing request. Please try again.";	
	}
	else
	{
		$message = "The request has been submitted. <div id='approval_code' name='approval_code'>Confirmation Code: " . $app_code . "</div>";	
	}
}
elseif ((isset($_POST['approval_code']) && isset($_POST['search'])))
{
	if (!$request = Client::getRequest($_SESSION['id'], $_POST['approval_code']))
	{
		$message = "Error processing request. Please try again.";	
	}
}


?>
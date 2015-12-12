<?php
/*	Client script used by members_area.php.
*----------------------------------------------------------------------------
*	Original Author: Joshua Thompson
*	Creation Date: 11/16/2015
*
*	Modification Author: Joshua Thompson
*	Modification Date: 11/30/2015
*----------------------------------------------------------------------------
*/

// Required for the internal classes we use to retrieve data.
require_once( 'scripts/classes.php' );

// Determine if we're trying to submit a new request to the database.
if ((isset($_POST['request']) || isset($_GET['request'])) && isset($_POST['submit']))
{
	// Try to create the request, returning the approval code.
	if (!$app_code = Request::create($_SESSION['id'], $_POST['workType'], $_POST['experience'], $_POST['education'], $_POST['salary'], $_POST['zip'], $_POST['distance'], $_POST['candidates']))
	{
		$message = "Error processing request. Please try again.";	
	}
	else
	{
		$message = "The request has been submitted.<br />A contract manager will verify the request within 24 hours.<div id='approval_code' name='approval_code'>Confirmation Code: " . $app_code . "</div>";	
	}
}
// Determine if we're trying to search for a request based on approval code.
elseif ((isset($_POST['approval_code']) && isset($_POST['search'])))
{
	if (!$request = Request::getRequest($_POST['approval_code'], $_SESSION['access']))
	{
		$message = "No search results found.";	
	}
}


?>
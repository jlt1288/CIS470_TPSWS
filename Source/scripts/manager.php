<?php
/*	Manager script used by members_area.php.
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

// Determine if we're trying to search for something.
if (isset($_POST['search']))
{
	// Determine the area we want to access..
	if (isset($_POST['access']) && $_POST['access'] === "staff")
	{
		// If the employee_id is set then use this method.
		if (!empty($_POST['employee_id']))
		{
			// Determine if we got a proper ID.
			if (!$id = Staff::getID($_POST['employee_id']))
			{
				$message = "No search results found.";
			}
			else
			{
				$staff = new Staff($id);
			}
		}
		// otherwise use the id posted to the server.
		elseif (!empty($_POST['id']))
		{
			$id = $_POST['id'];
			$staff = new Staff($id);
		}
		// otherwise no ID has been sent to the server, show error message.
		else
		{
			$message = "An error has occured, please contact the administration for further assistance.";
		}
	}
	elseif (isset($_POST['access']) && $_POST['access'] === "client" && isset($_POST['approval_code']))
	{	
		// Determine if we're searching for a staff request.
		if ($_POST['search'] !== "Search")
		{
			// Determine if we're trying to update the staff request.
			if (!Request::update($_POST['search'], $_POST['status']))
			{
				$message = "Unable to update status of request: " . $_POST['approval_code'];
			}
		}

		// Get the staff request data from the database.
		if (!$request = Request::getRequest($_POST['approval_code'], $_SESSION['access']))
		{
			$message = "No search results found.";	
		}
	}
	
}	
	
?>
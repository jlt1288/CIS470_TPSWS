<?php
/*	Manager script used by members_area.php.
*----------------------------------------------------------------------------
*	Original Author: Joshua Thompson
*	Creation Date: 11/16/2015
*
*	Modification Author: Joshua Thompson
*	Modification Date: 11/27/2015
*----------------------------------------------------------------------------
*/

// Required for the internal classes we use to retrieve data.
require_once( 'scripts/classes.php' );

if (isset($_POST['search']))
{
	// Determine the access type.
	if (isset($_POST['access']) && $_POST['access'] === "staff")
	{
		// If the employee_id is set then use this method.
		if (!empty($_POST['employee_id']))
		{
			if (!$id = Staff::getID($_POST['employee_id']))
			{
				$message = "No search results found.";
			}
			else
			{
				$staff = new Staff($id);
			}
		}
		elseif (!empty($_POST['id']))
		{
			$id = $_POST['id'];
			$staff = new Staff($id);
		}
		else
		{
			$message = "An error has occured, please contact the administration for further assistance.";
		}
	}
	elseif (isset($_POST['access']) && $_POST['access'] === "client" && isset($_POST['approval_code']))
	{	
		if ($_POST['search'] !== "Search")
		{
			if (!Request::update($_POST['search'], $_POST['status']))
			{
				$message = "Unable to update status of request: " . $_POST['approval_code'];
			}
		}

		if (!$request = Client::getRequest($_POST['approval_code'], $_SESSION['access']))
		{
			$message = "No search results found.";	
		}
	}
	
}	
	
?>
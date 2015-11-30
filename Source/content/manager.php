<?php 
/*	Manager area landing page.
*----------------------------------------------------------------------------
*	Original Author: Joshua Thompson
*	Creation Date: 11/13/2015
*
*	Modification Author: Joshua Thompson
*	Modification Date: 11/30/2015
*----------------------------------------------------------------------------
*/

// check if we're searching for either an employee or staffing request.
if (isset($_POST['search']))
{
	// check to see if we're searching for a staff member.
	if (isset($_POST['access']) && $_POST['access'] === "staff")
	{
		// show staff content for that staff member.
		require_once("content/staff_view.php");
	}
	// check to see if we're searching for a staffing request.
	elseif (isset($_POST['access']) && $_POST['access'] === "client")
	{
		// show information pertaining to that staff request.
		require_once("content/client_viewrequest.php");
	}
	
}
// otherwise show the landing page. 
else {
	require_once("content/manager_landing.php");		
}
	

?>

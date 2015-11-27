<?php 
/*	Manager area landing page.
*----------------------------------------------------------------------------
*	Original Author: Joshua Thompson
*	Creation Date: 11/13/2015
*
*	Modification Author: Joshua Thompson
*	Modification Date: 11/27/2015
*----------------------------------------------------------------------------
*/

if (isset($_POST['search']))
{
	if (isset($_POST['access']) && $_POST['access'] === "staff")
	{
		require_once("content/staff_view.php");
	}
	elseif (isset($_POST['access']) && $_POST['access'] === "client")
	{
		require_once("content/client_viewrequest.php");
	}
	
} else {
	require_once("content/manager_landing.php");		
}
	

?>

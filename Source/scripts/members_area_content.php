<?php 
/* Members Area Content script used by the members area page.
*----------------------------------------------------------------------------
*	Original Author: Joshua Thompson
*	Creation Date: 11/08/2015
*
*	Modification Author: Joshua Thompson
*	Modification Date: 11/08/2015
*----------------------------------------------------------------------------
*/

if ($_GET['access'] === "client"){
	// TODO: Load the page contents for the client area.
	require_once('content/client_area.php');
}elseif ($_GET['access'] === "staff"){
	// TODO: Load the page contents for the staff area.	
	require_once('content/staff_area.php');	
}elseif ($_GET['access'] === "manager"){
	// TODO: Load the page contents for the manager area.
	require_once('content/manager_area.php');
}

?>
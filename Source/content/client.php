<?php
/*	Client area landing page.
*----------------------------------------------------------------------------
*	Original Author: Joshua Thompson
*	Creation Date: 11/13/2015
*
*	Modification Author: Joshua Thompson
*	Modification Date: 11/27/2015
*----------------------------------------------------------------------------
*/
	// if we're trying to view a request, show view content.
	if (isset($_POST['view']) || isset($_GET['view']))
	{
		require_once('content/client_viewrequest.php');	
	}
	// otherwise show the create new request content.
	else
	{
		require_once('content/client_request.php');
	}

?>
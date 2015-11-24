<?php

	if (isset($_POST['request']) || isset($_GET['request']))
	{
		require_once('content/client_request.php');
		
	}
	else
	{
		require_once('content/client_viewrequest.php');	
	}

?>
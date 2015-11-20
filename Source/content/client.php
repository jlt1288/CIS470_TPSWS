<?php

	if (isset($_POST['view']) || isset($_GET['view']))
	{
		require_once('content/client_viewrequest.php');	
	}
	else
	{
		require_once('content/client_request.php');
	}

?>
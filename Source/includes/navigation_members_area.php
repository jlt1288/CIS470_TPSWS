<?php
/*	Client Navigation script used by the members area page, client section.
*----------------------------------------------------------------------------
*	Original Author: Joshua Thompson
*	Creation Date: 11/08/2015
*
*	Modification Author: Joshua Thompson
*	Modification Date: 11/09/2015
*----------------------------------------------------------------------------
*/
?>
<a href="search.php" class="myButton">Search</a>
<?php if (isset($_SESSION['access']) && $_SESSION['access'] === "client" || $_GET['access'] === "client"){
		// TODO: Remove the $_GET['access'] section of code to ensure security.	
?>
	<a href="request.php" class="myButton">Request</a>
<?php } ?>
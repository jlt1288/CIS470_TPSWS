<?php 
/*	Logout script used to log out of the session.
*----------------------------------------------------------------------------
*	Original Author: Joshua Thompson
*	Creation Date: 11/03/2015
*
*	Modification Author: Joshua Thompson
*	Modification Date: 11/03/2015
*----------------------------------------------------------------------------
*/
	session_start();
    session_destroy();
    header("Location:index.php");
?>
<?php 
/*	Logout script used to log out of the session.
*----------------------------------------------------------------------------
*	Original Author: Joshua Thompson
*	Creation Date: 11/03/2015
*
*	Modification Author: Joshua Thompson
*	Modification Date: 11/30/2015
*----------------------------------------------------------------------------
*/
// Only run script if we're tryin got log out of the user.
if (isset($_GET['logout']))
{
	require_once( 'scripts/classes.php' );
	
	User::logout();
}
?>
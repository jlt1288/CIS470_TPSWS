<?php
/*	staff area landing page.
*----------------------------------------------------------------------------
*	Original Author: Joshua Thompson
*	Creation Date: 11/13/2015
*
*	Modification Author: Joshua Thompson
*	Modification Date: 11/30/2015
*----------------------------------------------------------------------------
*/
	// check to see if we're in edit mode.
	if (isset($_GET['edit']) || isset($_POST['edit']))
	{
		// show the edit mode content.
		require_once("content/staff_edit.php");
	}
	// otherwise show the view page. 
	else
	{		
		require_once("content/staff_view.php");		
	}
?>
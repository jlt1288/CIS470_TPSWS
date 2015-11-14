<?php 
/*	Navigation script used by all pages for navigation.
*----------------------------------------------------------------------------
*	Original Author: Joshua Thompson
*	Creation Date: 11/08/2015
*
*	Modification Author: Joshua Thompson
*	Modification Date: 11/09/2015
*----------------------------------------------------------------------------
*/

// Requires the string scripts file.
require_once('scripts/strings.php');

// Returns the type of button we need for the current link.
function getButton($page)
{
	return (containsWord($_SERVER["PHP_SELF"], $page)) ? "currentButton" : "myButton";
}
?>

<img src="resources/tpslogo.png" class="logo" alt="TPS">
<img src="resources/fb.png" class="fblogo" alt="Facebook">
<img src="resources/twitter.png" class="tlogo" alt="Twitter">
<img src="resources/google.png" class="glogo" alt="Google">
<p style="float: right; margin: 0px; margin-right: 65px; margin-top: -6px; font-size: 48px; color:#202020;">Taylor's Professional Services</p>
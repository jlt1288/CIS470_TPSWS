<?php 
/*	Navigation script used by all pages for navigation.
*----------------------------------------------------------------------------
*	Original Author: Joshua Thompson
*	Creation Date: 11/08/2015
*
*	Modification Author: Joshua Thompson
*	Modification Date: 11/08/2015
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
<a href="#" class="myButton">Search</a>
<a href="#" class="myButton">Contract</a>
<a href="#" class="myButton">Request</a>
<a href="members_area.php" class="<?php echo getButton("member_area"); ?>">Members</a>
<a href="register.php" class="<?php echo getButton("register"); ?>">Register</a>
<a href="login.php" class="<?php echo getButton("login"); ?>">Login</a>
<a href="index.php" class="<?php echo getButton("index"); ?>">Home</a>
<?php
/*	Client script used by members_area.php.
*----------------------------------------------------------------------------
*	Original Author: Joshua Thompson
*	Creation Date: 11/16/2015
*
*	Modification Author: Joshua Thompson
*	Modification Date: 11/16/2015
*----------------------------------------------------------------------------
*/

$random_hash = md5(uniqid(rand(), true));
$confirmation_code = strtoupper(substr($random_hash, (strlen($random_hash) % 2), 10));
?>
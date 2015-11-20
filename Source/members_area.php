<?php
/*	Members area main template page.
*----------------------------------------------------------------------------
*	Original Author: Joshua Thompson
*	Creation Date: 11/13/2015
*
*	Modification Author: Joshua Thompson
*	Modification Date: 11/17/2015
*----------------------------------------------------------------------------
*/
//===============================================================================
//	START SESSION
//===============================================================================
session_start();

require_once('scripts/logout.php');

//===============================================================================
//	SESSION INFORMATION
//===============================================================================
if ((isset($_SESSION['access']) && !empty($_SESSION['access'])))
{
	require_once('scripts/' . $_SESSION['access'] . '.php');	
	
} else {
	// Redirect back to index page.
	header('Location:index.php');	
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
<title>Taylor's Professional Services</title>
<link rel="stylesheet" type="text/css" href="styles/style.css" media="screen" />
<style></style>
<?php require_once('scripts/javascript_' . $_SESSION['access'] . '.php');	?>
</head>

<body>
	<?php require_once('content/header.php'); ?>
    
    <div id="main">	
		<div id="content">
        	<?php
				require_once('content/' . $_SESSION['access'] . '.php');					
			?>
		</div>
	</div>
    
    <?php require_once('content/footer.php'); ?>
</body>
</html>
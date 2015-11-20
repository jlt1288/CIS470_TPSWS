<?php
/*	Header template used by all pages of the website.
*----------------------------------------------------------------------------
*	Original Author: Joshua Thompson
*	Creation Date: 11/13/2015
*
*	Modification Author: Joshua Thompson
*	Modification Date: 11/20/2015
*----------------------------------------------------------------------------
*/
?>
<div id="header">
	<div id="navigationHeader">
		<img src="styles/tpslogo.png" class="logo" alt="TPS" style="float: left;">
		<p style="float: left; margin: 0px; margin-left: 80px; margin-top: -6px; font-size: 48px; color:#202020;">Taylor's Professional Services</p>        
		<?php if (isset($_SESSION['id'])) { ?>
	        <div id="logout" style="float: right; margin-top: 0px; font-size: 18px;">
				<a id="logout_link" href="<?php $_SERVER["PHP_SELF"];?>?logout">Logout</a>
			</div>
		<?php } ?>
        
        <?php if (isset($_SESSION['access']) && ($_SESSION['access'] === "client")) { ?>
			<div id="search_request" style="float: right; margin-top: 12px; font-size: 12px; color:#E0E0E0;">
            	<form action="?view" method="POST">
                	<label>Search: </label>
                    <input id="approval_code" name="approval_code" placeholder="Search by code." />
                    <input type="submit" id="search" name="search" value="Search" />
                </form>
            </div>
		<?php } ?>
	</div>	
</div>
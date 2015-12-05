<?php
/*	Header template used by all pages of the website.
*----------------------------------------------------------------------------
*	Original Author: Joshua Thompson
*	Creation Date: 11/13/2015
*
*	Modification Author: Joshua Thompson
*	Modification Date: 11/27/2015
*----------------------------------------------------------------------------
*/
?>
<div id="header">
	<div id="navigationHeader">
		<img src="styles/tpslogo.png" class="logo" alt="TPS" style="float: left;">
		<p style="float: left; margin: 0px; margin-left: 80px; margin-top: -6px; font-size: 48px; color:#202020;">Taylor's Professional Services</p>   
		<?php if (isset($_SESSION['id'])) { ?>
        	<div id="logout" style="float: right; margin-top: 20px; font-size: 18px;">
				<a id="home_link" href="members_area.php">Home</a>
			</div>     
	        <div id="logout" style="float: right; margin-right:12px; margin-top: 20px; font-size: 18px;">
				<a id="logout_link" href="<?php $_SERVER["PHP_SELF"];?>?logout">Logout</a>
			</div>
		<?php }// end if ?>
        
        <?php 
			// Show if we're a client or manager.
			if (isset($_SESSION['access']) && ($_SESSION['access'] === "client" || $_SESSION['access'] === "manager")) { ?>
			<div id="search_request" style="float: right; margin-top: 58px; font-size: 14px; color:#202020;">
            	<form action="?view" method="POST">
                	<input type="hidden" id="access" name="access" value="client" />
                    <input id="approval_code" name="approval_code" placeholder="Search for request." required/>
                    <input type="submit" id="search" name="search" value="Search" />
                </form>
            </div>
            <?php 
				// Only show if we're a client, not if we're a manager.
				if ($_SESSION['access'] === "client") { ?>
            <span id="request" style="float: right; margin-right: -168px; margin-top: 88px; font-size: 12px; color: #E0E0E0">
            	<a href="members_area.php?request">Create New Request</a>
            </span>
		<?php } // end if
		}// end if?>
        
        <?php if (isset($_SESSION['access']) && ($_SESSION['access'] === "manager")) { ?>
			<div id="search_request" style="float: right; margin-top: 58px;  font-size: 12px; color:#E0E0E0;">
            	<form action="?view" method="POST">
                	<input type="hidden" id="access" name="access" value="staff" />
                    <input id="employee_id" name="employee_id" placeholder="Search for employee." required/>
                    <input type="submit" style="margin-right: 50px;" id="search" name="search" value="Search" />
                </form>
            </div>
		<?php } //end if ?>
	</div>	
</div>
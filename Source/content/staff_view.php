<?php
/*	Staff Member edit page.
*----------------------------------------------------------------------------
*	Original Author: Joshua Thompson
*	Creation Date: 11/13/2015
*
*	Modification Author: Joshua Thompson
*	Modification Date: 12/03/2015
*----------------------------------------------------------------------------
*/

// if a message is set show message.
/*
if (isset($message)) { ?><div id="message" align="center" style="margin:0px; padding-top:2.5px;"><?php echo $message; ?></div> <?php } // end if
*/

// Only show if we're a manager and arrived here from a staff request.
if ($_SESSION['access'] === "manager" && (!empty($_POST['approval_code'])))
{?>
	<div id="back_request" style="float: right; margin-right: 40px; margin-top: 17px;">
        <form action="?view" method="POST">
            <input type="hidden" id="access" name="access" value="client" />
            <input type="hidden" id="search" name="search" value="search" />
            <input  type = "hidden" id="approval_code" name="approval_code" value="<?php echo $_POST['approval_code']; ?>"/>
			<input type="submit" id="submit" name="submit" value="Go Back" />
		</form>
	</div>	
<?php } // end if ?>
<h3 style= "margin-left: 20px; margin-top: 0px; padding-top: 15px; color: #202020;"><u>Staff</u></h3>
<?php // if no staff is set, show error message.
if (empty($staff)) { ?><div id="message" style="margin:0px; margin-left: 20px; font-size: 18px; padding:5px; color:red"><b><?php echo "No results match that criteria."; ?></b></div> <?php } 
else
{?>
<div id="staffView">
	<?php if ($_SESSION['id'] === $id) { // Only show if we're the staff member associated with this profile. ?>
		<div style="margin-bottom: 10px;">
			<form action="?edit" method="POST">
				<input type="hidden" id="edit" name="edit" />
				<input type="submit" id="submit" name="submit" value="Edit Profile" />
			</form>
		</div><!-- End of Edit Profile -->
	<?php } // end if ?>

	<?php if (isset($staff->picture) && !empty($staff->picture) && file_exists("uploads/pictures/" . $staff->picture)){ ?>
		<img class="image" id="pic" name="pic" style="float: left;" src="uploads/pictures/<?php echo $staff->picture; ?>" />
	<?php } ?>
    
	<?php if (isset($staff->picture) && empty($staff->picture)){ ?>
		<img class="image" id="pic" name="pic" style="float: left;" src="uploads/pictures/noperson.png<?php echo $staff->picture; ?>" />
	<?php } ?>
	
    <div id="infoBox">
		<div id="availability" name="availability">
    		<label><b><u>Availability:</u></b></label><br />
        	<label id="availabe" name="available" style="margin-left: 20px;"><?php echo (($staff->available === "0") ? "Not Available" : "Available"); ?></label>
	    </div><!-- End of Availability -->

		<div id="information" name="information">
    		<label><b><u>First Name:</u></b></label><br />
	        <label id="Fname" name="Fname" style="margin-left: 20px;"><?php echo $staff->Fname; ?></label><br />
    	    <label><b><u>Last Name:</u></b></label><br />
        	<label id="Lname" name="Lname" style="margin-left: 20px;"><?php echo $staff->Lname; ?></label><br />
	        <label><b><u>City:</u></b></label><br />
    	    <label id="city" name="city" style="margin-left: 20px;"><?php echo $staff->city; ?></label><br />
        	<label><b><u>State:</u></b></label><br />
		    <label id="state" name="state" style="margin-left: 20px;"><?php echo $staff->state; ?></label><br />
	        <label><b><u>Zip Code:</u></b></label><br />
    	    <label id="zip" name="zip" style="margin-left: 20px;"><?php echo $staff->zip; ?></label><br />
	    </div><!-- End of Information -->
    
	    <div>
    		<label><b><u>Type of Work:</u></b></label><br />
	      	<label id="workType" name="workType" style="margin-left: 20px;"><?php echo $staff->workType; ?></label><br />
    		<label><b><u>Experience:</u></b></label><br />
        	<label id="experience" name="experience" style="margin-left: 20px;"><?php echo $staff->experience; ?></label><br />
	        <label><b><u>Education:</u></b></label><br />
			<label id="education" name="education" style="margin-left: 20px;"><?php echo (($staff->education === "0") ? "No Degree" : ($staff->education === "1") ? "High School" : "College" ); ?></label><br />
        	<label><b><u>Salary:</u></b></label><br />
	        <label id="salary" name="salary" style="margin-left: 20px;"><?php echo $staff->salary; ?></label>
    	</div><!-- End of Work Information -->
    
    	<?php if (isset($staff->resume) && !empty($staff->resume) && file_exists("uploads/resumes/" . $staff->resume)){ ?>
    		<div style="float: left;">
    			<label><b><u>Resume:</u></b></label><br />
		        <a href="uploads/resumes/<?php echo $staff->resume; ?>" target="_blank" style="margin-left: 20px;">Download</a>
		   	</div><!-- End of Resume -->
	   	<?php } ?>
	</div><!-- End of Information Box -->
</div><!-- End of View -->
<?php } ?>
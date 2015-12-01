<?php
/*	Staff Member edit page.
*----------------------------------------------------------------------------
*	Original Author: Joshua Thompson
*	Creation Date: 11/13/2015
*
*	Modification Author: Joshua Thompson
*	Modification Date: 11/30/2015
*----------------------------------------------------------------------------
*/

// if a message is set show message.
if (isset($message)) { ?>
<div id="message" align="center" style="margin:0px; padding-top:2.5px;"><?php echo $message; ?></div> <?php } // end if

// if no staff is set, show error message.
if (empty($staff)) echo "Error staff is nil.";

// Only show if we're a manager and arrived here from a staff request.
if ($_SESSION['access'] === "manager" && (!empty($_POST['approval_code'])))
{?>
	<div id="back_request" style="float: right; margin-right: 15px; margin-top: 12px;">
        <form action="?view" method="POST">
            <input type="hidden" id="access" name="access" value="client" />
            <input type="hidden" id="search" name="search" value="search" />
            <input  type = "hidden" id="approval_code" name="approval_code" value="<?php echo $_POST['approval_code']; ?>"/>
			<input type="submit" id="submit" name="submit" value="Go Back" />
		</form>
	</div>	
<?php } // end if

// Only show if we're the staff member associated with this profile.
if ($_SESSION['id'] === $id) { ?>
<div>
<form action="?edit" method="POST">
	<input type="hidden" id="edit" name="edit" />
	<input type="submit" id="submit" name="submit" value="Edit Profile" />
</form>
</div><?php } // end if

 if (isset($staff->picture) && !empty($staff->picture) && file_exists("uploads/pictures/" . $staff->picture)){ ?>
<img id="pic" name="pic" src="uploads/pictures/<?php echo $staff->picture; ?>" /> <?php } ?>
	<div id="availability" name="availability">
    	<label>Availability:</label><br />
        <label id="availabe" name="available"><?php echo (($staff->available === "0") ? "Not Available" : "Available"); ?></label>
    </div>

	<div id="information" name="information">
    	<label>First Name:</label><br />
        <label id="Fname" name="Fname" ><?php echo $staff->Fname; ?></label><br />
        <label>Last Name:</label><br />
        <label id="Lname" name="Lname"><?php echo $staff->Lname; ?></label><br />
        <label>City:</label><br />
        <label id="city" name="city"><?php echo $staff->city; ?></label><br />
        <label>State:</label><br />
        <label id="state" name="state"><?php echo $staff->state; ?></label><br />
        <label>Zip Code:</label><br />
        <label id="zip" name="zip"><?php echo $staff->zip; ?></label><br />
    </div>
    
    <div>
    	<label>Type of Work:</label><br />
        <label id="workType" name="workType"><?php echo $staff->workType; ?></label><br />
    	<label>Experience:</label><br />
        <label id="experience" name="experience"><?php echo $staff->experience; ?></label><br />
        <label>Education:</label><br />
		<label id="education" name="education"><?php echo (($staff->education === "0") ? "No Degree" : ($staff->education === "1") ? "High School" : "College" ); ?></label><br />
        <label>Salary:</label><br />
        <label id="salary" name="salary"><?php echo $staff->salary; ?></label>
    </div>
    
    <?php if (isset($staff->resume) && !empty($staff->resume) && file_exists("uploads/resumes/" . $staff->resume)){ ?>
    <div>
    	<label>Resume:</label><br />
        <a href="uploads/resumes/<?php echo $staff->resume; ?>" target="_blank">Download</a>
   </div><?php } ?>
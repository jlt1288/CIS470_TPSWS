<?php
/*	Staff Member edit page.
*----------------------------------------------------------------------------
*	Original Author: Joshua Thompson
*	Creation Date: 11/13/2015
*
*	Modification Author: Joshua Thompson
*	Modification Date: 11/13/2015
*----------------------------------------------------------------------------
*/

if (isset($message)) { ?>
<p id="message" align="center" style="margin:0px; padding-top:2.5px;"><?php echo $message; ?></p> <?php }

if ($_SESSION['id'] === $id) { ?>
<div>
<form action="?edit" method="POST">
	<input type="hidden" id="edit" name="edit" />
	<input type="submit" id="submit" name="submit" value="Edit Profile" />
</form>
</div><?php }

 if (isset($staff->picture)){ ?>
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
		<label id="education" name="education"><?php echo $staff->education; ?></label><br />
        <label>Salary:</label><br />
        <label id="salary" name="salary"><?php echo $staff->salary; ?></label>
    </div>
    
    <?php if (isset($staff->resume) && !empty($staff->resume)){ ?>
    <div>
    	<label>Resume:</label><br />
        <a href="uploads/resumes/<?php echo $staff->resume; ?>" target="_blank">Download</a>
   </div><?php } ?>
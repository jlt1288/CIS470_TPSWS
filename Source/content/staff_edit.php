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
<p id="message" align="center" style="margin:0px; padding-top:2.5px;"><?php echo $message ?></p><?php ; }?>

<div>
<form action="?view=<?php echo $_SESSION['id']; ?>" method="POST">
	<input type="submit" id="submit" name="submit" value="View Profile" />
</form>
</div>
<?php if (isset($staff->picture)){ ?>
<img id="pic" name="pic" src="uploads/pictures/<?php echo $staff->picture; ?>" /> <?php } ?>
<form method="POST" action="<?php $_SERVER["PHP_SELF"]; ?>?edit" enctype="multipart/form-data">
    <input type="hidden" name="type" value="picture" />
    <input type="file" name="picture" id="picture" required/>
    <br />
	<input type="submit" value="Upload" name="submit" id="submit" />
</form><br />

<form id="account" name="account" action="<?php $_SERVER['PHP_SELF']; ?>?edit" method="POST" >
    <input type="hidden" name="type" value="account" />
    <div id="e_mail" name="e_mail">
    	<label>E-Mail:</label><br />
        <input type="email" id="email" name="email" placeholder="E-Mail Address" value="<?php echo $user->email; ?>" /><br />
    </div>
    <div id="password" name="password">
		<label>Current Password:</label><br />
        <input type="password" title="Field cannot be left blank." pattern="\w+" placeholder="Password" id="current_pwd" name="current_pwd" required><br />
    	<label>Password:</label><br />
        <input placeholder="Password" id="pwd" name="pwd" title="Password must contain at least 6 characters, including UPPER/lowercase and numbers." type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}"><br />
    	<label>Confirm Password:</label><br />
        <input title="Please enter the same Password as above." type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" placeholder="Confirm Password" id="confirm_pwd" name="confirm_pwd"><br />
    </div>
    <input type="submit" id="submit" value="Submit" name="submit" />
</form><br />

<form action="<?php $_SERVER['PHP_SELF']; ?>?edit" method="POST">
	<input type="hidden" id="type" name="type" value="info" />
	<div id="availability" name="availability">
    	<label>Availability:</label><br />
        <select id="availabe" name="available">
        	<option value=0 <?php echo (($staff->available === "0") ? "selected" : ""); ?>>Not Available</option>
            <option value=1 <?php echo (($staff->available === "1") ? "selected" : ""); ?>>Available</option>
        </select>
    </div>
	<div id="information" name="information">
    	<label>First Name:</label><br />
        <input type="text" id="Fname" name="Fname" value="<?php echo $staff->Fname; ?>" required/><br />
        <label>Last Name:</label><br />
        <input type="text" id="Lname" name="Lname" value="<?php echo $staff->Lname; ?>" required/><br />
        <label>City:</label><br />
        <input id="city" name="city" value="<?php echo $staff->city; ?>"  required/><br />
        <label>State:</label><br />
        <select id="state" name="state" required><option value="0">Choose a state</option><?php echo listStates($staff->state); ?></select><br />
        <label>Zip Code:</label><br />
        <input type="text" pattern="[0-9]{5}" id="zip" name="zip" value="<?php echo $staff->zip; ?>" required/><br />
    </div>
    
    <div>
    	<label>Type of Work:</label><br />
        <select id="workType" name="workType" required>
        	<option value="Professional" <?php echo (($staff->workType === "Professional") ? "selected" : ""); ?>>Professional</option>
            <option value="Scientific" <?php echo (($staff->workType === "Scientific") ? "selected" : ""); ?>>Scientific</option>
        </select><br />
    	<label>Experience:</label><br />
        <input type="number" pattern="[0-9]{2}" id="experience" name="experience" value="<?php echo $staff->experience; ?>" required /><br />
        <label>Education:</label><br />
		<select id="education" name="education" required>
            <option value="0" <?php echo (($staff->education === "0") ? "selected" : ""); ?>>No Degree</option>
            <option value="1" <?php echo (($staff->education === "1") ? "selected" : ""); ?>>High School</option>
			<option value="2" <?php echo (($staff->education === "2") ? "selected" : ""); ?>>College</option>
        </select><br />
        <label>Salary:</label><br />
        <input type="text" pattern="[0-9]*\.[0-9]{2}" id="salary" name="salary" value="<?php echo $staff->salary; ?>" required/>
    </div>
    
    <div id="submit_form">
    	<input type="submit" id="submit" name="submit" value="Submit" />
    </div>
</form><br />

<form method="POST" action="<?php $_SERVER["PHP_SELF"]; ?>?edit" enctype="multipart/form-data">
	<table>
		<tr>
        	<th><label>Resume:</label></th>
        </tr>
        <tr>
			<th>
            	<?php // TODO: Get link from data base for user uploaded resume. ?>
                <input type="hidden" name="type" value="resume" />
			    <input type="file" name="resume" id="resume" required/>
				<input type="submit" value="Upload" name="submit" id="submit" />
            </th>
        </tr>
    </table>
</form>
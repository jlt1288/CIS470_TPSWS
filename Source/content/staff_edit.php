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
if (isset($message)) { ?> <div id="message" align="center" style="margin:0px; padding-top:2.5px;"><?php echo $message ?></div><!-- End of Message --><?php ; }?>

<div id="view">
	<div style="margin-bottom: 10px;">
		<form action="?view=<?php echo $_SESSION['id']; ?>" method="POST">
			<input type="submit" id="submit" name="submit" value="View Profile" />
		</form>
	</div><!-- End of View Profile -->
    
	<div style="float: left;">
		<img class="image" id="pic" name="pic" src="<?php echo ((!empty($staff->picture) && file_exists("uploads/pictures/" . $staff->picture)) ? 'uploads/pictures/' . $staff->picture : "styles/noperson.png"); ?>" /><br />
		<form style="margin-top:5px;" method="POST" action="<?php $_SERVER["PHP_SELF"]; ?>?edit" enctype="multipart/form-data">
		    <input type="hidden" name="type" value="picture" />
		    <input type="file" name="picture" id="picture" required/><br />
			<input type="submit" value="Upload" name="submit" id="submit" />
		</form><br />
	</div><!-- End of Upload Picture -->

	<div id="editInfoBox">
    	<div style="float:left;">
			<form id="account" name="account" action="<?php $_SERVER['PHP_SELF']; ?>?edit" method="POST">
			    <input type="hidden" name="type" value="account" />
			    <div id="eMail" name="eMail">
			    	<label>E-Mail:</label><br />
			        <input style="margin-bottom:5px;" type="email" id="email" name="email" placeholder="E-Mail Address" value="<?php echo $user->email; ?>" /><br />
			    </div><!-- End of Email -->
    			<div id="password" name="password">
					<label>Current Password:</label><br />
			        <input style="margin-bottom:5px;" type="password" title="Field cannot be left blank." x-moz-errormessage="Field cannot be left blank." pattern="\w+" placeholder="Password" id="current_pwd" name="current_pwd" required><br />
			    	<label>Password:</label><br />
			        <input style="margin-bottom:5px;" placeholder="Password" id="pwd" name="pwd" title="Password must contain at least 6 characters, including UPPER/lowercase and numbers." x-moz-errormessage="Password must contain at least 6 characters, including UPPER/lowercase and numbers." type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}"><br />
			    	<label>Confirm Password:</label><br />
			        <input style="margin-bottom:10px;" title="Please enter the same Password as above." type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" placeholder="Confirm Password" id="confirm_pwd" name="confirm_pwd"><br />
			    </div><!-- End of Password -->
			    <input type="submit" id="submit" value="Submit" name="submit" />
			</form><br />
		</div><!-- End of Account -->

		<form action="<?php $_SERVER['PHP_SELF']; ?>?edit" method="POST" style="margin-left: 300px;">
			<input type="hidden" id="type" name="type" value="info" />
			<div id="availability" name="availability">
		    	<label>Availability:</label><br />
		        <select id="availabe" name="available">
        			<option value=0 <?php echo (($staff->available === "0") ? "selected" : ""); ?>>Not Available</option>
		            <option value=1 <?php echo (($staff->available === "1") ? "selected" : ""); ?>>Available</option>
		        </select>
		    </div><!-- End of Availability -->

			<div id="information" name="information">
		    	<label>First Name:</label><br />
        		<input style="margin-bottom:5px;" type="text" id="Fname" name="Fname" value="<?php echo $staff->Fname; ?>" required/><br />
		        <label>Last Name:</label><br />
		        <input style="margin-bottom:5px;" type="text" id="Lname" name="Lname" value="<?php echo $staff->Lname; ?>" required/><br />
		        <label>City:</label><br />
		        <input style="margin-bottom:5px;" id="city" name="city" value="<?php echo $staff->city; ?>"  required/><br />
		        <label>State:</label><br />
		        <select style="margin-bottom:5px;" id="state" name="state" required><option value="0">Choose a state</option><?php echo listStates($staff->state); ?></select><br />
        		<label>Zip Code:</label><br />
		        <input style="margin-bottom:5px;" type="text" placeholder="12345" pattern="[0-9]{5}" id="zip" name="zip" value="<?php echo $staff->zip; ?>" required title="Please input the zip code in the correct format: 00000" x-moz-errormessage="Please input the zip code in the correct format: 00000" /><br />
            </div><!-- End of Information -->
            
            <div>
		    	<label>Type of Work:</label><br />
		        <select style="margin-bottom:5px;" id="workType" name="workType" required>
		        	<option value="Professional" <?php echo (($staff->workType === "Professional") ? "selected" : ""); ?>>Professional</option>
        		    <option value="Scientific" <?php echo (($staff->workType === "Scientific") ? "selected" : ""); ?>>Scientific</option>
		        </select><br />
		    	<label>Experience:</label><br />
		        <input style="margin-bottom:5px;" type="number" max="99" min="1.00" id="experience" name="experience" value="<?php echo $staff->experience; ?>" required /><br />
        		<label>Education:</label><br />
				<select style="margin-bottom:5px;" id="education" name="education" required>
		            <option value="0" <?php echo (($staff->education === "0") ? "selected" : ""); ?>>No Degree</option>
		            <option value="1" <?php echo (($staff->education === "1") ? "selected" : ""); ?>>High School</option>
					<option value="2" <?php echo (($staff->education === "2") ? "selected" : ""); ?>>College</option>
		        </select><br />
		        <label>Salary:</label><br />
		        <input style="margin-bottom:10px;" type="text" placeholder="0.00" pattern="^[1-9]\d*\.[0-9]{2}" id="salary" name="salary" value="<?php echo $staff->salary; ?>" required title="Please input the salary in the correct format: 0.00" x-moz-errormessage="Please input the salary in the correct format: 0.00"/>
			</div><!-- End of Work Information -->
    
		    <div id="submit_form">
		    	<input type="submit" id="submit" name="submit" value="Submit" />
		    </div><!-- End of Submit Information -->
		</form><br />
	</div><!-- End of Information Box -->

	<form method="POST" action="<?php $_SERVER["PHP_SELF"]; ?>?edit" enctype="multipart/form-data">
		<table>
			<tr>
        		<td><label><b>Resume:</b></label></td>
	        </tr>
            <tr>
            	<td>
                	<a href="uploads/resumes/<?php echo $staff->resume; ?>" target="_blank">Download Resume</a>
                <td>
            </tr>
    	    <tr>
				<td>
                	<input type="hidden" name="type" value="resume" />
				    <input type="file" name="resume" id="resume" required/>
					<input type="submit" value="Upload" name="submit" id="submit" />
        	    </td>
	        </tr>
    	</table>
	</form>
</div><!-- End of View -->
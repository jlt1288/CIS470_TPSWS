<?php
/*	Create New Staffing Request page.
*----------------------------------------------------------------------------
*	Original Author: Joshua Thompson
*	Creation Date: 11/13/2015
*
*	Modification Author: Joshua Thompson
*	Modification Date: 11/20/2015
*----------------------------------------------------------------------------
*/

if (isset($message))
{
	echo $message;
}
else{
?>
<form action="<?php echo $_SERVER['PHP_SELF'] . "?request"; ?>" method="POST" name="form1">
	<div>
    	<label>Type of Work:</label>
        <select id="workType" name="workType" required>
        	<option value="Professional" <?php echo (($_POST['workType'] === "Professional") ? "selected" : ""); ?>>Professional</option>
            <option value="Scientific" <?php echo (($_POST['workType'] === "Scientific") ? "selected" : ""); ?>>Scientific</option>
        </select><br />
        <label>Experience:</label>
        <input type="number" id="experience" name="experience" min="1" max="99" value="<?php echo $_POST['experience']; ?>" required/><br />
        <label>Education:</label>
        <select id="education" name="education" required>
        	<option value="0" <?php echo (($_POST['education'] === "0") ? "selected" : ""); ?>>No Degree</option>
            <option value="1" <?php echo (($_POST['education'] === "1") ? "selected" : ""); ?>>High School</option>
            <option value="2" <?php echo (($_POST['education'] === "2") ? "selected" : ""); ?>>College</option>
        </select><br />
        <label>Salary:</label>
        <input type="text" pattern="^[1-9]\d*\.[0-9]{2}" id="salary" name="salary" value="<?php echo $_POST['salary']; ?>" required/><br />
        <label>Zip Code:</label>
        <input type="text" pattern="[0-9]{5}" id="zip" name="zip" value="<?php echo $_POST['zip']; ?>" required/><br />
        <label>Search Distance:</label>
        <select name="distance">
            <option value="5" <?php if($_POST['distance'] == "5") { echo "selected"; } ?>>5</option>
            <option value="10" <?php if($_POST['distance'] == "10") { echo "selected"; } ?>>10</option>
            <option value="25" <?php if($_POST['distance'] == "25") { echo "selected"; } ?>>25</option>
            <option value="50" <?php if($_POST['distance'] == "50") { echo "selected"; } ?>>50</option>
        	<option value="100" <?php if($_POST['distance'] == "100") { echo "selected"; } ?>>100</option>
		</select><br />
        <input type="submit" name="search" id="search" value="Search" />
	</div>

	<div>
    	<!-- TODO: Create the select for the potential candidates. -->
        
	    <?php
		    if ($_POST['search'])
			{
				// Get the list of potential candidates.
				if (($candidates = Client::search($_POST['workType'], $_POST['experience'], $_POST['education'], $_POST['salary'], $_POST['zip'], $_POST['distance'])) !== false && count($candidates) >= 1)
				{ 
				?>
				<div id="potential_candidates">
					<?php 
					$i = 0;
					foreach ($candidates as $row)
					{ 
						$staff = new Staff($row['userID']);?>
                    <div id="candidate<?php echo $i; ?>" onclick='selectCandidate(<?php echo $i; ?>)'>
                    	<?php if (!empty($staff->picture)){ ?><img src="uploads/pictures/<?php echo $staff->picture; ?>" /><br /><?php }?>
                        <label><?php echo $staff->Fname . " " . $staff->Lname; ?></label><br />
                        <label>Experience: <?php echo $staff->experience; ?> Year(s)</label><br />
                        <label>Education: <?php echo (($staff->education === "0") ? "No Degree" : ($staff->education === "1") ? "High School" : "College" ); ?></label><br />
                        <label>Desired Salary: $<?php echo $staff->salary; ?></label><br />
                        <?php if (!empty($staff->resume)) { ?><a href="uploads/resumes/<?php echo $staff->resume; ?>" target="_blank">View Resume</a><br /><?php } ?>
    	                <input type="checkbox" id="candidates[]" name='candidates[]' onclick='selectCandidate(<?php echo $i; ?>)' value="<?php echo $staff->id; ?>"/>
                    </div>
					<?php $i++; }?>					
                </div>
				<?php }
				else 
				{
					echo $GLOBALS['message'];
				}
			}
			
			
		?>
        
    </div>
    
   	<?php
		if ($_POST['search'])
		{ ?>
	<div>
    	<input type="submit" name="submit" id="submit" value="Submit" />
    </div>
    <?php } ?>
</form>
<?php } ?>
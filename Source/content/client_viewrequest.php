<?php
/*	View Staffing Request page.
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

<div id="request">
	<div id="state">
		<label>Status: </label>
		<?php if (($_SESSION['access'] === "manager" && $request->status !== "VALID") || $_SESSION['access'] === "client") { ?><label id="status" name="status"><?php echo $request->status; ?></label><br /><?php } else { ?>
        <select id="status" anme="status">
			<option value="VALID" selected>VALID</option>
            <option value="INVALID">INVALID</option>
            <option value="UNABLE TO FILL">UNABLE TO FILL</option>
            <option value="FILLED">FILLED</option>
        </select><br /><?php } ?>
		<label>Date Opened: </label>
		<label id="dateOpened" name="dateOpened"><?php echo $request->dateOpened; ?></label><br />
    </div>
    
    <div id="info">
    	<label>Work Type: </label>
        <label id="workType" name="workType"><?php echo $request->workType; ?></label><br />
    	<label>Desired Experience: </label>
        <label id="experience" name="experience"><?php echo $request->experience; ?></label><br />
        <label>Desired Education: </label>
        <label id="eduation" name="education"><?php echo (($request->education === "0") ? "No Degree" : ($request->education === "1") ? "High School" : "College"); ?></label><br />
   	    <label>Location: </label>
        <label id="zip" name="zip"><?php echo $request->zip; ?></label><br />
        <label>Desired Distance: </label>
        <label id="distance" name="distance"><?php echo $request->distance; ?></label><br />
        
    </div>
    
    <div id="candidates">
    	<table>    
        	<tr>        	
    	<?php if (($candidates = $request->getCandidates()) === false){
				echo '<h2>There are no candidates associated with this staffing request.</h2>';				
			} else {
				foreach ($candidates as $candidate)
				{
					$staff = new Staff($candidate['staffID']);
		?>		
				<th>
                	<div>
                    	<?php if (!empty($staff->picture)) { ?><img src="uploads/pictures/<?php echo $staff->picture; ?>" /><br /><?php } ?>
                		<label><?php echo $staff->Fname . " " . $staff->Lname; ?></label><br />
	                    <label><?php echo $staff->city . ", " . $staff->state . " " . $staff->zip;?></label><br />
    	                <label>Experience: <?php echo $staff->experience . " Years"; ?></label><br />
        	            <label>Education: <?php echo (($staff->education === "0") ? "No Degree" : ($staff->education === "1") ? "High School" : "College"); ?></label><br />
            	        <label>Salary: <?php echo "$" . $staff->salary; ?></label>
                	    <?php
							if ($_SESSION['acccess'] === "manager")
							{
						?>
    	                <br /><a href="?page=staff&view=<?php echo $staff->id; ?>">View Profile</a>
        	            <?php } ?>
                	</div>
				</th>
		<?php		
				}
			}
		?>
        	</tr>
    	</table>
    </div>


</div>

<?php }?>
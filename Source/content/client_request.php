<?php
/*	Create New Staffing Request page.
*----------------------------------------------------------------------------
*	Original Author: Joshua Thompson
*	Creation Date: 11/13/2015
*
*	Modification Author: Joshua Thompson
*	Modification Date: 12/03/2015
*----------------------------------------------------------------------------
*/

// If there is an error message display it.
if (isset($message)) {?><div id="message" align="center" style="margin:0px; padding-top:2.5px;"><?php echo $message; ?></div><?php }
// Otherwise display layout.
else{
?>
<h3 style= "margin-left: 20px; margin-top: -1em; padding-top: 15px; color: #202020;"><u>Create New Request</u></h3>
<div id="searchBox">
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>?request" method="POST" name="form1">
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
		</div> <!-- End of Begin Search -->

		<div id="resultsBox">       
		    <?php
				// Ensure we've searched and are looking at a page.
			    if ($_POST['search'] || !empty($_REQUEST['page']))
				{		
					$hasResults = false;	
					// Get the list of potential candidates.
					if (($candidates = Client::search($_POST['workType'], $_POST['experience'], $_POST['education'], $_POST['salary'], $_POST['zip'], $_POST['distance'], (!empty($_REQUEST['page']) ? $_REQUEST['page'] : 1))) !== false && count($candidates->data) >= 1)
					{ 
						$hasResults = true; ?>
						<table>
							<tr>
                				<?php if (!empty($_POST['candidates']))
									{
										$i = 0;
										foreach ($_POST['candidates'] as $candidate) :
											$staff = new Staff($candidate); ?>
                                          <td>                    
                                          	<img class="image" src="<?php echo ((!empty($staff->picture) && file_exists($staff->picture)) ? 'uploads/pictures/' . $staff->picture : "styles/noperson.png"); ?>" /><br />
                                          	<label><?php echo $staff->Fname . " " . $staff->Lname; ?></label><br />
	                                        <label>Experience: <?php echo $staff->experience; ?> Year(s)</label><br />
    	                                    <label>Education: <?php echo (($staff->education === "0") ? "No Degree" : ($staff->education === "1") ? "High School" : "College" ); ?></label><br />
        	                                <label>Desired Salary: $<?php echo $staff->salary; ?></label><br />
                                          	<?php if (!empty($staff->resume)) { ?><a href="uploads/resumes/<?php echo $staff->resume; ?>" target="_blank">View Resume</a><br /><?php } // end if ?>
                                          	<input type="checkbox" id="candidates[]" name="candidates[]" onchange="selectCandidate(this)" value="<?php echo $staff->id; ?>" checked/>
                                          </td>
										<?php $i++; endforeach;// end foreach
									}// end if?>
							</tr>
							<tr>
								<?php 
									for ($i = 0; $i < count ($candidates->data); $i++) :
					
										// Only show 3 results per row.
										if ($i % 3 === 0) { echo '</tr><tr>'; } // end if
						
										// Don't show selected potential candidates again.
										if (!empty($_POST['candidates']) && in_array($candidates->data[$i]['userID'], $_POST['candidates'])) { continue; } // end if
							
										// Create the staff information for the candidate.
										$staff = new Staff($candidates->data[$i]['userID']);?>
                                        
                        				<td>                    
                    						<img class="image" src="<?php echo ((!empty($staff->picture) && file_exists($staff->picture)) ? 'uploads/pictures/' . $staff->picture : "styles/noperson.png"); ?>" /><br />
                        					<label><?php echo $staff->Fname . " " . $staff->Lname; ?></label><br />
                        					<label>Experience: <?php echo $staff->experience; ?> Year(s)</label><br />
                        					<label>Education: <?php echo (($staff->education === "0") ? "No Degree" : ($staff->education === "1") ? "High School" : "College" ); ?></label><br />
                        					<label>Desired Salary: $<?php echo $staff->salary; ?></label><br />
                        					<?php if (!empty($staff->resume)) { ?><a href="uploads/resumes/<?php echo $staff->resume; ?>" target="_blank">View Resume</a><br /><?php } // end if ?>
    	                					<input type="checkbox" id="candidates[]" name="candidates[]" onchange='selectCandidate(this)' value="<?php echo $staff->id; ?>"/>
                        				</td>
								<?php endfor;?>
                    		</tr>					
                	</table>                    
					<div>
				    	<input type="submit" name="submit" id="submit" value="Submit" />
				    </div><!-- End of Submit Request -->
				<?php }// end if
				else 
				{ ?>
					<div id="message">
                    	<label>No potential candidates found.</label>
                    </div><!-- End of Message -->                              
				<?php } // end if-else
			}// end if ?>
		</div><!-- End of Results Box -->
        
        <?php if (!empty($candidates) || isset($candidates)){ ?>
	        <div id="links">
				<!-- Links are in <ul> <li>LINK</li> <li>LINK2</li> </ui> tags. -->
				<?php echo $candidates->links; ?>
			</div><!-- End of Links -->
        <?php } //end if ?>
	</form>
</div><!-- End of Search Box -->
<?php } ?>
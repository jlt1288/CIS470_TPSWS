<?php
/*	View Staffing Request page.
*----------------------------------------------------------------------------
*	Original Author: Joshua Thompson
*	Creation Date: 11/13/2015
*
*	Modification Author: Joshua Thompson
*	Modification Date: 12/03/2015
*----------------------------------------------------------------------------
*/
if (isset($message))
{?>
	<div id="message">
    	<label><?php echo $message; ?></label>
	</div>
<?php } elseif (!empty($request)){?>
	<div id="resultsBox">
		<div id="state">
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
              <label>Date Opened: </label>
              <label id="dateOpened" name="dateOpened"><?php echo $request->dateOpened; ?></label><br />
              <label>Status: </label>
              <?php if (($_SESSION['access'] === "manager" && $request->status != "VALID") || $_SESSION['access'] === "client") { ?>
                  <label id="status" name="status"><?php echo $request->status; ?></label><br />
              <?php } else { ?>
                  <select id="status" name="status">
                      <option value="VALID" selected>VALID</option>
                      <option value="INVALID">INVALID</option>
                      <option value="UNABLE TO FILL">UNABLE TO FILL</option>
                      <option value="FILLED">FILLED</option>
                  </select><br />
                  <input type="hidden" name="approval_code" id="approval_code" value="<?php echo $_POST['approval_code']; ?>" />
                  <input type="hidden" name="search" id="search" value="<?php echo $request->id; ?>" />
                  <input type="hidden" name="access" id="access" value="client" />
                  <input type="submit" name="submit" id="submit" value="Submit" />
              <?php } ?>		
          </form>
      </div>
      
      <div id="info">
          <label>Work Type: </label>
          <label id="workType" name="workType"><?php echo $request->workType; ?></label><br />
          <label>Desired Experience: </label>
          <label id="experience" name="experience"><?php echo $request->experience . " Year(s)";; ?></label><br />
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
                  <?php if (($candidates = $request->getCandidates()) === false){ ?>
                      <h2>There are no candidates associated with this staffing request.</h2>				
                  <?php } else {
                      foreach ($candidates as $candidate) :
                      
                          $staff = new Staff($candidate['staffID']);?>		
                          <td>
                              <div id="candidate">
                                  <img class="image" src="<?php echo ((!empty($staff->picture) && file_exists($staff->picture)) ? 'uploads/pictures/' . $staff->picture : "styles/noperson.png"); ?>" /><br />
                                  <label><?php echo $staff->Fname . " " . $staff->Lname; ?></label><br />
                                  <label><?php echo $staff->city . ", " . $staff->state . " " . $staff->zip;?></label><br />
                                  <label>Experience: <?php echo $staff->experience . " Year(s)"; ?></label><br />
                                  <label>Education: <?php echo (($staff->education === "0") ? "No Degree" : ($staff->education === "1") ? "High School" : "College"); ?></label><br />
                                  <label>Salary: <?php echo "$" . $staff->salary; ?></label>
                                  <?php if ($_SESSION['access'] === "manager") { ?>
                                      <div id="managerBox">
                                          <form action="<?php echo $_SERVER['PHP_SELF']; ?>?view" method="POST">
                                              <input type="hidden" name="approval_code" id="approval_code" value="<?php echo $request->approvalNumber; ?>" />
                                              <input type="hidden" name="id" id="id" value="<?php echo $candidate['staffID']; ?>" />
                                              <input type="hidden" name="access" id="access" value="staff" />
                                              <input type="submit" name="search" id="search" value="View Profile" />
                                            </form>
                                      </div> <!-- End of Manager Box -->
                                   <?php } ?>
                             </div> <!-- End of Candidate -->
                          </td>
                  <?php endforeach;
                  } // end else ?>
              </tr>
          </table>
      </div><!-- End of Candidates -->
  </div><!-- End of Results Box -->
<?php } else {?>
	<div id="message">
    	<label>No search results found.</label>
    </div><!-- End of Message -->
<?php } // end else ?>
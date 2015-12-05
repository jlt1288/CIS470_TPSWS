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
	<h3 style= "margin-left: 15px; margin-top: 0px; padding-top: 15px; color: #202020;"><u>View Requests</u></h3>
	<div id="message" style="margin:0px; margin-left: 20px; font-size: 18px; padding:5px; color:red">
    	<label><b><?php echo $message; ?></b></label>
	</div>
<?php } elseif (!empty($request)){?>
	<div>
	<h3 style= "margin-left: 20px; margin-top: 0px; padding-top: 15px; color: #202020;"><u>View Requests</u></h3>
		<div id="viewRequestBox">
		<div id="state">
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
              <label><b>Status: </b></label>
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
                  <input type="submit" style="margin:5px; margin-left:0px;" name="submit" id="submit" value="Submit" /><br />
              <?php } ?>	
			  <label><b>Date Opened: </b></label>
              <label id="dateOpened" name="dateOpened"><?php echo $request->dateOpened; ?></label><br />
          </form>
      </div>
      
      <div id="info">
          <label><b>Work Type: </b></label>
          <label id="workType" name="workType"><?php echo $request->workType; ?></label><br />
          <label><b>Desired Experience: </b></label>
          <label id="experience" name="experience"><?php echo $request->experience . " Year(s)";; ?></label><br />
          <label><b>Desired Education: </b></label>
          <label id="eduation" name="education"><?php echo (($request->education === "0") ? "No Degree" : ($request->education === "1") ? "High School" : "College"); ?></label><br />
          <label><b>Location: </b></label>
          <label id="zip" name="zip"><?php echo $request->zip; ?></label><br />
          <label><b>Desired Distance: </b></label>
          <label id="distance" name="distance"><?php echo $request->distance; ?></label><br />
      </div>
      </div>
      <div id="candidates">
	  <h3 style= "margin-left: 410px; margin-top: 12px; color: #E0E0E0;"><u>Candidates</u></h3>
          <table style="margin-top: 40px; width: 910px;">    
              <tr>        	
                  <?php if (($candidates = $request->getCandidates()) === false){ ?>
                      <h2>There are no candidates associated with this staffing request.</h2>				
                  <?php } else {
                      foreach ($candidates as $candidate) :
                      
                          $staff = new Staff($candidate['staffID']);?>		
                          <td align="center">
                              <div id="candidate">									
                                  <?php if (!empty($staff->picture)) { ?><img class="image" src="uploads/pictures/<?php echo $staff->picture; ?>" /><br /><?php } ?>
								  <?php if (empty($staff->picture)) { ?><img class="image" src="uploads/pictures/noperson.png<?php echo $staff->picture; ?>" /><br /><?php } ?>
                                  <label><?php echo $staff->Fname . " " . $staff->Lname; ?></label><br />
                                  <label><?php echo $staff->city . ", " . $staff->state . " " . $staff->zip;?></label><br />
                                  <label>Experience: <?php echo $staff->experience . " Year(s)"; ?></label><br />
                                  <label>Education: <?php echo (($staff->education === "0") ? "No Degree" : ($staff->education === "1") ? "High School" : "College"); ?></label><br />
                                  <label>Salary: <?php echo "$" . $staff->salary; ?></label>
                                  <?php if ($_SESSION['access'] === "manager") { ?>
                                      <div>
                                          <form action="<?php echo $_SERVER['PHP_SELF']; ?>?view" method="POST">
                                              <input type="hidden" name="approval_code" id="approval_code" value="<?php echo $request->approvalNumber; ?>" />
                                              <input type="hidden" name="id" id="id" value="<?php echo $candidate['staffID']; ?>" />
                                              <input type="hidden" name="access" id="access" value="staff" />
                                              <input type="submit" name="search" id="search" value="View Profile" />
                                            </form>
                                      </div><!-- End of Manager Box -->
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
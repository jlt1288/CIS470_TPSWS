<?php
/*	Manager landing page.
*----------------------------------------------------------------------------
*	Original Author: Joshua Thompson
*	Creation Date: 11/27/2015
*
*	Modification Author: Joshua Thompson
*	Modification Date: 11/30/2015
*----------------------------------------------------------------------------
*/

// get new staffing requests which are valid. Invalid, Unable to Fill or Filled requests will not be shown as they are closed out.
if ($results = Request::getNew((!empty($_POST['page']) ? $_POST['page'] : 1 ))) { ?>

	<div style="float: left; margin-top: 0px; font-size: 18px;">Staff Requests:</div><br /><br />
	<table align="center">
    	<tr>
	   		<th>Date Opened</th>
            <th>Status</th>
           	<th>Approval Code</th>
       	</tr>
    <?php 
		// iterate through the requests.
		for ($i = 0; $i < count ($results->data); $i++) :
		
			$request = new Request($results->data[$i]);
	?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
       		<tr>
            	<td><?php echo $request->dateOpened; ?></td>
                <td><?php echo $request->status; ?></td>
	           	<td><?php echo $request->approvalNumber; ?></td>               	   	        
        	    <td>
                	<input type="hidden" name="search" id="search" value="search" />
                	<input type="hidden" name="approval_code" id="approval_code" value="<?php echo $request->approvalNumber; ?>" />
                	<input type="hidden" name="access" id="access" value="client" />
                	<input type="submit" name="submit" id="submit" value="View Request" />
                </td>
        	</tr>
        </form>
    <?php	
	
		endfor;
	?>
    </table>
   	<div id="links">
		<?php echo $results->links; ?>
	</div>
<?php
} else
{
	// Show error message if there is an error message.
	if (!empty($GLOBALS['message'])) { ?>
	
    	<div id="message">
    		<label><?php echo $GLOBALS['message']; ?></label>
	    </div>
<?php } // end if

}// end if

?>
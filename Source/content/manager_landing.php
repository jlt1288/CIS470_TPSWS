<?php
/*	Manager landing page.
*----------------------------------------------------------------------------
*	Original Author: Joshua Thompson
*	Creation Date: 11/27/2015
*
*	Modification Author: Joshua Thompson
*	Modification Date: 11/27/2015
*----------------------------------------------------------------------------
*/

if ($results = Request::getNew((!empty($_POST['page']) ? $_POST['page'] : 1 ))) { ?>
	<table>
    	<tr>
	   		<th>Date Opened</th>
            <th>Status</th>
           	<th>Approval Code</th>
	        <th>Work Type</th>
            <th>Experience</th>
            <th>Education</th>
            <th>Salary</th>
       	</tr>
    <?php 
		for ($i = 0; $i < count ($results->data); $i++) :
		
			$request = new Request($results->data[$i]);
	?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
       		<tr>
            	<td><?php echo $request->dateOpened; ?></td>
                <td><?php echo $request->status; ?></td>
	           	<td><?php echo $request->approvalNumber; ?></td>
                <td><?php echo $request->workType; ?></td>
                <td><?php echo $request->experience; ?> Year(s)</td>
                <td><?php echo (($staff->education === "0") ? "No Degree" : ($staff->education === "1") ? "High School" : "College" ); ?></td>
                <td><?php echo $request->salary; ?></td>                	   	        
        	    <td>
                	<input type="hidden" name="search" id="search" value="search" />
                	<input type="hidden" name="approval_code" id="approval_code" value="<?php echo $request->approvalNumber; ?>" />
                	<input type="hidden" name="access" id="access" value="client" />
                	<input type="submit" name="submit" id="submit" value="View Request" />
                </td>
        	</tr>
        </form><br />
    <?php	
	
		endfor;
	?>
    </table>
<?php 
	echo $results->links;
}
else
{
	if (!empty($GLOBALS['message'])) { ?>
	
    	<div id="message" name="message">
    		<label><?php echo $GLOBALS['message']; ?></label>
	    </div>
<?php } // end if

}// end if

?>
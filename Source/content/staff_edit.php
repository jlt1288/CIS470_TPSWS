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

$id = $_SESSION['id'];

// Connect to the database for further use.
require_once( 'scripts/database.php' );

// Run query to find if the username/password combination exists.
// TODO: Change table, values, and variables to be in line with the database.
$sql = "SELECT * FROM staff WHERE userID = '$id'";
$result = $connection->query($sql) or die('Error: ' . mysqli_error($connection));

if (mysqli_num_rows($result)===0){
	$message = "No such users exists.";
} else {
	$row = mysqli_fetch_assoc($result);		
}

function listStates($selected)
{
	$states_arr = array('AL'=>"Alabama",'AK'=>"Alaska",'AZ'=>"Arizona",'AR'=>"Arkansas",'CA'=>"California",'CO'=>"Colorado",'CT'=>"Connecticut",'DE'=>"Delaware",'DC'=>"District Of Columbia",'FL'=>"Florida",'GA'=>"Georgia",'HI'=>"Hawaii",'ID'=>"Idaho",'IL'=>"Illinois", 'IN'=>"Indiana", 'IA'=>"Iowa",  'KS'=>"Kansas",'KY'=>"Kentucky",'LA'=>"Louisiana",'ME'=>"Maine",'MD'=>"Maryland", 'MA'=>"Massachusetts",'MI'=>"Michigan",'MN'=>"Minnesota",'MS'=>"Mississippi",'MO'=>"Missouri",'MT'=>"Montana",'NE'=>"Nebraska",'NV'=>"Nevada",'NH'=>"New Hampshire",'NJ'=>"New Jersey",'NM'=>"New Mexico",'NY'=>"New York",'NC'=>"North Carolina",'ND'=>"North Dakota",'OH'=>"Ohio",'OK'=>"Oklahoma", 'OR'=>"Oregon",'PA'=>"Pennsylvania",'RI'=>"Rhode Island",'SC'=>"South Carolina",'SD'=>"South Dakota",'TN'=>"Tennessee",'TX'=>"Texas",'UT'=>"Utah",'VT'=>"Vermont",'VA'=>"Virginia",'WA'=>"Washington",'WV'=>"West Virginia",'WI'=>"Wisconsin",'WY'=>"Wyoming");
		
   	$string = '';
    foreach($states_arr as $k => $v)
	{
		$s = (($selected === $k) ? "selected" : "");
   		$string .= '<option value="'.$k.'" '.$s.'>'.$v.'</option>'."\n";
	}
	return $string;
}

if (isset($row['picture'])){ ?>
<img id="pic" name="pic" src="uploads/pictures/<?php echo $row['picture']; ?>" /> <?php } ?>
<form method="POST" action="<?php $_SERVER["PHP_SELF"]; ?>" enctype="multipart/form-data">
    <input type="hidden" name="type" value="picture" />
    <input type="file" name="picture" id="picture" required/>
    <br />
	<input type="submit" value="Upload" name="submit" id="submit" />
</form>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
	<input type="hidden" id="type" name="type" value="info" />
	<div id="availability" name="availability">
    	<label>Availability:</label><br />
        <select id="availabe" name="available">
        	<option value=0 <?php echo (($row["available"] === "0") ? "selected" : ""); ?>>Not Available</option>
            <option value=1 <?php echo (($row["available"] === "1") ? "selected" : ""); ?>>Available</option>
        </select>
    </div>
    <div id="password" name="password">
    	<label>Password:</label><br />
        <input type="password" id="pwd" name="pwd" /><br />
    	<label>Confirm Password:</label><br />
        <input type="password" id="confirm_pwd" name="confirm_pwd" /><br />        
    </div>

	<div id="information" name="information">
    	<label>First Name:</label><br />
        <input type="text" id="Fname" name="Fname" value="<?php echo $row['Fname']; ?>"/><br />
        <label>Last Name:</label><br />
        <input type="text" id="Lname" name="Lname" value="<?php echo $row['Lname']; ?>"/><br />
        <label>City:</label><br />
        <input id="city" name="city" value="<?php echo $row['city']; ?>"/><br />
        <label>State:</label><br />
        <select id="state" name="state"><option value="0">Choose a state</option><?php echo listStates($row['state']); ?></select><br />
        <label>Zip Code:</label><br />
        <input type="text" pattern="[0-9]{5}" id="zip" name="zip" value="<?php echo $row['zip']; ?>" /><br />
    </div>
    
    <div>
    	<label>Experience:</label><br />
        <input type="number" pattern="[0-9]{2}" id="experience" name="experience" value="<?php echo $row['experience']; ?>" /><br />
        <label>Education:</label><br />
		<select id="education" name="education">
            <option value="No Degree" <?php echo (($row['education'] === "No Degree") ? "selected" : ""); ?>>No Degree</option>
            <option value="High School" <?php echo (($row['education'] === "High School") ? "selected" : ""); ?>>High School</option>
			<option value="College" <?php echo (($row['education'] === "College") ? "selected" : ""); ?>>College</option>
        </select><br />
        <label>Salary:</label><br />
        <input type="test" pattern="[0-9]*\.[0-9]{2}" id="salary" name="salary" value="<?php echo $row['salary']; ?>"/>
    </div>
    
    <div id="submit_form">
    	<input type="submit" id="submit" name="submit" value="Submit" />
    </div>
</form>

<form method="POST" action="<?php $_SERVER["PHP_SELF"]; ?>" enctype="multipart/form-data">
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
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
$sql = "SELECT * FROM staff INNER JOIN users ON staff.userID=users.userID";
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

if (isset($message)) { echo '<p id="message" align="center" style="margin:0px; padding-top:2.5px;">' . $message . '</p>'; }?>

<div id="view">
	<div>
		<form action="?view=<?php echo $_SESSION['id']; ?>" method="POST" style="margin-bottom: 10px;">
			<input type="submit" id="submit" name="submit" value="View Profile" />
		</form>
	</div>
	
<?php if (isset($row['picture'])){ ?>
	<div style="float: left;">
		<img id="pic" name="pic" src="uploads/pictures/<?php echo $row['picture']; ?>" /> <?php } ?>
		<form method="POST" action="<?php $_SERVER["PHP_SELF"]; ?>?edit" enctype="multipart/form-data">
			<input type="hidden" name="type" value="picture" />
			<input type="file" style="margin-top: 7px;" name="picture" id="picture" required/>
			<br />
			<input type="submit" style="margin-top: 10px;" value="Upload" name="submit" id="submit" />
		</form><br />
	</div>

<div id="infoBox">
	<div style="float:left;">
		<form id="account" name="account" action="<?php $_SERVER['PHP_SELF']; ?>?edit" method="POST" onsubmit="return checkForm(this);">
		<input type="hidden" name="type" value="account" />
		<div id="e_mail" name="e_mail">
			<label>E-Mail:</label><br />
			<input type="email" id="email" style="margin:5px;" name="email" placeholder="E-Mail Address" value="<?php echo $row['userEmail']; ?>" />
		</div>
		<div id="password" name="password">
			<label>Current Password:</label><br />
			<input type="password"  style="margin:5px;" title="Field cannot be left blank." pattern="\w+" placeholder="Password" id="current_pwd" name="current_pwd" required><br />
			<label>Password:</label><br />
			<input placeholder="Password"  style="margin:5px;" id="pwd" name="pwd" title="Password must contain at least 6 characters, including UPPER/lowercase and numbers." type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}"><br />
			<label>Confirm Password:</label><br />
			<input title="Please enter the same Password as above."  style="margin:5px;" type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" placeholder="Confirm Password" id="confirm_pwd" name="confirm_pwd"><br />
		</div>
		<input type="submit" style="margin-top: 10px;" id="submit" value="Submit" name="submit" />
		</form>
	</div>

<form action="<?php $_SERVER['PHP_SELF']; ?>?edit" method="POST" style="margin-left: 300px;">
	<input type="hidden" id="type" name="type" value="info" />
	<div id="availability" name="availability">
    	<label>Availability:</label><br />
        <select id="availabe" name="available"  style="margin:5px;">
        	<option value=0 <?php echo (($row["available"] === "0") ? "selected" : ""); ?>>Not Available</option>
            <option value=1 <?php echo (($row["available"] === "1") ? "selected" : ""); ?>>Available</option>
        </select>
    </div>
	<div id="information" name="information">
    	<label>First Name:</label><br />
        <input type="text" id="Fname"  style="margin:5px;" name="Fname" placeholder="First Name" value="<?php echo $row['Fname']; ?>" required/><br />
        <label>Last Name:</label><br />
        <input type="text" id="Lname"  style="margin:5px;" name="Lname" placeholder="Last Name" value="<?php echo $row['Lname']; ?>" required/><br />
        <label>City:</label><br />
        <input id="city" name="city"  style="margin:5px;" placeholder="City" value="<?php echo $row['city']; ?>"  required/><br />
        <label>State:</label><br />
        <select id="state" name="state"  style="margin:5px;" required><option value="0">Choose a state</option><?php echo listStates($row['state']); ?></select><br />
        <label>Zip Code:</label><br />
        <input type="text" pattern="[0-9]{5}"  style="margin:5px;" id="zip" name="zip" value="<?php echo $row['zip']; ?>" required/><br />
    </div>
    
    <div>
    	<label>Type of Work:</label><br />
        <select id="workType"  style="margin:5px;" name="workType" required>
        	<option value="Professional" <?php echo (($row['workType'] === "Professional") ? "selected" : ""); ?>>Professional</option>
            <option value="Scientific" <?php echo (($row['workType'] === "Scientific") ? "selected" : ""); ?>>Scientific</option>
        </select><br />
    	<label>Experience:</label><br />
        <input type="number" pattern="[0-9]{2}"  style="margin:5px;" id="experience" placeholder="Experience" name="experience" value="<?php echo $row['experience']; ?>" required /><br />
        <label>Education:</label><br />
		<select id="education"  style="margin:5px;" name="education" required>
            <option value="No Degree" <?php echo (($row['education'] === "No Degree") ? "selected" : ""); ?>>No Degree</option>
            <option value="High School" <?php echo (($row['education'] === "High School") ? "selected" : ""); ?>>High School</option>
			<option value="College" <?php echo (($row['education'] === "College") ? "selected" : ""); ?>>College</option>
        </select><br />
        <label>Salary:</label><br />
        <input type="test" pattern="[0-9]*\.[0-9]{2}"  style="margin:5px;" id="salary" name="salary" value="<?php echo $row['salary']; ?>" required/>
    </div>
    
    <div id="submit_form">
    	<input type="submit" id="submit" style="margin-top: 10px;" name="submit" value="Submit" />
    </div>
</form>
</div>
<br />

<form method="POST" action="<?php $_SERVER["PHP_SELF"]; ?>?edit" enctype="multipart/form-data">
	<table>
		<tr>
        	<label>Resume:</label>
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
</div>
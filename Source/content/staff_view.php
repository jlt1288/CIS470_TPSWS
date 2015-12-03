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

if (isset($_POST['view']))
{
	$id = $_POST['view'];
}
elseif (isset($_GET['view']))
{
	$id = $_GET['view'];
}
else
{
	$id = $_SESSION['id'];
}

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

if (isset($message)) { echo '<p id="message" align="center" style="margin:0px; padding-top:2.5px;">' . $message . '</p>'; }



if ($_SESSION['id'] === $id) { ?>
<div id="view">
	<div>
		<form action="?edit" method="POST" style="margin-bottom: 10px;">
			<input type="hidden" id="edit" name="edit" />
			<input type="submit" id="submit" name="submit" value="Edit Profile" />
		</form>
	</div><?php }

	 if (isset($row['picture'])){ ?>
	<img id="pic" name="pic" style="float: left;" src="uploads/pictures/<?php echo $row['picture']; ?>" /> <?php } ?>
	<?php if (isset($row['resume']) && !empty($row['resume'])){ ?>
	
	<div id="infoBox">
		<div id="availability" name="availability">
			<label><b><u>Availability:</u></b></label><br />
			<label id="availabe" name="available" style="margin-left: 20px;"><?php echo (($row["available"] === "0") ? "Not Available" : "Available"); ?></label>
		</div>

		<div id="information" name="information">
			<label><br /><b><u>First Name:</u></b></label><br />
			<label id="Fname" name="Fname" style="margin-left: 20px;"><?php echo $row['Fname']; ?><br /></label><br />
			<label><b><u>Last Name:</u></b></label><br />
			<label id="Lname" name="Lname" style="margin-left: 20px;"><?php echo $row['Lname']; ?><br /></label><br />
			<label><b><u>City:</u></b></label><br />
			<label id="city" name="city" style="margin-left: 20px;"><?php echo $row['city']; ?><br /></label><br />
			<label><b><u>State:</u></b></label><br />
			<label id="state" name="state" style="margin-left: 20px;"><?php echo $row['state']; ?><br /></label><br />
			<label><b><u>Zip Code:</u></b></label><br />
			<label id="zip" name="zip" style="margin-left: 20px;"><?php echo $row['zip']; ?><br /></label><br />
		</div>
	
		<div>
			<label><b><u>Type of Work:</u></b></label><br />
			<label id="workType" name="workType" style="margin-left: 20px;"><?php echo $row['workType']; ?><br /></label><br />
			<label><b><u>Experience:</u></b></label><br />
			<label id="experience" name="experience" style="margin-left: 20px;"><?php echo $row['experience']; ?><br /></label><br />
			<label><b><u>Education:</u></b></label><br />
			<label id="education" name="education" style="margin-left: 20px;"><?php echo $row['education']; ?><br /></label><br />
			<label><b><u>Salary:</u></b></label><br />
			<label id="salary" name="salary" style="margin-left: 20px;"><?php echo $row['salary']; ?><br /></label>
		</div>
	</div>
		<div style="float: left;">
		<label><b><u>Resume:</u></b></label><br />
		<a href="uploads/resumes/<?php echo $row['resume']; ?>" target="_blank">Download</a>
	</div>
</div>
<?php } ?>
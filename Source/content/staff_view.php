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

?>

<?php if ($_SESSION['id'] === $id) { ?>
<div>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
	<input type="hidden" id="edit" name="edit" />
	<input type="submit" id="submit" name="submit" value="Edit Profile" />
</form>
</div><?php }

 if (isset($row['picture'])){ ?>
<img id="pic" name="pic" src="uploads/pictures/<?php echo $row['picture']; ?>" /> <?php } ?>
	<div id="availability" name="availability">
    	<label>Availability:</label><br />
        <label id="availabe" name="available"><?php echo (($row["available"] === "0") ? "Not Available" : "Available"); ?></label>
    </div>

	<div id="information" name="information">
    	<label>First Name:</label><br />
        <label id="Fname" name="Fname" ><?php echo $row['Fname']; ?></label><br />
        <label>Last Name:</label><br />
        <label id="Lname" name="Lname"><?php echo $row['Lname']; ?></label><br />
        <label>City:</label><br />
        <label id="city" name="city"><?php echo $row['city']; ?></label><br />
        <label>State:</label><br />
        <label id="state" name="state"><?php echo $row['state']; ?></label><br />
        <label>Zip Code:</label><br />
        <label id="zip" name="zip"><?php echo $row['zip']; ?></label><br />
    </div>
    
    <div>
    	<label>Experience:</label><br />
        <label id="experience" name="experience"><?php echo $row['experience']; ?></label><br />
        <label>Education:</label><br />
		<label id="education" name="education"><?php echo $row['education']; ?></label><br />
        <label>Salary:</label><br />
        <label id="salary" name="salary"><?php echo $row['salary']; ?></label>
    </div>
    
    <?php if (isset($row['resume']) && !empty($row['resume'])){ ?>
    <div>
    	<label>Resume:</label><br />
        <a href="uploads/resumes/<?php echo $row['resume']; ?>">Download</a>
   </div><?php } ?>
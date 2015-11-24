<?php
/*	Staff script used by members_area.php.
*----------------------------------------------------------------------------
*	Original Author: Joshua Thompson
*	Creation Date: 11/16/2015
*
*	Modification Author: Joshua Thompson
*	Modification Date: 11/16/2015
*----------------------------------------------------------------------------
*/

if (isset($_POST['type']) && $_POST['type'] !== "info" && $_POST['type'] != "account")
{
	// Required for upload purposes.
	require_once('scripts/upload.php');

	if (isset($target_filename))
	{
		// TODO: Update the database information for the picture.
		$id = $_SESSION['id'];
		$type = $_POST['type'];
		
		require_once('scripts/database_admin.php');
		$query = "UPDATE staff SET $type='$target_filename' WHERE userID=$id";
		$result = $connection->query($query) or die('Error: ' . mysqli_error( $connection ));
	}
}
elseif (isset($_POST['type']) && $_POST['type'] === "info")
{
	$id = $_SESSION['id'];
	$available = $_POST['available'];
	$Fname = $_POST['Fname'];
	$Lname = $_POST['Lname'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$zip = $_POST['zip'];
	$workType = $_POST['workType'];
	$experience = $_POST['experience'];
	$education = $_POST['education'];
	$salary = $_POST['salary'];
	
	require_once('scripts/database_admin.php');
	$query = "UPDATE staff SET available='$available', Fname='$Fname', Lname='$Lname', city='$city', state='$state', zip='$zip', workType='$workType', experience='$experience', education='$education', salary='$salary' WHERE userID=$id";	
	$result = $connection->query($query) or die('Error: ' . mysqli_error( $connection ));
	
	if ($result !== 0) { $message = "Information was successfully updated."; } else {$message = "Encountered an error. Information could not be updated."; }
} elseif (isset($_POST['type']) && $_POST['type'] === "account")
{
	if (isset($_POST['current_pwd']))
	{		
		$id = $_SESSION['id'];
		$pass = md5(trim($_POST['current_pwd']));
		require_once('scripts/database_admin.php');
		$query = "SELECT * FROM users WHERE userID='$id' and userPassword='$pass'";
		$result = $connection->query($query) or die('Error: ' . mysqli_error( $connection ));;
		$row = mysqli_fetch_row($result);
		
		if ($row[0] != NULL && $row[0] != '')
		{
			if (isset($_POST['email']))
			{
				$email = $_POST['email'];
				$query = "UPDATE users SET userEmail='$email' WHERE userID='$id'";
								
				if ($connection->query($query) or die('Error: ' . mysqli_error( $connection ) )){
					$message = "Email address has been successfully changed.";	
				}
			}
			
			// Check to see if the password was set.
			if ((isset($_POST['pwd']) && !empty($_POST['pwd'])) && (isset($_POST['confirm_pwd']) && !empty($_POST['confirm_pwd']) && $_POST['pwd'] == $_POST['confirm_pwd']))
			{
				$message = "Password has been successfully changed.";
				$password = md5(trim($_POST['pwd']));
				$query = "UPDATE users SET userPassword='$password' WHERE userID='$id'";
				$connection->query($query) or die('Error: ' . mysqli_error( $connection ));
			} elseif ((isset($_POST['pwd']) && !empty($_POST['pwd'])) && (isset($_POST['confirm_pwd']) && !empty($_POST['confirm_pwd']) && $_POST['pwd'] !== $_POST['confirm_pwd'])) {
				$message = "Password change was unsuccessful.";
			}
		}else {
			$message = "Invalid credentials given.";
		}
	}
}

?>
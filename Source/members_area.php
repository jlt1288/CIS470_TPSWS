<?php

//===============================================================================
//	START SESSION
//===============================================================================
session_start();

require_once('scripts/logout.php');

//===============================================================================
//	SESSION INFORMATION
//===============================================================================
switch( $_SESSION['access'])
{
	case "client":	
		if (isset($_POST["submit"]))
		{
			$random_hash = md5(uniqid(rand(), true));
			$confirmation_code = strtoupper(substr($random_hash, (strlen($random_hash) % 2), 10));
		}
		break;
	case "staff":
	
		if (isset($_POST['type']) && $_POST['type'] !== "info")
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
			$experience = $_POST['experience'];
			$education = $_POST['education'];
			$salary = $_POST['salary'];
			
			require_once('scripts/database_admin.php');
			$query = "UPDATE staff SET available='$available', Fname='$Fname', Lname='$Lname', city='$city', state='$state', zip='$zip', experience='$experience', education='$education', salary='$salary' WHERE userID=$id";	
			$connection->query($query) or die('Error: ' . mysqli_error( $connection ));
			
			if (isset($_POST['pwd']) && !empty($_POST['pwd']))
			{
				$password = md5(trim($_POST['pwd']));
				$query = "UPDATE users SET userPassword='$password' WHERE userID='$id'";
				$connection->query($query) or die('Error: ' . mysqli_error( $connection ));
			}

		}
		
		
		break;
	case "manager":
		break;
	default:
		// Redirect back to index page.
		header('Location:index.php');	
		break;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
<title>Taylor's Professional Services</title>
<link rel="stylesheet" type="text/css" href="styles/style.css" media="screen" />
<style></style>
</head>

<body>
	<?php require_once('content/header.php'); ?>
    
    <div id="main">	
		<div id="content">
        	<?php
				require_once('content/' . $_SESSION['access'] . '.php');					
			?>
		</div>
	</div>
    
    <?php require_once('content/footer.php'); ?>
<body>
</body>
</html>
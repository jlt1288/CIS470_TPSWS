<?php 

//===============================================================================
//	START SESSION
//===============================================================================
session_start();

require_once('scripts/logout.php');

if (isset($_SESSION['access']))
{
	// Redirect to members area.
	header('Location:members_area.php?' . (($_SESSION['access'] === "staff") ? 'view=' . $_SESSION['id'] : ""));
}

//===============================================================================
//	INCOMING INFORMATION
//===============================================================================
if (isset($_POST['submit']) && (isset($_GET['forgotpassword']) or isset($_POST['forgotpassword'])))
{
	// Get information submitted to the page.
	$email = trim($_POST['email']);
	
	// Connect to the database for further use.
	require_once( 'scripts/database.php' );

	// Run query to find if the username/password combination exists.
	// TODO: Change table, values, and variables to be in line with the database.
	$sql = "SELECT * FROM users WHERE userEmail = '$email'";
	$result = $connection->query($sql) or die('Error: ' . mysqli_error($connection));
	
	if (mysqli_num_rows($result)===0){
		$message = '<h2 style="color:red;">The provided email address is not linked to an account.</h2>';
	} else {
		// TODO: Get user based on email, email new password to email address.
		
		$message = 'An email has been sent to the email provided. Please check your email for more details.';
	}	
} elseif (isset($_POST['submit']) && (!isset($_GET['forgotpassword']) or !isset($_POST['forgotpassword']))){
	// Get information submitted to the page.
	$login = trim($_POST['login']);
	$pwd = md5(trim($_POST['password']));

	// Connect to the database for further use.
	require_once( 'scripts/database.php' );

	// Run query to find if the username/password combination exists.
	// TODO: Change table, values, and variables to be in line with the database.
	$sql = "SELECT * FROM users WHERE userName = '$login' AND userPassword = '$pwd'";
	$result = $connection->query($sql) or die('Error: ' . mysqli_error($connection));
	
	if (mysqli_num_rows($result)===0){		
		$message = ' <h2 style="color:red;">Invalid Credentials!</h2>';
	} else {
		$row = mysqli_fetch_assoc($result);
	
		$_SESSION['id'] = $row['userID'];
		$_SESSION['access'] = $row['userAccess'];
		
		// TODO: Push the area which we want to goto as the header:location.
		header("Location:members_area.php");
	}

	
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
				if (!isset($_GET['forgotpassword']))
				{
					if (isset($message))
					{
			?>
            	<span id="message" name="message"><?php echo $message; ?></span><br \>
            <?php } ?>
	        <form id="login" name="login" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
            	<table>
                	<tr>
                    	<th><label>Username</label></th>
                        <th><input id="login" name="login" type="text"></th>
                    </tr>
                    <tr>
                    	<th><label>Password</label></th>
                        <th><input type="password" id="password" name="password"></th>
                    </tr>
                    <tr>
                    	<th><a href="<?php $_SERVER['PHP_SELF']; ?>?forgotpassword">Forgot Password?</a></th>
                        <th><input type="submit" id="submit" name="submit" value="Login"></th>
                    </tr>
                </table>                
            </form>
            <?php } else { 
				if (isset($message)) {?>
                    <span id="message" name="message"><?php echo $message; ?></span><br \>
            <?php } ?>
            <form id="login" name="forgot" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
            	<table>
                	<tr>
                    	<th><label>Email</label></th>
                        <th><input id="email" name="email" type="text"></th>
                    </tr>
                    <tr>
                    	<th></th>
                        <th><input type="submit" id="submit" name="submit" value="Login"></th>
                    </tr>
                </table>                
            </form>            	
            <?php } ?>
        </div>
	</div>
    
    <?php require_once('content/footer.php'); ?>
</body>
</html>
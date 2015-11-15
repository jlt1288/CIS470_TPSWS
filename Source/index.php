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
		$message = '<h5 style="color:red; margin-top: 10px; margin-left: 8px; margin-right: 8px;">The provided email address is not linked to an account.</h5>';
	} else {
		// TODO: Get user based on email, email new password to email address.
		
		$message = '<p style="margin: 0px; margin-left: 8px; margin-right: 8px;">An email has been sent to the email provided. Please check your email for more details.</p>';
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
		$message = ' <h5 style="color:red;  margin-top: 10px; margin-left: 75px;">Invalid Credentials!</h5>';
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
			<div id="loginMain">
            <?php
				if (!isset($_GET['forgotpassword']))
				{
					if (isset($message))
					{
			?>
            <?php } ?>
				<h3 style= "margin-left: 110px; margin-top: 15px; color: #E0E0E0;"><u>Login</u></h3>
				<form id="login" style="margin-top: 26px;" name="login" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
					<table>
						<tr>
							<th><label>Username:</label></th>
							<th><input id="login" name="login" type="text" style="margin-right: 8px;"></th>
						</tr>
						<tr>
							<th><label style="margin-top: 8px;">Password:</label></th>
							<th><input type="password" id="password" name="password" style="margin-right: 8px;"></th>
						</tr>
						<tr>
							<th><a href="<?php $_SERVER['PHP_SELF']; ?>?forgotpassword"  style="font-size: 12px;">Forgot Password?</a></th>
							<th><input type="submit" id="submit" name="submit" value="Login"></th>
						</tr>
					</table>                
				</form>
				<span id="message" name="message"><?php echo $message; ?></span><br \>
				<?php } else { 
					if (isset($message)) {?>
						
				<?php } ?>
				
				<h3 style= "margin-left: 55px; margin-top: 15px; color: #E0E0E0;"><u>Recover Password</u></h3>
				<form id="login" style="margin-top: 26px; margin-left: 27px;" name="forgot" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
					<table>
						<tr>
							<th><label>Email:</label></th>
							<th><input id="email" name="email" type="text"></th>
						</tr>
					</table>  
					<table style= "margin-left: 50px; margin-top: 10px;">
						<tr>
							<th><input type="submit" style= "float: right; margin: 5px;" id="back" name="back" value="Back"></th>
							<th><input type="submit" style= "float: left; margin: 5px;" id="submit" name="submit" value="Send"></th>
						</tr>
					</table>
				</form> 
					<span id="message" name="message"><?php echo $message; ?></span><br \>
				<?php } ?>
			</div>
        </div>
	</div>
    
    <?php require_once('content/footer.php'); ?>
</body>
</html>
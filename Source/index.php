<?php 

//===============================================================================
//	START SESSION
//===============================================================================
session_start();

//===============================================================================
//	Required classes.
//===============================================================================
require_once( 'scripts/classes.php' );
require_once ( 'scripts/logout.php' );

//===============================================================================
//	INCOMING INFORMATION
//===============================================================================
if (isset($_SESSION['access']))
{
	// Redirect to members area.
	header('Location:members_area.php?' . (($_SESSION['access'] === "staff") ? 'view=' . $_SESSION['id'] : ""));
}

if (isset($_POST['submit']) && (isset($_GET['forgotpassword']) or isset($_POST['forgotpassword'])))
{
	$random_hash = md5(uniqid(rand(), true));
	$new_pass = strtoupper(substr($random_hash, (strlen($random_hash) % 2), 10));
	
	// Get information submitted to the page.
	if (User::emailPassword($_POST['email'], $new_pass))
	{
		// collect the form valus
		$email_message = "Thank you for using the automated password retrieval system.\n\n\tPassword:" . $new_pass . "\n\nPlease log into the system using the above password.";
		
		// set the email properties
		$to = $_POST['email'];
		$subject = "Password reset information.";
		$from = "support@tps.com";
		$headers = "From: support@tps.com";
	
		// attempt to send the mail, catch errors if they occur
		try {
				mail($to, $subject, $email_message, $headers);
				$message = '<p style="margin: 0px; margin-left: 8px; margin-right: 8px;">An email has been sent to the email provided. Please check your email for more details.</p>';
		} catch (Exception $e){
				$message = "An Exception was thrown: " . $e -> getMessage() . "<br>";
		}
		
	}
	else
	{
		$message = '<h5 style="color:red; margin-top: 10px; margin-left: 8px; margin-right: 8px;">The provided email address is not linked to an account.</h5>';
	}
	
} 
elseif (isset($_POST['submit']) && (!isset($_GET['forgotpassword']) or !isset($_POST['forgotpassword'])))
{	
	// Get information submitted to the page.
	$user = new User($_POST['login'], $_POST['password'], "");
	
	if ($user->isLoggedIn)
	{
		$_SESSION['id'] = $user->id;
		$_SESSION['access'] = $user->access;
		
		header('Location:members_area.php?' . (($_SESSION['access'] === "staff") ? 'view=' . $_SESSION['id'] : ""));
	}
	else
	{
		$message = ' <h5 style="color:red;  margin-top: 10px; margin-left: 75px;">Invalid Credentials!</h5>';
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
				<form id="login" style="margin-top: 26px;" name="login" method="post" action="<?php echo  $_SERVER['PHP_SELF']; ?>">
					<table>
						<tr>
							<th><label>Username:</label></th>
							<th><input required id="login" name="login" type="text" style="margin-right: 8px;"></th>
						</tr>
						<tr>
							<th><label style="margin-top: 8px;">Password:</label></th>
							<th><input required type="password" id="password" name="password" style="margin-right: 8px;"></th>
						</tr>
						<tr>
							<th><a href="<?php echo $_SERVER['PHP_SELF']; ?>?forgotpassword"  style="font-size: 12px;">Forgot Password?</a></th>
							<th><input type="submit" id="submit" name="submit" value="Login"></th>
						</tr>
					</table>                
				</form>
				<span id="message" name="message"><?php echo $message; ?></span><br \>
				<?php } else { 
					if (isset($message)) {?>
						
				<?php } ?>
				
				<h3 style= "margin-left: 55px; margin-top: 15px; color: #E0E0E0;"><u>Recover Password</u></h3>
				<form id="login" style="margin-top: 26px; margin-left: 27px;" name="forgot" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?forgotpassword">
					<table>
						<tr>
							<th><label>Email:</label></th>
							<th><input id="email" name="email" type="email" required></th>
						</tr>
					</table>  
					<table style= "margin-left: 50px; margin-top: 10px;">
						<tr>
							<th><a href="index.php" class="button">Back</a></th>
							<th><input type="submit" class="button" style="float: left; margin: 5px;" id="submit" name="submit" value="Send"></th>
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
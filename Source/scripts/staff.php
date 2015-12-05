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
// Required for the internal classes we use to retrieve data.
require_once( 'scripts/classes.php' );

// Determine if there is an ID in the address bar.
if (isset($_POST['view']))
{
	$id = $_POST['view'];
}
elseif (isset($_GET['view']))
{
	$id = $_GET['view'];
}
// otherwise use session ID.
else
{
	$id = $_SESSION['id'];
}

// if we get it from the session ID populate the user information for editing purposes.
if ($id == $_SESSION['id']){
	$user = new User($id, "", "populate");
}

// Create a new staff member based on the id.
$staff = new Staff($id);

// Determine what is being done by the users.
if (isset($_POST['type']) && $_POST['type'] !== "info" && $_POST['type'] != "account")
{
	// Looks like we're trying to upload a picture or resume.
	
	// Required for upload purposes.
	require_once('scripts/upload.php');
	$results = upload();
	
	if ($results[0] === true)
	{
		// TODO: Update the database information for the picture.
		$id = $_SESSION['id'];
		$type = $_POST['type'];
		$message = $results[1];
		$target_filename = $results[2];
				
		
		require_once('scripts/database_admin.php');
		$query = "UPDATE staff SET $type='$target_filename' WHERE userID=$id";
		$result = $connection->query($query) or die('Error: ' . mysqli_error( $connection ));
	}
	else
	{
		$message = $results[1];
	}
	
	$staff->refresh();
}
elseif (isset($_POST['type']) && $_POST['type'] === "info")
{
	// Looks like we're trying to update our staffing information in the database.
	$id = $_SESSION['id'];
	$staff->available = $_POST['available'];
	$staff->Fname = $_POST['Fname'];
	$staff->Lname = $_POST['Lname'];
	$staff->city = $_POST['city'];
	$staff->state = $_POST['state'];
	$staff->zip = $_POST['zip'];
	$staff->workType = $_POST['workType'];
	$staff->experience = $_POST['experience'];
	$staff->education = $_POST['education'];
	$staff->salary = $_POST['salary'];
		
	if ($staff->update()) 
	{ 
		$message = "Information was successfully updated."; 
	}
	else 
	{
		$message = "Encountered an error. Information could not be updated."; 
	}
	
} elseif (isset($_POST['type']) && $_POST['type'] === "account")
{
	// Looks like we're trying to update our account information in the database.
	if (isset($_POST['current_pwd']))
	{		
		$user = new User($_SESSION['id'], $_POST['current_pwd'], "id");
		
		// Only allow information to be changed if we can log in with the account.
		if ($user->isLoggedIn)
		{
			if (isset($_POST['email']))
			{
				$email = $_POST['email'];
												
				if ($user->update("Email", trim($_POST['email']))){
					$message = "Email address has been successfully changed.";	
				}
			}
			
			// Check to see if the password was set.
			if ((isset($_POST['pwd']) && !empty($_POST['pwd'])) && (isset($_POST['confirm_pwd']) && !empty($_POST['confirm_pwd']) && $_POST['pwd'] == $_POST['confirm_pwd']))
			{
				if ($user->update("Password", md5(trim($_POST['pwd']))))
				{
					$message = "Password has been successfully changed.";
				}
			} elseif ((isset($_POST['pwd']) && !empty($_POST['pwd'])) && (isset($_POST['confirm_pwd']) && !empty($_POST['confirm_pwd']) && $_POST['pwd'] !== $_POST['confirm_pwd'])) {
				$message = "Password change was unsuccessful.";
			}
			
			$user->refresh();
		}else {
			$message = "Invalid credentials given.";
		}
	}
}

// This function is used to list the states for choosing.
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

?>
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

require_once( 'scripts/classes.php' );

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

if ($id == $_SESSION['id']){
	$user = new User($id, "", "populate");
}

$staff = new Staff($id);

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
	if (isset($_POST['current_pwd']))
	{		
		$user = new User($_SESSION['id'], $_POST['current_pwd'], "id");
		
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
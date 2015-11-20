<?php
	function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
    	$sort_col = array();
		foreach ($arr as $key=> $row) {
    		$sort_col[$key] = $row[$col];
		}
		array_multisort($sort_col, $dir, $arr);
	}
	
	class User {
				
		public function __construct($user, $pass, $type)
		{
			if ($type === "populate")
			{
				$this->populate($user);
			}
			elseif ($this->login(trim($user), md5(trim($pass)), $type))
			{
				$this->isLoggedIn = true;
			}
		}
				
		public $id = "";
		public $login = "";
		public $password = "";
		public $email = "";
		public $access = "";
		public $isLoggedIn = false;
		
		private function populate($id)
		{
			// Connect to the database for further use.
			require( 'scripts/database.php' );
			
			// Run query to find if the username/password combination exists.
			// TODO: Change table, values, and variables to be in line with the database.
			$sql = "SELECT * FROM users WHERE userID='$id'";
			$result = $connection->query($sql) or die('Error: ' . mysqli_error($connection));			
			
			if ( mysqli_num_rows( $result ) === 0 ){
				mysqli_free_result($result);
				return false;
			}else{
				$row = mysqli_fetch_assoc( $result );
				
				$this->id = $row['userID'];
				$this->email = $row['userEmail'];
				$this->access = $row['userAccess'];
				
				mysqli_free_result($result);
				return true;
			}
		}
				
		private function login($user, $pass, $type)
		{
			// Connect to the database for further use.
			require( 'scripts/database.php' );
			
			// Run query to find if the username/password combination exists.
			// TODO: Change table, values, and variables to be in line with the database.
			$sql = "SELECT * FROM users WHERE " . (($type === "id") ? "userID" : "userName") . "= '$user' AND userPassword = '$pass'";
			$result = $connection->query($sql) or die('Error: ' . mysqli_error($connection));			
			
			if ( mysqli_num_rows( $result ) === 0 ){
				mysqli_free_result($result);
				return false;
			}else{
				$row = mysqli_fetch_assoc( $result );
				
				$this->id = $row['userID'];
				$this->email = $row['userEmail'];
				$this->access = $row['userAccess'];
				
				mysqli_free_result($result);
				return true;
			}
		}
		
		public static function logout()
		{
			session_start();
		    session_destroy();
		    header("Location:");
		}
		
		public function update($var, $value)
		{		
			// Connect to the database for further use.
			require( 'scripts/database_admin.php' );

			$query = "UPDATE users SET user" . $var ."='$value' WHERE userID='$this->id'";
			
			if ($connection->query($query) or die('Error: ' . mysqli_error( $connection ) ) === 0){
				return true;
			}

			return false;		
		}
		
		public static function emailPassword($email, $new_pass)
		{
			// Trim the whitespaces off the email address.
			$email = trim($email);
			$pass = md5($new_pass);
			
			// Connect to the database for further use.
			require( 'scripts/database_admin.php' );
			
			// Run query to find if the username/password combination exists.
			$query = "SELECT * FROM users WHERE userEmail = '$email'";
	
			if ($connection->query($query) or die('Error: ' . mysqli_error($connection))===0){
		
				// TODO: Email new password to email address.				
				$query = "UPDATE users SET userPassword='$pass' WHERE userEmail='$email'";
				
				if ($connection->query($query) or die('Error: ' . mysqli_error( $connection ) ) === 0){
					return true;	
				}				
				
				return false;
				
			} else {

				return false;			
			}	
		}
		
		public function refresh()
		{
			$this->populate($this->id);
		}
		
	}
	
	class Staff{
		
		public function __construct($id)
		{
			if ($this->populate($id))
			{
				$this->isPopulated = true;
			}
		}
		
		public $isPopulated = false;
	
		public $id = "";
		public $Fname = "";
		public $Lname = "";
		public $city = "";
		public $state = "";
		public $zip = "";
		public $workType = "";
		public $experience = "";
		public $education = "";
		public $salary = "";
		public $picture = "";
		public $resume = "";
		public $available = "";
		
		
		private function populate($id)
		{
			// Connect to the database for further use.
			require( 'scripts/database.php' );

			// Run query to find if the username/password combination exists.
			// TODO: Change table, values, and variables to be in line with the database.
			$sql = "SELECT * FROM staff WHERE userID='$id'";
			$result = $connection->query($sql) or die('Error: ' . mysqli_error($connection));

			if (mysqli_num_rows($result)===0){
				return false;
			} else {
				$row = mysqli_fetch_assoc($result);		
				
				$this->id = $id;
				$this->Fname = $row['Fname'];
				$this->Lname = $row['Lname'];
				$this->city = $row['city'];
				$this->state = $row['state'];
				$this->zip = $row['zip'];
				$this->workType = $row['workType'];
				$this->experience = $row['experience'];
				$this->education = $row['education'];
				$this->salary = $row['salary'];
				$this->picture = $row['picture'];
				$this->resume = $row['resume'];
				$this->available = $row['available'];
				
				return true;
			}
		}
		
		public function update()
		{
			// Connect to the database for further use.
			require_once('scripts/database_admin.php');
			
			$query = "UPDATE staff SET available='$this->available', Fname='$this->Fname', Lname='$this->Lname', city='$this->city', state='$this->state', zip='$this->zip', workType='$this->workType', experience='$this->experience', education='$this->education', salary='$this->salary' WHERE userID=$this->id";	
			$connection->query($query) or die('Error: ' . mysqli_error( $connection ));

			return true;			
		}
		
		public function refresh()
		{
			$this->populate($this->id);
		}
		
		
	}
	
	
	class Client {
	
	
		
		
		public static function getZipCodes($code, $distance)
		{
			//connect to db server; select database
			require('scripts/database.php');
					
			//query for coordinates of provided ZIP Code
			if(!$rs = $connection->query("SELECT * FROM zipcodes WHERE code = '$code'")) {
				$GLOBALS['message'] = "Database error.";
				return false;
			}
			else {
				if(mysqli_num_rows($rs) == 0) {
					$GLOBALS['message'] = "No zip codes found.";
					return false;
				}
				else {
					//if found, set variables
					$row = mysqli_fetch_array($rs);
					$lat1 = $row['latitude'];
					$lon1 = $row['longitude'];
					$d = $distance;
					$r = 3959;
							
					//compute max and min latitudes / longitudes for search square
					$latN = rad2deg(asin(sin(deg2rad($lat1)) * cos($d / $r) + cos(deg2rad($lat1)) * sin($d / $r) * cos(deg2rad(0))));
					$latS = rad2deg(asin(sin(deg2rad($lat1)) * cos($d / $r) + cos(deg2rad($lat1)) * sin($d / $r) * cos(deg2rad(180))));
					$lonE = rad2deg(deg2rad($lon1) + atan2(sin(deg2rad(90)) * sin($d / $r) * cos(deg2rad($lat1)), cos($d / $r) - sin(deg2rad($lat1)) * sin(deg2rad($latN))));
					$lonW = rad2deg(deg2rad($lon1) + atan2(sin(deg2rad(270)) * sin($d / $r) * cos(deg2rad($lat1)), cos($d / $r) - sin(deg2rad($lat1)) * sin(deg2rad($latN))));
					
					//find all coordinates within the search square's area
					//exclude the starting point and any empty city values
					$query = "SELECT * FROM zipcodes WHERE (latitude <= $latN AND latitude >= $latS AND longitude <= $lonE AND longitude >= $lonW) AND (latitude != $lat1 AND longitude != $lon1) AND city != '' ORDER BY state, city, latitude, longitude";
					if(!$rs = $connection->query($query)) {
						$GLOBALS['message'] = "Database error while searching for zip codes in area.";
						return false;
					}
					elseif(mysqli_num_rows($rs) == 0) {
						$GLOBALS['message'] = "No zip codes found within that distance.";
						return false;
					}
					else {
						//output all matches to array to be used to search for people in the area.
						$tmp = array();
						$i = 0;
								
						while($row = mysqli_fetch_array($rs)) {
							$distance = round(acos(sin(deg2rad($lat1)) * sin(deg2rad($row['latitude'])) + cos(deg2rad($lat1)) * cos(deg2rad($row['latitude'])) * cos(deg2rad($row['longitude']) - deg2rad($lon1))) * $r);
							if($d >= $distance) {
								$tmp[$i] = $row;
								$tmp[$i]['distance'] = $distance;
								$i++;
							}
						}								
						//now we can sort the temp array via the function at the top of the page
						array_sort_by_column($tmp, 'distance');
						
						return $tmp;
					}
				}
			}
		}
	
		public static function Search($workType, $experience, $education, $salary, $zip, $distance)
		{
			if (($tmp = Client::getZipCodes($zip, $distance)) !== false)
			{
				//connect to db server; select database
				require('scripts/database.php');
				
				$i = 0;
				$query = "SELECT * FROM staff WHERE (";		
				foreach($tmp as $data) 
				{
					if ($i === 0)
					{
						$query .= "zip='" . $data[code]. "'";	
					}
					else
					{
						$query .= " OR zip='" . $data[code] . "'";	
					}	
					$i++;				
				}
				$query .= ") AND experience >= '$experience' AND workType='$workType' AND education>='$education' AND salary<='$salary' AND available=1";
				
				$GLOBALS['query'] = $query;
				
				if(!$rs = $connection->query($query)) {
					$GLOBALS['message'] = "No potential candidates fit that criteria.";
					return false;	
				}
				else
				{
					$tmp = array();
					$i = 0;
					
					while($row = mysqli_fetch_array($rs)) {
						$tmp[$i] = $row;
						$i++;
					}
					
					if ($i !== 0)
					{
						array_sort_by_column($tmp, 'experience');

						return $tmp;
					}
					else
					{
						$GLOBALS['message'] = "No potential candidates fit that criteria.";
						
						return false;
					}
				}						
			}
			else
			{
				return false;
			}
		}		
	}

?>
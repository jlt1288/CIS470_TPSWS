<?php
/*	Classes which will be used by various pages.
*----------------------------------------------------------------------------
*	Original Author: Joshua Thompson
*	Creation Date: 11/17/2015
*
*	Modification Author: Joshua Thompson
*	Modification Date: 11/30/2015
*----------------------------------------------------------------------------
*/
	// Use to sort arrays by column name.
	function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
    	$sort_col = array();
		foreach ($arr as $key=> $row) {
    		$sort_col[$key] = $row[$col];
		}
		array_multisort($sort_col, $dir, $arr);
	}
	
	
	class User {
		// constructor needs user, pass and type.
		public function __construct($user, $pass, $type = "id")
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
		
		// This function is used to update data for the active user account.
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
		
		// This function is used to send a new password to the email account.
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
		
		// This function updates the active user.
		public function refresh()
		{
			$this->populate($this->id);
		}
		
	}
	
	class Staff{
		// constructor requires id.
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

			// Run query to find if the staff member exists.
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
		
		// This function is used to update the data associated with the active staff member.
		public function update()
		{
			// Connect to the database for further use.
			require_once('scripts/database_admin.php');
			
			$query = "UPDATE staff SET available='$this->available', Fname='$this->Fname', Lname='$this->Lname', city='$this->city', state='$this->state', zip='$this->zip', workType='$this->workType', experience='$this->experience', education='$this->education', salary='$this->salary' WHERE userID=$this->id";	
			$connection->query($query) or die('Error: ' . mysqli_error( $connection ));

			return true;			
		}
		
		// This function is used to refresh the data for the active staff member.
		public function refresh()
		{
			$this->populate($this->id);
		}
		
		// This function is used to get the staff ID based on employee ID.
		public static function getID($employee_id)
		{
			// Connect to the database for further use.
			require_once('scripts/database.php');
			
			$sql = "SELECT * FROM users WHERE userName='$employee_id'";
			
			$result = $connection->query($sql) or die('Error: ' . mysqli_error($connection));			
			
			if ( mysqli_num_rows( $result ) === 0 ){
				mysqli_free_result($result);
				return false;
			}else{
				$row = mysqli_fetch_assoc( $result );
				
				$id = $row['userID'];
				return $id;
			}
		}
	}
	
	class Request{
		// constructor requires row.
		public function __construct($row)
		{
			$this->id = $row['staffRequestID'];
			$this->userID = $row['userID'];
			$this->workType = $row['workType'];
			$this->experience = $row['experience'];
			$this->education = $row['education'];
			$this->salary = $row['salary'];
			$this->zip = $row['zipcode'];
			$this->distance = $row['distance'];
			$this->status = $row['status'];
			$this->dateOpened = $row['dateOpened'];
			$this->approvalNumber = $row['approvalNumber'];
		}
		
		public $id;
		public $userID;
		public $workType;
		public $experience;
		public $education;
		public $salary;
		public $zip;
		public $distance;
		public $status;
		public $dateOpened;
		public $approvalNumber;
		
		// This function returns the candidates associated with this staffing request.
		public function getCandidates()
		{
			//connect to db server; select database
			require('scripts/database.php');
			
			$query = "SELECT * FROM candidate WHERE staffRequestID='$this->id'";
			if (!$result = $connection->query($query))
			{
				return false;
			}
			
			$tmp = array();
			$i = 0;
								
			while($row = mysqli_fetch_array($result)) {
				$tmp[$i] = $row;
				$i++;	
			}								
			
			//now we can sort the temp array via the function at the top of the page
			array_sort_by_column($tmp, 'staffID');
			
			return $tmp;
		}
		
		// This function is used to update the staff request status.
		public static function update($id, $value)
		{
			// Connect to the database for further use.
			require( 'scripts/database_admin.php' );

			$query = "UPDATE staffrequest SET status='$value' WHERE staffRequestID='$id'";
			
			if ($connection->query($query) or die('Error: ' . mysqli_error( $connection ) ) === 0){
				return true;
			}

			return false;	
		}
		
		// This function is used to get the new staffing requests in the database.
		public static function getNew($page = 1)
		{
			//connect to db server; select database
			require('scripts/database.php');
			
			$query = "SELECT * FROM staffrequest WHERE status='VALID'";
			
			$paginator = new Paginator($query);
								
			if(!$results = $paginator->getData( $page, 25 )) {
				$GLOBALS['message'] = "No new staffing requests at this time.";
				return false;	
			}
			else
			{
				$results->links = $paginator->createLinks($page, 'pages');
				return $results;
			}	
		}
		
		// This function is used to get the request associated with the approval code.
		public static function getRequest($approval_code, $access)
		{
			//connect to db server; select database
			require('scripts/database.php');
			
			if ($access === "manager")
			{
				$query = "SELECT * FROM staffrequest WHERE approvalNumber='$approval_code'";
			}
			elseif ($access === "client")
			{
				$id = $_SESSION['id'];
				$query = "SELECT * FROM staffrequest WHERE userID='$id' AND approvalNumber='$approval_code'";
			}
						
			if (!$rs = $connection->query($query))
			{
				return false;
			}

			return ($rs->num_rows > 0) ? new Request($rs->fetch_array()) : false ;			
		}
		
		// This function is used to create a new request.
		public static function create($id, $workType, $experience, $education, $salary, $zip, $distance, $potential_candidates)
		{
			$random_hash = md5(uniqid(rand(), true));			
			$app_num =  strtoupper(substr($random_hash, (strlen($random_hash) % 2), 10));
			
			//connect to db server; select database
			require('scripts/database_admin.php');
			$status = "VALID";
			$date = date('Y-m-d');
			
			$query = "INSERT INTO staffrequest (userID, workType, experience, education, salary, zipcode, distance, status, dateOpened, approvalNumber) VALUES ('$id', '$workType', '$experience', '$education', '$salary', '$zip', '$distance', '$status', '$date', '$app_num')";			
			$connection->query($query);
						
			if (!$request = Request::getRequest($app_num, $_SESSION['access']))
			{
				return false;		
			}
			
			foreach ($potential_candidates as $candidate)
			{
				//connect to db server; select database
				require('scripts/database_admin.php');
					
				$query = "INSERT INTO candidate (staffRequestID, staffID) VALUES ($request->id, $candidate)";
				$connection->query($query);		
			}	
				
			return $app_num;	
		}
	}
	
	class Paginator {
		private $_conn;
		private $_query;
		private $_limit;
		private $_page;
		private $_total;
		
		// constructor requires query.
		public function __construct($query)
		{
			//connect to db server; select database
			require('scripts/database.php');

			$this->_query = $query;
			
			$rs = $connection->query( $this->_query );
			$this->_total = $rs->num_rows;
		}
		
		// This function is used to get the data associated with this query.
		public function getData($page = 1, $limit = 9)
		{
			//connect to db server; select database
			require('scripts/database.php');
			
			$this->_limit = $limit;
			$this->_page = $page;
			
			if ($this->limit == 'all')
			{
				$query = $this->query;
			} else {
				$query = $this->_query . " LIMIT " . ( ( $this->_page - 1 ) * $this->_limit ) . ", $this->_limit";
    		}
		    
			$rs = $connection->query( $query );

		    while ( $row = $rs->fetch_assoc() ) {
        		$results[]  = $row;
		    }

		    $result         = new stdClass();
		    $result->page   = $this->_page;
		    $result->limit  = $this->_limit;
		    $result->total  = $this->_total;
		    $result->data   = $results;

		    return $result;
		}
		
		// This function is used to create a links list based on this query.
		public function createLinks( $links, $list_class )
		{
			if ( $this->_limit == 'all' ) {
				return '';
			}
		
			$last       = ceil( $this->_total / $this->_limit );
		
			$start      = ( ( $this->_page - $links ) > 0 ) ? $this->_page - $links : 1;
			$end        = ( ( $this->_page + $links ) < $last ) ? $this->_page + $links : $last;
		
			$html       = '<ul class="' . $list_class . '">';
			
			if ( $start > 1 ) {
				$html   .= '<li><input type="submit" id="page" name="page" value="1" /></li>';
				$html   .= '<li class="disabled"><span>...</span></li>';
			}
		
			for ( $i = $start ; $i <= $end; $i++ ) {
				$class  = ( $this->_page != $i ) ? "active" : "disabled";
				$html   .= '<li class="' . $class . '"><input '. (($class == "active") ? "" : "disabled" ). ' type="submit" id="page" name="page" value="' . $i . '" /></li>';
			}
		
			if ( $end < $last ) {
				$html   .= '<li class="disabled"><span>...</span></li>';
				$html   .= '<li><input type="submit" id="page" name="page" value="' . $last . '" /></li>';
			}
		
			$html       .= '</ul>';
		
			return $html;
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
	
		public static function Search($workType, $experience, $education, $salary, $zip, $distance, $page)
		{
			if (($tmp = Client::getZipCodes($zip, $distance)) !== false)
			{				
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
				
				$paginator = new Paginator($query);
								
				if(!$results = $paginator->getData( $page )) {
					$GLOBALS['message'] = "No potential candidates fit that criteria.";
					return false;	
				}
				else
				{
					$results->links = $paginator->createLinks($page, 'pages');
					return $results;
				}						
			}
			else
			{
				return false;
			}
		}		
	}

?>
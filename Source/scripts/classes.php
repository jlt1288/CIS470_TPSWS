<?php

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
			
			if ($connection->query($query) or die('Error: ' . mysqli_error( $connection )) === 0){
				return true;
			}

			return false;			
		}
		
		public function refresh()
		{
			$this->populate($this->id);
		}
		
		
	}

?>
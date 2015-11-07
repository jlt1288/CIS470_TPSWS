<?php require('scripts/login.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
<title>Taylor's Professional Services</title>
<link rel="stylesheet" type="text/css" href="styles/style.css" media="screen" />
<style></style>
</head>

<body>
	<?php include_once('includes/header.php'); ?>
	
	
	<div id="main">	
		<div id="content">
	        <form id="login" name="login" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
            	<table>
                	<tr>
                    	<th><label>Username</label></th>
                        <th><input id="username" name="username" type="text"></th>
                    </tr>
                    <tr>
                    	<th><label>Password</label></th>
                        <th><input type="password" id="password" name="password"></th>
                    </tr>
                    <tr>
                    	<th></th>
                        <th><input type="submit" id="submit_login" name="submit_login" value="Login"></th>
                    </tr>
                </table>                
            </form>
        </div>
	</div>
    
	<?php include_once('includes/footer.php'); ?>
</body>

</html>
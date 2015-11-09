<form method="POST" action="<?php $_SERVER["PHP_SELF"] ?>">
	<table>
		<tr>
    		<th><label>Username:</label></th>
    	    <th><label id="username" name="username"></label></th>
	    </tr>
	    <tr>
	    	<th><label>Password:</label></th>
        	<th><input type="password" id="password" name="password" /></th>
    	</tr>
	    <tr></tr>
	    <tr>
    		<th><label>Resume:</label></th>
	        <th><label id="resume_file" name="resume_file"></label></th>
	        <th><input type="button" value="Browse" /></th>
        	<th><input type="button" value="Upload" /></th>
		</tr>
	</table>
</form>
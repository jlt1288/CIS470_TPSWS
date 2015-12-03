<?php
function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
    $sort_col = array();
    foreach ($arr as $key=> $row) {
        $sort_col[$key] = $row[$col];
    }
    array_multisort($sort_col, $dir, $arr);
}
?>
<h3 style= "margin-left: 20px; margin-top: -1em; padding-top: 15px; color: #202020;"><u>Submit Request</u></h3>
<p style="margin-top:20px;">
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF'] . "?request"); ?>" method="post" name="zipform" style="margin-left: 20px;">
            <label>Enter your ZIP Code: <input type="text" name="zipcode" size="6" maxlength="5" value="<?php echo $_POST['zipcode']; ?>" /></label>
            <label>&nbsp Select a distance (in miles) from this point:</label>
            <select name="distance">
                <option<?php if($_POST['distance'] == "5") { echo " selected=\"selected\""; } ?>>5</option>
                <option<?php if($_POST['distance'] == "10") { echo " selected=\"selected\""; } ?>>10</option>
                <option<?php if($_POST['distance'] == "25") { echo " selected=\"selected\""; } ?>>25</option>
                <option<?php if($_POST['distance'] == "50") { echo " selected=\"selected\""; } ?>>50</option>
                <option<?php if($_POST['distance'] == "100") { echo " selected=\"selected\""; } ?>>100</option>
            </select>
            <input type="submit" style="margin-left: 20px;" name="submit" value="Submit" />
        </form>
        <br />
        <?php
			if(isset($_POST['submit'])) {
				if(!preg_match('/^[0-9]{5}$/', $_POST['zipcode'])) {
					echo "<p><strong>&nbsp&nbsp&nbsp You did not enter a properly formatted ZIP Code.</strong> Please try again.</p>\n";
				}
				elseif(!preg_match('/^[0-9]{1,3}$/', $_POST['distance'])) {
					echo "<p><strong>&nbsp&nbsp&nbsp You did not enter a properly formatted distance.</strong> Please try again.</p>\n";
				}
				else {
					//connect to db server; select database
					require_once('scripts/database.php');
					
					//query for coordinates of provided ZIP Code
					if(!$rs = $connection->query("SELECT * FROM zipcodes WHERE code = '$_POST[zipcode]'")) {
						echo "<p><strong>There was a database error attempting to retrieve your ZIP Code.</strong> Please try again.</p>\n";
					}
					else {
						if(mysqli_num_rows($rs) == 0) {
							echo "<p><strong>No database match for provided ZIP Code.</strong> Please enter a new ZIP Code.</p>\n";	
						}
						else {
							//if found, set variables
							$row = mysqli_fetch_array($rs);
							$lat1 = $row['latitude'];
							$lon1 = $row['longitude'];
							$d = $_POST['distance'];
							$r = 3959;
							
							//compute max and min latitudes / longitudes for search square
							$latN = rad2deg(asin(sin(deg2rad($lat1)) * cos($d / $r) + cos(deg2rad($lat1)) * sin($d / $r) * cos(deg2rad(0))));
							$latS = rad2deg(asin(sin(deg2rad($lat1)) * cos($d / $r) + cos(deg2rad($lat1)) * sin($d / $r) * cos(deg2rad(180))));
							$lonE = rad2deg(deg2rad($lon1) + atan2(sin(deg2rad(90)) * sin($d / $r) * cos(deg2rad($lat1)), cos($d / $r) - sin(deg2rad($lat1)) * sin(deg2rad($latN))));
							$lonW = rad2deg(deg2rad($lon1) + atan2(sin(deg2rad(270)) * sin($d / $r) * cos(deg2rad($lat1)), cos($d / $r) - sin(deg2rad($lat1)) * sin(deg2rad($latN))));
							
							//display information about starting point
							//provide max and min latitudes / longitudes
							echo "<table id=\"resultTable\" class=\"bordered\">\n";
							echo "<tr><td><b>City</b></td><td><b>State</b></td><td><b>Lat</b></td><td><b>Lon</b></td><td><b>Max Lat (N)</b></td><td><b>Min Lat (S)</b></td><td><b>Max Lon (E)</b></td><td><b>Min Lon (W)</b></td></tr>\n";
							echo "<tr><td>$row[city]</td><td>$row[state]</td><td>$lat1</td><td>$lon1</td><td>$latN</td><td>$latS</td><td>$lonE</td><td>$lonW</td></tr>\n";
							echo "</table>\n<br />\n";
							
							//find all coordinates within the search square's area
							//exclude the starting point and any empty city values
							$query = "SELECT * FROM zipcodes WHERE (latitude <= $latN AND latitude >= $latS AND longitude <= $lonE AND longitude >= $lonW) AND (latitude != $lat1 AND longitude != $lon1) AND city != '' ORDER BY state, city, latitude, longitude";
							if(!$rs = $connection->query($query)) {
								echo "<p><strong>There was an error selecting nearby ZIP Codes from the database.</strong></p>\n";
							}
							elseif(mysqli_num_rows($rs) == 0) {
								echo "<p><strong>No nearby ZIP Codes located within the distance specified.</strong> Please try a different distance.</p>\n";								
							}
							else {
								//output all matches to screen
								echo "<div id=\"resultsDiv\"><table id=\"resultTable2\" class=\"bordered\">\n";
								echo "<tr><td><b>City</b></td><td><b>State</b></td><td><b>ZIP Code</b></td><td><b>Latitude</b></td><td><b>Longitude</b></td><td><b>Miles, Point A To B</b></td></tr>\n";
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
								
								foreach($tmp as $data) {
									echo "<tr><td>$data[city]</td><td>$data[state]</td><td>$data[code]</td><td>$data[latitude]</td><td>$data[longitude]</td><td>$data[distance]</td></tr>\n";	
								}
								while($row = mysqli_fetch_array($rs)) {
									
								}
								echo "</table></div>\n<br />\n";
							}
						}
					}
				}
			}
		?></p>
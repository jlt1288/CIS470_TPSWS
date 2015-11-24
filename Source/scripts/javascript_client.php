<?php
/*	Javascript for the Client area.
*----------------------------------------------------------------------------
*	Original Author: Joshua Thompson
*	Creation Date: 11/13/2015
*
*	Modification Author: Joshua Thompson
*	Modification Date: 11/20/2015
*----------------------------------------------------------------------------
*/
 if(isset($_POST['request']) || isset($_GET['request']))
{ ?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script type="text/javascript">
		//initial count of zero.
		var checked = 0;
		//maximum number of allowed checked.
		var maximum = 3;
		
		$(document).ready(function()
		{
			var $boxes = $('input[name="candidates[]"]:checked');
			
			checked = $boxes.length;
		});
				
		function selectCandidate(obj)
		{
			if (obj.checked){
				checked += 1;	
			}
			else
			{
				if ( checked - 1 < 0 ) { return; }
				checked -= 1;
			}

			if (checked > maximum){
				obj.checked = false;
				checked -= 1;
				alert("You may only select three (3) potential candidates per staffing request.");	
			}
		}		
	</script>
<?php }
?>
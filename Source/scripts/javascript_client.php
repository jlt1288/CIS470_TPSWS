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
	<script>
		function selectCandidate(j)
		{
			var total=0;
			for(var i=0; i < document.form1.candidates.length; i++)
			{
				if(document.form1.candidates[i].checked)
				{
					total =total +1;
				}
				
				if(total > 3)
				{
					alert("You may only select three (3) potential candidates per staffing request.");
					document.form1.candidates[j].checked = false ;
					return false;	
				}
			}
		}		
	</script>
<?php }
?>
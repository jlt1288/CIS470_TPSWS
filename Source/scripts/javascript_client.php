<?php if(isset($_POST['request']) || isset($_GET['request']))
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
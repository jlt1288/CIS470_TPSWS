<div id="header">
	<div id="navigationHeader">
    	<?php if (isset($_SESSION['id'])) { ?>
			<a href="<?php $_SERVER["PHP_SELF"]; ?>?logout">Logout</a>
        <?php } ?>
	</div>	
</div>
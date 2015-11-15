<div id="header">
	<div id="navigationHeader">
		<img src="styles/tpslogo.png" class="logo" alt="TPS" style="float: left;">
		<p style="float: left; margin: 0px; margin-left: 80px; margin-top: -6px; font-size: 48px; color:#202020;">Taylor's Professional Services</p>
		<div style="float: right; margin-top: 20px; font-size: 18px;">
		<?php if (isset($_SESSION['id'])) { ?>
			<a href="<?php $_SERVER["PHP_SELF"];?>?logout">Logout</a>
        <?php } ?>
		</div>
	</div>	
</div>
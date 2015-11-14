<br />
<p> Client area layout goes down here. </p>
<?php if (isset($confirmation_code)){ echo '<p>Confirmation Code: ' . $confirmation_code . '</p>'; } ?>

<form action="<?php $_SERVER["PHP_SELF"]; ?>" method="POST">
	<input type="submit" name="submit_request" id="submit_request" value="Submit" />
</form>
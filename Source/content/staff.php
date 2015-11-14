<?php
	if (isset($_GET['edit']) || isset($_POST['edit']))
	{
		require_once("content/staff_edit.php");
	} else {
		require_once("content/staff_view.php");		
	}
?>
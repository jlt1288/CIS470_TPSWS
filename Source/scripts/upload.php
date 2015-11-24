<?php

if (isset($_POST['type']) && $_POST['type'] === "picture" && !empty($_FILES))
{
	$target_dir = "uploads/pictures/";
	$imageFileType = pathinfo($target_dir . basename($_FILES["picture"]["name"]),PATHINFO_EXTENSION);
	$target_filename = md5(uniqid(basename($_FILES["picture"]["name"]), true)) . '.' . $imageFileType;
	$target_file = $target_dir . $target_filename;
	$uploadOk = 1;
	
	// Check if image file is a actual image or fake image
	$check = getimagesize($_FILES["picture"]["tmp_name"]);
	list($width, $height, $type, $attr) = getimagesize($_FILES["picture"]["tmp_name"]);
	if($check !== false) {
		$message = "File is an image - " . $check["mime"] . ".";
		$uploadOk = 1;
	} else {
		$message = "File is not an image.";
		$uploadOk = 0;
	}
	// Check if file already exists
	if (file_exists($target_file)) {
		$message = "Sorry, file already exists.";
		$uploadOk = 0;
	}
	// Check file size
	if ($_FILES["picture"]["size"] > 500000) {
		$message = "Sorry, your file is too large.";
		$uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		$message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an upload
	if ($uploadOk == 0) {
		$message = "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
			$message = "The " . $_POST['type'] . " was successfully uploaded.";
		} else {
			$message = "Sorry, there was an upload uploading your file.";
		}
	}
}elseif (isset($_POST['type']) && $_POST['type'] === "resume" && !empty($_FILES))
{
	$target_dir = "uploads/resumes/";
	$fileType = pathinfo($target_dir . basename($_FILES["resume"]["name"]),PATHINFO_EXTENSION);
	$target_filename = md5(uniqid(basename($_FILES["resume"]["name"]), true)) . '.' . $fileType;
	$target_file = $target_dir . $target_filename;
	$uploadOk = 1;
	
	// Check if file already exists
	if (file_exists($target_file)) {
		$message = "Sorry, file already exists.";
		$uploadOk = 0;
	}
	
	// Check if $uploadOk is set to 0 by an upload
	if ($uploadOk == 0) {
		$message = "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["resume"]["tmp_name"], $target_file)) {
			$message = "The " . $_POST['type'] . " was successfully uploaded.";
		} else {
			$message = "Sorry, there was an upload uploading your file.";
		}
	}
}

?> 
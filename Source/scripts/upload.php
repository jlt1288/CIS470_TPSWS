<?php
/*	Upload component used to upload pictures and resumes to the server.
*----------------------------------------------------------------------------
*	Original Author: Joshua Thompson
*	Creation Date: 11/13/2015
*
*	Modification Author: Joshua Thompson
*	Modification Date: 11/30/2015
*----------------------------------------------------------------------------
*/

function upload()
{
	$max_width = 256;
	$max_height = 256;
	
	// Determine what item we're triyng to upload.
	if (isset($_POST['type']) && $_POST['type'] === "picture" && !empty($_FILES))
	{
		// Looks like we're trying to upload a picture.
	
		$target_dir = "uploads/pictures/";
		$imageFileType = pathinfo($target_dir . basename($_FILES["picture"]["name"]),PATHINFO_EXTENSION);
		$target_filename = md5(uniqid(basename($_FILES["picture"]["name"]), true)) . '.' . $imageFileType;
		$target_file = $target_dir . $target_filename;
	
		list($width, $height, $type, $attr) = getimagesize($_FILES["picture"]["tmp_name"]);
		// Check width and height to make sure they are within the limitation.
		if ($width > $max_width)
		{
			return array(false, "The width of the picture cannot exceed 256 pixels.<br>Please reduce the image and try again.");
		}
	
		if ($height > $max_height)
		{
			return array(false, "The height of the picture cannot exceed 256 pixels.<br>Please reduce the image and try again.");
		}
	
		// Check if file already exists
		if (file_exists($target_file)) {
			return array(false, "Sorry, file already exists.");
		}
		// Check file size
		if ($_FILES["picture"]["size"] > 500000) {
			return array(false, "Sorry, your file is too large.");
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			return array(false, "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
		}
		// if everything is ok, try to upload file
		if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
			return array(true, "The " . $_POST['type'] . " was successfully uploaded.", $target_filename);
		} else {
			return array(false, "Sorry, there was an error uploading your file.");
		}
	}elseif (isset($_POST['type']) && $_POST['type'] === "resume" && !empty($_FILES))
	{
		// Looks like we're trying to upload a resume.
	
		$target_dir = "uploads/resumes/";
		$fileType = pathinfo($target_dir . basename($_FILES["resume"]["name"]),PATHINFO_EXTENSION);
		$target_filename = md5(uniqid(basename($_FILES["resume"]["name"]), true)) . '.' . $fileType;
		$target_file = $target_dir . $target_filename;
	
		// Check if file already exists
		if (file_exists($target_file)) {
			return array(false, "Sorry, file already exists.");
		}
	
		if (move_uploaded_file($_FILES["resume"]["tmp_name"], $target_file)) {
			return array(true, "The " . $_POST['type'] . " was successfully uploaded.", $target_filename);
		} else {
			return array(false, "Sorry, there was an error uploading your file.");
		}
	}
	else
	{
		return array(false, "Unable to verify upload data.");
	}
}
?> 
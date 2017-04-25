<?php
require_once('../private/initialize.php');
$message = '';
$message_path = '';
if(is_post_request()) {
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
	$uploadOk = 1;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $message = "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $message = "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
				$message_path = "Path: " . $target_file;
    } else {
        $message ="Sorry, there was an error uploading your file.";
    }
}
}
?>

<!DOCTYPE html>
<html>
<body>

<h1>Page Under Construction</h1>
<form action="hidden.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form> <br />
		<br />
		<label> <?php echo $message?> </label> <br />
		<label> <?php echo $message_path?> </label> <br />
 </body>
</html>
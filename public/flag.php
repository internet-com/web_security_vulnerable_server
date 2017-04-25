<?php
	require_once('../private/initialize.php');
	global $db;
	$sql = "SELECT secret FROM secrets WHERE id='1'";
	$result = db_query($db, $sql);
	$secret = db_fetch_assoc($result);
	echo $secret['secret'];
?>
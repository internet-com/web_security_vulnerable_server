<?php
	global $db;
	$sql = "SELECT secret FROM secrets WHERE id='1'";
	echo db_query($db, $sql);
?>
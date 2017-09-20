<?php
	session_start();
	$_SESSION['status'] = FALSE;
	header("Location: index.php");
?>

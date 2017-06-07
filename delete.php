<?php
	require 'database.class.php';

	session_start();
	if ($_SESSION['status'] != TRUE || $_GET['user'] != $_SESSION['uid'])
		header("Location: feed.php");
	$database = new DataBase();
	$database->deleteImage($_GET['id']);
	header("Location: feed.php");
?>

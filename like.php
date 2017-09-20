<?php
	require 'likes.class.php';

	$likes = new Likes();
	$user = $_GET['user'];
	$id = $_GET['id'];
	$likes->addLike($user, $id);
	header("Location: feed.php");
?>

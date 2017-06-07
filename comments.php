<?php
	require 'comments.class.php';

	session_start();
	if ($_SESSION['status'] === FALSE)
		header("Location: index.php");
	$user = $_SESSION['login_user'];
	$id = $_SESSION['uid'];
	foreach ($_POST as $key => $value)
	{
		if (strpos($key, 'comment') == 0)
		{
			$comment = $_POST[$key];
			$pid = substr($key, 7);
		}
	}
	$db = new Comments();
	$db->addComment($pid, $user, $comment);
	header("Location: feed.php");
?>

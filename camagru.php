<?php
include'database.class.php';
if ($_POST['username'] && $_POST['password'])
{
	$db = new DataBase();
	$tmp = $db->login($_POST['username'], $_POST['password']);
	if ($tmp === false)
		header('location: index.php?login=false');
	if ($tmp === true)
	{
		@session_start();
		$_SESSION['login_user'] = $_POST['username'];
		header('location: welcome.php');
	}
}
?>
<link rel = "stylesheet" href = "style.css">

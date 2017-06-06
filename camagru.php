<link rel = "stylesheet" href = "style.css">
<?php
	include'database.class.php';
	if ($_POST['username'] && $_POST['password'])
	{
		$db = new DataBase();
		$tmp = $db->login($_POST['username'], $_POST['password']);
		if ($tmp === false)
			header('location: index.php?login=false');
		else
		{
			@session_start();
			$_SESSION['login_user'] = $_POST['username'];
			$_SESSION['status'] = TRUE;
			$_SESSION['uid'] = $tmp;
			header('location: welcome.php');
		}
	}
?>

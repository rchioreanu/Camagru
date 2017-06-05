<link rel = "stylesheet" type = "text/css" href = "style.css">
<?php
	session_start();
	if (!isset($_SESSION['login_user']))
		header("Location: index.php");
?>
<!DOCTYPE html>

<html>
	<head>
		<title>Feed</title>
		<link rel = "stylesheet" type = "text/css" href = "style.css">
	</head>
	<body>
		<div class = "header">
			<h1 class = "center" id = "welcome">Welcome, <?php echo $_SESSION['login_user'];?></h1>
			<div class = "buttons">
				<a href = "welcome.php"><button type = "button" id = "home-btn">Take a photo</button></a>
				<a href = "feed.php"><button type = "button" id = "feed-btn">Feed</button></a>
				<a href = "logout.php"><button type = "button" id = "logout-btn">Logout</button></a>
			</div>
		</div>
	</body>
</html>
<?php
	require 'database.class.php';

	$db = new DataBase();
	$db->feed();
?>

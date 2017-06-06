<link rel = "stylesheet" type = "text/css" href = "style.css">
<?php
	session_start();
	if ($_SESSION['status'] === TRUE)
		$status = TRUE;
	else
		$status = FALSE;
	$start = $_GET['start'];
	if (!isset($_GET['start']))
		$start = 1;
?>
<!DOCTYPE html>

<html>
	<head>
		<title>Feed</title>
		<link rel = "stylesheet" type = "text/css" href = "style.css">
	</head>
	<body>
		<div class = "header">
			<h1 class = "center" id = "welcome">Welcome <?php echo $_SESSION['login_user'];?></h1>
			<div class = "buttons">
				<a href = "welcome.php"><button type = "button" id = "home-btn">Take a photo</button></a>
				<a href = "feed.php"><button type = "button" id = "feed-btn">Feed</button></a>
				<?php
					if ($status === TRUE)
						echo '
				<a href = "logout.php"><button type = "button" id = "logout-btn">Logout</button></a>';
				?>

			</div>
		</div>
	</body>
	<?php
		require 'database.class.php';

		$db = new DataBase();
		$db->feed($start, $status);
	?>
	<footer>
		<a href = "feed.php?start=<?php echo $start + 5;?>"><button id = "next-btn" type = "button">Next -></button></a>
	</footer>
</html>

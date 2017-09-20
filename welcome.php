<?php
	require 'database.class.php';
	session_start();
	if ($_SESSION['status'] != TRUE || !isset($_SESSION))
		header('location: index.php');
?>
<html>
	<head>
		<title>Welcome </title>
		<link rel = "stylesheet" type = "text/css" href = "style.css">
	</head>
	<body>
		<div class = "header">
			<h1 class = "center" id = "welcome">Welcome, <?php echo $_SESSION['login_user'];?></h1>
			<div class = "buttons">
				<button type = "button" id = "home-btn">Take a photo</button>
				<a href = "feed.php"><button type = "button" id = "feed-btn">Feed</button></a>
				<a href = "logout.php"><button type = "button" id = "logout-btn">Logout</button></a>
			</div>
		</div>
		<div id = "photo-div">
			<canvas id = "canvas" width = 640 height = 480></canvas>
			<div class = "upload" id = "uimage">
				<video id = "video" autoplay></video>
				<img id = "overlay" src = "image/dragnea.png">
			</div>
			<div class = "center">
				<select id = "list">
					<option value = "dragnea">Dintii lui Dragnea</option>
					<option value = "iVoted">I Voted</option>
					<option value = "pineapple">Pineapple</option>
					<option value = "agreement">Paris agreement</option>
					<option value = "explore">Romania - Explore the Carpathian Garden</option>
					<option value = "romania">Romania</option>
					<option value = "cpf"> Coalitia pentru Familie</option>
				</select>
			</div>
			<button type = "button" id = "button">Smile!</button>
			<div class = "center">
				<input type = "file" id = "uploadbtn">
				<button type = "button" class = "line-btn" id = "submitbtn">Submit!</button>
			</div>
		</div>
		<div id = "feed-div">
			<?php
				$db = new DataBase();
				$db->lastImages();
			?>
		</div>
		<script type = "text/javascript" src = "webcam.js"></script>
	</body>
</html>

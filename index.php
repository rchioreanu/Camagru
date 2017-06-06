<link rel='stylesheet' type='text/css' href='style.css'/>
<?php
	session_start();
	if ($_SESSION['status'] === TRUE)
		header('location: welcome.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Camagru</title>
	</head>
	<body>
<?php
	if ($_GET['signup'] == 'true')
		echo "<link rel='stylesheet' type='text/css' href='style.css'/>
		<h5 class = 'success'>You signed up succesfully! Log in now!</h5>";
	else if ($_GET['login'] == 'false')
		echo "<h5 class = 'error'>Error loging in :(</h5>";
?>
		<h1 class = "Title">Camagru</h1>
		<form action = "/camagru/camagru.php" method = "post">
			<input type = "text" class = "cassette" name = "username" placeholder = "username/email">
			<input type = "password" id = "password" name = "password" placeholder = "password">
			<input id = "button" type = "submit" action = "submit" value = "Log in" class = "login">
		</form>
		<a href = "/camagru/signup.php"><h6 id = "sign-up">Sign up here! It is awesome!</h></a>
	</body>
</html>

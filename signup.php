<?php
	require_once 'validations.php';
	require_once 'database.class.php'
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel = "stylesheet" type = "text/css" href = "style.css">
		<title>Sign up!</title>
	</head>
	<body>
<?php
	if ($_GET['username'])
	{
		echo '<h5 class = "error">Username is taken</h5>';
	}

	if ($_GET['email'])
	{
		echo '<h5 class = "error">Email is '.$_GET["email"].'</h5>';
	}

	if ($_GET['password'])
	{
		echo '<h5 class = "error">Password is weak. Include at least small, capital letters and numbers!</h5>';
	}

	if ($_GET['incomplete'])
	{
		echo '<h5 class = "error">The form is incomplete. Please review it!</h5>';
	}
	if ($_GET['psw'])
	{
		echo '<h5 class = "error">The passwords do not match</h5>';
	}

	if(!$_POST)
		echo '<h1 class = "Title">Sign up</h1>
		<form action = "/camagru/signup.php" method = "post">
		<p class = "text">First Name: <input type = "text" class = "cassette" name = "FName"></p>
		<p class = "text">Last Name: <input type = "text" class = "cassette" name = "LName" /></p>
		<p class = "text">Email: <input type = "text" class = "cassette" name = "email" /></p>
		<p class = "text">Username: <input type = "text" class = "cassette" name = "username" /></p>
		<p class = "text">Password: <input type = "password" id = "password" name = "password" /></p>
		<p class = "text">Repeat password: <input type = "password" id = "password" name = "rpassword" /></p>
		<br />
		<input type = "submit" action = "submit" value = "Sign up!" class = "login">
		</form>';
	else
	{
		$get = "?";
		$dataBase = new DataBase();
		if ($_POST['password'] != $_POST['rpassword'])
		{
			$error = TRUE;
			$get .= "psw=nomatch";
		}
		if (!$dataBase->checkUser($_POST['username']))
		{
			$error = TRUE;
			$get .= "username=taken&";
		}
		if (email($_POST['email']))
		{
			if (!$dataBase->checkEmail($_POST['email']))
			{
				$error = TRUE;
				$get .= "email=registered&";
			}
		}
		else
		{
			$error = TRUE;
			$get .= "email=false&";
		}
		if (!password($_POST['password']))
		{
			$error = TRUE;
			$get .= "password=weak&";
		}
		if (!$_POST['FName'] || !$_POST['LName'] || !$_POST['email']
			|| !$_POST['username'] || !$_POST['password'])
		{
			$error = TRUE;
			$get .= "incomplete=true&";
		}
		if ($error == TRUE)
			header("Refresh:0; url=signup.php$get");
		else
		{
			$dataBase->addUser($_POST['username'], $_POST['password'], $_POST['FName'],
				$_POST['LName'], $_POST['email']);
			header("location: index.php?signup=true");
		}
	}
?>
	</body>
</html>

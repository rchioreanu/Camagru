<?php
	require 'database.php';
	$comments = "CREATE TABLE `comments` (
	  `id` int(11) NOT NULL,
	  `user` varchar(1000) NOT NULL,
	  `photo_id` int(11) NOT NULL,
	  `comment` text NOT NULL
	);";
	$commentsKey = "ALTER TABLE `comments`
	  ADD PRIMARY KEY (`id`);";
	$commentsIncrement = "ALTER TABLE `comments`
	  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
	$images = "CREATE TABLE `images` (
	  `id` int(11) NOT NULL,
	  `uid` int(11) NOT NULL,
	  `img` mediumblob NOT NULL,
	  `likes` int(11) NOT NULL DEFAULT '0'
	);";
	$imagesKey = "ALTER TABLE `images`
	  ADD PRIMARY KEY (`id`);";
	$imagesIncrement = "ALTER TABLE `images`
	  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
	$likes = "CREATE TABLE `likes` (
	  `id` int(11) NOT NULL,
	  `user` varchar(1000) NOT NULL,
	  `photo_id` int(11) NOT NULL
	);";
	$likesKey = "ALTER TABLE `likes`
	  ADD PRIMARY KEY (`id`);";
	$likesIncrement = "ALTER TABLE `likes`
	  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
	$users = "CREATE TABLE `users` (
	  `id` int(100) NOT NULL,
	  `fname` varchar(100) NOT NULL,
	  `lname` varchar(100) NOT NULL,
	  `email` varchar(100) NOT NULL,
	  `uname` varchar(100) NOT NULL,
	  `passwd` varchar(1000) NOT NULL
	);";
	$usersKey = "ALTER TABLE `users`
	  ADD UNIQUE KEY `id` (`id`);";
	$usersIncrement = "ALTER TABLE `users`
	  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;COMMIT;";
	$tmp = substr($DB_DSN, 6);
	$tmp2 = explode(';', $tmp);
	foreach ($tmp2 as $tmp3)
	{
		if (strstr($tmp3, 'host'))
			$host = strstr($tmp3, 'host');
		if (strstr($tmp3, 'db'))
		{
			$t = strstr($tmp3, 'db');
			$t = substr($t, 7);
			if ($t[0] == '=')
				$t = substr($t, 1);
			$db = $t;
		}
	}
	try
	{
		var_dump($db);
		$dbh = new PDO("mysql:".$host, $DB_USER, $DB_PASSWORD);
		$query = "CREATE DATABASE $db";
		$status = $dbh->query($query);
		if ($status === FALSE)
		{
			$dbh->exec("DROP DATABASE `$db`;");
			$dbh->query($query);
		}
		$dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$dbh->query("USE $db;");
		$dbh->query($comments);
		$dbh->query($commentsKey);
		$dbh->query($commentsIncrement);
		$dbh->query($images);
		$dbh->query($imagesKey);
		$dbh->query($imagesIncrement);
		$dbh->query($likes);
		$dbh->query($likesKey);
		$dbh->query($likesIncrement);
		$dbh->query($users);
		$dbh->query($usersKey);
		$dbh->query($usersIncrement);
	}
	catch (PDOException $e)
	{
		die("DB ERROR: ". $e->getMessage());
	}
?>

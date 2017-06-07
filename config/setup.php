<?php
	require 'database.php';
	$comments = "CREATE TABLE `comments` (
	  `id` int(11) NOT NULL,
	  `user` varchar(1000) NOT NULL,
	  `photo_id` int(11) NOT NULL,
	  `comment` text NOT NULL
	);";
	$images = "CREATE TABLE `images` (
	  `id` int(11) NOT NULL,
	  `uid` int(11) NOT NULL,
	  `img` mediumblob NOT NULL,
	  `likes` int(11) NOT NULL DEFAULT '0'
	);";
	$likes = "CREATE TABLE `likes` (
	  `id` int(11) NOT NULL,
	  `user` varchar(1000) NOT NULL,
	  `photo_id` int(11) NOT NULL
	);";
	$users = "CREATE TABLE `users` (
	  `id` int(100) NOT NULL,
	  `fname` varchar(100) NOT NULL,
	  `lname` varchar(100) NOT NULL,
	  `email` varchar(100) NOT NULL,
	  `uname` varchar(100) NOT NULL,
	  `passwd` varchar(1000) NOT NULL
	);";
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
		$dbh->query($comments);
		$dbh->query($images);
		$dbh->query($likes);
		$dbh->query($users);
	}
	catch (PDOException $e)
	{
		die("DB ERROR: ". $e->getMessage());
	}
?>

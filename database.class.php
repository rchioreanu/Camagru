<?php
	include 'comments.class.php';
	class DataBase
	{
		private		$user = "root";
		private		$passwd = "123456";
		protected	$db;

		function __construct()
		{
			try
			{
				$databaseName = "mysql:host=localhost;dbname=db_camagru";
				$this->db = new PDO($databaseName, $this->user, $this->passwd);
			}
			catch (PDOException $e)
			{
				$e->getTrace();
				die();
			}
		}
		public function checkUser($user)
		{
			$query = "SELECT * FROM `users` WHERE `uname` LIKE '$user'";
			try
			{
				foreach ($this->db->query($query) as $elem)
				{
					if ($elem['uname'])
						return (FALSE);
				}
				return (TRUE);
			}
			catch (PDOException $e)
			{
				echo "Error";
			}
		}

		public function checkEmail($email)
		{
			$query = "SELECT * FROM `users` WHERE `email` LIKE '$email'";
			try
			{
				foreach ($this->db->query($query) as $elem)
				{
					if ($elem['email'])
						return (FALSE);
				}
				return (TRUE);
			}
			catch (PDOException $e)
			{
				echo "Error";
			}
		}

		public function addUser($user, $password, $FName, $LName, $email)
		{
			$tmp = hash("whirlpool", trim($password));
			$query = "INSERT INTO users (fname, lname, email, uname, passwd) VALUES ('$FName','$LName','$email', '$user','$tmp');";
			$this->db->query($query);
			$mail = 'You signed up for Camagru!';
			mail($email, 'Camagru registration', $mail);
		}

		public function login($user, $password)
		{
			$query =  "SELECT * FROM `users` WHERE `uname` LIKE '$user'";
			foreach ($this->db->query($query) as $elem)
			{
				if ($elem['uname'])
				{
					if ($elem['passwd'] == hash("whirlpool", $password))
						return ($elem['id']);
					else
						return (FALSE);
				}
			}
			$query =  "SELECT * FROM `users` WHERE `email` LIKE '$user'";
			foreach ($this->db->query($query) as $elem)
			{
				if ($elem['email'])
				{
					if ($elem['passwd'] == hash("whirlpool", $password))
						return ($elem['id']);
					else
						return (FALSE);
				}
			}
			return (FALSE);
		}
		public function	addImage($img)
		{
			$query = "INSERT INTO images (img) VALUES ('$img');";
			try
			{
				$this->db->query($query);
			}
			catch (PDOException $e)
			{
				$e->getTrace();
			}
		}

		public function	getImage($id)
		{
			$query = "SELECT * FROM `images` WHERE `id` LIKE '$id';";
			try
			{
				foreach ($this->db->query($query) as $elem)
				{
					return ($elem['img']);
				}
			}
			catch (PDOException $e)
			{
				$e->getTrace();
			}
		}

		public function lastImages()
		{
			$query = "SELECT img FROM images ORDER BY id DESC LIMIT 2;";
			try
			{
				foreach ($this->db->query($query) as $elem)
				{
					echo "<img class = 'history' src = 'data:image/png;base64,".$elem["img"]."'>";
				}
			}
			catch (PDOException $e)
			{
				$e->getTrace();
			}
		}
		public function feed($start, $status)
		{
			$query = "SELECT * FROM images ORDER BY id DESC LIMIT 5 OFFSET $start;";
			try
			{
				$tmp = 0;
				foreach ($this->db->query($query) as $elem)
				{
					$id = $elem['id'];
					echo '<div class = "feed">';
					echo "<img class = 'history' src = 'data:image/png;base64,".$elem["img"]."'>";
					$comments = new Comments();
					$comments->getComments($id);
					if ($status === TRUE)
					{
						echo '<form action = "comments.php"
							method = "post" id = "comments'.$id.'">
							<textarea name = "comment'.$id.'"></textarea>
							</form>';
						echo '<input type = "submit" value = "Comment" id = "com'.$id.'" class = "comment-btn" form = "comments'.$id.'" />';
						echo '<button class = "like-btn" id = "like-btn'.$id.'" type = "button">Like</button>';
					}
					echo '</div>';
					echo '<br />';
					$tmp++;
				}
				if ($tmp == 0)
					header("Location: feed.php");
			}
			catch (PDOException $e)
			{
				$e->getTrace();
			}
		}
	}
?>

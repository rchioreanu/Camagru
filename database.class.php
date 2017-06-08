<?php
	require_once 'comments.class.php';
	require_once 'likes.class.php';


	class DataBase
	{
		private	$db;
		private $user;
		private $passwd;
		private $data;

		function __construct()
		{
			require_once 'config/database.php';
			$this->data = $DB_DSN;
			$this->user = $DB_USER;
			$this->passwd = $DB_PASSWORD;
			try
			{
				$this->db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
			}
			catch (PDOException $e)
			{
				echo $e->getMessage();
				die("Error");
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
			try
			{
				$this->db->query($query);
			}
			catch (PDOException $e)
			{
				echo "Error: ";
				echo $e->getMessage();
			}
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
		public function	addImage($uid, $img)
		{
			$query = "INSERT INTO images (uid, img) VALUES ('$uid', '$img');";
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
			session_start();
			$user = $_SESSION['login_user'];
			$user_id = $_SESSION['uid'];
			try
			{
				$tmp = 0;
				$d = $this->db->prepare($query);
				$d->execute();
				if ($d->rowCount() == 0)
				{
					echo "<h1 class = 'Title'>THERE ARE NO PICTURES TO BE SHOWN :(</h1>";
					die();
				}
				foreach ($this->db->query($query) as $elem)
				{
					$id = $elem['id'];
					$uid = $elem['uid'];
					if ($uid !== $user_id)
						$isAuthor = FALSE;
					else
						$isAuthor = TRUE;
					$author = $elem['uid'];
					echo '<div class = "feed">';
					echo "<img class = 'history' src = 'data:image/png;base64,".$elem["img"]."'>";
					$comments = new Comments();
					$comments->getComments($id);
					$likes = new Likes();
					$likesNr = $likes->getLikes($id);
					$isLiked = $likes->checkLike($user, $id);
					if ($status === TRUE)
					{
						echo '<form action = "comments.php"
							method = "post" id = "comments'.$id.'">
							<textarea name = "comment'.$id.'"></textarea>
							</form>';
						echo '<input type = "submit" value = "Comment" id = "com'.$id.'" class = "comment-btn" form = "comments'.$id.'" />';
						if ($isLiked === FALSE)
							echo '<a href = "like.php?user='.$user.'&id='.$id.'"><button  class = "like-btn" id = "like-btn'.$id.'" type = "button">Like</button></a>';
						else
							echo '<a href = "unlike.php?user='.$user.'&id='.$id.'"><button  class = "like-btn" id = "like-btn'.$id.'" type = "button">Unlike</button></a>';
						if ($isAuthor)
							echo '<a href = "delete.php?id='.$id.'&user='.$uid.'"><button  class = "del-btn" id = "del-btn'.$id.'" type = "button">Delete</button></a>';
						echo "Likes: ".$likesNr;
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
				echo $e->getMessage();
			}
		}

		public function deleteImage($id)
		{
			$query = "DELETE FROM images WHERE id LIKE $id;";
			try
			{
				$this->db->query($query);
			}
			catch (PDOException $e)
			{
				$e->getTrace();
			}
		}
	}
?>

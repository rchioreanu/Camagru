<link rel = "stylesheet" href = "style.css">
<?php
	class Likes
	{
		private	$user = "root";
		private	$passwd = "123456";
		private	$db;

		public function __construct()
		{
			$dbName = "mysql:host=localhost;dbname=db_camagru";
			try
			{
				$this->db = new PDO($dbName, $this->user, $this->passwd);
			}
			catch (PDOException $e)
			{
				$e->getTrace();
				die();
			}
		}
		public function getLikes($id)
		{
			$query = "SELECT * from images WHERE id like $id";
			try
			{
				foreach ($this->db->query($query) as $elem)
					return ($elem['likes']);
			}
			catch (PDOException $e)
			{
				$e->getTrace();
			}
		}

		public function checkLike($user, $pid)
		{
			$query = "SELECT * FROM `likes` WHERE photo_id LIKE $pid AND user like '$user';";
			try
			{
				foreach ($this->db->query($query) as $elem)
				{
					if ($elem['id'])
						return (TRUE);
					else
						return (FALSE);
				}
			}
			catch (PDOException $e)
			{
				$e->getTrace();
			}
			return (FALSE);
		}

		public function addLike($user, $pid)
		{
			$query = "UPDATE images SET likes = likes + 1 WHERE id LIKE $pid;";
			$query2 = "INSERT INTO likes(user, photo_id) VALUES('$user', $pid);";
			try
			{
				$this->db->query($query);
				$this->db->query($query2);
			}
			catch (PDOException $e)
			{
				$e->getTrace();
			}
		}

		public function removeLike($user, $pid)
		{
			$query = "UPDATE images SET likes = likes - 1 WHERE id LIKE $pid;";
			$query2 = "DELETE FROM likes WHERE likes.photo_id = $pid AND likes.user = '$user';";
			try
			{
				$this->db->query($query);
				$this->db->query($query2);
			}
			catch (PDOException $e)
			{
				$e->getTrace();
			}
		}
	}
?>

<link rel = "stylesheet" href = "style.css">
<?php
	class Comments
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
		public function getComments($id)
		{
			$query = "SELECT * FROM comments WHERE photo_id LIKE $id;";
			echo '<link rel = "stylesheet" type = "text/css" href = "style.css">';
			echo '<div id = "comment-box">';
			foreach ($this->db->query($query) as $elem)
			{
				echo $elem['comment'];
				echo '<br />';
			}
			echo '</div>';
		}

		public function addComment($pid, $uid, $comment)
		{
			$query = "INSERT INTO comments (comment, user_id, photo_id) VALUES ('$comment', '$uid', '$pid');";
			try
			{
				$this->db->query($query);
			}
			catch (PDOException $e)
			{
				echo "NO";
				$e->getTrace();
			}
		}
	}
?>

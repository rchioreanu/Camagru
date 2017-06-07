<link rel = "stylesheet" href = "style.css">
<?php
	class Comments
	{
		private	$db;

		public function __construct()
		{
			require_once 'config/database.php';
			try
			{
				$this->db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
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
			try
			{
				foreach ($this->db->query($query) as $elem)
				{
					echo "<p>";
					echo "<span class = 'uname'>".$elem['user'].": </span>";
					echo $elem['comment'];
					echo "</p>";
				}
			}
			catch (PDOException $e)
			{
				$e->getTrace();
			}
			echo '</div>';
		}

		public function addComment($pid, $user, $comment)
		{
			$query = "INSERT INTO comments (comment, user, photo_id) VALUES ('$comment', '$user', '$pid');";
			$query2 = "SELECT users.email FROM users WHERE users.id IN (SELECT uid FROM images WHERE id LIKE $pid)";
			try
			{
				$this->db->query($query);
				foreach ($this->db->query($query2) as $elem)
					$email = $elem['email'];
				$subject = "You have a new comment!";
				$message = "Your post just got commented on! Participate in the discussion!";
				mail($email, $subject, $message);
			}
			catch (PDOException $e)
			{
				$e->getTrace();
			}
		}
	}
?>

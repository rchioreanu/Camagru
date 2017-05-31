<link rel = "stylesheet" type = "text/css" href = "style.css">
<?php
session_start();
if (!isset($_SESSION['login_user']))
	header('location: index.php');
?>
<html>
   <head>
	  <title>Welcome </title>
   </head>

   <body>
	  <h1>Welcome <?php echo $_SESSION['login_user'];?></h1>
<canvas id = "canvas"></canvas>
<video id = "video" autoplay></video>
<input id = "button" type = "button" value = "photo!" >
<img id = "image">
<script type = "text/javascript" src = "webcam.js"></script>
<a href = "logout.php">Log out!</a>
   </body>
</html>

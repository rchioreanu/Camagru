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
<canvas id = "canvas" width = 640 height = 480></canvas>
<div class = "div">
<video id = "video" autoplay></video>
<img id = "overlay" src = "">
</div>
<div class = "center">
<select id = "list">
<option value = "dragnea">Dintii lui Dragnea</option>
<option value = "iVoted">I Voted</option>
<option value = "pineapple">Pineapple</option>
<option value = "agreement">Paris agreement</option>
<option value = "explore">Romania - Explore the Carpathian Garden</option>
<option value = "romania">Romania</option>
<option value = "cpf"> Coalitia pentru Familie</option>
</select>
<button type = "button" id = "refresh">Refresh image</button>
</div>
<button type = "button" id = "button">PHOTO</button>
<script type = "text/javascript" src = "webcam.js"></script>
<a href = "logout.php">Log out!</a>
   </body>
</html>

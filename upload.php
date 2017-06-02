<link rel = "stylesheet" type = "text/css" href = "style.css">
<?php
require 'database.class.php';
$database = new DataBase();
$image = str_replace(' ', '+', $_POST['image']);
$database->addImage($image);
?>
<div class = "div">
	<img id = 'image' src = <?php echo $image;?>>
<img id = 'overlay' src = 'image/explore.png'>
</div>
<?php
$nobase64 = substr($image, 22);
$decoded = base64_decode($nobase64);
$img = imagecreatefromstring($decoded);
$img2 = imagecreatefrompng('image/explore.png');
imagealphablending($img2, true);
imagealphablending($img, true);
imagecopy($img, $img2, 0, 0, 0, 0, 640, 480);
header('Content-Type: image/png');
imagepng($img, 'image.png');
?>

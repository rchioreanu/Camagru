<link rel = "stylesheet" type = "text/css" href = "style.css">
<?php
require 'database.class.php';
$base64Tag = "data:image/png;base64,";
$database = new DataBase();
$image = str_replace(' ', '+', $_POST['image']);
$nobase64 = substr($image, 22);
$decoded = base64_decode($nobase64);
$img = imagecreatefromstring($decoded);
$img2 = imagecreatefrompng("image/".$_GET['filter'].".png");
imagealphablending($img2, true);
imagealphablending($img, true);
imagecopy($img, $img2, 0, 0, 0, 0, 640, 480);
$im = imagecreatetruecolor(640, 480);
imagealphablending($im, true);
imagecopy($img, $img2, 0, 0, 0, 0, 640, 480);
ob_start();
imagepng($img);
$temp = ob_get_clean();
$ready = base64_encode($temp);
$database->addImage($ready);
header("Location: welcome.php");
?>

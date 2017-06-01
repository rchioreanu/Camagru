<link rel = "stylesheet" type = "text/css" href = "style.css">
<?php
require 'database.class.php';

$database = new DataBase();
$image = str_replace(' ', '+', $_POST['image']);
$database->addImage($image);
echo "<img id = 'image' src = '";
echo $database->getImage(8);
echo "'>";

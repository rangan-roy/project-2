<?php
session_start();
header('Content-type: image/jpeg');

$text = $_SESSION['captcha'] = rand(10000, 99999);
$fontFile = $_SERVER['DOCUMENT_ROOT'].'/assets/fonts/BRADHITC.TTF';
$fontSize = 30;
$imageWidth = 200;
$imageHeight = 100;

// now create the image
$image = imageCreate($imageWidth, $imageHeight);

// allocate image background color
imageColorAllocate($image, 255, 255, 255);

// allocate font color
$fontColor = imageColorAllocate($image, 10, 10, 10);

// now set the text on the image
imageTtfText($image, $fontSize, rand(15, -15), rand(10, 70), 60, $fontColor, $fontFile, $text);

// now set lines over the text on the image
for($i = 0; $i < 30; $i++)
{
	$x1 = rand(0, 200);
	$y1 = rand(0, 100);
	$x2 = rand(0, 200);
	$y2 = rand(0, 100);
	
	imageLine($image, $x1, $y1, $x2, $y2, $fontColor);
}

// output the image
imageJpeg($image);
?>
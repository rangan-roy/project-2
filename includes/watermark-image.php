<?php
$logoDirectory = $_SERVER['DOCUMENT_ROOT'].'/assets/images';
$imageDirectory = $_SERVER['DOCUMENT_ROOT'].'/assets/post_images';

if(isset($_GET['image']) && file_exists($imageDirectory.'/'.$_GET['image']))
{
	// get logo info
	$logoFile = $logoDirectory.'/logo-text.png';
	$logoInfo = getImageSize($logoFile);
	$logoWidth = $logoInfo[0];
	$logoHeight = $logoInfo[1];
	
	// get image info
	$imageFile = $imageDirectory.'/'.$_GET['image'];
	$imageInfo = getImageSize($imageFile);
	$imageWidth = $imageInfo[0];
	$imageHeight = $imageInfo[1];
	$imageExtension = $imageInfo['mime'];
	
	if($imageWidth >= $logoWidth && $imageHeight >= $logoHeight)
	{
		// set watermark place on the image
		$x = $imageWidth - $logoWidth - 10;
		$y = $imageHeight - $logoHeight - 10;

		$logo = imageCreateFromPng($logoFile);
		
		if(strpos($imageExtension, 'jpeg') !== false)
		{
			$image = imageCreateFromJpeg($imageFile);
		}
		else if(strpos($imageExtension, 'png') !== false)
		{
			$image = imageCreateFromPng($imageFile);
		}
		else if(strpos($imageExtension, 'gif') !== false)
		{
			$image = imageCreateFromGif($imageFile);
		}
		else if(strpos($imageExtension, 'webp') !== false)
		{
			$image = imageCreateFromWebp($imageFile);
		}
		
		imageCopyMerge($image, $logo, $x, $y, 0, 0, $logoWidth, $logoHeight, 10);
		
		if(strpos($imageExtension, 'jpeg') !== false)
		{
			header('Content-type: image/jpeg');
			imageJpeg($image);
		}
		else if(strpos($imageExtension, 'png') !== false)
		{
			header('Content-type: image/png');
			imagePng($image);
		}
		else if(strpos($imageExtension, 'gif') !== false)
		{
			header('Content-type: image/gif');
			imageGif($image);
		}
		else if(strpos($imageExtension, 'webp') !== false)
		{
			header('Content-type: image/webp');
			imageWebp($image);
		}
	}
}
?>
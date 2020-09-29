<?php
namespace Classes;

// This class is designed to check file upload error and file requirment.

trait FileCheck
{
	protected function checkUploadedFile($fieldName, $requiredFileType, $maxFileSize)
	{
		$uploadErrors = [
			1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
			2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
			3 => 'The uploaded file was only partially uploaded.',
			4 => 'No file was uploaded.',
			6 => 'Missing a temporary folder to keep file.',
			7 => 'Failed to write file to disk.',
			8 => 'A PHP extension stopped the file upload.'
		];
		$errorNo = $_FILES[$fieldName]['error'];
		$fileType = $_FILES[$fieldName]['type'];
		$fileSize = $_FILES['image']['size'] / 1048576;
		
		if($errorNo != 0)
		{
			return $uploadErrors[$errorNo];
		}
		
		if(strpos($fileType, $requiredFileType) === false)
		{
			return 'Upload '.$requiredFileType.' type file.';
		}
		
		if($fileSize > $maxFileSize)
		{
			return 'Uploaded file exceeds file size limit.';
		}
		
		return 1;
	}
}
?>
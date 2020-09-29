<?php
function __autoload($name)
{
	$cutStart = strrpos($name, '\\');
	
	if($cutStart === false)
	{
		$cutStart = 0;
	}
	else $cutStart++;
	
	$className = substr($name, $cutStart);
	
	require $_SERVER['DOCUMENT_ROOT'].'/classes/'.$className.'.php';
}
?>
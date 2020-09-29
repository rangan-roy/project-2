<?php
session_start();

require '../autoload.php';
use Classes\QueryExecute;

if(isset($_SESSION['adminId']))
{
	$query = "UPDATE admins SET remember = null WHERE id = $_SESSION[adminId]";
	$queryExecute = new QueryExecute;
	$queryExecute->executeQuery($query);
	setcookie('admin_remember', null, -1);
	session_unset();
	$_SESSION['message'] = 'You\'re logged out successfully.';
}
else $_SESSION['message'] = 'You\'re not logged in.';

header('Location: index.php');
?>
<?php
session_start();

require $_SERVER['DOCUMENT_ROOT'].'/autoload.php';
use Classes\QueryExecute;

if(isset($_SESSION['userId']))
{
	$query = "UPDATE users SET remember = null WHERE id = $_SESSION[userId]";
	$queryExecute = new QueryExecute;
	$queryExecute->executeQuery($query);
	setcookie('user_remember', null, -1);
	session_unset();
	$_SESSION['message'] = 'You\'re signed out successfully.';
}
else $_SESSION['message'] = 'You\'re not signed in.';

if(isset($_SERVER['HTTP_REFERER']))
{
    header('Location: '.$_SERVER['HTTP_REFERER']);
}
else header('Location: /');
?>
<?php
session_start();

require $_SERVER['DOCUMENT_ROOT'].'/autoload.php';
use Classes\Login;

$login = new Login();
$isUser = $login->userLoginCheck();
?>
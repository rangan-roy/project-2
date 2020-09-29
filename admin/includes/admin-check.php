<?php
session_start();

require '../autoload.php';
use Classes\Login;

$login = new Login();
$login->adminLoginCheck();
?>
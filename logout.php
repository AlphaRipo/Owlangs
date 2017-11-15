<?php 
session_start();

setcookie('login', '', time() - 3600);
setcookie('password', '', time() - 3600);

$_SESSION['login'] = '';
$_SESSION['password'] = '';

session_destroy();
header('Location: /index');
?>
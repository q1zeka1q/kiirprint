<?php 
session_start(); 
session_destroy(); 
// Выходим из папки admin на главную страницу сайта
header("Location: login.php"); 
exit;
?>
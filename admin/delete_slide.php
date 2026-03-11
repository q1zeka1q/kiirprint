<?php
session_start();
if (!isset($_SESSION['logged_in'])) { exit; }
require_once '../includes/config.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    // Можно добавить код для удаления самого файла картинки из папки img/ если хочешь
    $conn->query("DELETE FROM slider WHERE id=$id");
}
header("Location: admin.php?page=avaleht");
?>
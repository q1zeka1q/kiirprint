<?php
session_start();
// Проверка авторизации
if (!isset($_SESSION['logged_in'])) { exit; }

require_once '../includes/config.php'; 

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    $stmt = $pdo->prepare("SELECT image_url FROM slider WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $slide = $stmt->fetch();
    
    if ($slide && !empty($slide['image_url'])) {
        $file_path = "../img/" . $slide['image_url'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }
    $stmt = $pdo->prepare("DELETE FROM slider WHERE id = :id");
    $stmt->execute(['id' => $id]);
}

header("Location: admin.php?page=avaleht");
exit;
?>
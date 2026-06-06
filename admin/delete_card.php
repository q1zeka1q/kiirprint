<?php
session_start();
// Проверка авторизации
if (!isset($_SESSION['logged_in'])) { exit; }

require_once '../includes/config.php'; // Убедись, что тут $pdo

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // БЕЗОПАСНОЕ УДАЛЕНИЕ ЧЕРЕЗ PDO
    $stmt = $pdo->prepare("DELETE FROM home_cards WHERE id = :id");
    $stmt->execute(['id' => $id]);
}

header("Location: admin.php?page=avaleht");
exit;
?>
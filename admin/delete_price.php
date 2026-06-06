<?php
session_start();
// Проверка авторизации
if (!isset($_SESSION['logged_in'])) { exit; }

require_once '../includes/config.php'; 

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // БЕЗОПАСНОЕ УДАЛЕНИЕ ЦЕНЫ ЧЕРЕЗ PDO
    $stmt = $pdo->prepare("DELETE FROM prices WHERE id = :id");
    $stmt->execute(['id' => $id]);
}

header("Location: admin.php?page=prices");
exit;
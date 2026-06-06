<?php
session_start();
// Проверка авторизации
if (!isset($_SESSION['logged_in'])) { exit; }

require_once '../includes/config.php'; // Убедись, что тут $pdo

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($id > 0) {
    if ($action === 'mark_read') {
        // БЕЗОПАСНОЕ ОБНОВЛЕНИЕ ЧЕРЕЗ PDO
        $stmt = $pdo->prepare("UPDATE paringud SET is_read = 1 WHERE id = :id");
        $stmt->execute(['id' => $id]);
    } elseif ($action === 'delete') {
        // БЕЗОПАСНОЕ УДАЛЕНИЕ ЧЕРЕЗ PDO
        $stmt = $pdo->prepare("DELETE FROM paringud WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}

// Возвращаемся обратно на страницу запросов
header("Location: admin.php?page=queries");
exit;
<?php
session_start();
if (!isset($_SESSION['logged_in'])) { exit; }
require_once '../includes/config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($id > 0) {
    if ($action == 'mark_read') {
        $conn->query("UPDATE paringud SET is_read = 1 WHERE id = $id");
    } elseif ($action == 'delete') {
        $conn->query("DELETE FROM paringud WHERE id = $id");
    }
}

// Возвращаемся обратно на страницу запросов
header("Location: admin.php?page=queries");
exit;
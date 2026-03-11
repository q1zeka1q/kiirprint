<?php
session_start();
require_once '../includes/config.php';
if (!isset($_SESSION['logged_in'])) { exit; }
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $conn->query("DELETE FROM orders WHERE id = $id");
}
header("Location: admin.php?page=orders");
exit;
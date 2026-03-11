<?php
session_start();
if (!isset($_SESSION['logged_in'])) { exit; }
require_once '../includes/config.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $conn->query("DELETE FROM services WHERE id=$id");
}
header("Location: admin.php?page=services");
?>
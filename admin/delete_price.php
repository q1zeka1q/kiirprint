<?php
session_start();
require_once '../includes/config.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $conn->query("DELETE FROM prices WHERE id=$id");
}
header("Location: admin.php?page=prices");
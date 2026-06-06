<?php
session_start();
// Проверка авторизации
if (!isset($_SESSION['logged_in'])) { exit; }
require_once '../includes/config.php'; // Убедись, что тут $pdo

// --- БЕЗОПАСНОЕ СОХРАНЕНИЕ ДАННЫХ (PDO) ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_order'])) {
    $update_id = (int)$_POST['order_id'];
    $c_name    = strip_tags($_POST['client_name']);
    $c_email   = filter_var($_POST['client_email'], FILTER_SANITIZE_EMAIL);
    $c_phone   = strip_tags($_POST['client_phone']);
    $c_message = strip_tags($_POST['client_message']);
    $c_qty     = (int)$_POST['quantity'];
    $c_price   = (float)$_POST['total_price'];

    $sql = "UPDATE orders SET 
            client_name = :name, 
            client_email = :email, 
            client_phone = :phone, 
            client_message = :msg,
            quantity = :qty,
            total_price = :price
            WHERE id = :id";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'name'  => $c_name,
        'email' => $c_email,
        'phone' => $c_phone,
        'msg'   => $c_message,
        'qty'   => $c_qty,
        'price' => $c_price,
        'id'    => $update_id
    ]);
    
    header("Location: view_order.php?id=$update_id&success=1");
    exit;
}

// --- БЕЗОПАСНАЯ ВЫБОРКА (PDO) ---
$id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT o.*, s.title as service_name FROM orders o LEFT JOIN services s ON o.service_id = s.id WHERE o.id = :id");
$stmt->execute(['id' => $id]);
$o = $stmt->fetch();

if (!$o) die("Tellimust ei leitud!");

$is_ready = ($o['status'] == 'valmis');
?>
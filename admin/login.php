<?php
session_start();
require_once '../includes/config.php';

$admin_user = 'admin';
$admin_pass_hash = '$2y$10$YourGeneratedHashHere'; 

if (isset($_POST['login'])) {
    $user = trim($_POST['user']);
    $pass = $_POST['pass'];

    if ($user === $admin_user && password_verify($pass, $admin_pass_hash)) {
        session_regenerate_id(true); // Защита от фиксации сессии
        $_SESSION['logged_in'] = true;
        header("Location: admin.php");
        exit;
    } else {
        sleep(1); // Задержка для защиты от брутфорса
        $error = "Vale kasutajatunnus või parool!";
    }
}
?>
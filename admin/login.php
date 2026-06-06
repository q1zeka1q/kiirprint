<?php
session_start();
require_once '../includes/config.php';

// Вставь сюда хеш, который ты получишь после выполнения шагов выше
$admin_user = 'admin';
$admin_pass_hash = ''; 

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $user = trim($_POST['user'] ?? '');
    $pass = $_POST['pass'] ?? '';

    // Проверка логина и хеша пароля
    if ($user === $admin_user && password_verify($pass, $admin_pass_hash)) {
        session_regenerate_id(true); // Защита от подмены сессии
        $_SESSION['logged_in'] = true;
        header("Location: admin.php");
        exit;
    } else {
        // Задержка против перебора паролей (brute-force)
        sleep(1); 
        $error = "Vale kasutajatunnus või parool!";
    }
}
?>
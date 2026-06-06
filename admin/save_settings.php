<?php
session_start();
// Проверка авторизации
if (!isset($_SESSION['logged_in'])) { exit; }

require_once '../includes/config.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_settings'])) {
    
    $sql = "INSERT INTO settings (config_key, config_value) 
            VALUES (:key, :val) 
            ON DUPLICATE KEY UPDATE config_value = :val";
    $stmt = $pdo->prepare($sql);

    foreach ($_POST as $key => $value) {
        if ($key === 'save_settings') continue;

        $stmt->execute([
            'key' => $key,
            'val' => $value // PDO сам позаботится о безопасности, эскейпинг не нужен
        ]);
    }
}

// Возвращаемся обратно в админку
header("Location: admin.php?page=avaleht&success=1");
exit;
<?php
// Проверь этот путь! Если файл в папке admin, то до includes нужно выйти на уровень вверх (../)
require_once '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_settings'])) {
    foreach ($_POST as $key => $value) {
        if ($key == 'save_settings') continue;

        $safe_key = mysqli_real_escape_string($conn, $key);
        $safe_value = mysqli_real_escape_string($conn, $value);
        
        // Этот запрос обновит существующие или создаст новые записи
        $conn->query("INSERT INTO settings (config_key, config_value) 
                      VALUES ('$safe_key', '$safe_value') 
                      ON DUPLICATE KEY UPDATE config_value = '$safe_value'");
    }
}

// Возвращаемся обратно в админку
header("Location: admin.php?page=avaleht&success=1");
exit;
<?php
// Запускаем сессию, если она еще не запущена
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$default_lang = 'et';
$allowed_langs = ['et', 'ru', 'en', 'fi'];

if (isset($_GET['lang']) && in_array($_GET['lang'], $allowed_langs)) {
    $_SESSION['lang'] = $_GET['lang'];
}

$current_lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : $default_lang;

require_once __DIR__ . '/../lang/' . $current_lang . '.php';

$host = 'localhost';
$db   = 'kiirprint_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4'; // Установили кодировку

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       
    PDO::ATTR_EMULATE_PREPARES   => false,                 
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Andmebaasi ühendus ebaõnnestus: " . $e->getMessage());
}
function get_setting($key) {
    global $pdo; 
    
    $stmt = $pdo->prepare("SELECT config_value FROM settings WHERE config_key = :key");
    
    $stmt->execute(['key' => $key]);
    
    $row = $stmt->fetch();
    
    if ($row) {
        return $row['config_value'];
    }
    return ""; 
}
?>
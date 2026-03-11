<?php
// Запускаем сессию, если она еще не запущена
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Устанавливаем язык по умолчанию
$default_lang = 'et';
$allowed_langs = ['et', 'ru', 'en', 'fi'];

// Если пользователь нажал на переключатель языка (?lang=ru)
if (isset($_GET['lang']) && in_array($_GET['lang'], $allowed_langs)) {
    $_SESSION['lang'] = $_GET['lang'];
}

// Текущий язык сайта
$current_lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : $default_lang;

// Подключаем нужный словарь
// Убедись, что путь к папке lang правильный. 
// Если config.php лежит в папке includes, то выходим на уровень выше (../)
require_once __DIR__ . '/../lang/' . $current_lang . '.php';

// Andmebaasi seaded
$host = 'localhost';
$db   = 'kiirprint_db';
$user = 'root';
$pass = '';

// Ühenduse loomine
$conn = new mysqli($host, $user, $pass, $db);

// Kontrollime ühendust
if ($conn->connect_error) {
    die("Ühendus ebaõnnestus: " . $conn->connect_error);
}

// Määrame kooditabeli
$conn->set_charset("utf8");

function get_setting($key) {
    global $conn;
    $result = $conn->query("SELECT config_value FROM settings WHERE config_key = '$key'");
    if ($result && $row = $result->fetch_assoc()) {
        return $row['config_value'];
    }
    return ""; 
}


?>
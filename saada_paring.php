<?php
// Подключаем базу данных
require_once 'includes/config.php'; // Убедись, что тут $pdo

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Используем strip_tags для удаления HTML-тегов, чтобы предотвратить XSS
    $pealkiri = strip_tags($_POST['pealkiri']);
    $email    = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $tekst    = strip_tags($_POST['tekst']);

    // Запрос к базе через PDO (Prepared Statements)
    $sql = "INSERT INTO paringud (pealkiri, email, tekst, kuupaev) 
            VALUES (:pealkiri, :email, :tekst, NOW())";

    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([
        'pealkiri' => $pealkiri,
        'email'    => $email,
        'tekst'    => $tekst
    ])) {
        // Если всё ок, возвращаемся на главную
        header("Location: index.php?success=1");
        exit;
    } else {
        die("Viga andmete salvestamisel.");
    }
}
?>
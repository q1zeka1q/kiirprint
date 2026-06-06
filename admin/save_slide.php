<?php
session_start();
// Проверка авторизации
if (!isset($_SESSION['logged_in'])) { exit; }

require_once '../includes/config.php'; // Используем $pdo

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Безопасная очистка ссылки
    $link = strip_tags($_POST['link']);
    
    // Определяем язык из сессии
    $lang = $_SESSION['edit_lang'] ?? 'et';
    
    $image_name = "";
    
    // Безопасная обработка файла
    if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower(pathinfo($_FILES['image_url']['name'], PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            $image_name = uniqid() . '_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['image_url']['tmp_name'], "../img/" . $image_name)) {
                
                // Вставка данных через PDO
                $stmt = $pdo->prepare("INSERT INTO slider (image_url, link, lang) VALUES (:img, :link, :lang)");
                $stmt->execute([
                    'img'  => $image_name,
                    'link' => $link,
                    'lang' => $lang
                ]);
            }
        }
    }
    
    header("Location: admin.php?page=avaleht");
    exit;
}
?>
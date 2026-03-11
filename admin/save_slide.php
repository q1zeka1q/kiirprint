<?php
session_start();
require_once '../includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $link = mysqli_real_escape_string($conn, $_POST['link']);
    
    // Смотрим, какой язык сейчас включен в админке
    $lang = isset($_SESSION['edit_lang']) ? $_SESSION['edit_lang'] : 'et';
    
    $image_url = "";
    if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] == 0) {
        $image_name = time() . "_" . basename($_FILES['image_url']['name']);
        if (move_uploaded_file($_FILES['image_url']['tmp_name'], "../img/" . $image_name)) {
            $image_url = $image_name;
        }
    }

    if ($image_url) {
        // Создаем слайд с привязкой к конкретному языку!
        $sql = "INSERT INTO slider (image_url, link, lang) VALUES ('$image_url', '$link', '$lang')";
        mysqli_query($conn, $sql);
    }
    header("Location: admin.php?page=avaleht");
    exit;
}
?>
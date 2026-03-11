<?php
session_start();
require_once '../includes/config.php';

// Проверяем, какой язык сейчас выбран в админке
$edit_lang = isset($_SESSION['edit_lang']) ? $_SESSION['edit_lang'] : 'et';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из формы
    $title_input = mysqli_real_escape_string($conn, $_POST['title']);
    $description_input = mysqli_real_escape_string($conn, $_POST['description']);
    $link_url = mysqli_real_escape_string($conn, $_POST['link_url']);
    $price = !empty($_POST['price']) ? (float)$_POST['price'] : 0;
    
    // Определяем, в какие колонки сохранять текст
    $col_title = ($edit_lang == 'et') ? 'title' : 'title_' . $edit_lang;
    $col_desc = ($edit_lang == 'et') ? 'description' : 'description_' . $edit_lang;

    // Обработка картинки (она ОДНА для всех языков)
    $image_url = "";
    if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] == 0) {
        $image_name = time() . "_" . basename($_FILES['image_url']['name']);
        if (move_uploaded_file($_FILES['image_url']['tmp_name'], "../img/" . $image_name)) {
            $image_url = $image_name;
        }
    }

    // Если мы создаем товар НЕ на эстонском, базовые поля title и description не могут быть NULL, 
    // поэтому запишем туда тот же текст для страховки.
    $base_title = ($edit_lang == 'et') ? $title_input : $title_input; 
    $base_desc = ($edit_lang == 'et') ? $description_input : $description_input;

    if ($edit_lang == 'et') {
        $sql = "INSERT INTO services (title, description, image_url, link_url, price) 
                VALUES ('$title_input', '$description_input', '$image_url', '$link_url', '$price')";
    } else {
        $sql = "INSERT INTO services (title, description, $col_title, $col_desc, image_url, link_url, price) 
                VALUES ('$base_title', '$base_desc', '$title_input', '$description_input', '$image_url', '$link_url', '$price')";
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: admin.php?page=services");
        exit; 
    } else {
        echo "Viga: " . mysqli_error($conn);
    }
}
?>
<?php
session_start();
require_once '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $link_url = mysqli_real_escape_string($conn, $_POST['link_url']);
    $calc_type = mysqli_real_escape_string($conn, $_POST['calc_type']);

    // Прямо здесь выведем ошибку, если вдруг подключение пропало
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    // --- МУЛЬТИЯЗЫЧНАЯ ЛОГИКА ---
    // Проверяем, на каком языке мы сейчас редактируем
    $edit_lang = isset($_SESSION['edit_lang']) ? $_SESSION['edit_lang'] : 'et';

    // Определяем нужные колонки
    $col_title = ($edit_lang == 'et') ? 'title' : 'title_' . $edit_lang;
    $col_desc = ($edit_lang == 'et') ? 'description' : 'description_' . $edit_lang;
    // ----------------------------

    // Обновляем базу. link_url и calc_type общие, а вот title и description - языковые!
    $sql = "UPDATE services SET 
            $col_title = '$title', 
            $col_desc = '$description', 
            link_url = '$link_url', 
            calc_type = '$calc_type' 
            WHERE id = $id";

    if ($conn->query($sql)) {
        // Если была картинка, загружаем её (Картинка ОБЩАЯ для всех языков у услуг)
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $filename = time() . "_" . $_FILES['image']['name'];
            if (move_uploaded_file($_FILES['image']['tmp_name'], "../img/" . $filename)) {
                $conn->query("UPDATE services SET image_url = '$filename' WHERE id = $id");
            }
        }
        
        // Успешный редирект
        header("Location: admin.php?page=services&success=1");
        exit;
    } else {
        // ЕСЛИ НЕ СОХРАНИЛОСЬ — МЫ УВИДИМ ПОЧЕМУ
        die("DATABASE ERROR: " . $conn->error . "<br>SQL: " . $sql);
    }
}
?>
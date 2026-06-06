<?php
session_start();
if (!isset($_SESSION['logged_in'])) { exit; }

require_once '../includes/config.php'; 
require_once '../includes/htmlpurifier/library/HTMLPurifier.auto.php';

$config = HTMLPurifier_Config::createDefault();
$purifier = new HTMLPurifier($config);

$edit_lang = $_SESSION['edit_lang'] ?? 'et';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Безопасная очистка данных
    $title_input = strip_tags($_POST['title']);
    $description_input = $purifier->purify($_POST['description']); 
    $link_url = strip_tags($_POST['link_url']);
    $price = !empty($_POST['price']) ? (float)$_POST['price'] : 0;
    
    $col_title = ($edit_lang == 'et') ? 'title' : 'title_' . $edit_lang;
    $col_desc = ($edit_lang == 'et') ? 'description' : 'description_' . $edit_lang;

    $image_name = "";
    if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower(pathinfo($_FILES['image_url']['name'], PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            $image_name = uniqid() . '.' . $ext;
            move_uploaded_file($_FILES['image_url']['tmp_name'], "../img/" . $image_name);
        }
    }
    if ($edit_lang == 'et') {
        $sql = "INSERT INTO services (title, description, image_url, link_url, price) 
                VALUES (:title, :desc, :img, :link, :price)";
        $params = [
            'title' => $title_input,
            'desc'  => $description_input,
            'img'   => $image_name,
            'link'  => $link_url,
            'price' => $price
        ];
    } else {
        $sql = "INSERT INTO services (title, description, $col_title, $col_desc, image_url, link_url, price) 
                VALUES (:title, :desc, :title_lang, :desc_lang, :img, :link, :price)";
        $params = [
            'title'      => $title_input,
            'desc'       => $description_input,
            'title_lang' => $title_input,
            'desc_lang'  => $description_input,
            'img'        => $image_name,
            'link'       => $link_url,
            'price'      => $price
        ];
    }

    $stmt = $pdo->prepare($sql);
    if ($stmt->execute($params)) {
        header("Location: admin.php?page=services");
        exit;
    } else {
        die("Viga andmete salvestamisel.");
    }
}
?>
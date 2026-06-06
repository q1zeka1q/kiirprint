<?php
session_start();
if (!isset($_SESSION['logged_in'])) { exit; }

require_once '../includes/config.php'; // Используем $pdo
require_once '../includes/htmlpurifier/library/HTMLPurifier.auto.php';

$config = HTMLPurifier_Config::createDefault();
$purifier = new HTMLPurifier($config);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = (int)$_POST['id'];
    $title = strip_tags($_POST['title']);
    $description = $purifier->purify($_POST['description']); // Защита от XSS
    $link_url = strip_tags($_POST['link_url']);
    $calc_type = strip_tags($_POST['calc_type']);
    
    $edit_lang = $_SESSION['edit_lang'] ?? 'et';
    $col_title = ($edit_lang == 'et') ? 'title' : 'title_' . $edit_lang;
    $col_desc = ($edit_lang == 'et') ? 'description' : 'description_' . $edit_lang;

    // Безопасное обновление данных через PDO
    $sql = "UPDATE services SET 
            $col_title = :title, 
            $col_desc = :desc, 
            link_url = :link, 
            calc_type = :calc 
            WHERE id = :id";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'title' => $title,
        'desc'  => $description,
        'link'  => $link_url,
        'calc'  => $calc_type,
        'id'    => $id
    ]);

    // Обработка картинки
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            $filename = uniqid() . '.' . $ext;
            if (move_uploaded_file($_FILES['image']['tmp_name'], "../img/" . $filename)) {
                $stmt_img = $pdo->prepare("UPDATE services SET image_url = :img WHERE id = :id");
                $stmt_img->execute(['img' => $filename, 'id' => $id]);
            }
        }
    }
    
    header("Location: admin.php?page=services&success=1");
    exit;
}
?>
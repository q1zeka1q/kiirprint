<?php
session_start();
// Проверка авторизации
if (!isset($_SESSION['logged_in'])) { header("Location: login.php"); exit; }

require_once '../includes/config.php'; // Убедись, что тут $pdo

if (!isset($_GET['id'])) { header("Location: admin.php?page=avaleht"); exit; }

$id = (int)$_GET['id'];

// Получаем текущие данные слайда (PDO)
$stmt = $pdo->prepare("SELECT * FROM slider WHERE id = :id");
$stmt->execute(['id' => $id]);
$slide = $stmt->fetch();

if (!$slide) die("Slaidi ei leitud!");

if (isset($_POST['update'])) {
    $link = strip_tags($_POST['link']);
    $new_image = $slide['image_url'];

    // Если загружен новый файл
    if (!empty($_FILES['image']['name'])) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            $new_filename = uniqid() . '.' . $ext;
            $target = "../img/" . $new_filename;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                // Удаляем старый файл, если он существует
                if (file_exists("../img/" . $slide['image_url'])) {
                    unlink("../img/" . $slide['image_url']);
                }
                $new_image = $new_filename;
            }
        }
    }

    // Обновление записи (PDO)
    $stmt = $pdo->prepare("UPDATE slider SET image_url = :img, link = :link WHERE id = :id");
    $stmt->execute(['img' => $new_image, 'link' => $link, 'id' => $id]);

    header("Location: admin.php?page=avaleht");
    exit;
}
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Muuda slaidi - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --main-orange: #f36f21; --main-orange-hover: #d95e16; --text-dark: #2d3748; --border-color: #cbd5e0; --bg-color: #f8fafc; }
        body { font-family: 'Segoe UI', sans-serif; background: var(--bg-color); display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; padding: 20px; }
        .card { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 100%; max-width: 450px; }
        .card-header { text-align: center; margin-bottom: 30px; }
        .card-header i { font-size: 40px; color: var(--main-orange); margin-bottom: 15px; }
        .card-header h2 { color: var(--text-dark); margin: 0; font-size: 24px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px; }
        .img-preview { max-width: 100%; max-height: 200px; border-radius: 6px; margin-bottom: 15px; }
        input[type="text"], input[type="file"] { width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 6px; box-sizing: border-box; }
        .btn-save { background: var(--main-orange); color: white; border: none; padding: 14px; border-radius: 6px; width: 100%; font-weight: 600; cursor: pointer; }
        .btn-save:hover { background: var(--main-orange-hover); }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            <i class="fas fa-images"></i>
            <h2>Muuda slaidi</h2>
        </div>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Praegune pilt</label>
                <img src="../img/<?= htmlspecialchars($slide['image_url']) ?>" class="img-preview">
                <input type="file" name="image" accept="image/*">
            </div>
            <div class="form-group">
                <label>Slaidi link</label>
                <input type="text" name="link" value="<?= htmlspecialchars($slide['link']) ?>">
            </div>
            <button type="submit" name="update" class="btn-save">Salvesta muudatused</button>
            <a href="admin.php?page=avaleht" style="display:block; text-align:center; margin-top:15px; color:#666;">Tagasi</a>
        </form>
    </div>
</body>
</html>
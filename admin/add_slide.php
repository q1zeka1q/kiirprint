<?php
session_start();
// Проверка авторизации
if (!isset($_SESSION['logged_in'])) { header("Location: login.php"); exit; }

require_once '../includes/config.php';

if (isset($_POST['submit'])) {
    $link = strip_tags($_POST['link']);
    $image = $_FILES['image']['name'];
    
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp'];
    $file_extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));
    
    if (in_array($file_extension, $allowed_extensions)) {
        $new_filename = uniqid() . '.' . $file_extension;
        $target = "../img/" . $new_filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            // Безопасный INSERT через PDO
            $stmt = $pdo->prepare("INSERT INTO slider (image_url, link, lang) VALUES (:img, :link, 'et')");
            $stmt->execute(['img' => $new_filename, 'link' => $link]);
            
            header("Location: admin.php?page=avaleht");
            exit;
        }
    } else {
        $error = "Viga: Ainult JPG, JPEG, PNG ja WEBP failid on lubatud!";
    }
}
?>

<div style="padding: 40px; max-width: 600px; font-family: Arial;">
    <h2>Lisa uus slaid</h2>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST" enctype="multipart/form-data" style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        <label>1. Vali pilt:</label><br>
        <input type="file" name="image" required style="margin: 10px 0 20px 0;"><br>
        
        <label>2. Link (kuhu slaid viib):</label><br>
        <input type="text" name="link" placeholder="näiteks: visiitkaardid.php" style="width:100%; padding:10px; margin: 10px 0 20px 0; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;"><br>
        
        <button type="submit" name="submit" style="background:#f36f21; color:white; padding:12px 25px; border:none; cursor:pointer; border-radius: 4px; font-weight: bold;">Salvesta slaid</button>
        <a href="admin.php?page=avaleht" style="margin-left: 15px; color: #666; text-decoration: none;">Tagasi</a>
    </form>
</div>
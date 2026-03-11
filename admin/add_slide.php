<?php
session_start();
require_once 'includes/config.php';
include 'includes/header.php';

if (isset($_POST['submit'])) {
    $link = $_POST['link'];
    $image = $_FILES['image']['name'];
    $target = "img/" . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        // Сохраняем картинку и ссылку
        $conn->query("INSERT INTO slider (image_url, link) VALUES ('$image', '$link')");
        echo "<script>window.location.href='admin.php?page=slider';</script>";
    }
}
?>

<div style="padding: 40px; max-width: 600px; font-family: Arial;">
    <h2>Lisa uus slaid</h2>
    <form method="POST" enctype="multipart/form-data" style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        <label>1. Vali pilt:</label><br>
        <input type="file" name="image" required style="margin: 10px 0 20px 0;"><br>
        
        <label>2. Link (kuhu slaid viib):</label><br>
        <input type="text" name="link" placeholder="näiteks: visiitkaardid.php" style="width:100%; padding:10px; margin: 10px 0 20px 0; border: 1px solid #ddd; border-radius: 4px;"><br>
        
        <button type="submit" name="submit" style="background:#28a745; color:white; padding:12px 25px; border:none; cursor:pointer; border-radius: 4px; font-weight: bold;">Salvesta slaid</button>
        <a href="admin.php?page=slider" style="margin-left: 15px; color: #666; text-decoration: none;">Tagasi</a>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
<?php
session_start();
if (!isset($_SESSION['logged_in'])) { header("Location: login.php"); exit; }
require_once '../includes/config.php'; // Убедись, что тут $pdo

if (isset($_POST['add_price'])) {
    $kogus = (int)$_POST['kogus'];
    $hind_4_0 = (float)str_replace(',', '.', $_POST['hind_4_0']); 
    $hind_4_4 = (float)str_replace(',', '.', $_POST['hind_4_4']);

    $sql = "INSERT INTO visiitkaardid_hinnad (kogus_alates, hind_4_0, hind_4_4) 
            VALUES (:kogus, :h40, :h44)";
    
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute(['kogus' => $kogus, 'h40' => $hind_4_0, 'h44' => $hind_4_4])) {
        header("Location: admin.php?page=prices");
        exit;
    } else {
        $error = "Viga andmete salvestamisel.";
    }
}
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Lisa uus hind</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .card { background: white; padding: 35px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        h2 { margin-top: 0; color: #333; border-bottom: 2px solid #f36f21; padding-bottom: 10px; font-size: 22px; }
        label { display: block; margin-top: 15px; color: #666; font-size: 14px; font-weight: bold; }
        input { width: 100%; padding: 12px; margin-top: 5px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; font-size: 16px; }
        .btn-add { background: #f36f21; color: white; border: none; padding: 14px; border-radius: 6px; cursor: pointer; font-weight: bold; width: 100%; margin-top: 25px; transition: 0.3s; font-size: 16px; }
        .btn-add:hover { background: #d95d16; }
        .back-link { display: block; text-align: center; margin-top: 20px; color: #888; text-decoration: none; font-size: 14px; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Lisa uus visiitkaardi hind</h2>
        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="POST">
            <label>Kogus alates:</label>
            <input type="number" name="kogus" placeholder="500" required>
            <label>Hind 4+0:</label>
            <input type="text" name="hind_4_0" placeholder="0.000" required>
            <label>Hind 4+4:</label>
            <input type="text" name="hind_4_4" placeholder="0.000" required>
            <button type="submit" name="add_price" class="btn-add">Lisa hind</button>
            <a href="admin.php?page=prices" class="back-link">← Tagasi</a>
        </form>
    </div>
</body>
</html>
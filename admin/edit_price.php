<?php
session_start();
// 1. ЗАЩИТА
if (!isset($_SESSION['logged_in'])) { 
    header("Location: login.php"); 
    exit; 
}

// 2. ПОДКЛЮЧЕНИЕ
require_once '../includes/config.php'; // Убедись, что тут $pdo

// Получаем ID
if (!isset($_GET['id'])) {
    header("Location: admin.php?page=prices");
    exit;
}

$id = (int)$_GET['id'];

// ИСПРАВЛЕНИЕ: Используем PDO для получения данных
$stmt = $pdo->prepare("SELECT * FROM prices WHERE id = :id");
$stmt->execute(['id' => $id]);
$price = $stmt->fetch();

if (!$price) {
    die("Hinda ei leitud!");
}

// 3. ОБРАБОТКА СОХРАНЕНИЯ (БЕЗОПАСНО ЧЕРЕЗ PDO)
if (isset($_POST['update_price'])) {
    $kogus = (int)$_POST['kogus'];
    $hind_4_0 = (float)str_replace(',', '.', $_POST['hind_4_0']);
    $hind_4_4 = (float)str_replace(',', '.', $_POST['hind_4_4']);

    $sql = "UPDATE prices SET 
            kogus_alates = :kogus, 
            hind_4_0 = :h40, 
            hind_4_4 = :h44 
            WHERE id = :id";
    
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([
        'kogus' => $kogus, 
        'h40' => $hind_4_0, 
        'h44' => $hind_4_4, 
        'id' => $id
    ])) {
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
    <title>Muuda hinda</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --main-orange: #f36f21;
            --main-orange-hover: #d95d16;
            --text-dark: #2d3748;
            --border-color: #e2e8f0;
            --bg-color: #f8fafc;
        }
        body { font-family: 'Segoe UI', system-ui, sans-serif; background: var(--bg-color); display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; padding: 20px; }
        .container { width: 100%; max-width: 450px; }
        .edit-card { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); border: 1px solid var(--border-color); }
        .card-header { margin-bottom: 25px; padding-bottom: 15px; border-bottom: 2px solid #edf2f7; display: flex; align-items: center; gap: 15px; }
        .card-header h2 { margin: 0; font-size: 22px; color: var(--text-dark); }
        .card-header i { color: var(--main-orange); font-size: 24px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; font-size: 12px; font-weight: 700; color: #4a5568; margin-bottom: 8px; text-transform: uppercase; }
        input { width: 100%; padding: 14px 15px; border: 1px solid #cbd5e0; border-radius: 6px; box-sizing: border-box; font-size: 15px; font-weight: 600; }
        .actions { display: flex; flex-direction: column; gap: 12px; margin-top: 30px; padding-top: 25px; border-top: 1px solid var(--border-color); }
        .btn { padding: 14px 24px; border-radius: 6px; border: none; cursor: pointer; font-weight: 700; text-transform: uppercase; text-align: center; text-decoration: none; display: block; }
        .btn-orange { background: var(--main-orange); color: white; }
        .btn-orange:hover { background: var(--main-orange-hover); }
        .btn-gray { background: #e2e8f0; color: #4a5568; }
    </style>
</head>
<body>
    <div class="container">
        <div class="edit-card">
            <div class="card-header">
                <i class="fas fa-tags"></i>
                <h2>Muuda hinda</h2>
            </div>
            
            <?php if(isset($error)): ?>
                <p style="color:red;"><?= $error ?></p>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label>Kogus alates</label>
                    <input type="number" name="kogus" value="<?= htmlspecialchars($price['kogus_alates']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Hind 4+0 (Ühepoolne, €/tk)</label>
                    <input type="text" name="hind_4_0" value="<?= htmlspecialchars($price['hind_4_0']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Hind 4+4 (Kahepoolne, €/tk)</label>
                    <input type="text" name="hind_4_4" value="<?= htmlspecialchars($price['hind_4_4'] ?? '0.000') ?>" required>
                </div>
                <div class="actions">
                    <button type="submit" name="update_price" class="btn btn-orange">Salvesta muudatused</button>
                    <a href="admin.php?page=prices" class="btn btn-gray">Tühista</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
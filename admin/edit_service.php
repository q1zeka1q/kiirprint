<?php
session_start();
if (!isset($_SESSION['logged_in'])) { header("Location: login.php"); exit; }
require_once '../includes/config.php'; // Убедись, что тут $pdo

if (!isset($_GET['id'])) {
    header("Location: admin.php?page=services");
    exit;
}

$id = (int)$_GET['id'];

// БЕЗОПАСНАЯ ВЫБОРКА ЧЕРЕЗ PDO
$stmt = $pdo->prepare("SELECT * FROM services WHERE id = :id");
$stmt->execute(['id' => $id]);
$s = $stmt->fetch();

if (!$s) die("Teenust ei leitud!");

$edit_lang = $_SESSION['edit_lang'] ?? 'et';
$col_title = ($edit_lang == 'et') ? 'title' : 'title_' . $edit_lang;
$col_desc = ($edit_lang == 'et') ? 'description' : 'description_' . $edit_lang;

$current_title = $s[$col_title] ?? '';
$current_desc = $s[$col_desc] ?? '';
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Muuda teenust | <?= htmlspecialchars($s['title']) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
    <style>
        :root { --main-orange: #f36f21; --main-orange-hover: #d95d16; --text-dark: #2d3748; --border-color: #e2e8f0; --bg-color: #f8fafc; }
        body { font-family: 'Segoe UI', sans-serif; padding: 40px 20px; background: var(--bg-color); color: var(--text-dark); margin: 0; display: flex; justify-content: center; }
        .container { width: 100%; max-width: 800px; }
        .edit-card { background: white; padding: 35px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); border: 1px solid var(--border-color); }
        .card-header { margin-bottom: 25px; padding-bottom: 15px; border-bottom: 2px solid #edf2f7; display: flex; align-items: center; justify-content: space-between;}
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-group { display: flex; flex-direction: column; }
        label { font-size: 13px; font-weight: 700; color: #4a5568; margin-bottom: 8px; text-transform: uppercase; }
        input[type="text"], select { width: 100%; padding: 12px; border: 1px solid #cbd5e0; border-radius: 6px; box-sizing: border-box; }
        .btn { padding: 12px 24px; border-radius: 6px; border: none; cursor: pointer; font-weight: 700; text-transform: uppercase; }
        .btn-orange { background: var(--main-orange); color: white; }
    </style>
</head>
<body>
<div class="container">
    <div class="edit-card">
        <div class="card-header">
            <h2>Muuda teenust: <?= htmlspecialchars($s['title']) ?></h2>
            <div style="background:#fff5f0; padding:5px 12px; border-radius:20px; color:var(--main-orange); font-weight:bold;">
                Režiim: <?= strtoupper($edit_lang) ?>
            </div>
        </div>

        <form action="update_service_full.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $s['id'] ?>">
            <div class="form-grid">
                <div class="form-group">
                    <label>Nimetus (<?= strtoupper($edit_lang) ?>)</label>
                    <input type="text" name="title" value="<?= htmlspecialchars($current_title) ?>" required>
                </div>
                <div class="form-group">
                    <label>Faili nimi</label>
                    <input type="text" name="link_url" value="<?= htmlspecialchars($s['link_url']) ?>">
                </div>
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Pikk kirjeldus</label>
                    <textarea name="description" id="editor"><?= htmlspecialchars($current_desc) ?></textarea>
                </div>
            </div>
            <div style="margin-top:20px;">
                <button type="submit" class="btn btn-orange">SALVESTA</button>
            </div>
        </form>
    </div>
</div>
<script>
    ClassicEditor.create(document.querySelector('#editor')).catch(console.error);
</script>
</body>
</html>
<?php
session_start();
require_once '../includes/config.php';

// Проверка авторизации
if (!isset($_SESSION['logged_in'])) { header("Location: login.php"); exit; }

$id = intval($_GET['id']);
$res = $conn->query("SELECT * FROM services WHERE id = $id");
$s = $res->fetch_assoc();

if (!$s) die("Teenust ei leitud!");

// Получаем текущий язык редактирования
$edit_lang = isset($_SESSION['edit_lang']) ? $_SESSION['edit_lang'] : 'et';

// Определяем, из каких колонок брать данные для формы
$col_title = ($edit_lang == 'et') ? 'title' : 'title_' . $edit_lang;
$col_desc = ($edit_lang == 'et') ? 'description' : 'description_' . $edit_lang;

// Если перевода еще нет, показываем пустое поле (или эстонский текст для ориентира)
$current_title = isset($s[$col_title]) ? $s[$col_title] : '';
$current_desc = isset($s[$col_desc]) ? $s[$col_desc] : '';
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Muuda teenust | <?= htmlspecialchars($s['title']) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --main-orange: #f36f21;
            --main-orange-hover: #d95d16;
            --text-dark: #2d3748;
            --text-muted: #718096;
            --border-color: #e2e8f0;
            --bg-color: #f8fafc;
        }
        body { 
            font-family: 'Segoe UI', system-ui, sans-serif; 
            padding: 40px 20px; 
            background: var(--bg-color); 
            color: var(--text-dark);
            margin: 0;
            display: flex;
            justify-content: center;
        }
        .container { width: 100%; max-width: 800px; }
        .back-link { display: inline-flex; align-items: center; text-decoration: none; color: var(--text-muted); font-weight: 600; margin-bottom: 20px; font-size: 15px; transition: color 0.2s; }
        .back-link i { margin-right: 8px; }
        .back-link:hover { color: var(--main-orange); }

        .edit-card { background: white; padding: 35px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); border: 1px solid var(--border-color); }
        .card-header { margin-bottom: 25px; padding-bottom: 15px; border-bottom: 2px solid #edf2f7; display: flex; align-items: center; justify-content: space-between;}
        .card-header-left { display: flex; align-items: center; gap: 15px; }
        .card-header h2 { margin: 0; font-size: 24px; color: var(--text-dark); }
        .card-header i { color: var(--main-orange); font-size: 24px; }
        
        .lang-badge { background: #fff5f0; color: var(--main-orange); padding: 5px 12px; border-radius: 20px; font-weight: bold; border: 1px solid #fed7d7;}

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .full-width { grid-column: 1 / -1; }

        .form-group { display: flex; flex-direction: column; }
        label.input-title { font-size: 13px; font-weight: 700; color: #4a5568; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
        input[type="text"], textarea, select { width: 100%; padding: 12px 15px; border: 1px solid #cbd5e0; border-radius: 6px; font-family: inherit; font-size: 14px; background: #fff; transition: 0.2s; box-sizing: border-box; color: #1a202c;}
        input:focus, textarea:focus, select:focus { border-color: var(--main-orange); outline: none; box-shadow: 0 0 0 3px rgba(243, 111, 33, 0.15); }
        textarea { height: 120px; resize: vertical; line-height: 1.5; }

        .custom-file-upload { border: 1px solid #cbd5e0; display: inline-flex; align-items: center; gap: 8px; padding: 12px 15px; cursor: pointer; border-radius: 6px; background: #f8fafc; color: #4a5568; font-size: 14px; font-weight: 600; transition: 0.2s; width: fit-content; }
        .custom-file-upload:hover { background: #edf2f7; border-color: #a0aec0; }
        .file-name { margin-top: 8px; font-size: 13px; color: var(--text-muted); display: block; word-break: break-all;}
        .preview-img { margin-bottom: 15px; border-radius: 8px; border: 1px solid #e2e8f0; max-height: 120px; width: fit-content; object-fit: cover; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }

        .actions { display: flex; gap: 15px; margin-top: 35px; padding-top: 25px; border-top: 1px solid var(--border-color); }
        .btn { padding: 12px 24px; border-radius: 6px; border: none; cursor: pointer; font-weight: 700; font-size: 14px; transition: 0.2s; display: inline-flex; align-items: center; gap: 8px; text-transform: uppercase; letter-spacing: 0.5px; text-decoration: none;}
        .btn-orange { background: var(--main-orange); color: white; box-shadow: 0 4px 10px rgba(243, 111, 33, 0.2); }
        .btn-orange:hover { background: var(--main-orange-hover); transform: translateY(-2px); box-shadow: 0 6px 15px rgba(243, 111, 33, 0.3); }
        .btn-gray { background: #e2e8f0; color: #4a5568; }
        .btn-gray:hover { background: #cbd5e0; }

        @media (max-width: 600px) { .form-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

<div class="container">
    <a href="admin.php?page=services" class="back-link"><i class="fas fa-arrow-left"></i> Tagasi teenuste juurde</a>

    <div class="edit-card">
        <div class="card-header">
            <div class="card-header-left">
                <i class="fas fa-layer-group"></i>
                <h2>Muuda teenust: <?= htmlspecialchars($s['title']) ?></h2>
            </div>
            <div class="lang-badge">Režiim: <?= strtoupper($edit_lang) ?></div>
        </div>

        <form action="update_service_full.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $s['id'] ?>">

            <div class="form-grid">
                <div class="form-group">
                    <label class="input-title">Teenuse nimetus (<?= strtoupper($edit_lang) ?>)</label>
                    <input type="text" name="title" value="<?= htmlspecialchars($current_title) ?>" placeholder="Sisesta tõlge..." required>
                    <?php if($edit_lang != 'et' && empty($current_title)): ?>
                        <small style="color:#718096; margin-top:5px;">Originaal (EST): <?= htmlspecialchars($s['title']) ?></small>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label class="input-title">Faili nimi (nt: visiitkaardid.php) - Ühine</label>
                    <input type="text" name="link_url" value="<?= htmlspecialchars($s['link_url']) ?>">
                </div>

                <div class="form-group full-width">
                    <label class="input-title">Pikk kirjeldus (<?= strtoupper($edit_lang) ?>)</label>
                    <textarea name="description" placeholder="Sisesta tõlge..."><?= htmlspecialchars($current_desc) ?></textarea>
                     <?php if($edit_lang != 'et' && empty($current_desc)): ?>
                        <small style="color:#718096; margin-top:5px;">Originaal (EST): <?= htmlspecialchars($s['description']) ?></small>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label class="input-title">Kalkulaatori tüüp (Ühine)</label>
                    <select name="calc_type">
                        <?php $current_type = isset($s['calc_type']) ? $s['calc_type'] : 'none'; ?>
                        <option value="none" <?= $current_type == 'none' ? 'selected' : '' ?>>Ilma kalkulaatorita</option>
                        <option value="visiitkaardid" <?= $current_type == 'visiitkaardid' ? 'selected' : '' ?>>Visiitkaardid</option>
                        <option value="flaierid" <?= $current_type == 'flaierid' ? 'selected' : '' ?>>Flaierid</option>
                        <option value="voldikud" <?= $current_type == 'voldikud' ? 'selected' : '' ?>>Voldikud</option>
                        <option value="plakatid" <?= $current_type == 'plakatid' ? 'selected' : '' ?>>Plakatid</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="input-title">Toote pilt (Ühine kõikidele keeltele)</label>
                    <?php if(!empty($s['image_url'])): ?>
                        <img src="../img/<?= $s['image_url'] ?>" class="preview-img" alt="Current Image">
                    <?php endif; ?>
                    
                    <div>
                        <label class="custom-file-upload">
                            <input type="file" name="image" style="display: none;" onchange="document.getElementById('file-name').innerText = this.files[0] ? this.files[0].name : 'Uut faili pole valitud'">
                            <i class="fas fa-upload"></i> Vali uus pilt
                        </label>
                        <span id="file-name" class="file-name">Uut faili pole valitud</span>
                    </div>
                </div>
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-orange"><i class="fas fa-save"></i> SALVESTA (<?= strtoupper($edit_lang) ?>)</button>
                <a href="admin.php?page=services" class="btn btn-gray"><i class="fas fa-times"></i> Tühista</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
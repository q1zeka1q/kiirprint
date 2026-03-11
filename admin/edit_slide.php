<?php
session_start();
if (!isset($_SESSION['logged_in'])) { header("Location: login.php"); exit; }
require_once '../includes/config.php';

$id = (int)$_GET['id'];
$slide = $conn->query("SELECT * FROM slider WHERE id=$id")->fetch_assoc();

if (isset($_POST['update'])) {
    $link = $conn->real_escape_string($_POST['link']);
    if (!empty($_FILES['image']['name'])) {
        $img = time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "../img/" . $img);
        $conn->query("UPDATE slider SET image_url='$img', link='$link' WHERE id=$id");
    } else {
        $conn->query("UPDATE slider SET link='$link' WHERE id=$id");
    }
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
        :root {
            --main-orange: #f36f21;
            --main-orange-hover: #d95e16;
            --text-dark: #2d3748;
            --text-muted: #718096;
            --border-color: #cbd5e0;
            --bg-color: #f8fafc;
        }

        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: var(--bg-color); 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
            margin: 0; 
            padding: 20px;
        }

        .card { 
            background: white; 
            padding: 40px; 
            border-radius: 12px; 
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); 
            width: 100%;
            max-width: 450px; 
            box-sizing: border-box;
        }

        .card-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .card-header i {
            font-size: 40px;
            color: var(--main-orange);
            margin-bottom: 15px;
        }

        .card-header h2 { 
            color: var(--text-dark); 
            margin: 0; 
            font-size: 24px;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .img-preview-container {
            background: var(--bg-color);
            padding: 10px;
            border-radius: 8px;
            border: 1px dashed var(--border-color);
            text-align: center;
            margin-bottom: 15px;
        }

        .img-preview {
            max-width: 100%;
            max-height: 200px;
            object-fit: contain;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        input[type="text"], input[type="file"] { 
            width: 100%; 
            padding: 12px 15px; 
            border: 1px solid var(--border-color); 
            border-radius: 6px; 
            box-sizing: border-box; 
            font-size: 15px;
            color: var(--text-dark);
            transition: all 0.3s ease;
        }

        input[type="text"]:focus, input[type="file"]:focus {
            border-color: var(--main-orange);
            outline: none;
            box-shadow: 0 0 0 3px rgba(243, 111, 33, 0.1);
        }

        /* Стилизация input file для красоты */
        input[type="file"] {
            padding: 9px;
            background: white;
            cursor: pointer;
        }
        input[type="file"]::file-selector-button {
            background: var(--bg-color);
            border: 1px solid var(--border-color);
            padding: 6px 12px;
            border-radius: 4px;
            color: var(--text-dark);
            cursor: pointer;
            margin-right: 15px;
            transition: background 0.2s;
        }
        input[type="file"]::file-selector-button:hover {
            background: #e2e8f0;
        }

        .btn-save { 
            background: var(--main-orange); 
            color: white; 
            border: none; 
            padding: 14px; 
            border-radius: 6px; 
            cursor: pointer; 
            width: 100%; 
            font-weight: 600; 
            font-size: 16px;
            transition: background 0.3s ease, transform 0.1s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .btn-save:hover { 
            background: var(--main-orange-hover); 
        }

        .btn-save:active {
            transform: scale(0.98);
        }

        .btn-cancel { 
            display: flex; 
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-top: 20px; 
            color: var(--text-muted); 
            text-decoration: none; 
            font-size: 15px; 
            transition: color 0.2s ease;
        }

        .btn-cancel:hover {
            color: var(--text-dark);
        }
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
                <label><i class="fas fa-image" style="color: var(--text-muted); margin-right: 5px;"></i> Praegune pilt</label>
                <div class="img-preview-container">
                    <img src="../img/<?= htmlspecialchars($slide['image_url']) ?>" class="img-preview" alt="Slaidi pilt">
                </div>
                <input type="file" name="image" accept="image/*">
                <small style="color: var(--text-muted); font-size: 12px; margin-top: 5px; display: block;">Vali uus pilt ainult siis, kui soovid praegust vahetada.</small>
            </div>

            <div class="form-group">
                <label for="link"><i class="fas fa-link" style="color: var(--text-muted); margin-right: 5px;"></i> Slaidi link</label>
                <input type="text" id="link" name="link" value="<?= htmlspecialchars($slide['link']) ?>" placeholder="Näiteks: /teenused.php või https://...">
            </div>

            <button type="submit" name="update" class="btn-save">
                <i class="fas fa-save"></i> Salvesta muudatused
            </button>
            
            <a href="admin.php?page=avaleht" class="btn-cancel">
                <i class="fas fa-arrow-left"></i> Tagasi admin-paneeli
            </a>
        </form>
    </div>
</body>
</html>
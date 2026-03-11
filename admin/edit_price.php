<?php
session_start();

// 1. ЗАЩИТА
if (!isset($_SESSION['logged_in'])) { 
    header("Location: login.php"); 
    exit; 
}

// 2. ПОДКЛЮЧЕНИЕ
require_once '../includes/config.php';

// Получаем ID
if (!isset($_GET['id'])) {
    header("Location: admin.php?page=prices");
    exit;
}

$id = (int)$_GET['id'];
// ИСПРАВЛЕНИЕ: Используем таблицу prices, как в admin.php
$query = $conn->query("SELECT * FROM prices WHERE id=$id");
$price = $query->fetch_assoc();

if (!$price) {
    die("Hinda ei leitud!");
}

// 3. ОБРАБОТКА СОХРАНЕНИЯ
if (isset($_POST['update_price'])) {
    $kogus = $conn->real_escape_string($_POST['kogus']);
    $hind_4_0 = $conn->real_escape_string($_POST['hind_4_0']);
    $hind_4_4 = $conn->real_escape_string($_POST['hind_4_4']);

    // Обновляем цены в правильной таблице
    $sql = "UPDATE prices SET 
            kogus_alates='$kogus', 
            hind_4_0='$hind_4_0', 
            hind_4_4='$hind_4_4' 
            WHERE id=$id";
    
    if ($conn->query($sql)) {
        header("Location: admin.php?page=prices");
        exit;
    } else {
        $error = "Viga: " . $conn->error;
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
            --text-muted: #718096;
            --border-color: #e2e8f0;
            --bg-color: #f8fafc;
        }
        body { 
            font-family: 'Segoe UI', system-ui, sans-serif; 
            background: var(--bg-color); 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
            margin: 0; 
            color: var(--text-dark);
            padding: 20px;
        }
        .container { width: 100%; max-width: 450px; }
        
        .edit-card { 
            background: white; 
            padding: 40px; 
            border-radius: 12px; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.04); 
            border: 1px solid var(--border-color); 
        }
        .card-header { 
            margin-bottom: 25px; 
            padding-bottom: 15px; 
            border-bottom: 2px solid #edf2f7; 
            display: flex; 
            align-items: center; 
            gap: 15px; 
        }
        .card-header h2 { margin: 0; font-size: 22px; color: var(--text-dark); }
        .card-header i { color: var(--main-orange); font-size: 24px; }

        .form-group { margin-bottom: 20px; }
        label { 
            display: block; 
            font-size: 12px; 
            font-weight: 700; 
            color: #4a5568; 
            margin-bottom: 8px; 
            text-transform: uppercase; 
            letter-spacing: 0.5px; 
        }
        input[type="text"], input[type="number"] { 
            width: 100%; 
            padding: 14px 15px; 
            border: 1px solid #cbd5e0; 
            border-radius: 6px; 
            font-family: inherit; 
            font-size: 15px; 
            background: #fff; 
            transition: 0.2s; 
            box-sizing: border-box; 
            color: #1a202c;
            font-weight: 600;
        }
        input:focus { 
            border-color: var(--main-orange); 
            outline: none; 
            box-shadow: 0 0 0 3px rgba(243, 111, 33, 0.15); 
        }

        .actions { 
            display: flex; 
            flex-direction: column; 
            gap: 12px; 
            margin-top: 30px; 
            padding-top: 25px;
            border-top: 1px solid var(--border-color);
        }
        .btn { 
            padding: 14px 24px; 
            border-radius: 6px; 
            border: none; 
            cursor: pointer; 
            font-weight: 700; 
            font-size: 14px; 
            transition: 0.2s; 
            display: inline-flex; 
            align-items: center; 
            justify-content: center;
            gap: 8px; 
            text-transform: uppercase; 
            letter-spacing: 0.5px; 
            text-decoration: none; 
            width: 100%; 
            box-sizing: border-box;
        }
        .btn-orange { 
            background: var(--main-orange); 
            color: white; 
            box-shadow: 0 4px 10px rgba(243, 111, 33, 0.2); 
        }
        .btn-orange:hover { 
            background: var(--main-orange-hover); 
            transform: translateY(-2px); 
            box-shadow: 0 6px 15px rgba(243, 111, 33, 0.3); 
        }
        .btn-gray { 
            background: #e2e8f0; 
            color: #4a5568; 
        }
        .btn-gray:hover { 
            background: #cbd5e0; 
        }

        .alert-error { 
            background: #fff5f5; 
            color: #c53030; 
            padding: 15px; 
            border-radius: 8px; 
            margin-bottom: 20px; 
            font-size: 14px; 
            border: 1px solid #fed7d7; 
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
        }
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
                <div class="alert-error"><i class="fas fa-exclamation-circle"></i> <?= $error ?></div>
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
                    <button type="submit" name="update_price" class="btn btn-orange"><i class="fas fa-save"></i> Salvesta muudatused</button>
                    <a href="admin.php?page=prices" class="btn btn-gray"><i class="fas fa-times"></i> Tühista ja mine tagasi</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
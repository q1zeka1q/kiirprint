<?php
session_start();
require_once '../includes/config.php';
if (!isset($_SESSION['logged_in'])) { exit; }

// --- ОБРАБОТКА СОХРАНЕНИЯ НОВЫХ ДАННЫХ ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_order'])) {
    $update_id = intval($_POST['order_id']);
    $c_name = mysqli_real_escape_string($conn, $_POST['client_name']);
    $c_email = mysqli_real_escape_string($conn, $_POST['client_email']);
    $c_phone = mysqli_real_escape_string($conn, $_POST['client_phone']);
    $c_message = mysqli_real_escape_string($conn, $_POST['client_message']);
    $c_qty = intval($_POST['quantity']);
    $c_price = floatval($_POST['total_price']);

    $sql = "UPDATE orders SET 
            client_name = '$c_name', 
            client_email = '$c_email', 
            client_phone = '$c_phone', 
            client_message = '$c_message',
            quantity = '$c_qty',
            total_price = '$c_price'
            WHERE id = $update_id";
            
    $conn->query($sql);
    
    // Перезагружаем страницу, чтобы показать новые данные и сообщение об успехе
    header("Location: view_order.php?id=$update_id&success=1");
    exit;
}
// -----------------------------------------

$id = intval($_GET['id']);
$res = $conn->query("SELECT o.*, s.title as service_name FROM orders o LEFT JOIN services s ON o.service_id = s.id WHERE o.id = $id");
$o = $res->fetch_assoc();

$is_ready = ($o['status'] == 'valmis');
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Tellimus #<?= $id ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --main-orange: #f36f21;
            --main-orange-hover: #d95d16;
            --text-dark: #2d3748;
            --text-muted: #718096;
            --border-color: #e2e8f0;
            --bg-color: #f4f7f6;
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
        .order-container { width: 100%; max-width: 750px; }
        .back-link { display: inline-flex; align-items: center; text-decoration: none; color: var(--text-muted); font-weight: 600; margin-bottom: 20px; font-size: 15px; transition: color 0.2s; }
        .back-link i { margin-right: 8px; }
        .back-link:hover { color: var(--main-orange); }

        .order-card { background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); overflow: hidden; border: 1px solid var(--border-color); }
        .card-header { padding: 25px 30px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; background: #fff; }
        .card-header h2 { margin: 0; font-size: 24px; color: var(--text-dark); display: flex; align-items: center; gap: 15px; }
        
        .status-badge { padding: 6px 14px; border-radius: 20px; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        .status-uus { background: #feebc8; color: #7b341e; }
        .status-valmis { background: #def7ec; color: #03543f; }
        
        .header-actions { display: flex; align-items: center; gap: 15px; }
        .order-date { color: var(--text-muted); font-size: 14px; font-weight: 500; display: flex; align-items: center; gap: 6px; }

        .card-body { padding: 30px; }
        
        .info-section { margin-bottom: 35px; }
        .info-section:last-child { margin-bottom: 0; }
        
        .section-title { font-size: 16px; font-weight: 700; color: var(--text-dark); margin-top: 0; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #edf2f7; padding-bottom: 10px; }
        .section-title i { color: var(--main-orange); font-size: 18px; }

        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .info-item { background: #f8fafc; padding: 15px 20px; border-radius: 8px; border: 1px solid #edf2f7; }
        .info-label { font-size: 12px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px; font-weight: 600; display: block; }
        .info-value { font-size: 15px; font-weight: 600; color: var(--text-dark); word-break: break-word; }
        .info-value.price { color: var(--main-orange); font-size: 20px; font-weight: 800; }

        .message-box { grid-column: 1 / -1; background: #fff8f4; border-color: #feebc8; }
        .message-content { font-weight: 500; line-height: 1.6; color: #4a5568; }

        /* Стили для формы редактирования */
        input[type="text"], input[type="number"], input[type="email"], textarea {
            width: 100%; padding: 10px 12px; border: 1px solid #cbd5e0; border-radius: 6px; font-family: inherit; font-size: 14px; box-sizing: border-box; background: #fff; transition: 0.2s;
        }
        input:focus, textarea:focus { border-color: var(--main-orange); outline: none; box-shadow: 0 0 0 3px rgba(243, 111, 33, 0.1); }
        
        .btn { padding: 8px 16px; border-radius: 6px; border: none; cursor: pointer; font-weight: 600; font-size: 13px; transition: 0.2s; display: inline-flex; align-items: center; gap: 6px; }
        .btn-orange { background: var(--main-orange); color: white; }
        .btn-orange:hover { background: var(--main-orange-hover); }
        .btn-gray { background: #e2e8f0; color: #4a5568; }
        .btn-gray:hover { background: #cbd5e0; }

        .alert-success { background: #def7ec; border: 1px solid #31c48d; color: #03543f; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: 600; display: flex; align-items: center; gap: 10px; }

        @media (max-width: 600px) {
            .info-grid { grid-template-columns: 1fr; }
            .card-header { flex-direction: column; align-items: flex-start; gap: 15px; }
            .header-actions { width: 100%; justify-content: space-between; }
        }
    </style>
</head>
<body>
    <div class="order-container">
        <a href="admin.php?page=orders" class="back-link"><i class="fas fa-arrow-left"></i> Tagasi tellimuste juurde</a>
        
        <?php if(isset($_GET['success'])): ?>
            <div class="alert-success"><i class="fas fa-check-circle"></i> Andmed on edukalt uuendatud!</div>
        <?php endif; ?>

        <div class="order-card">
            <div class="card-header">
                <h2>
                    Tellimus #<?= $id ?> 
                    <span class="status-badge <?= $is_ready ? 'status-valmis' : 'status-uus' ?>">
                        <?= $is_ready ? 'VALMIS' : 'UUS' ?>
                    </span>
                </h2>
                <div class="header-actions">
                    <div class="order-date"><i class="far fa-calendar-alt"></i> <?= date('d.m.Y H:i', strtotime($o['order_date'])) ?></div>
                    <button type="button" class="btn btn-orange" id="btn-edit" onclick="toggleEdit()"><i class="fas fa-pen"></i> Muuda andmeid</button>
                </div>
            </div>

            <div class="card-body">
                
                <div id="view-mode">
                    <div class="info-section">
                        <h3 class="section-title"><i class="fas fa-box-open"></i> Toote andmed</h3>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Teenus</div>
                                <div class="info-value"><?= htmlspecialchars($o['service_name'] ?? 'Kustutatud teenus') ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Kogus</div>
                                <div class="info-value"><?= $o['quantity'] ?> tk</div>
                            </div>
                            <div class="info-item" style="grid-column: 1 / -1;">
                                <div class="info-label">Valitud paber / Lisad</div>
                                <div class="info-value"><?= htmlspecialchars($o['paper_type']) ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Hind kokku (KM-ta)</div>
                                <div class="info-value price"><?= number_format($o['total_price'], 2) ?> €</div>
                            </div>
                        </div>
                    </div>

                    <div class="info-section">
                        <h3 class="section-title"><i class="fas fa-user-circle"></i> Kliendi andmed</h3>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Nimi</div>
                                <div class="info-value"><?= htmlspecialchars($o['client_name']) ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Telefon</div>
                                <div class="info-value"><a href="tel:<?= htmlspecialchars($o['client_phone']) ?>" style="color: inherit; text-decoration: none;"><?= htmlspecialchars($o['client_phone']) ?></a></div>
                            </div>
                            <div class="info-item" style="grid-column: 1 / -1;">
                                <div class="info-label">E-mail</div>
                                <div class="info-value"><a href="mailto:<?= htmlspecialchars($o['client_email']) ?>" style="color: #3182ce; text-decoration: none;"><?= htmlspecialchars($o['client_email']) ?></a></div>
                            </div>
                            
                            <div class="info-item message-box">
                                <div class="info-label" style="color: var(--main-orange);">Lisainfo / Sõnum</div>
                                <div class="info-value message-content">
                                    <?= isset($o['client_message']) && !empty($o['client_message']) ? nl2br(htmlspecialchars($o['client_message'])) : 'Puudub' ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <form id="edit-mode" method="POST" style="display: none;">
                    <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                    
                    <div class="info-section">
                        <h3 class="section-title"><i class="fas fa-box-open"></i> Toote andmed (Muutmine)</h3>
                        <div class="info-grid">
                            <div class="info-item">
                                <label class="info-label">Teenus (Ei saa muuta)</label>
                                <input type="text" value="<?= htmlspecialchars($o['service_name'] ?? 'Kustutatud teenus') ?>" disabled style="background:#edf2f7; color:#a0aec0;">
                            </div>
                            <div class="info-item" style="grid-column: 1 / -1;">
                                <label class="info-label">Valitud paber / Lisad (Ei saa muuta)</label>
                                <input type="text" value="<?= htmlspecialchars($o['paper_type']) ?>" disabled style="background:#edf2f7; color:#a0aec0;">
                            </div>
                            <div class="info-item">
                                <label class="info-label">Kogus (tk)</label>
                                <input type="number" name="quantity" value="<?= $o['quantity'] ?>" required>
                            </div>
                            <div class="info-item">
                                <label class="info-label">Hind kokku (€)</label>
                                <input type="number" step="0.01" name="total_price" value="<?= $o['total_price'] ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="info-section">
                        <h3 class="section-title"><i class="fas fa-user-circle"></i> Kliendi andmed (Muutmine)</h3>
                        <div class="info-grid">
                            <div class="info-item">
                                <label class="info-label">Nimi</label>
                                <input type="text" name="client_name" value="<?= htmlspecialchars($o['client_name']) ?>" required>
                            </div>
                            <div class="info-item">
                                <label class="info-label">Telefon</label>
                                <input type="text" name="client_phone" value="<?= htmlspecialchars($o['client_phone']) ?>" required>
                            </div>
                            <div class="info-item" style="grid-column: 1 / -1;">
                                <label class="info-label">E-mail</label>
                                <input type="email" name="client_email" value="<?= htmlspecialchars($o['client_email']) ?>" required>
                            </div>
                            <div class="info-item message-box">
                                <label class="info-label" style="color: var(--main-orange);">Lisainfo / Sõnum</label>
                                <textarea name="client_message" rows="4"><?= htmlspecialchars($o['client_message'] ?? '') ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 10px; margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--border-color);">
                        <button type="submit" name="update_order" class="btn btn-orange"><i class="fas fa-save"></i> Salvesta muudatused</button>
                        <button type="button" class="btn btn-gray" onclick="toggleEdit()"><i class="fas fa-times"></i> Tühista</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function toggleEdit() {
            const viewMode = document.getElementById('view-mode');
            const editMode = document.getElementById('edit-mode');
            const btnEdit = document.getElementById('btn-edit');

            if (viewMode.style.display === 'none') {
                viewMode.style.display = 'block';
                editMode.style.display = 'none';
                btnEdit.style.display = 'inline-flex';
            } else {
                viewMode.style.display = 'none';
                editMode.style.display = 'block';
                btnEdit.style.display = 'none';
            }
        }
    </script>
</body>
</html>
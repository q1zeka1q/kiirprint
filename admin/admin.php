<?php
session_start();

// 1. ЗАЩИТА
if (!isset($_SESSION['logged_in'])) { 
    header("Location: login.php"); 
    exit; 
}

// --- МУЛЬТИЯЗЫЧНОСТЬ: Установка языка редактирования ---
if (isset($_GET['edit_lang'])) {
    $_SESSION['edit_lang'] = $_GET['edit_lang'];
    $redirect_page = isset($_GET['page']) ? $_GET['page'] : 'services';
    header("Location: admin.php?page=" . $redirect_page);
    exit;
}
if (!isset($_SESSION['edit_lang'])) {
    $_SESSION['edit_lang'] = 'et';
}
$edit_lang = $_SESSION['edit_lang'];
$lang_suffix = ($edit_lang == 'et') ? '' : '_' . $edit_lang;
// --------------------------------------------------------

// 2. ПОДКЛЮЧЕНИЕ К БАЗЕ
if (!file_exists('../includes/config.php')) {
    die("Viga: config.php faili ei leitud!");
}
require_once '../includes/config.php';

// Функция для получения настроек, чтобы не было ошибок
if (!function_exists('get_setting')) {
    function get_setting($key) {
        global $conn;
        $res = $conn->query("SELECT config_value FROM settings WHERE config_key = '$key'");
        if ($res && $res->num_rows > 0) {
            $row = $res->fetch_assoc();
            return $row['config_value'];
        }
        return '';
    }
}

// СОХРАНЕНИЕ НАСТРОЕК
if (isset($_POST['save_settings'])) {
    $home_title = mysqli_real_escape_string($conn, $_POST['home_title']);
    $home_subtitle = mysqli_real_escape_string($conn, $_POST['home_subtitle']);
    $footer_email = mysqli_real_escape_string($conn, $_POST['footer_email']);
    $footer_phone = mysqli_real_escape_string($conn, $_POST['footer_phone']);
    $footer_about = mysqli_real_escape_string($conn, $_POST['footer_about']);
    $footer_address = mysqli_real_escape_string($conn, $_POST['footer_address']);
    
    // Новые поля для контактов
    $contact_company = mysqli_real_escape_string($conn, $_POST['contact_company']);
    $contact_reg = mysqli_real_escape_string($conn, $_POST['contact_reg']);
    $contact_kmk = mysqli_real_escape_string($conn, $_POST['contact_kmk']);
    $contact_bank = mysqli_real_escape_string($conn, $_POST['contact_bank']);
    $contact_swift = mysqli_real_escape_string($conn, $_POST['contact_swift']);
    $contact_hours = mysqli_real_escape_string($conn, $_POST['contact_hours']);

    // Умная функция: если ключа нет в базе, она его создаст, если есть - обновит!
    function save_or_update_setting($key, $val) {
        global $conn;
        $check = $conn->query("SELECT * FROM settings WHERE config_key = '$key'");
        if ($check->num_rows > 0) {
            $conn->query("UPDATE settings SET config_value = '$val' WHERE config_key = '$key'");
        } else {
            $conn->query("INSERT INTO settings (config_key, config_value) VALUES ('$key', '$val')");
        }
    }

    // Сохраняем переводимые тексты с суффиксом (например: home_title_ru)
    save_or_update_setting('home_title' . $lang_suffix, $home_title);
    save_or_update_setting('home_subtitle' . $lang_suffix, $home_subtitle);
    save_or_update_setting('footer_about' . $lang_suffix, $footer_about);
    save_or_update_setting('footer_address' . $lang_suffix, $footer_address);
    save_or_update_setting('contact_hours' . $lang_suffix, $contact_hours);

    // Сохраняем общие данные (email, телефоны, рег. коды), они не зависят от языка
    save_or_update_setting('footer_email', $footer_email);
    save_or_update_setting('footer_phone', $footer_phone);
    save_or_update_setting('contact_company', $contact_company);
    save_or_update_setting('contact_reg', $contact_reg);
    save_or_update_setting('contact_kmk', $contact_kmk);
    save_or_update_setting('contact_bank', $contact_bank);
    save_or_update_setting('contact_swift', $contact_swift);

    header("Location: admin.php?page=avaleht&status=success");
    exit;
}

$page = isset($_GET['page']) ? $_GET['page'] : 'services';
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Kiirprint | Halduspaneel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { 
            --sidebar-width: 260px; 
            --sidebar-collapsed-width: 75px; 
            --main-orange: #f36f21; 
            --main-orange-hover: #d95d16;
            --dark-bg: #1a1c23; 
            --light-bg: #f4f7f6;
            --text-dark: #2d3748;
            --text-muted: #718096;
            --border-color: #e2e8f0;
        }
        body { margin: 0; font-family: 'Segoe UI', system-ui, sans-serif; background: var(--light-bg); display: flex; min-height: 100vh; color: var(--text-dark); }

        /* SIDEBAR */
        .sidebar { width: var(--sidebar-width); background: var(--dark-bg); color: white; position: fixed; height: 100vh; display: flex; flex-direction: column; transition: width 0.3s ease; z-index: 1000; box-shadow: 4px 0 15px rgba(0,0,0,0.05); }
        .sidebar.collapsed { width: var(--sidebar-collapsed-width); }
        .sidebar-header { padding: 20px; display: flex; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.05); height: 75px; box-sizing: border-box; white-space: nowrap; }
        .toggle-btn { background: none; color: #a0aec0; border: none; cursor: pointer; font-size: 20px; margin-right: 15px; transition: 0.3s; }
        .toggle-btn:hover { color: var(--main-orange); }
        .logo-text { font-size: 22px; font-weight: 800; color: var(--main-orange); letter-spacing: 1px; }
        .sidebar.collapsed .logo-text, .sidebar.collapsed .nav-item span { display: none; } 
        .sidebar.collapsed .toggle-btn { margin-right: 0; width: 100%; text-align: center; }
        .sidebar.collapsed .nav-item { padding: 15px 0; justify-content: center; }
        .sidebar.collapsed .nav-item i { margin-right: 0; font-size: 22px; }

        .nav-list { list-style: none; padding: 0; margin: 20px 0; flex-grow: 1; }
        .nav-item { display: flex; align-items: center; padding: 16px 25px; text-decoration: none; color: #a0aec0; transition: 0.3s; border-left: 4px solid transparent; font-weight: 500; white-space: nowrap; }
        .nav-item i { width: 30px; font-size: 18px; margin-right: 15px; text-align: center; }
        .nav-item:hover, .nav-item.active { background: rgba(243, 111, 33, 0.08); color: white; border-left: 4px solid var(--main-orange); }
        .nav-item.active i { color: var(--main-orange); }
        .logout { color: #fc8181; border-top: 1px solid rgba(255,255,255,0.05); margin-top: auto; }
        .logout:hover { color: #fff; background: rgba(252, 129, 129, 0.1); border-left-color: #fc8181; }

        /* MAIN CONTENT */
        .main-content { flex-grow: 1; margin-left: var(--sidebar-width); padding: 40px 50px; transition: margin-left 0.3s ease; }
        .sidebar.collapsed + .main-content { margin-left: var(--sidebar-collapsed-width); }
        
        .admin-card { background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); padding: 35px; border: 1px solid rgba(0,0,0,0.02); }
        h2 { margin-top: 0; color: #1a202c; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #edf2f7; padding-bottom: 15px; margin-bottom: 25px; font-size: 22px; }
        
        /* TABLES */
        table { width: 100%; border-collapse: separate; border-spacing: 0; margin-top: 10px; border-radius: 8px; overflow: hidden; border: 1px solid var(--border-color); }
        th { text-align: left; padding: 16px; background: #f8fafc; color: var(--text-muted); font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid var(--border-color); font-weight: 600; }
        td { padding: 16px; border-bottom: 1px solid #edf2f7; vertical-align: middle; font-size: 14px; background: #fff; transition: background 0.2s; }
        tr:hover td { background: #f8fafc; }
        tr:last-child td { border-bottom: none; }
        
        /* BADGES */
        .badge { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; display: inline-block; }
        .badge-green { background: #def7ec; color: #03543f; }
        .badge-orange { background: #feebc8; color: #7b341e; }
        
        /* BUTTONS & LINKS */
        .btn { padding: 10px 20px; border-radius: 6px; border: none; cursor: pointer; font-weight: 600; text-decoration: none; display: inline-block; font-size: 14px; transition: all 0.2s; }
        .btn-green { background: #10b981; color: white; box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2); }
        .btn-green:hover { background: #059669; transform: translateY(-1px); }
        .btn-orange { background: var(--main-orange); color: white; box-shadow: 0 2px 4px rgba(243, 111, 33, 0.2); }
        .btn-orange:hover { background: var(--main-orange-hover); transform: translateY(-1px); }
        
        .action-links a { text-decoration: none; margin-left: 12px; font-weight: 600; font-size: 13px; padding: 6px 10px; border-radius: 4px; transition: 0.2s; }
        .edit { color: #3182ce; background: #ebf8ff; }
        .edit:hover { background: #bee3f8; }
        .delete { color: #e53e3e; background: #fff5f5; }
        .delete:hover { background: #fed7d7; }

        /* FORMS */
        .inline-form { display: none; background: #f8fafc; padding: 25px; border-radius: 8px; margin-bottom: 25px; border: 1px solid var(--border-color); }
        input[type="text"], input[type="number"], input[type="email"], textarea, select {
            width: 100%; padding: 12px 15px; border: 1px solid var(--border-color); border-radius: 6px; font-family: inherit; font-size: 14px; transition: all 0.2s; box-sizing: border-box; background: #fff;
        }
        input:focus, textarea:focus, select:focus { border-color: var(--main-orange); outline: none; box-shadow: 0 0 0 3px rgba(243, 111, 33, 0.15); }
        label { font-weight: 600; color: #4a5568; font-size: 13px; margin-bottom: 6px; display: inline-block; }

        .table-responsive { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }
        td.action-links { white-space: nowrap; text-align: right; min-width: 120px; }
        td.client-col { max-width: 200px; word-break: break-word; overflow-wrap: anywhere; }
        td.desc-col { max-width: 250px; white-space: normal; word-break: break-word; }

        /* СТИЛИ ЯЗЫКОВОЙ ПАНЕЛИ */
        .lang-switcher-bar {
            background: white; padding: 15px 25px; border-radius: 12px; margin-bottom: 25px; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.03); border: 1px solid var(--border-color); 
            display: flex; align-items: center; gap: 15px;
        }
        .btn-lang {
            padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 14px; transition: all 0.2s;
        }
        .btn-lang.active { background: var(--main-orange); color: white; box-shadow: 0 2px 4px rgba(243, 111, 33, 0.2); }
        .btn-lang.inactive { background: #edf2f7; color: #4a5568; }
        .btn-lang.inactive:hover { background: #e2e8f0; }
    </style>
</head>
<body>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <button class="toggle-btn" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
            <div class="logo-text">KIIRPRINT</div>
        </div>
        <nav class="nav-list">
            <a href="admin.php?page=avaleht" class="nav-item <?= $page=='avaleht'?'active':'' ?>"><i class="fas fa-images"></i><span>Avaleht</span></a>
            <a href="admin.php?page=orders" class="nav-item <?= $page=='orders'?'active':'' ?>"><i class="fas fa-shopping-basket"></i><span>Tellimused</span></a>
            <a href="admin.php?page=services" class="nav-item <?= $page=='services'?'active':'' ?>"><i class="fas fa-layer-group"></i><span>Teenused</span></a>
            <a href="admin.php?page=prices" class="nav-item <?= $page=='prices'?'active':'' ?>"><i class="fas fa-tags"></i><span>Hinnad</span></a>
            <a href="admin.php?page=queries" class="nav-item <?= $page=='queries'?'active':'' ?>"><i class="fas fa-envelope"></i><span>Päringud</span></a>
        </nav>
        <a href="../index.php" class="nav-item" target="_blank"><i class="fas fa-external-link-alt"></i><span>Vaata saiti</span></a>
        <a href="logout.php" class="nav-item logout"><i class="fas fa-sign-out-alt"></i><span>Välju</span></a>
    </div>

    <div class="main-content">
        
        <div class="lang-switcher-bar">
            <strong style="color: #4a5568;"><i class="fas fa-globe"></i> Redigeeritav keel:</strong>
            <a href="?page=<?= $page ?>&edit_lang=et" class="btn-lang <?= $edit_lang == 'et' ? 'active' : 'inactive' ?>">EST</a>
            <a href="?page=<?= $page ?>&edit_lang=ru" class="btn-lang <?= $edit_lang == 'ru' ? 'active' : 'inactive' ?>">RUS</a>
            <a href="?page=<?= $page ?>&edit_lang=en" class="btn-lang <?= $edit_lang == 'en' ? 'active' : 'inactive' ?>">ENG</a>
            <a href="?page=<?= $page ?>&edit_lang=fi" class="btn-lang <?= $edit_lang == 'fi' ? 'active' : 'inactive' ?>">FIN</a>
            
            <?php if($edit_lang != 'et'): ?>
                <span style="margin-left:auto; color: #e53e3e; font-size: 13px; font-weight: 600;"><i class="fas fa-info-circle"></i> Oled <?= strtoupper($edit_lang) ?> keele režiimis</span>
            <?php endif; ?>
        </div>

        <div class="admin-card">
            
<?php if ($page == 'services'): ?>
    <h2>Teenuste haldus <button class="btn btn-green" onclick="toggleForm('form-service')"><i class="fas fa-plus"></i> Lisa uus (<?= strtoupper($edit_lang) ?>)</button></h2>
    <div id="form-service" class="inline-form">
        <form action="save_service.php" method="POST" enctype="multipart/form-data" style="display: grid; gap: 15px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <input type="text" name="title" placeholder="Teenuse nimi (<?= strtoupper($edit_lang) ?>)" required>
                <input type="text" name="link_url" placeholder="Link (nt: visiitkaardid.php)">
            </div>
            <textarea name="description" placeholder="Teenuse pikk kirjeldus (<?= strtoupper($edit_lang) ?>)..." style="height: 100px;"></textarea>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; align-items: center;">
                <input type="number" name="price" step="0.01" placeholder="Hind (€) - Ühine kõikidele">
                <input type="file" name="image_url" style="padding: 9px;">
            </div>
            <button type="submit" class="btn btn-orange" style="justify-self: start;">SALVESTA TEENUS</button>
        </form>
    </div>

<div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th style="width: 70px;">Pilt</th>
                <th>Pealkiri (<?= strtoupper($edit_lang) ?>)</th>
                <th>Kirjeldus (<?= strtoupper($edit_lang) ?>)</th>
                <th>Hind</th>
                <th style="text-align:center;">Näita</th>
                <th style="text-align:right;">Tegevus</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $res = $conn->query("SELECT * FROM services ORDER BY id DESC");
            // Умные колонки для вывода
            $title_col = ($edit_lang == 'et') ? 'title' : 'title_' . $edit_lang;
            $desc_col = ($edit_lang == 'et') ? 'description' : 'description_' . $edit_lang;

            while($s = $res->fetch_assoc()): 
                // Если перевода еще нет, показываем эстонский оригинал
                $display_title = !empty($s[$title_col]) ? $s[$title_col] : $s['title'];
                $display_desc = !empty($s[$desc_col]) ? $s[$desc_col] : $s['description'];
            ?>
                <tr>
                    <td>
                        <img src="../img/<?= !empty($s['image_url']) ? htmlspecialchars($s['image_url']) : 'placeholder.png' ?>" 
                             style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px; border: 1px solid #edf2f7; display: block;">
                    </td>
                    <td><strong><?= htmlspecialchars($display_title) ?></strong></td>
                    <td class="desc-col">
                        <span style="color: #718096; font-size: 13px;">
                            <?= mb_strimwidth(htmlspecialchars($display_desc), 0, 60, "...") ?>
                        </span>
                    </td>
                    <td><strong style="color: var(--main-orange); font-size: 15px;"><?= number_format($s['price'], 2) ?> €</strong></td>
                    <td style="text-align:center;">
                        <input type="checkbox" style="transform: scale(1.3); cursor:pointer;"
                            onclick="updateVisibility(<?= $s['id'] ?>, this.checked)" 
                            <?= (isset($s['is_visible']) && $s['is_visible'] == 1) ? 'checked' : '' ?>>
                    </td>
                    <td style="text-align:right" class="action-links">
                        <a href="edit_service.php?id=<?= $s['id'] ?>" class="edit" title="Muuda"><i class="fas fa-pen"></i></a>
                        <a href="delete_service.php?id=<?= $s['id'] ?>" class="delete" onclick="return confirm('Kas oled kindel, et soovid kustutada?')" title="Kustuta"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php elseif ($page == 'orders'): ?>
<h2><i class="fas fa-shopping-cart" style="color: var(--main-orange); margin-right: 10px;"></i> Tellimused</h2>
    
    <?php
    $where_clauses = [];
    $search_query = isset($_GET['search']) ? trim($_GET['search']) : '';
    $status_filter = isset($_GET['status_filter']) ? $_GET['status_filter'] : 'all';

    if (!empty($search_query)) {
        $safe_search = $conn->real_escape_string($search_query);
        $where_clauses[] = "(o.id = '$safe_search' OR o.client_name LIKE '%$safe_search%' OR o.client_email LIKE '%$safe_search%' OR o.client_phone LIKE '%$safe_search%')";
    }
    if ($status_filter === 'uus') {
        $where_clauses[] = "(o.status IS NULL OR o.status != 'valmis')";
    } elseif ($status_filter === 'valmis') {
        $where_clauses[] = "o.status = 'valmis'";
    }

    $where_sql = "";
    if (count($where_clauses) > 0) {
        $where_sql = " WHERE " . implode(" AND ", $where_clauses);
    }

    $sql = "SELECT o.*, s.title as service_name FROM orders o LEFT JOIN services s ON o.service_id = s.id $where_sql ORDER BY o.order_date DESC";
    $res = $conn->query($sql);
    ?>

    <div style="background: #f8fafc; padding: 20px; border-radius: 8px; border: 1px solid var(--border-color); margin-bottom: 25px;">
        <form method="GET" style="display: flex; gap: 15px; align-items: center; margin: 0; flex-wrap: wrap;">
            <input type="hidden" name="page" value="orders">

            <div style="flex-grow: 1; position: relative; min-width: 250px;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #a0aec0;"></i>
                <input type="text" name="search" value="<?= htmlspecialchars($search_query) ?>" placeholder="Otsi: ID, Nimi, E-mail, Telefon..." style="width: 100%; padding: 12px 15px 12px 40px; border: 1px solid #cbd5e0; border-radius: 6px; box-sizing: border-box; font-size: 14px; outline: none;">
            </div>

            <select name="status_filter" style="padding: 12px 15px; border: 1px solid #cbd5e0; border-radius: 6px; background: white; min-width: 180px; color: #4a5568; font-weight: 600; font-size: 14px; outline: none;">
                <option value="all" <?= $status_filter == 'all' ? 'selected' : '' ?>>Kõik staatused</option>
                <option value="uus" <?= $status_filter == 'uus' ? 'selected' : '' ?>>Uued tellimused (UUS)</option>
                <option value="valmis" <?= $status_filter == 'valmis' ? 'selected' : '' ?>>Valmis tellimused</option>
            </select>

            <button type="submit" class="btn btn-orange" style="padding: 12px 25px;"><i class="fas fa-filter"></i> Filtreeri</button>

            <?php if(!empty($search_query) || $status_filter != 'all'): ?>
                <a href="admin.php?page=orders" class="btn btn-gray" style="padding: 12px 18px; text-decoration: none;" title="Tühista filter"><i class="fas fa-times"></i></a>
            <?php endif; ?>
        </form>
    </div>

    <?php if ($res && $res->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID / Aeg</th>
                    <th>Toode / Kogus</th>
                    <th>Hind</th>
                    <th>Klient</th>
                    <th>Staatus</th>
                    <th style="text-align:right">Tegevus</th>
                </tr>
            </thead>
                <tbody>
                    <?php while($o = $res->fetch_assoc()): 
                        $is_ready = ($o['status'] == 'valmis');
                    ?>
                        <tr>
                            <td>
                                <strong>#<?= $o['id'] ?></strong><br>
                                <span style="font-size:12px; color:#a0aec0;"><?= date('d.m.Y H:i', strtotime($o['order_date'])) ?></span>
                            </td>
                            <td>
                                <strong><?= htmlspecialchars($o['service_name'] ?? 'Kustutatud') ?></strong> (<?= $o['quantity'] ?> tk)<br>
                                <span style="font-size:12px; color:#718096;"><?= htmlspecialchars($o['paper_type']) ?></span>
                            </td>
                            <td style="color: var(--main-orange); font-weight: 700; font-size: 16px;"><?= number_format($o['total_price'], 2) ?> €</td>
                            <td>
                                <strong><?= htmlspecialchars($o['client_name']) ?></strong><br>
                                <span style="font-size:12px; color:#718096;"><i class="fas fa-phone-alt"></i> <?= htmlspecialchars($o['client_phone']) ?></span><br>
                                <span style="font-size:12px; color:#718096;"><i class="fas fa-envelope"></i> <?= htmlspecialchars($o['client_email']) ?></span>
                            </td>
                            <td>
                                <span class="badge <?= $is_ready ? 'badge-green' : 'badge-orange' ?>">
                                    <?= $is_ready ? 'VALMIS' : 'UUS' ?>
                                </span>
                            </td>
                            <td style="text-align:right" class="action-links">
                                <a href="view_order.php?id=<?= $o['id'] ?>" class="edit" title="Vaata detailid"><i class="fas fa-eye"></i></a>
                                
                                <?php if(!$is_ready): ?>
                                    <a href="update_order_status.php?id=<?= $o['id'] ?>&status=valmis" class="edit" style="color: #047857; background: #d1fae5;" title="Märgi valmis"><i class="fas fa-check"></i></a>
                                <?php endif; ?>
                                
                                <a href="delete_order.php?id=<?= $o['id'] ?>" class="delete" onclick="return confirm('Kustutada?')" title="Kustuta"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
        </table>
    <?php else: ?>
        <div style="text-align:center; padding: 60px 20px; background: #f8fafc; border-radius: 8px; border: 1px dashed #cbd5e0;">
            <i class="fas fa-box-open" style="font-size: 40px; color: #a0aec0; margin-bottom: 15px;"></i>
            <?php if(!empty($search_query) || $status_filter != 'all'): ?>
                <p style="color: #718096; margin: 0; font-size: 16px;">Otsingule ei leitud ühtegi vastet.</p>
                <a href="admin.php?page=orders" class="btn btn-orange" style="margin-top: 15px;">Näita kõiki tellimusi</a>
            <?php else: ?>
                <p style="color: #718096; margin: 0; font-size: 16px;">Tellimusi pole veel laekunud.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

<?php elseif ($page == 'prices'): ?>
<?php
    $services_list = $conn->query("SELECT id, title FROM services ORDER BY title ASC");
    $selected_service_id = isset($_GET['service_id']) ? intval($_GET['service_id']) : 0;
    if ($selected_service_id == 0) {
        $first_service = $conn->query("SELECT id FROM services LIMIT 1")->fetch_assoc();
        $selected_service_id = $first_service ? $first_service['id'] : 0;
    }
    ?>

    <h2>Hinnakirja haldus</h2>

    <div style="background: #f8fafc; padding: 20px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 15px; border: 1px solid var(--border-color);">
        <strong style="color: #4a5568;">Vali toode/teenus:</strong>
        <form method="GET" id="serviceFilter" style="margin: 0;">
            <input type="hidden" name="page" value="prices">
            <select name="service_id" onchange="this.form.submit()" style="min-width: 250px; padding: 10px;">
                <?php 
                $services_list->data_seek(0);
                while($sl = $services_list->fetch_assoc()): ?>
                    <option value="<?= $sl['id'] ?>" <?= $selected_service_id == $sl['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($sl['title']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </form>
        <button class="btn btn-green" onclick="toggleForm('form-price')" style="margin-left: auto;"><i class="fas fa-plus"></i> Lisa hind</button>
    </div>

    <div id="form-price" class="inline-form">
        <form action="save_price.php" method="POST" style="display: grid; gap: 15px; grid-template-columns: 1fr 1fr 1fr auto; align-items: end;">
            <input type="hidden" name="service_id" value="<?= $selected_service_id ?>">
            <div><label>Kogus alates:</label><input type="number" name="kogus_alates" placeholder="100" required></div>
            <div><label>Hind 4+0 (tk):</label><input type="text" name="hind_4_0" placeholder="0.10" required></div>
            <div><label>Hind 4+4 (tk):</label><input type="text" name="hind_4_4" placeholder="0.15" required></div>
            <button type="submit" name="add_price" class="btn btn-orange">SALVESTA</button>
        </form>
    </div>

    <table>
        <thead>
            <tr><th>Kogus</th><th>Hind 4+0 (tk)</th><th>Hind 4+4 (tk)</th><th style="text-align:right">Tegevus</th></tr>
        </thead>
        <tbody>
            <?php 
            $res = $conn->query("SELECT * FROM prices WHERE service_id = $selected_service_id ORDER BY kogus_alates ASC");
            if ($res && $res->num_rows > 0):
                while($p = $res->fetch_assoc()): ?>
                    <tr>
                        <td><strong><?= $p['kogus_alates'] ?>+</strong></td>
                        <td><?= number_format($p['hind_4_0'], 3) ?> €</td>
                        <td><?= number_format($p['hind_4_4'], 3) ?> €</td>
                        <td style="text-align:right" class="action-links">
                            <a href="edit_price.php?id=<?= $p['id'] ?>" class="edit"><i class="fas fa-pen"></i></a>
                            <a href="delete_price.php?id=<?= $p['id'] ?>" class="delete" onclick="return confirm('Kustutada?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endwhile; 
            else: ?>
                <tr><td colspan="4" style="text-align:center; padding: 30px; color: #a0aec0;">Selle toote jaoks pole veel hindu sisestatud.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

<?php elseif ($page == 'avaleht'): ?>
    <h2>Slaideri haldus <button class="btn btn-green" onclick="toggleForm('form-slider')"><i class="fas fa-plus"></i> Lisa slaid (<?= strtoupper($edit_lang) ?>)</button></h2>
    <div id="form-slider" class="inline-form">
        <form action="save_slide.php" method="POST" enctype="multipart/form-data" style="display: flex; gap:15px; align-items: center;">
            <input type="file" name="image_url" required style="flex:1;">
            <input type="text" name="link" placeholder="Link (<?= strtoupper($edit_lang) ?>)" style="flex:2;">
            <button type="submit" class="btn btn-orange">Lisa slaid</button>
        </form>
    </div>
<table>
        <tr><th>Pilt (<?= strtoupper($edit_lang) ?>)</th><th>Link</th><th style="text-align:right">Tegevus</th></tr>
        <?php 
        // Выбираем слайды ТОЛЬКО для текущего языка!
        $res = $conn->query("SELECT * FROM slider WHERE lang = '$edit_lang'");

        while($sl = $res->fetch_assoc()): 
        ?>
            <tr>
                <td><img src="../img/<?= htmlspecialchars($sl['image_url']) ?>" width="120" style="border-radius: 6px;"></td>
                <td style="color: #718096;"><?= htmlspecialchars($sl['link']) ?></td>
                <td style="text-align:right" class="action-links">
                    <a href="edit_slide.php?id=<?= $sl['id'] ?>" class="edit" title="Muuda"><i class="fas fa-pen"></i></a>
                    <a href="delete_slide.php?id=<?= $sl['id'] ?>" class="delete" onclick="return confirm('Kustutada?')" title="Kustuta"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <hr style="margin: 40px 0; border:0; border-top: 2px solid #edf2f7;">

   <h2>Üldised seaded (<?= strtoupper($edit_lang) ?>)</h2>
    <div style="background: #f8fafc; padding: 30px; border-radius: 8px; border: 1px solid var(--border-color);">
        <form method="POST" action=""> 
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 30px;">
                
                <div>
                    <h3 style="color: var(--main-orange); margin-top:0; border-bottom: 2px solid #edf2f7; padding-bottom: 10px;">Pealehe tekstid</h3>
                    <label>Pealkiri (oranž):</label>
                    <input type="text" name="home_title" value="<?= htmlspecialchars(get_setting('home_title' . $lang_suffix)) ?>" style="margin-bottom: 15px;">
                    <label>Kirjeldus (Subtitle):</label>
                    <textarea name="home_subtitle" style="height: 100px;"><?= htmlspecialchars(get_setting('home_subtitle' . $lang_suffix)) ?></textarea>
                </div>

                <div>
                    <h3 style="color: var(--main-orange); margin-top:0; border-bottom: 2px solid #edf2f7; padding-bottom: 10px;">Jaluse (Footer) seaded</h3>
                    <label>Meie kohta tekst:</label>
                    <textarea name="footer_about" style="height: 60px; margin-bottom: 15px;"><?= htmlspecialchars(get_setting('footer_about' . $lang_suffix)) ?></textarea>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                        <div><label>E-mail (Ühine):</label><input type="email" name="footer_email" value="<?= htmlspecialchars(get_setting('footer_email')) ?>"></div>
                        <div><label>Telefon (Ühine):</label><input type="text" name="footer_phone" value="<?= htmlspecialchars(get_setting('footer_phone')) ?>"></div>
                    </div>
                    
                    <label>Aadress:</label>
                    <input type="text" name="footer_address" value="<?= htmlspecialchars(get_setting('footer_address' . $lang_suffix)) ?>" style="margin-bottom: 20px;">
                </div>

                <div>
                    <h3 style="color: var(--main-orange); margin-top:0; border-bottom: 2px solid #edf2f7; padding-bottom: 10px;">Kontaktide lehe seaded</h3>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                        <div><label>Firma nimi (Ühine):</label><input type="text" name="contact_company" value="<?= htmlspecialchars(get_setting('contact_company')) ?>"></div>
                        <div><label>Reg kood (Ühine):</label><input type="text" name="contact_reg" value="<?= htmlspecialchars(get_setting('contact_reg')) ?>"></div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                        <div><label>KMK nr (Ühine):</label><input type="text" name="contact_kmk" value="<?= htmlspecialchars(get_setting('contact_kmk')) ?>"></div>
                        <div><label>Lahtiolekuajad:</label><input type="text" name="contact_hours" value="<?= htmlspecialchars(get_setting('contact_hours' . $lang_suffix)) ?>"></div>
                    </div>
                    
                    <label>Pangakonto (Ühine):</label>
                    <input type="text" name="contact_bank" value="<?= htmlspecialchars(get_setting('contact_bank')) ?>" style="margin-bottom: 15px;">
                    
                    <label>SWIFT/BIC (Ühine):</label>
                    <input type="text" name="contact_swift" value="<?= htmlspecialchars(get_setting('contact_swift')) ?>" style="margin-bottom: 20px;">
                </div>

            </div>
            <button type="submit" name="save_settings" class="btn btn-orange" style="width: 100%; padding: 15px; font-size: 16px; margin-top: 10px;">SALVESTA MUUDATUSED (<?= strtoupper($edit_lang) ?>)</button>
        </form>
    </div>
    
<?php elseif ($page == 'queries'): ?>
<h2><i class="fas fa-envelope-open-text" style="color: var(--main-orange); margin-right: 10px;"></i> Saabunud päringud</h2>
    <?php 
    $res = $conn->query("SELECT * FROM paringud ORDER BY is_read ASC, kuupaev DESC");
    if($res && $res->num_rows > 0):
        while($q = $res->fetch_assoc()): 
            $isRead = ($q['is_read'] == 1); ?>
            <div style="background: <?= $isRead ? '#f8fafc' : '#fff' ?>; border: 1px solid <?= $isRead ? '#edf2f7' : '#e2e8f0' ?>; padding: 25px; border-radius: 8px; margin-bottom: 15px; border-left: 4px solid <?= $isRead ? '#cbd5e0' : 'var(--main-orange)' ?>; box-shadow: <?= $isRead ? 'none' : '0 2px 10px rgba(0,0,0,0.03)' ?>;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <strong style="font-size: 16px; color: #1a202c;"><?= htmlspecialchars($q['email']) ?></strong> 
                        <span style="color: #718096; margin-left: 10px;">(<?= htmlspecialchars($q['pealkiri']) ?>)</span>
                        <div style="font-size: 12px; color: #a0aec0; margin-top: 5px;"><i class="far fa-clock"></i> <?= date('d.m.Y H:i', strtotime($q['kuupaev'])) ?></div>
                    </div>
                    <div class="action-links">
                        <?php if (!$isRead): ?>
                            <a href="update_query.php?id=<?= $q['id'] ?>&action=mark_read" class="edit" style="color: #047857; background: #d1fae5;"><i class="fas fa-check"></i> Loetud</a>
                        <?php endif; ?>
                        <a href="update_query.php?id=<?= $q['id'] ?>&action=delete" class="delete" onclick="return confirm('Kustuta?')"><i class="fas fa-trash"></i> Kustuta</a>
                    </div>
                </div>
                <div style="margin-top: 15px; color: #4a5568; line-height: 1.6; background: <?= $isRead ? 'transparent' : '#f8fafc' ?>; padding: <?= $isRead ? '0' : '15px' ?>; border-radius: 6px;">
                    <?= nl2br(htmlspecialchars($q['tekst'])) ?>
                </div>
            </div>
        <?php endwhile; 
    else: ?>
        <p style="text-align:center; padding: 40px; color: #a0aec0;">Päringuid ei ole.</p>
    <?php endif; ?>

<?php endif; ?>

        </div>
    </div>

    <script>
        function toggleForm(id) {
            const f = document.getElementById(id);
            f.style.display = (f.style.display === 'block' || f.style.display === 'grid') ? 'none' : 'block';
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('collapsed');
            localStorage.setItem('sidebar_collapsed', sidebar.classList.contains('collapsed'));
        }

        window.onload = function() {
            if (localStorage.getItem('sidebar_collapsed') === 'true') {
                document.getElementById('sidebar').classList.add('collapsed');
            }
        };
    </script>
</body>
</html>
<?php
require_once 'includes/config.php';
require_once 'includes/htmlpurifier/library/HTMLPurifier.auto.php';

$config = HTMLPurifier_Config::createDefault();
$purifier = new HTMLPurifier($config);

// Страховочный массив для новых слов
$c_title = $lang['contact_page_title'] ?? 'Võta meiega ühendust';
$c_success = $lang['contact_success'] ?? 'Aitäh! Teie kiri on saadetud. Vastame esimesel võimalusel.';
$c_info_title = $lang['contact_info_title'] ?? 'Kontaktandmed';
$c_desc = $lang['contact_form_desc'] ?? 'Küsi hinnapakkumist või jäta meile teade. Vastame tööpäeviti mõne tunni jooksul.';
$c_phone = $lang['contact_phone'] ?? 'Telefon:';
$c_address = $lang['contact_address'] ?? 'Aadress:';
$c_bank = $lang['contact_bank_details'] ?? 'Pangarekvisiidid:';
$c_hours = $lang['contact_hours_label'] ?? 'Lahtiolekuajad:';

// Функция для получения настроек (PDO)
if (!function_exists('get_setting')) {
    function get_setting($key) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT config_value FROM settings WHERE config_key = :key");
        $stmt->execute(['key' => $key]);
        return $stmt->fetchColumn() ?: '';
    }
}

// Обработка формы (БЕЗОПАСНО ЧЕРЕЗ PDO И HTMLPurifier)
$success_msg = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send_query'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $pealkiri = strip_tags($_POST['pealkiri']);
    $tekst = $purifier->purify($_POST['tekst']); // Защита от XSS

    $stmt = $pdo->prepare("INSERT INTO paringud (email, pealkiri, tekst, is_read) VALUES (:email, :pealkiri, :tekst, 0)");
    if ($stmt->execute(['email' => $email, 'pealkiri' => $pealkiri, 'tekst' => $tekst])) {
        $success_msg = $c_success;
    }
}

include 'includes/header.php'; 

// Умный суффикс
$lang_suffix = (isset($current_lang) && $current_lang != 'et') ? '_' . $current_lang : '';
$display_address = get_setting('footer_address' . $lang_suffix) ?: get_setting('footer_address');
$display_hours = get_setting('contact_hours' . $lang_suffix) ?: get_setting('contact_hours');
?>

<div class="contact-page-wrapper">
    <div class="container">
        <div class="breadcrumbs">
            <a href="index.php"><?= htmlspecialchars($lang['menu_home'] ?? 'Avaleht') ?></a> <i class="fas fa-chevron-right"></i> 
            <span><?= htmlspecialchars($lang['menu_contact'] ?? 'Kontaktid') ?></span>
        </div>

        <h1 class="page-title"><?= htmlspecialchars($c_title) ?></h1>

        <?php if($success_msg): ?>
            <div class="alert-success"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($success_msg) ?></div>
        <?php endif; ?>

        <div class="contact-layout">
            <div class="contact-info-box">
                <h3 class="box-title"><?= htmlspecialchars($c_info_title) ?></h3>
                
                <div class="info-row">
                    <i class="fas fa-building text-orange"></i>
                    <div>
                        <strong><?= htmlspecialchars(get_setting('contact_company')) ?></strong><br>
                        Reg kood: <?= htmlspecialchars(get_setting('contact_reg')) ?><br>
                        KMK nr: <?= htmlspecialchars(get_setting('contact_kmk')) ?>
                    </div>
                </div>

                <div class="info-row">
                    <i class="fas fa-phone-alt text-orange"></i>
                    <div>
                        <strong><?= htmlspecialchars($c_phone) ?></strong><br>
                        <a href="tel:<?= htmlspecialchars(get_setting('footer_phone')) ?>"><?= htmlspecialchars(get_setting('footer_phone')) ?></a>
                    </div>
                </div>

                <div class="info-row">
                    <i class="fas fa-envelope text-orange"></i>
                    <div>
                        <strong>E-mail:</strong><br>
                        <a href="mailto:<?= htmlspecialchars(get_setting('footer_email')) ?>"><?= htmlspecialchars(get_setting('footer_email')) ?></a>
                    </div>
                </div>

                <div class="info-row">
                    <i class="fas fa-map-marker-alt text-orange"></i>
                    <div>
                        <strong><?= htmlspecialchars($c_address) ?></strong><br>
                        <?= htmlspecialchars($display_address) ?>
                    </div>
                </div>

                <div class="info-row">
                    <i class="fas fa-university text-orange"></i>
                    <div>
                        <strong><?= htmlspecialchars($c_bank) ?></strong><br>
                        a/a Swedbank <?= htmlspecialchars(get_setting('contact_bank')) ?><br>
                        SWIFT/BIC: <?= htmlspecialchars(get_setting('contact_swift')) ?>
                    </div>
                </div>

                <div class="info-row" style="margin-top: 30px; padding-top: 20px; border-top: 1px dashed #e2e8f0;">
                    <i class="far fa-clock text-orange"></i>
                    <div>
                        <strong><?= htmlspecialchars($c_hours) ?></strong><br>
                        <span style="color: #f36f21; font-weight: bold;"><?= htmlspecialchars($display_hours) ?></span>
                    </div>
                </div>
            </div>

            <div class="contact-form-box">
                <h3 class="box-title"><?= htmlspecialchars($lang['form_title'] ?? 'Saada päring') ?></h3>
                <p style="color: #718096; margin-bottom: 25px; font-size: 15px;"><?= htmlspecialchars($c_desc) ?></p>
                
                <form method="POST" action="">
                    <div class="form-group">
                        <label><?= htmlspecialchars($lang['form_email'] ?? 'Sinu e-mail *') ?></label>
                        <input type="email" name="email" required placeholder="nimi@email.ee">
                    </div>
                    <div class="form-group">
                        <label><?= htmlspecialchars($lang['form_subject'] ?? 'Teema *') ?></label>
                        <input type="text" name="pealkiri" required placeholder="">
                    </div>
                    <div class="form-group">
                        <label><?= htmlspecialchars($lang['form_message'] ?? 'Sõnum *') ?></label>
                        <textarea name="tekst" required placeholder="..."></textarea>
                    </div>
                    <button type="submit" name="send_query" class="btn-submit"><?= htmlspecialchars($lang['form_send'] ?? 'SAADA KIRI') ?> <i class="fas fa-paper-plane" style="margin-left: 8px;"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
/* Стили остаются без изменений, они отличные */
.contact-page-wrapper { padding: 130px 20px 80px 20px; background-color: #fcfcfc; min-height: 60vh;}
.breadcrumbs { margin-bottom: 25px; font-size: 14px; color: #888; }
.breadcrumbs a { color: #f36f21; text-decoration: none; font-weight: 600; }
.page-title { color: #222; font-size: 32px; font-weight: 900; margin-top: 0; margin-bottom: 40px; text-transform: uppercase; position: relative; padding-bottom: 15px; }
.page-title::after { content: ""; position: absolute; left: 0; bottom: 0; width: 60px; height: 4px; background: #f36f21; border-radius: 2px; }
.contact-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; }
.contact-info-box, .contact-form-box { background: #fff; padding: 40px; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.04); border: 1px solid #edf2f7; }
.box-title { margin-top: 0; margin-bottom: 30px; font-size: 22px; color: #2d3748; border-bottom: 2px solid #edf2f7; padding-bottom: 15px; }
.info-row { display: flex; align-items: flex-start; margin-bottom: 20px; font-size: 16px; color: #4a5568; line-height: 1.6; }
.info-row i { font-size: 20px; width: 35px; margin-top: 4px; }
.text-orange { color: #f36f21; }
.info-row a { color: #3182ce; text-decoration: none; font-weight: 500; }
.info-row a:hover { text-decoration: underline; }
.form-group { margin-bottom: 20px; }
.form-group label { display: block; font-size: 13px; font-weight: 700; color: #4a5568; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
.contact-form-box input, .contact-form-box textarea { width: 100%; padding: 15px; border: 1px solid #cbd5e0; border-radius: 8px; font-family: inherit; font-size: 15px; transition: 0.2s; box-sizing: border-box; background: #f8fafc; }
.contact-form-box input:focus, .contact-form-box textarea:focus { border-color: #f36f21; outline: none; background: #fff; box-shadow: 0 0 0 3px rgba(243, 111, 33, 0.1); }
.contact-form-box textarea { height: 140px; resize: vertical; }
.btn-submit { width: 100%; background: #f36f21; color: white; border: none; padding: 18px; font-size: 16px; font-weight: 800; border-radius: 8px; cursor: pointer; text-transform: uppercase; transition: 0.3s; letter-spacing: 1px; }
.btn-submit:hover { background: #d95d16; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(243, 111, 33, 0.25); }
.alert-success { background: #def7ec; border: 1px solid #31c48d; color: #03543f; padding: 18px 20px; border-radius: 8px; margin-bottom: 30px; font-weight: 600; display: flex; align-items: center; gap: 10px; font-size: 16px; }
@media (max-width: 900px) { .contact-layout { grid-template-columns: 1fr; } .contact-page-wrapper { padding-top: 100px; } }
</style>

<?php include 'includes/footer.php'; ?>
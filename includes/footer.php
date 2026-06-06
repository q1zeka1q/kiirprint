<?php
// Безопасная функция для получения настроек через PDO
if (!function_exists('get_setting')) {
    function get_setting($key) {
        global $pdo; // Используем глобальный объект PDO
        $stmt = $pdo->prepare("SELECT config_value FROM settings WHERE config_key = :key");
        $stmt->execute(['key' => $key]);
        return $stmt->fetchColumn() ?: '';
    }
}

$lang_suffix = (isset($current_lang) && $current_lang != 'et') ? '_' . $current_lang : '';

$footer_about = get_setting('footer_about' . $lang_suffix) ?: get_setting('footer_about');
$footer_address = get_setting('footer_address' . $lang_suffix) ?: get_setting('footer_address');

$f_contacts = $lang['footer_contacts'] ?? 'Kontaktid';
$f_links = $lang['footer_links'] ?? 'Kiirlingid';
$f_rights = $lang['footer_rights'] ?? 'Kõik õigused kaitstud.';
$f_home = $lang['menu_home'] ?? 'Avaleht';
$f_products = $lang['menu_products'] ?? 'Tooted';
$f_contact_menu = $lang['menu_contact'] ?? 'Kontaktid';
?>

<footer class="site-footer">
    <div class="container footer-grid">
        <div class="footer-col">
            <h4>Kiirprint OÜ</h4>
            <div class="accent-line-footer"></div>
            <p class="about-text">
                <?= nl2br(htmlspecialchars($footer_about)) ?>
            </p>
        </div>

        <div class="footer-col">
            <h4><?= htmlspecialchars($f_contacts) ?></h4>
            <div class="accent-line-footer"></div>
            <ul class="contact-list">
                <li><i class="fas fa-envelope"></i> 
                    <a href="mailto:<?= htmlspecialchars(get_setting('footer_email')) ?>">
                        <?= htmlspecialchars(get_setting('footer_email')) ?>
                    </a>
                </li>
                <li><i class="fas fa-phone-alt"></i> 
                    <a href="tel:<?= htmlspecialchars(get_setting('footer_phone')) ?>">
                        <?= htmlspecialchars(get_setting('footer_phone')) ?>
                    </a>
                </li>
                <li><i class="fas fa-map-marker-alt"></i> 
                    <span><?= htmlspecialchars($footer_address) ?></span>
                </li>
            </ul>
        </div>

        <div class="footer-col">
            <h4><?= htmlspecialchars($f_links) ?></h4>
            <div class="accent-line-footer"></div>
            <ul class="links-list">
                <li><a href="/kiirprint/index.php"><i class="fas fa-chevron-right"></i> <?= htmlspecialchars($f_home) ?></a></li>
                <li><a href="/kiirprint/tooted.php"><i class="fas fa-chevron-right"></i> <?= htmlspecialchars($f_products) ?></a></li>
                <li><a href="/kiirprint/kontaktid.php"><i class="fas fa-chevron-right"></i> <?= htmlspecialchars($f_contact_menu) ?></a></li>
            </ul>
        </div>
    </div>
    
    <div class="footer-bottom">
        <div class="container">
            &copy; <?= date("Y") ?> Kiirprint OÜ. <?= htmlspecialchars($f_rights) ?>
        </div>
    </div>
</footer>
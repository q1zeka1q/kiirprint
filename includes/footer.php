<?php
// Умная логика для вывода текстов из базы данных
$lang_suffix = (isset($current_lang) && $current_lang != 'et') ? '_' . $current_lang : '';

// Берем перевод "О нас", если его нет - берем эстонский
$footer_about = get_setting('footer_about' . $lang_suffix);
if (empty($footer_about)) { $footer_about = get_setting('footer_about'); }

// Берем перевод "Адреса", если его нет - берем эстонский
$footer_address = get_setting('footer_address' . $lang_suffix);
if (empty($footer_address)) { $footer_address = get_setting('footer_address'); }

// Безопасные переменные для статических заголовков (если забыл добавить в словарь)
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
                <?php echo nl2br(htmlspecialchars($footer_about)); ?>
            </p>
        </div>

        <div class="footer-col">
            <h4><?php echo htmlspecialchars($f_contacts); ?></h4>
            <div class="accent-line-footer"></div>
            <ul class="contact-list">
                <li>
                    <i class="fas fa-envelope"></i> 
                    <a href="mailto:<?php echo htmlspecialchars(get_setting('footer_email')); ?>"><?php echo htmlspecialchars(get_setting('footer_email')); ?></a>
                </li>
                <li>
                    <i class="fas fa-phone-alt"></i> 
                    <a href="tel:<?php echo htmlspecialchars(get_setting('footer_phone')); ?>"><?php echo htmlspecialchars(get_setting('footer_phone')); ?></a>
                </li>
                <li>
                    <i class="fas fa-map-marker-alt"></i> 
                    <span><?php echo htmlspecialchars($footer_address); ?></span>
                </li>
            </ul>
        </div>

        <div class="footer-col">
            <h4><?php echo htmlspecialchars($f_links); ?></h4>
            <div class="accent-line-footer"></div>
            <ul class="links-list">
                <li><a href="/kiirprint/index.php"><i class="fas fa-chevron-right"></i> <?php echo htmlspecialchars($f_home); ?></a></li>
                <li><a href="/kiirprint/tooted.php"><i class="fas fa-chevron-right"></i> <?php echo htmlspecialchars($f_products); ?></a></li>
                <li><a href="/kiirprint/kontaktid.php"><i class="fas fa-chevron-right"></i> <?php echo htmlspecialchars($f_contact_menu); ?></a></li>
            </ul>
        </div>

    </div>
    
    <div class="footer-bottom">
        <div class="container">
            &copy; <?php echo date("Y"); ?> Kiirprint OÜ. <?php echo htmlspecialchars($f_rights); ?>
        </div>
    </div>
</footer>

<style>
/* ОСНОВНОЙ СТИЛЬ ФУТЕРА */
.site-footer {
    background-color: #2c2c2c;
    color: #a0aec0;
    font-family: 'Segoe UI', system-ui, sans-serif;
    margin-top: 60px;
    padding-top: 60px;
}

.footer-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 40px;
    margin-bottom: 50px;
}

.footer-col h4 {
    color: #ffffff;
    font-size: 18px;
    margin-bottom: 12px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.accent-line-footer {
    width: 40px;
    height: 3px;
    background: #f36f21;
    margin-bottom: 20px;
    border-radius: 2px;
}

.about-text {
    font-size: 14px;
    line-height: 1.7;
    color: #cbd5e0;
}

/* СПИСКИ И ССЫЛКИ */
.footer-col ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-col ul li {
    margin-bottom: 15px;
    font-size: 14px;
    line-height: 1.5;
    display: flex;
    align-items: flex-start;
    gap: 12px;
    color: #cbd5e0;
}

.footer-col ul li i {
    color: #f36f21;
    margin-top: 4px;
    font-size: 14px;
}

.footer-col a {
    color: #cbd5e0;
    text-decoration: none;
    transition: all 0.3s ease;
}

/* Эффекты при наведении (только для обычных ссылок) */
.links-list a {
    display: inline-flex;
    align-items: center;
    gap: 8px;
}
.links-list a i {
    font-size: 10px;
    transition: transform 0.3s;
}

.footer-col a:hover {
    color: #f36f21;
}
.links-list a:hover i {
    transform: translateX(5px); /* Стрелочка уезжает вправо при наведении */
}

/* НИЖНЯЯ ПОЛОСА С КОПИРАЙТОМ */
.footer-bottom {
    background-color: #1f1f1f;
    padding: 20px 0;
    text-align: center;
    font-size: 13px;
    color: #718096;
    border-top: 1px solid #333;
}

/* МОБИЛЬНАЯ АДАПТАЦИЯ */
@media (max-width: 768px) {
    .site-footer { padding-top: 40px; }
    .footer-grid { gap: 30px; margin-bottom: 30px; }
    .footer-col { text-align: center; }
    .accent-line-footer { margin: 0 auto 20px auto; }
    .footer-col ul li { justify-content: center; }
}
</style>

</body>
</html>
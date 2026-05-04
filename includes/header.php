<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/kiirprint/css/style.css">
    <?php
    // --- УМНОЕ SEO ДЛЯ ГЛАВНОЙ СТРАНИЦЫ И САЙТА ---
    $seo_lang = isset($current_lang) ? $current_lang : 'et';

    // Базовый URL вашего сайта (поменяй, если домен другой)
    $site_url = 'https://kiirprint.ee/kiirprint';
    $current_url = $site_url . $_SERVER['REQUEST_URI'];

    $seo_data = [
        'et' => [
            'title' => 'Kiirprint - Sinu usaldusväärne trükikoda | Trükiteenused',
            'desc' => 'Kvaliteetsed trükiteenused kiirelt ja soodsalt. Visiitkaardid, flaierid, brošüürid, plakatid ja palju muud. Telli trükised mugavalt veebist!'
        ],
        'ru' => [
            'title' => 'Kiirprint - Быстрая типография и полиграфия | Печать на заказ',
            'desc' => 'Профессиональные типографские услуги по выгодным ценам. Печать визиток, флаеров, брошюр и плакатов. Быстрое выполнение заказов!'
        ],
        'en' => [
            'title' => 'Kiirprint - Fast & Reliable Printing House | Print Services',
            'desc' => 'High-quality printing services at competitive prices. Business cards, flyers, brochures, posters, and more. Order prints online easily!'
        ],
        'fi' => [
            'title' => 'Kiirprint - Luotettava painotalo | Painopalvelut',
            'desc' => 'Laadukkaat painopalvelut nopeasti ja edullisesti. Käyntikortit, esitteet, flyerit ja julisteet. Tilaa painotuotteet helposti netistä!'
        ]
    ];

    // Получаем данные для текущего языка
    $seo_title = isset($seo_data[$seo_lang]['title']) ? $seo_data[$seo_lang]['title'] : $seo_data['et']['title'];
    $seo_desc = isset($seo_data[$seo_lang]['desc']) ? $seo_data[$seo_lang]['desc'] : $seo_data['et']['desc'];
    ?>

    <title><?= htmlspecialchars($seo_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($seo_desc) ?>">
    <meta name="keywords" content="trükikoda, типография, printing house, painotalo, visiitkaardid, flaierid, trükiteenused">

    <meta property="og:title" content="<?= htmlspecialchars($seo_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($seo_desc) ?>">
    <meta property="og:url" content="<?= htmlspecialchars($current_url) ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Kiirprint">

    <link rel="alternate" hreflang="et" href="<?= $site_url ?>/?lang=et" />
    <link rel="alternate" hreflang="ru" href="<?= $site_url ?>/?lang=ru" />
    <link rel="alternate" hreflang="en" href="<?= $site_url ?>/?lang=en" />
    <link rel="alternate" hreflang="fi" href="<?= $site_url ?>/?lang=fi" />
    <link rel="alternate" hreflang="x-default" href="<?= $site_url ?>/" /> 
</head>
<body>

<div class="fixed-header-wrapper">
    <header class="site-header">
        <div class="container header-flex">
            <div class="logo">
                <a href="/kiirprint/index.php">
                    <img src="/kiirprint/img/logo.jpg" alt="Kiirprint.ee" class="logo-img">
                </a>
            </div>

            <button class="menu-toggle" id="mobile-menu-btn">
                <i class="fas fa-bars"></i>
            </button>

            <nav class="main-nav" id="main-nav">
                <ul>
                    <li><a href="/kiirprint/index.php"><?= isset($lang['menu_home']) ? htmlspecialchars($lang['menu_home']) : 'AVALEHT' ?></a></li>
                    
<?php
                    $l = isset($current_lang) ? $current_lang : 'et';

                    
                    $mega_items = [
                        ['et' => 'Blanketid', 'ru' => 'Бланки', 'en' => 'Letterheads', 'fi' => 'Lomakkeet', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=43'],
                        ['et' => 'Brošüürid', 'ru' => 'Брошюры', 'en' => 'Brochures', 'fi' => 'Esitteet', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=38'],
                        ['et' => 'Bännerid', 'ru' => 'Баннеры', 'en' => 'Banners', 'fi' => 'Banderollit', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=35'],
                        ['et' => 'CD ümbrised', 'ru' => 'Обложки для CD', 'en' => 'CD covers', 'fi' => 'CD-kannet', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=33'],
                        ['et' => 'Diplomid', 'ru' => 'Дипломы', 'en' => 'Diplomas', 'fi' => 'Diplomat', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=43'],
                        ['et' => 'Doorhangerid', 'ru' => 'Хенгеры на дверь', 'en' => 'Door hangers', 'fi' => 'Ovikyltit', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=33'],
                        ['et' => 'Erikujulised trükised', 'ru' => 'Нестандартная полиграфия', 'en' => 'Custom shaped prints', 'fi' => 'Erikoismuotoiset painotuotteet', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=33'],
                        ['et' => 'Eripaberid', 'ru' => 'Специальная бумага', 'en' => 'Special papers', 'fi' => 'Erikoispaperit', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=29'],
                        ['et' => 'Etiketid', 'ru' => 'Этикетки', 'en' => 'Labels', 'fi' => 'Etiketit', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=41'],
                        ['et' => 'Flaierid', 'ru' => 'Флаеры', 'en' => 'Flyers', 'fi' => 'Lentolehtiset', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=43'],
                        ['et' => 'Hinnakirjad', 'ru' => 'Прайс-листы', 'en' => 'Price lists', 'fi' => 'Hinnastot', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=43'],
                        ['et' => 'Hinnasildid', 'ru' => 'Ценники', 'en' => 'Price tags', 'fi' => 'Hintalaput', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=29'],
                        ['et' => 'Kaelakaardid', 'ru' => 'Бейджи', 'en' => 'ID badges', 'fi' => 'Nimikortit', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=29'],
                        ['et' => 'Kalendrid', 'ru' => 'Календари', 'en' => 'Calendars', 'fi' => 'Kalenterit', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=30'],
                        ['et' => 'Kammköide', 'ru' => 'Пластиковая пружина', 'en' => 'Comb binding', 'fi' => 'Kierresidonta', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=38'],
                        ['et' => 'KAPA', 'ru' => 'Пенокартон (KAPA)', 'en' => 'Foam board (KAPA)', 'fi' => 'KAPA-levyt', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=32'],
                        ['et' => 'Kasutusjuhendid', 'ru' => 'Инструкции', 'en' => 'User manuals', 'fi' => 'Käyttöohjeet', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=38'],
                        ['et' => 'Kataloogid', 'ru' => 'Каталоги', 'en' => 'Catalogs', 'fi' => 'Luettelot', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=38'],
                        ['et' => 'Kinkekaardid', 'ru' => 'Подарочные карты', 'en' => 'Gift cards', 'fi' => 'Lahjakortit', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=34'],
                        ['et' => 'Klamberköide', 'ru' => 'Скрепка (переплет)', 'en' => 'Staple binding', 'fi' => 'Vihkosidonta', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=38'],
                        ['et' => 'Kleebised', 'ru' => 'Наклейки', 'en' => 'Stickers', 'fi' => 'Tarrat', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=41'],
                        ['et' => 'Kliendikaardid', 'ru' => 'Карты клиента', 'en' => 'Customer cards', 'fi' => 'Asiakaskortit', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=34'],
                        ['et' => 'Kutsed', 'ru' => 'Приглашения', 'en' => 'Invitations', 'fi' => 'Kutsut', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=34'],
                        ['et' => 'Laiformaat tooted', 'ru' => 'Широкоформатная печать', 'en' => 'Large format products', 'fi' => 'Suurkuvatulosteet', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=35'],
                        ['et' => 'Lauakalendrid', 'ru' => 'Настольные календари', 'en' => 'Desk calendars', 'fi' => 'Pöytäkalenterit', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=30'],
                        ['et' => 'Lauarääkijad', 'ru' => 'Тейбл-тенты', 'en' => 'Table tents', 'fi' => 'Pöytäkolmiot', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=37'],
                        ['et' => 'Lipud', 'ru' => 'Флаги', 'en' => 'Flags', 'fi' => 'Liput', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=36'],
                        ['et' => 'Menüüd', 'ru' => 'Меню', 'en' => 'Menus', 'fi' => 'Ruokalistat', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=31'],
                        ['et' => 'Messiseinad', 'ru' => 'Выставочные стенды', 'en' => 'Exhibition walls', 'fi' => 'Messuseinät', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=36'],
                        ['et' => 'Märkmikud', 'ru' => 'Блокноты', 'en' => 'Notebooks', 'fi' => 'Muistikirjat', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=38'],
                        ['et' => 'Numereerimine', 'ru' => 'Нумерация', 'en' => 'Numbering', 'fi' => 'Numerointi', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=29'],
                        ['et' => 'Pakendid', 'ru' => 'Упаковка', 'en' => 'Packaging', 'fi' => 'Pakkaukset', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=33'],
                        ['et' => 'Personaliseerimine', 'ru' => 'Персонализация', 'en' => 'Personalization', 'fi' => 'Personointi', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=29'],
                        ['et' => 'Piletid', 'ru' => 'Билеты', 'en' => 'Tickets', 'fi' => 'Pääsyliput', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=29'],
                        ['et' => 'Plaadid', 'ru' => 'Таблички на пластике', 'en' => 'Printed boards', 'fi' => 'Kyltit ja levyt', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=32'],
                        ['et' => 'Plakatid alates A2', 'ru' => 'Плакаты от A2', 'en' => 'Posters from A2', 'fi' => 'Julisteet alk. A2', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=42'],
                        ['et' => 'Plakatid kuni A3', 'ru' => 'Плакаты до A3', 'en' => 'Posters up to A3', 'fi' => 'Julisteet A3 asti', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=43'],
                        ['et' => 'Postkaardid', 'ru' => 'Открытки', 'en' => 'Postcards', 'fi' => 'Postikortit', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=34'],
                        ['et' => 'Põrandakleebised', 'ru' => 'Напольные наклейки', 'en' => 'Floor stickers', 'fi' => 'Lattiatarrat', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=35'],
                        ['et' => 'Raamatud', 'ru' => 'Книги', 'en' => 'Books', 'fi' => 'Kirjat', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=38'],
                        ['et' => 'Riiulirääkijad', 'ru' => 'Шелфтокеры', 'en' => 'Shelf talkers', 'fi' => 'Hyllypuhujat', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=37'],
                        ['et' => 'Roll-upid', 'ru' => 'Roll-up стенды', 'en' => 'Roll-ups', 'fi' => 'Roll-upit', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=36'],
                        ['et' => 'Sildid', 'ru' => 'Вывески и таблички', 'en' => 'Signs', 'fi' => 'Opasteet', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=41'],
                        ['et' => 'Sleevid', 'ru' => 'Шуберы (Сливы)', 'en' => 'Sleeves', 'fi' => 'Vyötteet', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=33'],
                        ['et' => 'Šokolaadi karbid', 'ru' => 'Коробки для шоколада', 'en' => 'Chocolate boxes', 'fi' => 'Suklaarasiat', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=33'],
                        ['et' => 'Tension seinad', 'ru' => 'Натяжные стенды', 'en' => 'Tension walls', 'fi' => 'Kangasseinät', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=36'],
                        ['et' => 'Tootekataloogid', 'ru' => 'Каталоги товаров', 'en' => 'Product catalogs', 'fi' => 'Tuoteluettelot', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=38'],
                        ['et' => 'Tooteümbrised', 'ru' => 'Упаковка для товаров', 'en' => 'Product wraps', 'fi' => 'Tuotekääreet', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=33'],
                        ['et' => 'Tänukirjad', 'ru' => 'Благодарственные письма', 'en' => 'Thank you letters', 'fi' => 'Kiitoskirjeet', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=43'],
                        ['et' => 'Ukse- ja aknakleebised', 'ru' => 'Наклейки на окна и двери', 'en' => 'Door & window stickers', 'fi' => 'Ovi- ja ikkunatarrat', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=35'],
                        ['et' => 'Visiitkaardid', 'ru' => 'Визитки', 'en' => 'Business cards', 'fi' => 'Käyntikortit', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=40'],
                        ['et' => 'Wobblerid', 'ru' => 'Воблеры', 'en' => 'Wobblers', 'fi' => 'Hyllyheilujat', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=37'],
                        ['et' => 'Voldikud', 'ru' => 'Буклеты', 'en' => 'Folders / Brochures', 'fi' => 'Taitteet', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=39'],
                        ['et' => 'Ümbrikud', 'ru' => 'Конверты', 'en' => 'Envelopes', 'fi' => 'Kirjekuoret', 'url' => 'https://kiirprint.ee/kiirprint/tooted/toode.php?id=29']
                    ];
                    
                    $columns = array_chunk($mega_items, ceil(count($mega_items) / 4));
                    ?>

                    <li class="products-dropdown">
                            <a href="/kiirprint/tooted.php?lang=<?= $l ?>" class="products-link">
                                <span class="prod-text-link"><?= isset($lang['menu_products']) ? htmlspecialchars($lang['menu_products']) : 'TOOTED' ?></span> 
                                <i class="fas fa-chevron-down arrow-prod"></i>
                            </a>
                        <div class="mega-menu">
                            <?php foreach ($columns as $column): ?>
                                <div class="mega-column">
                                    <?php foreach ($column as $item): ?>
                                        <?php 
                                       
                                        $link = $item['url'];
                                        if ($link !== '#') {
                                            $separator = (strpos($link, '?') !== false) ? '&' : '?';
                                            $final_link = $link . $separator . "lang=" . $l;
                                        } else {
                                            $final_link = "javascript:void(0)";
                                        }
                                        ?>
                                        <a href="<?= htmlspecialchars($final_link) ?>"><?= htmlspecialchars($item[$l]) ?></a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </li>
                    <li><a href="/kiirprint/nouded.php"><?= isset($lang['menu_requirements']) ? htmlspecialchars($lang['menu_requirements']) : 'NÕUDED FAILIDELE' ?></a></li>
                    <li><a href="/kiirprint/kontaktid.php"><?= isset($lang['menu_contact']) ? htmlspecialchars($lang['menu_contact']) : 'KONTAKTID' ?></a></li>
                    <li><a href="/kiirprint/admin/admin.php" class="admin-link"><i class="fas fa-lock"></i> ADMIN</a></li>

                    <li class="social-icon">
                        <a href="https://www.facebook.com/Kiirprint.ee" target="_blank" rel="noopener noreferrer" title="Jälgi meid Facebookis">
                            <i class="fab fa-facebook"></i>
                        </a>
                    </li>

                    <?php
                    // Умная генерация ссылок, чтобы не терялся ?id=... при смене языка
                    $q_et = $_GET; $q_et['lang'] = 'et';
                    $q_ru = $_GET; $q_ru['lang'] = 'ru';
                    $q_en = $_GET; $q_en['lang'] = 'en';
                    $q_fi = $_GET; $q_fi['lang'] = 'fi';
                    ?>
                    <li class="lang-dropdown">
                        <a href="javascript:void(0)" class="lang-current">
                            <i class="fas fa-globe"></i> <?= isset($current_lang) ? strtoupper($current_lang) : 'ET' ?> <i class="fas fa-chevron-down arrow"></i>
                        </a>
                        <ul class="lang-menu">
                            <li><a href="?<?= http_build_query($q_et) ?>" class="<?= (isset($current_lang) && $current_lang == 'et') ? 'active-lang' : '' ?>">Eesti (EST)</a></li>
                            <li><a href="?<?= http_build_query($q_ru) ?>" class="<?= (isset($current_lang) && $current_lang == 'ru') ? 'active-lang' : '' ?>">Русский (RUS)</a></li>
                            <li><a href="?<?= http_build_query($q_en) ?>" class="<?= (isset($current_lang) && $current_lang == 'en') ? 'active-lang' : '' ?>">English (ENG)</a></li>
                            <li><a href="?<?= http_build_query($q_fi) ?>" class="<?= (isset($current_lang) && $current_lang == 'fi') ? 'active-lang' : '' ?>">Suomi (FIN)</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="orange-bar">
        <div class="container">
            <i class="fas fa-bolt" style="margin-right: 8px;"></i> <?= isset($lang['header_promo']) ? htmlspecialchars($lang['header_promo']) : 'KIIRED JA KVALITEETSED TRÜKISED OTSE TOOTJALT' ?>
        </div>
    </div>
</div>

<style>
/* Обнуление базовых отступов */
* { margin: 0; padding: 0; box-sizing: border-box; }

body { 
    font-family: 'Segoe UI', system-ui, sans-serif; 
    padding-top: 120px; 
    background-color: #fcfcfc;
}

.container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }

.fixed-header-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

.site-header {
    background-color: #ffffff;
    padding: 15px 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header-flex { display: flex; justify-content: space-between; align-items: center; width: 100%; }
.logo-img { height: 50px; width: auto; display: block; transition: transform 0.3s ease; }
.logo a:hover img { transform: scale(1.05); }

.main-nav ul { list-style: none; display: flex; gap: 35px; margin: 0; align-items: center; }
.main-nav ul li { position: relative; } 

.main-nav ul li > a {
    color: #333333;
    text-decoration: none;
    font-weight: 650;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 1px;
    position: relative;
    padding: 10px 0;
    transition: color 0.3s;
    display: flex;
    align-items: center;
    gap: 6px;
}

/* Линия подчеркивания для главных ссылок (кроме кнопки админа, языков и выпадающего меню товаров) */
.main-nav ul li:not(.products-dropdown):not(.lang-dropdown):not(.social-icon) > a::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 2px;
    background-color: #f36f21;
    transition: width 0.3s ease;
}
.main-nav ul li:not(.products-dropdown):not(.lang-dropdown):not(.social-icon) > a:hover { color: #f36f21; }
.main-nav ul li:not(.products-dropdown):not(.lang-dropdown):not(.social-icon) > a:hover::after { width: 100%; }

.admin-link { color: #888 !important; }
.admin-link:hover { color: #f36f21 !important; }

.social-icon { margin-left: 10px; margin-right: -10px; }
.social-icon a {
    color: #1877F2 !important;
    font-size: 22px !important;
    padding: 0 !important;
    transition: transform 0.3s ease !important;
}
.social-icon a:hover { transform: scale(1.2); color: #0d5cb8 !important; }

/* === MEGA MENU "TOOTED" === */
.products-link .arrow-prod { font-size: 10px; transition: transform 0.3s; }
.products-dropdown:hover .products-link .arrow-prod { transform: rotate(180deg); }
.products-dropdown:hover .products-link { color: #f36f21; }

.mega-menu {
    position: absolute;
    top: 100%;
    left: -150px; /* Чтобы меню не улетало за правый край экрана */
    background: #ffffff;
    min-width: 950px; /* Широкое окно для 4 колонок */
    border-radius: 8px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.12);
    display: flex;
    gap: 10px; /* Немного уменьшили отступ между колонками */
    padding: 25px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(15px);
    transition: all 0.3s ease;
    z-index: 100;
    border: 1px solid #edf2f7;
}

.products-dropdown:hover .mega-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(10px);
}

.mega-column {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.mega-column a {
    color: #4a5568 !important;
    text-transform: none !important;
    font-size: 13px !important; 
    font-weight: 500 !important;
    padding: 5px 10px !important;
    border-radius: 4px;
    transition: all 0.2s !important;
}

.mega-column a:hover {
    color: #f36f21 !important;
    background: #fff5f0;
    padding-left: 15px !important; /* Легкий сдвиг вправо при наведении */
}

/* === ВЫПАДАЮЩЕЕ МЕНЮ ЯЗЫКОВ === */
.lang-dropdown { margin-left: 15px; }

.lang-current {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 12px !important;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.lang-current:hover { background: #f8fafc; border-color: #cbd5e0; }
.lang-current .arrow { font-size: 10px; transition: transform 0.3s; }
.lang-dropdown:hover .lang-current .arrow { transform: rotate(180deg); } 

.lang-menu {
    position: absolute;
    top: 100%; 
    right: 0;
    background: #ffffff;
    min-width: 140px;
    border-radius: 8px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.10);
    display: flex;
    flex-direction: column !important;
    gap: 0 !important;
    padding: 10px 0 !important;
    opacity: 0;
    visibility: hidden;
    transform: translateY(10px);
    transition: all 0.3s ease;
    z-index: 100;
    border: 1px solid #edf2f7;
}

.lang-dropdown:hover .lang-menu { opacity: 1; visibility: visible; transform: translateY(5px); }

.lang-menu li { width: 100%; }
.lang-menu a {
    color: #4a5568 !important;
    padding: 10px 20px !important;
    display: block;
    text-transform: none !important;
    font-weight: 500 !important;
    letter-spacing: 0 !important;
    font-size: 14px !important;
}

.lang-menu a:hover { background: #fff5f0; color: #f36f21 !important; }
.active-lang { color: #f36f21 !important; font-weight: bold !important; background: #fff5f0; }

.orange-bar { background-color: #f36f21; color: #ffffff; text-align: center; padding: 12px 0; font-weight: 700; font-size: 13px; letter-spacing: 1.5px; text-transform: uppercase; display: flex; align-items: center; justify-content: center; }

.menu-toggle { display: none; background: transparent; border: none; color: #333333; font-size: 26px; cursor: pointer; transition: color 0.3s; }
.menu-toggle:hover { color: #f36f21; }

/* === АДАПТАЦИЯ ДЛЯ ПЛАНШЕТОВ (iPad и средние экраны от 769px до 1150px) === */
@media (max-width: 1150px) and (min-width: 769px) {
    .site-header { padding: 15px 20px; }
    .main-nav ul { gap: 12px; } /* Уменьшаем огромные отступы с 35px до 12px */
    .main-nav ul li > a { font-size: 12px; letter-spacing: 0.5px; } /* Чуть уменьшаем шрифт */
    .lang-dropdown { margin-left: 0; }
    .lang-current { padding: 6px 10px !important; }
    .social-icon { margin-left: 5px; margin-right: 0; }
}

/* МОБИЛЬНАЯ АДАПТАЦИЯ */
@media (max-width: 768px) {
    .menu-toggle { display: block; }

    .main-nav {
        position: absolute;
        top: 80px; 
        left: 0;
        width: 100%;
        background-color: #ffffff;
        border-top: 1px solid #edf2f7;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease-out;
    }

    .main-nav.active { max-height: 80vh; box-shadow: 0 10px 20px rgba(0,0,0,0.1); overflow-y: auto; }

    .main-nav ul { flex-direction: column; gap: 0; padding: 0; }
    .main-nav ul li { width: 100%; text-align: left; } /* Выравнивание влево на мобилках */
    
    .main-nav ul li > a { 
        display: flex; 
        justify-content: space-between;
        padding: 15px 20px; 
        font-size: 16px; 
        border-bottom: 1px solid #edf2f7; 
        color: #333333;
    }
    
    /* Mega Menu на мобилках превращается в аккордеон */
    .mega-menu {
        position: static;
        min-width: 100%;
        box-shadow: none;
        padding: 0;
        background: #f8fafc;
        border: none;
        border-radius: 0;
        display: none;
        flex-direction: column;
        gap: 0;
        opacity: 1;
        visibility: visible;
        transform: none;
    }

    .products-dropdown.open .mega-menu { display: flex; }
    .products-dropdown.open .arrow-prod { transform: rotate(180deg); }

    .mega-column { gap: 0; }
    .mega-column a {
        padding: 12px 20px 12px 40px !important; /* Отступ слева, чтобы было видно иерархию */
        border-bottom: 1px solid #edf2f7;
        border-radius: 0;
    }

    .social-icon { margin: 0; padding: 10px 0; border-bottom: 1px solid #edf2f7; display: flex; justify-content: center; }
    .social-icon a { font-size: 28px !important; }

    .lang-dropdown { margin: 0; }
    .lang-current { justify-content: center; border: none; padding: 15px !important; border-top: none; border-radius: 0; }
    
    .lang-menu {
        position: static; opacity: 1; visibility: visible; transform: none; box-shadow: none;
        background: #f8fafc; border-radius: 0; display: none !important; border: none;
    }

    .lang-dropdown.open .lang-menu { display: flex !important; }
    .lang-menu a { color: #4a5568 !important; border-bottom: 1px solid #edf2f7; text-align: center; }

    .orange-bar { font-size: 11px; padding: 10px 0; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuBtn = document.getElementById('mobile-menu-btn');
    const nav = document.getElementById('main-nav');
    const icon = menuBtn.querySelector('i');

    // Бургер меню
    menuBtn.addEventListener('click', function() {
        nav.classList.toggle('active');
        if (nav.classList.contains('active')) {
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times');
        } else {
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        }
    });

    // Логика аккордеонов на мобильных (Для "TOOTED" и "ЯЗЫКОВ")
    if (window.innerWidth <= 768) {
        
        // Товары
        const prodLink = document.querySelector('.products-link');
        const prodDropdown = document.querySelector('.products-dropdown');
        if(prodLink && prodDropdown) {
            prodLink.addEventListener('click', function(e) {
                // Если кликнули прямо по самому слову (тексту)
                if (e.target.closest('.prod-text-link')) {
                    return; // Ссылка срабатывает как обычно, переходим на страницу!
                }
                // Если кликнули по пустой области или стрелочке - открываем меню
                e.preventDefault();
                prodDropdown.classList.toggle('open');
            });
        }

        // Языки
        const langCurrent = document.querySelector('.lang-current');
        const langDropdown = document.querySelector('.lang-dropdown');
        if(langCurrent && langDropdown) {
            langCurrent.addEventListener('click', function(e) {
                e.preventDefault();
                langDropdown.classList.toggle('open');
            });
        }
    }
});
</script>
</body>
</html>
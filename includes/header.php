<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiirprint.ee - Sinu usaldusväärne trükipartner</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/kiirprint/css/style.css"> 
</head>
<body>

<div class="fixed-header-wrapper">
    <header class="site-header">
        <div class="container header-flex">
            <div class="logo">
                <a href="/kiirprint/index.php">
                    <img src="/kiirprint/img/logo.png" alt="Kiirprint.ee">
                </a>
            </div>

            <button class="menu-toggle" id="mobile-menu-btn">
                <i class="fas fa-bars"></i>
            </button>

            <nav class="main-nav" id="main-nav">
                <ul>
                    <li><a href="/kiirprint/index.php"><?= isset($lang['menu_home']) ? htmlspecialchars($lang['menu_home']) : 'AVALEHT' ?></a></li>
                    <li><a href="/kiirprint/tooted.php"><?= isset($lang['menu_products']) ? htmlspecialchars($lang['menu_products']) : 'TOOTED' ?></a></li>
                    <li><a href="/kiirprint/tooted.php"><?= isset($lang['menu_requirements']) ? htmlspecialchars($lang['menu_requirements']) : 'NÕUDED FAILIDELE' ?></a></li>
                    <li><a href="/kiirprint/kontaktid.php"><?= isset($lang['menu_contact']) ? htmlspecialchars($lang['menu_contact']) : 'KONTAKTID' ?></a></li>
                    <li><a href="/kiirprint/admin/admin.php" class="admin-link"><i class="fas fa-lock"></i> ADMIN</a></li>

                    <?php
                    // Умная генерация ссылок, чтобы не терялся ?id=... при смене языка
                    $q_et = $_GET; $q_et['lang'] = 'et';
                    $q_ru = $_GET; $q_ru['lang'] = 'ru';
                    $q_en = $_GET; $q_en['lang'] = 'en';
                    $q_fi = $_GET; $q_fi['lang'] = 'fi';
                    ?>
                    <li class="lang-dropdown">
                        <a href="javascript:void(0)" class="lang-current">
                            <i class="fas fa-globe"></i> <?= strtoupper($current_lang) ?> <i class="fas fa-chevron-down arrow"></i>
                        </a>
                        <ul class="lang-menu">
                            <li><a href="?<?= http_build_query($q_et) ?>" class="<?= $current_lang == 'et' ? 'active-lang' : '' ?>">Eesti (EST)</a></li>
                            <li><a href="?<?= http_build_query($q_ru) ?>" class="<?= $current_lang == 'ru' ? 'active-lang' : '' ?>">Русский (RUS)</a></li>
                            <li><a href="?<?= http_build_query($q_en) ?>" class="<?= $current_lang == 'en' ? 'active-lang' : '' ?>">English (ENG)</a></li>
                            <li><a href="?<?= http_build_query($q_fi) ?>" class="<?= $current_lang == 'fi' ? 'active-lang' : '' ?>">Suomi (FIN)</a></li>
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

/* ФИКСАЦИЯ ШАПКИ */
.fixed-header-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

/* ОСНОВНАЯ ШАПКА */
.site-header {
    background-color: #2c2c2c;
    height: 80px;
    display: flex;
    align-items: center;
}

.header-flex {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}

.logo img {
    max-height: 50px;
    vertical-align: middle;
    transition: transform 0.3s ease;
}
.logo a:hover img { transform: scale(1.05); }

/* МЕНЮ ДЛЯ КОМПЬЮТЕРОВ */
.main-nav ul {
    list-style: none;
    display: flex;
    gap: 35px;
    margin: 0;
    align-items: center;
}

.main-nav ul li { position: relative; } /* Нужно для выпадающего меню */

.main-nav ul li a {
    color: #ffffff;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 1px;
    position: relative;
    padding: 10px 0;
    transition: color 0.3s;
}

.main-nav ul li a::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 2px;
    background-color: #f36f21;
    transition: width 0.3s ease;
}
.main-nav ul li a:hover { color: #f36f21; }
.main-nav ul li a:hover::after { width: 100%; }

.admin-link { color: #888 !important; }
.admin-link:hover { color: #fff !important; }
.admin-link::after { display: none; } 

/* === ВЫПАДАЮЩЕЕ МЕНЮ ЯЗЫКОВ === */
.lang-dropdown {
    margin-left: 15px;
}

.lang-current {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #f36f21 !important; /* Оранжевый акцент */
    padding: 10px 15px !important;
    border: 1px solid #444;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.lang-current::after { display: none !important; } /* Убираем нижнюю полосу */
.lang-current:hover { background: #333; border-color: #555; }
.lang-current .arrow { font-size: 10px; transition: transform 0.3s; }
.lang-dropdown:hover .lang-current .arrow { transform: rotate(180deg); } /* Стрелочка крутится */

/* Само выпадающее меню */
.lang-menu {
    position: absolute;
    top: 100%; /* Сразу под кнопкой */
    right: 0;
    background: #ffffff;
    min-width: 140px;
    border-radius: 8px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    display: flex;
    flex-direction: column !important;
    gap: 0 !important;
    padding: 10px 0 !important;
    opacity: 0;
    visibility: hidden;
    transform: translateY(10px);
    transition: all 0.3s ease;
    z-index: 100;
}

/* Показываем при наведении */
.lang-dropdown:hover .lang-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(5px);
}

.lang-menu li { width: 100%; }

.lang-menu a {
    color: #333 !important;
    padding: 10px 20px !important;
    display: block;
    text-transform: none !important;
    font-weight: 500 !important;
    letter-spacing: 0 !important;
    font-size: 14px !important;
}

.lang-menu a::after { display: none !important; }
.lang-menu a:hover { background: #f8fafc; color: #f36f21 !important; }

/* Подсветка активного языка */
.active-lang {
    color: #f36f21 !important;
    font-weight: bold !important;
    background: #fff5f0;
}


/* ОРАНЖЕВАЯ ПОЛОСА */
.orange-bar {
    background-color: #f36f21;
    color: #ffffff;
    text-align: center;
    padding: 12px 0;
    font-weight: 700;
    font-size: 13px;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* КНОПКА МЕНЮ */
.menu-toggle {
    display: none;
    background: transparent;
    border: none;
    color: #fff;
    font-size: 26px;
    cursor: pointer;
    transition: color 0.3s;
}
.menu-toggle:hover { color: #f36f21; }

/* МОБИЛЬНАЯ АДАПТАЦИЯ */
@media (max-width: 768px) {
    .menu-toggle { display: block; }

    .main-nav {
        position: absolute;
        top: 80px; 
        left: 0;
        width: 100%;
        background-color: #2c2c2c;
        border-top: 1px solid #444;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease-out;
    }

    .main-nav.active {
        max-height: 500px; /* Увеличили высоту для языков */
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        overflow-y: auto;
    }

    .main-nav ul {
        flex-direction: column;
        gap: 0;
        padding: 10px 0 20px 0;
    }

    .main-nav ul li { width: 100%; text-align: center; }
    .main-nav ul li a { display: block; padding: 15px 20px; font-size: 16px; border-bottom: 1px solid #333;}
    .main-nav ul li a::after { display: none; } 

    /* Языки на мобильном */
    .lang-dropdown { margin: 15px 0 0 0; }
    .lang-current { justify-content: center; border: none; padding: 15px !important; border-top: 1px solid #444; }
    
    .lang-menu {
        position: static;
        opacity: 1;
        visibility: visible;
        transform: none;
        box-shadow: none;
        background: #222;
        border-radius: 0;
        display: none !important; /* Прячем по умолчанию на мобильном */
    }

    /* Раскрываем список при клике на мобильном */
    .lang-dropdown.open .lang-menu { display: flex !important; }
    .lang-menu a { color: #aaa !important; border-bottom: 1px solid #333; }
    .lang-menu a:hover, .active-lang { background: #1a1a1a; color: #f36f21 !important; }

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

    // Логика выпадающего списка языков на телефоне
    const langDropdown = document.querySelector('.lang-dropdown');
    const langCurrent = document.querySelector('.lang-current');

    if (window.innerWidth <= 768) {
        langCurrent.addEventListener('click', function(e) {
            e.preventDefault();
            langDropdown.classList.toggle('open');
        });
    }
});
</script>
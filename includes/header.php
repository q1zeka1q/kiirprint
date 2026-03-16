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
                    <img src="/kiirprint/img/logo.jpg" alt="Kiirprint.ee" class="logo-img">
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
    background-color: #ffffff; /* Белый фон */
    padding: 15px 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header-flex {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}

.logo-img {
    height: 50px; 
    width: auto;
    display: block;
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

.main-nav ul li { position: relative; } 

.main-nav ul li a {
    color: #333333; /* ТЕМНЫЙ ТЕКСТ НА БЕЛОМ ФОНЕ */
    text-decoration: none;
    font-weight: 650;
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
.admin-link:hover { color: #f36f21 !important; }
.admin-link::after { display: none; } 

/* === ВЫПАДАЮЩЕЕ МЕНЮ ЯЗЫКОВ === */
.lang-dropdown { margin-left: 15px; }

.lang-current {
    display: flex;
    align-items: center;
    gap: 6px;
    /*color: #f36f21 !important;*/
    padding: 8px 12px !important;
    border: 1px solid #e2e8f0; /* Светлая рамка */
    border-radius: 6px;
    transition: all 0.3s ease;
}

.lang-current::after { display: none !important; } 
.lang-current:hover { background: #f8fafc; border-color: #cbd5e0; }
.lang-current .arrow { font-size: 10px; transition: transform 0.3s; }
.lang-dropdown:hover .lang-current .arrow { transform: rotate(180deg); } 

/* Само выпадающее меню */
.lang-menu {
    position: absolute;
    top: 100%; 
    right: 0;
    background: #ffffff;
    min-width: 140px;
    border-radius: 8px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.10); /* Более мягкая тень */
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

.lang-dropdown:hover .lang-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(5px);
}

.lang-menu li { width: 100%; }

.lang-menu a {
    color: #4a5568 !important; /* Темно-серый цвет языков */
    padding: 10px 20px !important;
    display: block;
    text-transform: none !important;
    font-weight: 500 !important;
    letter-spacing: 0 !important;
    font-size: 14px !important;
}

.lang-menu a::after { display: none !important; }
.lang-menu a:hover { background: #fff5f0; color: #f36f21 !important; }

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

/* КНОПКА МЕНЮ (МОБИЛЬНАЯ) */
.menu-toggle {
    display: none;
    background: transparent;
    border: none;
    color: #333333; /* Темная иконка для белого фона */
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
        background-color: #ffffff; /* Белое меню на мобилках */
        border-top: 1px solid #edf2f7;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease-out;
    }

    .main-nav.active {
        max-height: 500px; 
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        overflow-y: auto;
    }

    .main-nav ul {
        flex-direction: column;
        gap: 0;
        padding: 0; /* Убрал лишние отступы */
    }

    .main-nav ul li { width: 100%; text-align: center; }
    .main-nav ul li a { 
        display: block; 
        padding: 15px 20px; 
        font-size: 16px; 
        border-bottom: 1px solid #edf2f7; /* Светлые разделители */
        color: #333333;
    }
    .main-nav ul li a::after { display: none; } 

    /* Языки на мобильном */
    .lang-dropdown { margin: 0; }
    .lang-current { justify-content: center; border: none; padding: 15px !important; border-top: 1px solid #edf2f7; border-radius: 0; }
    
    .lang-menu {
        position: static;
        opacity: 1;
        visibility: visible;
        transform: none;
        box-shadow: none;
        background: #f8fafc; /* Чуть серее фон для подменю */
        border-radius: 0;
        display: none !important; 
        border: none;
    }

    .lang-dropdown.open .lang-menu { display: flex !important; }
    .lang-menu a { color: #4a5568 !important; border-bottom: 1px solid #edf2f7; }
    .lang-menu a:hover, .active-lang { background: #fff5f0; color: #f36f21 !important; }

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
</body>
</html>
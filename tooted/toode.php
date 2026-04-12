<?php 
require_once '../includes/config.php';

// Страховочный массив словаря (если ключей еще нет в файлах lang/et.php и т.д.)
if (!isset($lang)) {
    $lang = [
        'menu_home' => 'Avaleht',
        'product_not_found' => 'Toodet ei leitud',
        'ask_quote_title' => 'Küsi pakkumist',
        'ask_quote_text' => 'Selle toote puhul arvutame hinna personaalselt, vastavalt sinu soovidele.',
        'form_send' => 'SAADA PÄRING'
    ];
}

include '../includes/header.php'; 

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
// Берем все данные
$res = $conn->query("SELECT * FROM services WHERE id = $id");
$s = $res->fetch_assoc();

if (!$s) {
    // Безопасный вывод: если перевода нет, пишем по-эстонски
    $error_msg = $lang['product_not_found'] ?? 'Toodet ei leitud';
    echo "<div class='container' style='padding:100px 20px; text-align:center;'><h1>" . htmlspecialchars($error_msg) . "</h1></div>";
    include '../includes/footer.php';
    exit;
}

// --- УМНАЯ ЛОГИКА ДЛЯ ВЫВОДА ТОВАРА ---
$lang_suffix = ($current_lang == 'et') ? '' : '_' . $current_lang;

// Берем перевод. Если он пустой, подставляем эстонский оригинал, чтобы не было пустот.
$display_title = !empty($s['title' . $lang_suffix]) ? $s['title' . $lang_suffix] : $s['title'];
$display_desc = !empty($s['description' . $lang_suffix]) ? $s['description' . $lang_suffix] : $s['description'];
// --------------------------------------
?>

<div class="product-page-wrapper">
    <div class="container">
        
        <div class="breadcrumbs">
            <a href="../index.php"><?= htmlspecialchars($lang['menu_home']) ?></a> <i class="fas fa-chevron-right"></i> 
            <span><?php echo htmlspecialchars(mb_strtoupper($display_title)); ?></span>
        </div>

        <div class="product-layout">
            
            <div class="content-side">
                <h1 class="product-title"><?php echo htmlspecialchars(mb_strtoupper($display_title)); ?></h1>
                
                <div class="description-area">
                    <?php if(!empty($s['image_url'])): ?>
                        <div class="image-wrapper-left">
                            <img src="../img/<?php echo htmlspecialchars($s['image_url']); ?>" alt="<?php echo htmlspecialchars($display_title); ?>">
                        </div>
                    <?php endif; ?>

                    <div class="full-text">
                        <?php echo $display_desc; ?>
                    </div>
                    
                    <div style="clear: both;"></div> 
                </div>


                    <?php 
                    // Показывать для товара 15 И ТОЛЬКО если текущий язык эстонский ('et')
                    if ($s['id'] == 30 && $current_lang == 'et'): 
                    ?>
                <div class="product-gallery">
                    <div class="gallery-item">
                        <img src="../img/k1.jpg" alt="Kalender 1">
                    </div>
                    <div class="gallery-item">
                        <img src="../img/k2.jpg" alt="Kalender 2">
                    </div>
                    <div class="gallery-item">
                        <img src="../img/k3.jpg" alt="Kalender 3">
                    </div>
                    <div class="gallery-item">
                        <img src="../img/k4.jpg" alt="Kalender 3">
                    </div>
                </div>
                <?php endif; ?>

                <?php if ($s['calc_type'] == 'rollup'): ?>
                <div class="product-gallery">
                    <div class="gallery-item">
                        <img src="../img/Roll-up_classic1.jpg" alt="Roll-up Classic">
                    </div>
                    <div class="gallery-item">
                        <img src="../img/hof_fabric_tension_wall_10ft_1.png" alt="Tekstiilist sein">
                    </div>
                    <div class="gallery-item">
                        <img src="../img/Surf.jpg" alt="Surf Lipp">
                    </div>
                    <div class="gallery-item">
                        <img src="../img/Ranna.jpg" alt="Rannalipp">
                    </div>
                </div>
                <?php endif; ?>

            </div> <div class="sidebar-side">
                <div class="calc-box-styled">
                    <div class="calc-accent"></div>
                    
<?php 
                    $type = trim($s['calc_type']);
                    
                    // 1. Определяем правильный путь к файлу
                    if ($type == 'no_calc.php' || $type == 'no_calc') {
                        $calc_file = "calcs/no_calc.php";
                    } else {
                        $calc_file = "calcs/" . $type . "_calc.php";
                    }

                    // 2. Проверяем файл и подключаем его
                    if (!empty($type) && $type !== 'none' && file_exists($calc_file)) {
                        include $calc_file;
                    } else {
                        // Если файла нет или тип 'none' - показываем стандартную форму запроса
                        // Проверяем, есть ли у нас no_calc.php как запасной вариант
                        if (file_exists("calcs/no_calc.php")) {
                            include "calcs/no_calc.php";
                        } else {
                            // Если и файла нет, выводим старый добрый текст
                            $title = $lang['ask_quote_title'] ?? 'Küsi pakkumist';
                            $text = $lang['ask_quote_text'] ?? 'Selle toote puhul arvutame hinna personaalselt, vastavalt sinu soovidele.';
                            $btn = $lang['form_send'] ?? 'SAADA PÄRING';
                            
                            echo "<h3 style='color:#333; margin-top:0; font-weight:800;'>" . htmlspecialchars($title) . "</h3>";
                            echo "<p style='font-size:15px; color:#666; line-height:1.5; margin-bottom: 20px;'>" . htmlspecialchars($text) . "</p>";
                            echo "<a href='../kontaktid.php' class='orange-action-btn'>" . htmlspecialchars($btn) . "</a>";
                        }
                    }
                    ?>
                </div>
            </div> </div> </div>
</div>

<style>
/* Общая обертка */
.product-page-wrapper {
    padding: 130px 20px 80px 20px;
    background-color: #fcfcfc;
}

/* Навигация (хлебные крошки) */
.breadcrumbs {
    margin-bottom: 25px;
    font-size: 14px;
    color: #888;
}
.full-text strong {
    font-weight: 800;
    color: #000000;
}
.breadcrumbs a {
    color: #f36f21;
    text-decoration: none;
    font-weight: 600;
    transition: 0.2s;
}
.breadcrumbs a:hover { color: #d95d16; }
.breadcrumbs i { font-size: 10px; margin: 0 8px; color: #ccc; }
.breadcrumbs span { color: #555; font-weight: 500; }

/* Сетка (Layout) */
.product-layout { display: flex; gap: 40px; align-items: flex-start; }
.content-side { flex: 1.5; min-width: 0; }
.sidebar-side { flex: 1; min-width: 350px; }

/* Заголовок с оранжевым подчеркиванием */
.product-title { 
    color: #222;
    font-size: 32px; 
    font-weight: 900; 
    margin-top: 0;
    margin-bottom: 30px; 
    text-transform: uppercase;
    position: relative;
    padding-bottom: 15px;
}
.product-title::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: 0;
    width: 60px;
    height: 4px;
    background: #f36f21;
    border-radius: 2px;
}

/* Обтекание картинки */
.image-wrapper-left {
    float: left;
    width: 45%;
    max-width: 450px;
    margin-right: 35px;
    margin-bottom: 25px;
}
.image-wrapper-left img { 
    width: 100%; 
    height: auto; 
    border-radius: 12px; 
    box-shadow: 0 8px 25px rgba(0,0,0,0.08); 
}

/* Текст описания */
.full-text {
    line-height: 1.8;
    color: #4a4a4a;
    font-size: 16px;
    text-align: left;
}

/* Карточка калькулятора */
.calc-box-styled {
    background: #fff;
    padding: 35px;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.05);
    position: sticky;
    top: 100px;
    overflow: hidden;
}
.calc-accent {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 5px;
    background: linear-gradient(90deg, #f36f21, #ff985c);
}

/* Кнопка действия */
.orange-action-btn {
    display: block;
    background: #f36f21;
    color: #fff;
    text-align: center;
    padding: 16px;
    text-decoration: none;
    border-radius: 8px;
    font-weight: bold;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.orange-action-btn:hover { 
    background: #d95d16; 
    transform: translateY(-2px); 
    box-shadow: 0 5px 15px rgba(243, 111, 33, 0.3);
    color: #fff; 
}

/* --- СТИЛИ ДЛЯ ГАЛЕРЕИ ROLL-UP --- */
.product-gallery {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
    margin-top: 40px; 
}

.gallery-item {
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
    border: 1px solid #edf2f7;
    background: #f8fafc; /* Легкий приятный фон для пустых краев */
    aspect-ratio: 1 / 1; /* Сделаем карточки квадратными — это идеальный компромисс для высоких и широких картинок */
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 15px; /* Даем картинке немного "воздуха" вокруг */
}

.gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: contain; /* ГЛАВНАЯ МАГИЯ: картинка больше не обрезается, а вписывается целиком! */
    display: block;
    transition: transform 0.3s ease;
}

.gallery-item:hover img {
    transform: scale(1.05);
}
/* Стили для увеличенных картинок (Lightbox) */
.modal-lightbox {
    display: none; /* Скрыто по умолчанию */
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.85); /* Полупрозрачный черный фон */
    justify-content: center;
    align-items: center;
}

.modal-lightbox-content {
    max-width: 90%;
    max-height: 85vh;
    border-radius: 8px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.5);
    animation: zoomIn 0.3s ease; /* Плавное появление */
}

.close-lightbox {
    position: absolute;
    top: 20px;
    right: 40px;
    color: #f1f1f1;
    font-size: 50px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.close-lightbox:hover, .close-lightbox:focus {
    color: #f36f21;
    text-decoration: none;
    cursor: pointer;
}

/* Анимация появления */
@keyframes zoomIn {
    from {transform: scale(0.8); opacity: 0;}
    to {transform: scale(1); opacity: 1;}
}

/* Делаем курсор в виде "лупы" или "пальца" при наведении на картинки галереи */
.gallery-item img {
    cursor: pointer; 
}

/* Мобильная адаптация */
@media (max-width: 992px) {
    .product-layout { flex-direction: column; gap: 30px; }
    .sidebar-side { width: 100%; min-width: 100%; }
    .image-wrapper-left { width: 50%; }
    .product-page-wrapper { padding: 100px 15px 50px 15px; }
}

@media (max-width: 768px) {
    .image-wrapper-left { float: none; width: 100%; margin-right: 0; margin-bottom: 20px; }
    .product-title { font-size: 26px; }
}

@media (max-width: 600px) {
    .product-gallery {
        grid-template-columns: 1fr;
    }
}
</style>
<div id="imageModal" class="modal-lightbox">
    <span class="close-lightbox">&times;</span>
    <img class="modal-lightbox-content" id="modalImg">
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Находим наше окно и картинку внутри него
    const modal = document.getElementById("imageModal");
    const modalImg = document.getElementById("modalImg");
    const closeBtn = document.querySelector(".close-lightbox");

    // Находим все картинки в нашей галерее
    const images = document.querySelectorAll(".gallery-item img");

    if (modal && images.length > 0) {
        // Вешаем клик на каждую картинку
        images.forEach(function(img) {
            img.onclick = function() {
                modal.style.display = "flex"; // Показываем окно
                modalImg.src = this.src;      // Подставляем нужную картинку
            }
        });

        // Закрываем по клику на крестик
        closeBtn.onclick = function() {
            modal.style.display = "none";
        }

        // Закрываем по клику на темный фон
        modal.onclick = function(event) {
            if (event.target !== modalImg) {
                modal.style.display = "none";
            }
        }
    }
});
</script>
<?php include '../includes/footer.php'; ?>
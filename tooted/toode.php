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
                        <?php echo nl2br($display_desc); ?>
                    </div>
                    
                    <div style="clear: both;"></div> 
                </div>
            </div>

            <div class="sidebar-side">
                <div class="calc-box-styled">
                    <div class="calc-accent"></div>
                    
                    <?php 
                    $calc_file = "calcs/" . $s['calc_type'] . "_calc.php";
                    if (!empty($s['calc_type']) && $s['calc_type'] !== 'none' && file_exists($calc_file)) {
                        // Подключаем калькулятор (Его мы переведем следующим шагом!)
                        include $calc_file;
                        } else {
                        // Безопасный вывод без ошибок
                        $title = $lang['ask_quote_title'] ?? 'Küsi pakkumist';
                        $text = $lang['ask_quote_text'] ?? 'Selle toote puhul arvutame hinna personaalselt, vastavalt sinu soovidele.';
                        $btn = $lang['form_send'] ?? 'SAADA PÄRING';
                        
                        echo "<h3 style='color:#333; margin-top:0; font-weight:800;'>" . htmlspecialchars($title) . "</h3>";
                        echo "<p style='font-size:15px; color:#666; line-height:1.5; margin-bottom: 20px;'>" . htmlspecialchars($text) . "</p>";
                        echo "<a href='../kontaktid.php' class='orange-action-btn'>" . htmlspecialchars($btn) . "</a>";
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>
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
</style>

<?php include '../includes/footer.php'; ?>
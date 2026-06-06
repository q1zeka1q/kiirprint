<?php 
require_once 'includes/config.php';

// Убедимся, что массив $lang доступен. Если его нет, создадим запасной на эстонском, чтобы ничего не сломалось.
if (!isset($lang)) {
    $lang = [
        'products_title' => 'Meie Tooted',
        'products_subtitle' => 'Valige sobiv kategooria, et näha täpsemat infot ja arvutada hind.',
        'view_all' => 'Kõik tooted',
        'view_product' => 'Vaata tooteid',
        'no_products' => 'Tooteid pole veel lisatud.',
        'form_title' => 'Jäta meile teade või küsi pakkumist',
        'form_email' => 'Sinu E-mail *',
        'form_subject' => 'Teema *',
        'form_message' => 'Sõnum *',
        'form_send' => 'SAADA PÄRING'
    ];
}

// Функция для получения настроек (переведена на PDO)
if (!function_exists('get_setting')) {
    function get_setting($key) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT config_value FROM settings WHERE config_key = :key");
        $stmt->execute(['key' => $key]);
        $row = $stmt->fetch();
        if ($row) {
            return $row['config_value'];
        }
        return '';
    }
}

include 'includes/header.php'; 

// Берем слайды ТОЛЬКО для текущего языка сайта (PDO подготовленный запрос)
$stmt_slides = $pdo->prepare("SELECT * FROM slider WHERE lang = :lang");
$stmt_slides->execute(['lang' => $current_lang]);
$slides_res = $stmt_slides->fetchAll();

// Если клиент переключил на финский, а финских слайдов еще нет, показываем эстонские
if (count($slides_res) == 0) {
    $stmt_slides_et = $pdo->query("SELECT * FROM slider WHERE lang = 'et'");
    $slides_res = $stmt_slides_et->fetchAll();
}
?>

<main class="main-content">
    
    <div class="hero-wrapper">
        <div class="hero-slider">
           <div class="slides-container">
                    <?php 
                    $active_class = "active";
                    if ($slides_res && count($slides_res) > 0):
                        foreach($slides_res as $slide): 
                            
                            // УМНАЯ ЛОГИКА ДЛЯ СЛАЙДЕРА
                            $lang_suffix = ($current_lang == 'et') ? '' : '_' . $current_lang;
                            
                            // Берем картинку (если для текущего языка нет, берем основную image_url)
                            $display_img = !empty($slide['image' . $lang_suffix]) ? $slide['image' . $lang_suffix] : $slide['image_url'];
                            
                            // Берем ссылку
                            $display_link = !empty($slide['link' . $lang_suffix]) ? $slide['link' . $lang_suffix] : $slide['link'];
                            
                            $raw_l = trim($display_link);
                            if (empty($raw_l) || $raw_l == "#") {
                                $f_link = "javascript:void(0)";
                            } elseif (strpos($raw_l, 'http') !== false || strpos($raw_l, '.php') !== false) {
                                $f_link = $raw_l;
                            } else {
                                $f_link = "https://" . $raw_l;
                            }

                            $z_index = ($active_class == "active") ? "5" : "1";
                            $p_events = ($active_class == "active") ? "auto" : "none";
                    ?>
                       <a href="<?= $f_link ?>" class="slide-item <?= $active_class ?>" style="background-image: url('img/<?= htmlspecialchars($display_img) ?>'); z-index: <?= $z_index ?>; pointer-events: <?= $p_events ?>;">
                           <div class="slide-overlay"></div>
                        </a>
                    <?php 
                        $active_class = ""; 
                        endforeach; 
                    endif; 
                    ?>
                </div>
            <button class="nav-btn prev" onclick="moveSlide(-1)">&#10094;</button>
            <button class="nav-btn next" onclick="moveSlide(1)">&#10095;</button>
        </div>
    </div>

<section class="section-grey">
        <div class="container">
            <div class="about-content">
                <?php
                // Определяем суффикс языка (если 'et', то пусто, если другие - то '_ru', '_en', '_fi')
                $lang_suffix = ($current_lang == 'et') ? '' : '_' . $current_lang;
                
                // Пробуем получить заголовок на текущем языке
                $display_home_title = get_setting('home_title' . $lang_suffix);
                // Если пусто (перевод не заполнен), берем базовый (эстонский)
                if (empty($display_home_title)) {
                    $display_home_title = get_setting('home_title');
                }

                // Пробуем получить текст на текущем языке
                $display_home_subtitle = get_setting('home_subtitle' . $lang_suffix);
                // Если пусто, берем базовый
                if (empty($display_home_subtitle)) {
                    $display_home_subtitle = get_setting('home_subtitle');
                }
                ?>
                <h1 class="main-title"><?php echo htmlspecialchars($display_home_title); ?></h1>
                <div class="accent-line"></div>
                <p class="description">
                    <?php echo nl2br(htmlspecialchars($display_home_subtitle)); ?>
                </p>
            </div>
        </div>
    </section>

    <section class="section-white" style="padding-top: 60px; padding-bottom: 60px; background-color: #ffffff;">
        <div class="container">
            
            <div style="text-align: center; margin-bottom: 40px;">
                <h2 style="font-size: 32px; color: #2d3748; margin-bottom: 10px;"><?= htmlspecialchars($lang['products_title']) ?></h2>
                <p style="color: #718096; font-size: 16px;"><?= htmlspecialchars($lang['products_subtitle']) ?></p>
            </div>

<div class="cards-grid">
                <?php 
                // Выводим товары через PDO
                $stmt_tooted = $pdo->query("SELECT * FROM services WHERE is_visible = 1 ORDER BY id DESC LIMIT 6");
                $avaleht_tooted = $stmt_tooted->fetchAll();
                
                if ($avaleht_tooted && count($avaleht_tooted) > 0): 
                    foreach($avaleht_tooted as $service): 
                        
                        // УМНАЯ ЛОГИКА ДЛЯ ТОВАРОВ
                        $lang_suffix = ($current_lang == 'et') ? '' : '_' . $current_lang;
                        $display_title = !empty($service['title' . $lang_suffix]) ? $service['title' . $lang_suffix] : $service['title'];
                ?>
                    <a href="tooted/toode.php?id=<?php echo $service['id']; ?>&lang=<?= $current_lang ?>" class="modern-card">
                        <div class="image-wrapper">
                            <?php if(!empty($service['image_url'])): ?>
                                <img src="img/<?php echo htmlspecialchars($service['image_url']); ?>" alt="<?php echo htmlspecialchars($display_title); ?>">
                            <?php else: ?>
                                <img src="img/placeholder.png" alt="No image">
                            <?php endif; ?>
                        </div>
                        <div class="card-info">
                            <h3><?php echo htmlspecialchars(mb_strtoupper($display_title)); ?></h3>
                            <span class="more-link"><?= htmlspecialchars($lang['view_product']) ?> <i class="fas fa-arrow-right"></i></span>
                        </div>
                    </a>
                <?php 
                    endforeach; 
                else: 
                ?>
                    <p style="text-align:center; color:#888; grid-column: 1/-1; padding: 40px;"><?= htmlspecialchars($lang['no_products']) ?></p>
                <?php endif; ?>
            </div>

            <div style="text-align: center; margin-top: 50px;">
                <a href="tooted.php" style="background: #f36f21; color: white; padding: 14px 35px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 16px; box-shadow: 0 4px 10px rgba(243, 111, 33, 0.3); transition: background 0.3s;">
                    <?= htmlspecialchars($lang['view_all']) ?> <i class="fas fa-arrow-right" style="margin-left: 8px;"></i>
                </a>
            </div>

        </div>
    </section>

    <section class="section-grey border-top">
        <div class="container">
            <div class="query-container">
                <h2 class="query-title"><?= htmlspecialchars($lang['form_title']) ?></h2>
                <form action="saada_paring.php" method="POST" class="query-form">
                    <div class="form-inputs">
                        <div class="input-group">
                            <label><?= htmlspecialchars($lang['form_email']) ?></label>
                            <input type="email" name="email" placeholder="nimi@email.ee" required>
                        </div>
                        <div class="input-group">
                            <label><?= htmlspecialchars($lang['form_subject']) ?></label>
                            <input type="text" name="pealkiri" placeholder="nt: Hinnapäring" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <label><?= htmlspecialchars($lang['form_message']) ?></label>
                        <textarea name="tekst" placeholder="..." required></textarea>
                    </div>
                    <button type="submit" class="send-btn"><?= htmlspecialchars($lang['form_send']) ?> <i class="fas fa-paper-plane" style="margin-left: 8px;"></i></button>
                </form>
            </div>
        </div>
    </section>

</main>

<style>
/* ОБЩИЕ ЦВЕТОВЫЕ СЕКЦИИ */
body { background: #fcfcfc; }
.section-grey { background-color: #f8fafc; padding: 100px 0; }
.section-white { background-color: #ffffff; padding: 100px 0; }
.container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
.border-top { border-top: 1px solid #edf2f7; }

/* ТВОЙ ОРИГИНАЛЬНЫЙ СЛАЙДЕР */
.hero-slider { position: relative; width: 100%; height: 500px; overflow: hidden; background: #e2e8f0; }
.slide-item { position: absolute; width: 100%; height: 100%; background-size: cover; background-position: center; opacity: 0; transition: opacity 0.8s ease-in-out; }
.slide-item.active { opacity: 1; }
.slide-overlay { position: absolute; top:0; left:0; width:100%; height:100%; background: linear-gradient(to top, rgba(0,0,0,0.1), transparent); }

/* ТВОИ ОРИГИНАЛЬНЫЕ КНОПКИ СЛАЙДЕРА */
.nav-btn { 
    position: absolute; 
    top: 50%; 
    transform: translateY(-50%); 
    z-index: 20; 
    background: rgba(255,255,255,0.8);
    border: none; 
    width: 60px;
    height: 60px;
    border-radius: 50%; 
    cursor: pointer; 
    transition: all 0.3s; 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    color: #4a5568; 
    font-size: 32px;
    font-weight: bold;
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
}
.nav-btn:hover { 
    background: #f36f21; 
    color: white;
    transform: translateY(-50%) scale(1.1); 
    box-shadow: 0 6px 20px rgba(243, 111, 33, 0.4); 
}
.next { right: 30px; } 
.prev { left: 30px; }

/* ABOUT SECTION */
.about-content { text-align: center; max-width: 850px; margin: 0 auto; }
.main-title { color: #2d3748; font-size: 2.5rem; margin-bottom: 20px; font-weight: 900; letter-spacing: -0.5px; }
.accent-line { width: 80px; height: 4px; background: #f36f21; margin: 0 auto 30px; border-radius: 2px; }
.description { color: #4a5568; font-size: 1.15rem; line-height: 1.8; font-weight: 400; }

/* CARDS LAYOUT */
.cards-grid { 
    display: grid; 
    grid-template-columns: repeat(3, 1fr); 
    gap: 30px; 
}

.modern-card {
    background-color: #ffffff;
    text-decoration: none;
    display: block;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid #edf2f7;
}

.modern-card:hover { 
    transform: translateY(-8px); 
    box-shadow: 0 15px 35px rgba(0,0,0,0.12); 
    border-color: #f36f21;
}

.image-wrapper { 
    height: 240px; 
    width: 100%;
    overflow: hidden; 
    background: #f8fafc;
}

.image-wrapper img { 
    width: 100%; 
    height: 100%; 
    object-fit: cover; 
    display: block;
    transition: transform 0.5s ease; 
}

.modern-card:hover .image-wrapper img { 
    transform: scale(1.05); 
}

.card-info {
    padding: 25px 20px;
    text-align: center;
}

.card-info h3 {
    margin: 0 0 15px 0;
    color: #2d3748;
    font-size: 18px;
    font-weight: 800;
    letter-spacing: 0.5px;
}

.more-link {
    color: #f36f21;
    font-weight: 700;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* QUERY SECTION */
.query-container { max-width: 700px; margin: 0 auto; background: #fff; padding: 50px; border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.05); border: 1px solid #edf2f7; }
.query-title { text-align: center; margin-top: 0; margin-bottom: 35px; font-size: 1.8rem; color: #2d3748; font-weight: 800; }
.form-inputs { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
.input-group { margin-bottom: 20px; }
.input-group label { display: block; font-size: 13px; font-weight: 700; color: #4a5568; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
.query-form input, .query-form textarea { width: 100%; padding: 16px; border: 1px solid #cbd5e0; border-radius: 8px; font-family: inherit; font-size: 15px; background: #f8fafc; transition: 0.2s; box-sizing: border-box; }
.query-form input:focus, .query-form textarea:focus { border-color: #f36f21; outline: none; background: #fff; box-shadow: 0 0 0 3px rgba(243, 111, 33, 0.1); }
.query-form textarea { height: 140px; resize: vertical; }
.send-btn { width: 100%; background: #f36f21; color: white; border: none; padding: 18px; font-weight: 800; border-radius: 8px; cursor: pointer; transition: all 0.3s; font-size: 16px; text-transform: uppercase; letter-spacing: 1px; display: flex; align-items: center; justify-content: center; }
.send-btn:hover { background: #d95d16; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(243, 111, 33, 0.25); }

/* МОБИЛЬНАЯ АДАПТАЦИЯ */
@media (max-width: 768px) {
    .hero-wrapper { display: none; }
    .section-grey { 
        min-height: 60vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 80px 15px 40px 15px;
        background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%); 
        border-bottom: 1px solid #e2e8f0; 
    } 
    .about-content { width: 100%; text-align: center; }
    .main-title { 
        font-size: 2.2rem; 
        line-height: 1.2;
        color: #1a202c; 
        margin-bottom: 15px;
    }
    .accent-line { width: 60px; margin: 0 auto 25px auto; }
    .description { font-size: 1.1rem; line-height: 1.6; color: #4a5568; padding: 0 10px; }
    .section-white { padding: 60px 0; }
    .cards-grid { grid-template-columns: 1fr !important; gap: 20px; }
    .image-wrapper { height: 240px; }
    .form-inputs { grid-template-columns: 1fr; gap: 0; }
    .query-container { padding: 35px 20px; border-radius: 12px; }
    .query-title { font-size: 1.6rem; line-height: 1.3; margin-bottom: 25px; }
}
</style>

<script>
let cur = 0; 
const slides = document.querySelectorAll('.slide-item');

function updateSlides(n) { 
    if(!slides.length) return;
    
    slides.forEach(s => {
        s.classList.remove('active');
        s.style.zIndex = "1";            
        s.style.pointerEvents = "none";    
    }); 
    
    cur = (n + slides.length) % slides.length; 
    
    slides[cur].classList.add('active'); 
    slides[cur].style.zIndex = "5";        
    slides[cur].style.pointerEvents = "auto"; 
}

function moveSlide(n) { updateSlides(cur + n); }
setInterval(() => moveSlide(1), 6000);
</script>

<?php include 'includes/footer.php'; ?>
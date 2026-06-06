<?php 
require_once 'includes/config.php';

// Страховочный массив на случай, если словари еще не полностью заполнены
if (!isset($lang)) {
    $lang = [
        'menu_home' => 'Avaleht',
        'menu_products' => 'Tooted',
        'products_title' => 'Meie Tooted',
        'products_subtitle' => 'Valige sobiv kategooria, et näha täpsemat infot ja arvutada hind.',
        'view_product' => 'Vaata tooteid',
        'no_products' => 'Tooteid pole veel lisatud.',
        // Добавленные переводы для формы
        'form_title' => 'Jäta meile teade või küsi pakkumist',
        'form_email' => 'Sinu E-mail *',
        'form_subject' => 'Teema *',
        'form_message' => 'Sõnum *',
        'form_send' => 'SAADA PÄRING'
    ];
}

include 'includes/header.php'; 

// --- ПЕРЕВОД НА PDO ---
$stmt_services = $pdo->query("SELECT * FROM services WHERE is_visible = 1 ORDER BY id DESC");
$services_res = $stmt_services->fetchAll();
?>

<main class="main-content">
    
    <section class="page-header-section">
        <div class="container">
            <div class="breadcrumbs">
                <a href="index.php"><?= htmlspecialchars($lang['menu_home']) ?></a> <i class="fas fa-chevron-right"></i> 
                <span><?= htmlspecialchars($lang['menu_products']) ?></span>
            </div>

            <h1 class="page-title"><?= htmlspecialchars($lang['products_title']) ?></h1>
            <p class="page-subtitle"><?= htmlspecialchars($lang['products_subtitle']) ?></p>
        </div>
    </section>

    <section class="section-white">
        <div class="container">
            <div class="cards-grid">
                
                <?php if ($services_res && count($services_res) > 0): ?>
                    <?php foreach($services_res as $service): 
                        
                        // --- УМНАЯ ЛОГИКА ДЛЯ ТОВАРОВ ---
                        $lang_suffix = ($current_lang == 'et') ? '' : '_' . $current_lang;
                        // Если перевод есть - берем его, если пусто - берем эстонский
                        $display_title = !empty($service['title' . $lang_suffix]) ? $service['title' . $lang_suffix] : $service['title'];
                        // --------------------------------
                    ?>
                        
                        <a href="tooted/toode.php?id=<?php echo $service['id']; ?>" class="modern-card">
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

                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align:center; color:#888; grid-column: 1/-1; padding: 40px;"><?= htmlspecialchars($lang['no_products']) ?></p>
                <?php endif; ?>

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
/* ОБЩИЕ СЕКЦИИ */
body { background: #fcfcfc; }
.container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }

/* ШАПКА СТРАНИЦЫ */
.page-header-section { 
    background-color: #f8fafc; 
    padding: 100px 0 60px 0; 
    border-bottom: 1px solid #edf2f7; 
}
.breadcrumbs { 
    margin-bottom: 20px; 
    font-size: 14px; 
    color: #a0aec0; 
    display: flex;
    align-items: center;
    gap: 8px;
}
.breadcrumbs a { color: #f36f21; text-decoration: none; font-weight: 600; transition: 0.2s; }
    .breadcrumbs a:hover { color: #d95d16; }
.breadcrumbs i { font-size: 10px; }
.breadcrumbs span { color: #4a5568; font-weight: 500; }

.page-title { 
    color: #2d3748; 
    font-size: 2.8rem; 
    margin: 0 0 15px 0; 
    font-weight: 900; 
    letter-spacing: -0.5px; 
    position: relative;
    padding-bottom: 15px;
}
.page-title::after { 
    content: ""; 
    position: absolute; 
    left: 0; 
    bottom: 0; 
    width: 60px; 
    height: 4px; 
    background: #f36f21; 
    border-radius: 2px; 
}
.page-subtitle { 
    color: #718096; 
    font-size: 1.15rem; 
    margin: 0; 
    line-height: 1.6;
}

/* CARDS GRID (Сетка товаров) */
.section-white { background-color: #ffffff; padding: 80px 0; min-height: 50vh;}
.cards-grid { 
    display: grid; 
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); 
    gap: 40px; 
    justify-content: center; 
}

/* ДИЗАЙН КАРТОЧКИ */
.modern-card { 
    background: #fff; 
    border-radius: 16px; 
    border: 1px solid #edf2f7; 
    text-decoration: none; 
    transition: all 0.4s ease; 
    overflow: hidden; 
    box-shadow: 0 4px 20px rgba(0,0,0,0.03); 
    display: flex;
    flex-direction: column;
}
.modern-card:hover { 
    transform: translateY(-8px); 
    box-shadow: 0 15px 35px rgba(0,0,0,0.08); 
    border-color: #f36f21; 
}
.image-wrapper { 
    height: 240px; 
    padding: 30px; 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    background: #fff; 
    overflow: hidden;
}
.image-wrapper img { 
    max-height: 100%; 
    max-width: 100%; 
    object-fit: contain; 
    transition: transform 0.5s ease;
}
.modern-card:hover .image-wrapper img {
    transform: scale(1.05);
}

.card-info { 
    padding: 25px; 
    text-align: center; 
    background: #f8fafc; 
    border-top: 1px solid #edf2f7; 
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.card-info h3 { 
    margin: 0 0 15px 0; 
    color: #2d3748; 
    font-size: 1.25rem; 
    font-weight: 800;
    letter-spacing: 0.5px;
}
.more-link { 
    color: #f36f21; 
    font-weight: 700; 
    font-size: 14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    text-transform: uppercase;
    transition: 0.3s;
}
.modern-card:hover .more-link {
    gap: 12px; 
}

/* ФОРМА (Секция) */
.section-grey { background-color: #f8fafc; padding: 100px 0; }
.border-top { border-top: 1px solid #edf2f7; }

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
    .page-header-section { padding: 80px 0 40px 0; text-align: center; }
    .page-title { font-size: 2.2rem; }
    .page-title::after { left: 50%; transform: translateX(-50%); }
    .breadcrumbs { justify-content: center; }
    
    .section-white { padding: 50px 0; }
    .cards-grid { grid-template-columns: 1fr; max-width: 400px; margin: 0 auto; }

    /* ФОРМА НА МОБИЛЬНОМ */
    .form-inputs { grid-template-columns: 1fr; gap: 0; }
    .query-container { padding: 35px 20px; border-radius: 12px; }
    .query-title { font-size: 1.6rem; line-height: 1.3; margin-bottom: 25px; }
    .section-grey { padding: 60px 0; }
}
</style>

<?php include 'includes/footer.php'; ?>
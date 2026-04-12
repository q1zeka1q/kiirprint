<?php
// --- МИНИ-СЛОВАРЬ ДЛЯ ФОРМЫ ЗАПРОСА ---
$l = isset($current_lang) ? $current_lang : 'et';

$calc_lang = [
    'et' => [
        'header' => 'HINNAPÄRING',
        'intro' => 'Palun täitke vorm ja me teeme teile individuaalse pakkumise.',
        'ph_name' => 'Teie nimi *',
        'ph_email' => 'Teie e-mail *',
        'ph_phone' => 'Telefon',
        'ph_msg' => 'Kirjeldage soovi (kogus, mõõdud, materjal jne) *',
        'btn_send' => 'SAADA PÄRING',
        'success' => 'Aitäh! Teie päring on saadetud. Vastame esimesel võimalusel.'
    ],
    'ru' => [
        'header' => 'ЗАПРОС ЦЕНЫ',
        'intro' => 'Пожалуйста, заполните форму, и мы сделаем вам персональное предложение.',
        'ph_name' => 'Ваше имя *',
        'ph_email' => 'Ваш e-mail *',
        'ph_phone' => 'Телефон',
        'ph_msg' => 'Опишите запрос (кол-во, размеры, материал и т.д.) *',
        'btn_send' => 'ОТПРАВИТЬ ЗАПРОС',
        'success' => 'Спасибо! Ваш запрос отправлен. Мы ответим при первой возможности.'
    ],
    'en' => [
        'header' => 'PRICE QUOTE',
        'intro' => 'Please fill out the form for a custom quote.',
        'ph_name' => 'Your name *',
        'ph_email' => 'Your e-mail *',
        'ph_phone' => 'Phone',
        'ph_msg' => 'Describe your request (quantity, size, material etc.) *',
        'btn_send' => 'SEND REQUEST',
        'success' => 'Thank you! Your request has been sent. We will reply as soon as possible.'
    ],
    'fi' => [
        'header' => 'HINTAPYYNTÖ',
        'intro' => 'Täytä lomake saadaksesi tarjouksen.',
        'ph_name' => 'Sinun nimesi *',
        'ph_email' => 'Sähköpostisi *',
        'ph_phone' => 'Puhelin',
        'ph_msg' => 'Kuvaile pyyntösi (määrä, mitat, materiaali jne.) *',
        'btn_send' => 'LÄHETÄ PYYNTÖ',
        'success' => 'Kiitos! Pyyntösi on lähetetty. Vastaamme mahdollisimman pian.'
    ]
];

$t = isset($calc_lang[$l]) ? $calc_lang[$l] : $calc_lang['et'];

// === ОБРАБОТКА ФОРМЫ (Сохраняем прямо в таблицу paringud) ===
$success_msg = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send_custom_query'])) {
    global $conn; // Берем подключение к БД из toode.php
    
    $email = mysqli_real_escape_string($conn, $_POST['client_email']);
    $name = mysqli_real_escape_string($conn, $_POST['client_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['client_phone']);
    $msg = mysqli_real_escape_string($conn, $_POST['client_message']);
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    
    // Формируем красивый заголовок для админки, чтобы было понятно, откуда запрос
    $pealkiri = "Päring tootele: " . $product_name . " (" . $name . ")";
    
    // Формируем полный текст, добавляя туда имя и телефон
    $tekst = "Nimi: " . $name . "\nTelefon: " . $phone . "\n\nSõnum:\n" . $msg;

    // Записываем в базу
    $sql = "INSERT INTO paringud (email, pealkiri, tekst, is_read) VALUES ('$email', '$pealkiri', '$tekst', 0)";
    if ($conn->query($sql)) {
        $success_msg = $t['success'];
    }
}
?>

<div class="calc-container">
    <div class="price-box" style="margin-bottom: 25px; background: #fff8f4;">
        <div class="price-label" style="color: #f36f21; font-size: 18px;"><?= $t['header'] ?></div>
        <p style="font-size: 14px; color: #666; margin-top: 10px; line-height: 1.4;"><?= $t['intro'] ?></p>
    </div>

    <?php if($success_msg): ?>
        <div class="alert-success" style="background: #def7ec; border: 1px solid #31c48d; color: #03543f; padding: 18px 20px; border-radius: 8px; font-weight: 600; font-size: 15px; display: flex; align-items: center;">
            <i class="fas fa-check-circle" style="margin-right:10px; font-size: 20px;"></i> <?= htmlspecialchars($success_msg) ?>
        </div>
    <?php else: ?>
        <form action="" method="POST" class="order-form" style="display: block; border-top: none; padding-top: 0;">
            <input type="hidden" name="product_name" value="<?= htmlspecialchars($display_title) ?>">

            <div class="calc-group">
                <input type="text" name="client_name" class="calc-input form-spacing" placeholder="<?= $t['ph_name'] ?>" required>
            </div>
            
            <div class="calc-group">
                <input type="email" name="client_email" class="calc-input form-spacing" placeholder="<?= $t['ph_email'] ?>" required>
            </div>

            <div class="calc-group">
                <input type="text" name="client_phone" class="calc-input form-spacing" placeholder="<?= $t['ph_phone'] ?>">
            </div>

            <div class="calc-group">
                <textarea name="client_message" class="calc-input form-spacing" placeholder="<?= $t['ph_msg'] ?>" style="height:150px; resize: none;" required></textarea>
            </div>
            
            <button type="submit" name="send_custom_query" class="btn-submit"><?= $t['btn_send'] ?></button>
        </form>
    <?php endif; ?>
</div>

<style>
.calc-container { font-family: sans-serif; }
.calc-group { margin-top: 15px; }
.calc-input { 
    width: 100%; 
    padding: 14px; 
    border: 1px solid #ddd; 
    border-radius: 8px; 
    font-size: 15px; 
    box-sizing: border-box; 
    background: #fff;
    transition: 0.2s;
}
.calc-input:focus { outline: none; border-color: #f36f21; box-shadow: 0 0 0 3px rgba(243, 111, 33, 0.1); }
.price-box { padding: 25px 20px; border-radius: 12px; border: 2px solid rgba(243, 111, 33, 0.3); text-align: center; }
.btn-submit { 
    width: 100%; 
    background: #f36f21; 
    color: white; 
    border: none; 
    padding: 18px; 
    font-size: 16px; 
    font-weight: 800; 
    border-radius: 8px; 
    cursor: pointer; 
    text-transform: uppercase; 
    transition: 0.3s; 
    margin-top: 15px; 
    letter-spacing: 1px;
}
.btn-submit:hover { background: #d95d16; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(243, 111, 33, 0.25); }
</style>
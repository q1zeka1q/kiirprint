<?php
// Проверяем текущий язык сайта
$l = isset($current_lang) ? $current_lang : 'et';

// --- МИНИ-СЛОВАРЬ ДЛЯ ROLL-UP КАЛЬКУЛЯТОРА ---
$calc_lang = [
    'et' => [
        'qty' => 'Vali kogus:',
        'type' => 'Vali teenuse tüüp:',
        'type_swap' => 'Roll-up graafika vahetus',
        'type_full' => 'Roll-up komplekt graafikaga',
        'size' => 'Vali suurus:',
        'total' => 'Hind kokku (KM-ta):',
        'vat' => 'Käibemaks ei sisaldu lõpphinnas',
        'ph_name' => 'Teie nimi',
        'ph_email' => 'Teie e-mail',
        'ph_phone' => 'Telefon',
        'ph_msg' => 'Lisainfo (kuhu tarnida, erisoovid jne)',
        'btn_order' => 'TELLI KOHE',
        'btn_send' => 'SAADA TELLIMUS'
    ],
    'ru' => [
        'qty' => 'Выберите количество:',
        'type' => 'Выберите тип услуги:',
        'type_swap' => 'Замена графики Roll-up',
        'type_full' => 'Комплект Roll-up с графикой',
        'size' => 'Выберите размер:',
        'total' => 'Итого (без НДС):',
        'vat' => 'НДС не включен в стоимость',
        'ph_name' => 'Ваше имя',
        'ph_email' => 'Ваш e-mail',
        'ph_phone' => 'Телефон',
        'ph_msg' => 'Доп. инфо (куда доставить, пожелания)',
        'btn_order' => 'ЗАКАЗАТЬ СЕЙЧАС',
        'btn_send' => 'ОТПРАВИТЬ ЗАКАЗ'
    ],
    'en' => [
        'qty' => 'Select quantity:',
        'type' => 'Select service type:',
        'type_swap' => 'Roll-up graphics replacement',
        'type_full' => 'Roll-up set with graphics',
        'size' => 'Select size:',
        'total' => 'Total price (excl. VAT):',
        'vat' => 'VAT is not included in the final price',
        'ph_name' => 'Your name',
        'ph_email' => 'Your e-mail',
        'ph_phone' => 'Phone',
        'ph_msg' => 'Additional info (delivery address, requests)',
        'btn_order' => 'ORDER NOW',
        'btn_send' => 'SEND ORDER'
    ],
    'fi' => [
        'qty' => 'Valitse määrä:',
        'type' => 'Valitse palvelun tyyppi:',
        'type_swap' => 'Roll-up grafiikan vaihto',
        'type_full' => 'Roll-up setti grafiikalla',
        'size' => 'Valitse koko:',
        'total' => 'Yhteensä (alv 0%):',
        'vat' => 'ALV ei sisälly lopulliseen hintaan',
        'ph_name' => 'Sinun nimesi',
        'ph_email' => 'Sähköpostisi',
        'ph_phone' => 'Puhelin',
        'ph_msg' => 'Lisätiedot (toimitusosoite, toiveet)',
        'btn_order' => 'TILAA NYT',
        'btn_send' => 'LÄHETÄ TILAUS'
    ]
];

$t = isset($calc_lang[$l]) ? $calc_lang[$l] : $calc_lang['et'];
?>

<div class="calc-container">
    
    <div class="calc-group">
        <label class="calc-label"><?= $t['qty'] ?></label>
        <div class="qty-row">
            <input type="range" id="q_range" class="qty-range" min="1" max="50" step="1" value="1">
            <input type="number" id="q_input" class="qty-number" value="1" min="1">
        </div>
    </div>

    <div class="calc-group">
        <label class="calc-label"><?= $t['type'] ?></label>
        <div class="radio-group">
            <label><input type="radio" name="service_type" value="swap" checked> <?= $t['type_swap'] ?></label>
            <label><input type="radio" name="service_type" value="full"> <?= $t['type_full'] ?></label>
        </div>
    </div>

    <div class="calc-group">
        <label class="calc-label"><?= $t['size'] ?></label>
        <select id="rollup_size" class="calc-select">
            <option value="80" data-name="80x200cm">80 x 200 cm</option>
            <option value="85" data-name="85x200cm" selected>85 x 200 cm</option>
            <option value="100" data-name="100x200cm">100 x 200 cm</option>
            <option value="150" data-name="150x200cm">150 x 200 cm</option>
        </select>
    </div>

    <div class="price-box">
        <div class="price-label"><?= $t['total'] ?></div>
        <div class="price-value"><span id="final_price">0.00</span> €</div>
        <div class="price-vat"><?= $t['vat'] ?></div>
    </div>

<form id="orderForm" action="../submit_order.php" method="POST" class="order-form" style="display: none;">
        <input type="hidden" name="service_id" value="<?= $id ?>">
        
        <input type="hidden" name="quantity" id="hidden_qty">
        <input type="hidden" name="total_price" id="hidden_total">
        
        <input type="hidden" name="paper_type" id="hidden_options">

        <input type="text" name="client_name" class="calc-input form-spacing" placeholder="<?= $t['ph_name'] ?>" required>
        <input type="email" name="client_email" class="calc-input form-spacing" placeholder="<?= $t['ph_email'] ?>" required>
        <input type="text" name="client_phone" class="calc-input form-spacing" placeholder="<?= $t['ph_phone'] ?>" required>
        <textarea name="client_message" class="calc-input form-spacing" placeholder="<?= $t['ph_msg'] ?>" style="height:80px;"></textarea>
        
        <button type="submit" class="btn-submit"><?= $t['btn_send'] ?></button>
    </form>
    
    <button id="showOrder" class="btn-submit"><?= $t['btn_order'] ?></button>
</div>

<style>
/* Стили для калькулятора (Оригинальный дизайн) */
.calc-container { font-family: sans-serif; }
.calc-group { margin-top: 22px; }
.calc-label { font-weight: 700; display: block; margin-bottom: 8px; color: #333; font-size: 15px; }

/* Инпуты и селекты (крупные для пальцев) */
.calc-input, .calc-select { 
    width: 100%; 
    padding: 14px; 
    border: 1px solid #ddd; 
    border-radius: 8px; 
    font-size: 15px; 
    box-sizing: border-box; 
    background: #fff;
    transition: 0.2s;
}
.calc-select:focus, .calc-input:focus { outline: none; border-color: #f36f21; box-shadow: 0 0 0 3px rgba(243, 111, 33, 0.1); }

/* Ползунок и количество */
.qty-row { display: flex; align-items: center; gap: 15px; }
.qty-range { flex-grow: 1; accent-color: #f36f21; height: 6px; }
.qty-number { width: 90px; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 16px; text-align: center; box-sizing: border-box; font-weight: bold; color: #f36f21;}

/* Радиокнопки */
.radio-group label { 
    display: block; 
    padding: 12px 15px; 
    background: #fdfdfd; 
    border: 1px solid #eee; 
    border-radius: 8px; 
    margin-bottom: 8px; 
    cursor: pointer; 
    transition: 0.2s;
}
.radio-group label:hover { background: #fff8f4; border-color: #f36f21; }
.radio-group input { margin-right: 10px; accent-color: #f36f21; transform: scale(1.2); }

/* Блок цены */
.price-box { margin-top: 35px; padding: 25px 20px; background: #fff8f4; border-radius: 12px; border: 2px solid rgba(243, 111, 33, 0.3); text-align: center; }
.price-label { font-size: 13px; color: #666; text-transform: uppercase; letter-spacing: 0.5px; font-weight: bold;}
.price-value { font-size: 38px; font-weight: 900; color: #f36f21; margin: 10px 0; }
.price-vat { font-size: 12px; color: #999; }

/* Форма и кнопки */
.order-form { margin-top: 20px; border-top: 2px dashed #eee; padding-top: 25px; }
.form-spacing { margin-bottom: 12px; }
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

/* МОБИЛЬНАЯ ВЕРСИЯ КАЛЬКУЛЯТОРА */
@media (max-width: 480px) {
    .qty-row { flex-direction: column; align-items: stretch; gap: 10px; }
    .qty-number { width: 100%; text-align: left; }
    .price-value { font-size: 32px; }
    .calc-container { padding-bottom: 20px; }
}
</style>

<script>
function updatePrice() {
    const qty = parseInt(document.getElementById('q_input').value) || 1;
    const typeElem = document.querySelector('input[name="service_type"]:checked');
    const sizeElem = document.getElementById('rollup_size');
    
    const type = typeElem.value;
    const size = sizeElem.value;
    
    let unitPrice = 0;

    if (type === 'swap') {
        if (size === '80' || size === '85') unitPrice = (qty >= 10) ? 22 : 24;
        else if (size === '100') unitPrice = (qty >= 10) ? 26 : 28;
        else if (size === '150') unitPrice = 49;
    } else {
        if (size === '80') unitPrice = 49;
        else if (size === '85') unitPrice = 54;
        else if (size === '100') unitPrice = 64;
        else if (size === '150') unitPrice = 119;
    }

    const total = unitPrice * qty;
    const finalDisplay = total.toFixed(2);
    
    document.getElementById('final_price').innerText = finalDisplay;

    // Заполнение скрытых полей для отправки письма
    document.getElementById('hidden_qty').value = qty;
    document.getElementById('hidden_total').value = finalDisplay + ' €';
    
    const typeName = type === 'swap' ? 'Graafika vahetus' : 'Täiskomplekt';
    const sizeName = sizeElem.options[sizeElem.selectedIndex].getAttribute('data-name');
    document.getElementById('hidden_options').value = typeName + " / " + sizeName;
}

// Привязка событий
document.getElementById('q_range').addEventListener('input', function() {
    document.getElementById('q_input').value = this.value;
    updatePrice();
});
document.getElementById('q_input').addEventListener('input', function() {
    document.getElementById('q_range').value = this.value;
    updatePrice();
});
document.getElementById('rollup_size').addEventListener('change', updatePrice);
document.querySelectorAll('input[name="service_type"]').forEach(radio => {
    radio.addEventListener('change', updatePrice);
});

// Кнопка показа формы заказа
document.getElementById('showOrder').addEventListener('click', function() {
    this.style.display = 'none';
    document.getElementById('orderForm').style.display = 'block';
    updatePrice();
});

// Первичный расчет при загрузке
updatePrice();
</script>
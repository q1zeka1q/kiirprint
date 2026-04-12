<?php
// Проверяем текущий язык сайта
$l = isset($current_lang) ? $current_lang : 'et';

// --- МИНИ-СЛОВАРЬ ДЛЯ КАЛЬКУЛЯТОРА ФЛАЕРОВ ---
$calc_lang = [
    'et' => [
        'qty' => 'Vali kogus:',
        'format' => 'Vali formaat:',
        'paper' => 'Vali paber:',
        'paper_matt' => 'Matt',
        'paper_silk' => 'Silk (poolläikiv)',
        'gramm' => 'Vali grammkaal:',
        'print' => 'Vali trükk:',
        'print_1' => 'Ühepoolne trükk (4+0)',
        'print_2' => 'Kahepoolne trükk (4+4)',
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
        'format' => 'Выберите формат:',
        'paper' => 'Выберите бумагу:',
        'paper_matt' => 'Матовая (Matt)',
        'paper_silk' => 'Полуглянцевая (Silk)',
        'gramm' => 'Выберите плотность:',
        'print' => 'Выберите печать:',
        'print_1' => 'Односторонняя печать (4+0)',
        'print_2' => 'Двусторонняя печать (4+4)',
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
        'format' => 'Select format:',
        'paper' => 'Select paper:',
        'paper_matt' => 'Matte',
        'paper_silk' => 'Silk (semi-gloss)',
        'gramm' => 'Select paper weight:',
        'print' => 'Select printing:',
        'print_1' => 'Single-sided printing (4+0)',
        'print_2' => 'Double-sided printing (4+4)',
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
        'format' => 'Valitse koko:',
        'paper' => 'Valitse paperi:',
        'paper_matt' => 'Matta',
        'paper_silk' => 'Silkki (puolikiiltävä)',
        'gramm' => 'Valitse paperin paksuus:',
        'print' => 'Valitse painatus:',
        'print_1' => 'Yksipuolinen painatus (4+0)',
        'print_2' => 'Kaksipuolinen painatus (4+4)',
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
            <input type="range" id="q_range" class="qty-range" min="100" max="2000" step="50" value="100">
            <input type="number" id="q_input" class="qty-number" value="100" min="1">
        </div>
    </div>

    <div class="calc-group">
        <label class="calc-label"><?= $t['format'] ?></label>
        <select id="formaat" class="calc-select">
            <option value="A6">A6</option>
            <option value="A5">A5</option>
            <option value="A4" selected>A4</option>
            <option value="A3">A3</option>
        </select>
    </div>

    <div class="calc-group">
        <label class="calc-label"><?= $t['paper'] ?></label>
        <select id="paber" class="calc-select">
            <option value="Matt"><?= $t['paper_matt'] ?></option>
            <option value="Silk" selected><?= $t['paper_silk'] ?></option>
        </select>
    </div>

    <div class="calc-group">
        <label class="calc-label"><?= $t['gramm'] ?></label>
        <select id="gramm" class="calc-select">
            <option value="120g">120g</option>
            <option value="150g" selected>150g</option>
            <option value="170g">170g</option>
            <option value="200g">200g</option>
            <option value="250g">250g</option>
        </select>
    </div>

    <div class="calc-group">
        <label class="calc-label"><?= $t['print'] ?></label>
        <div class="radio-group">
            <label><input type="radio" name="trukk" value="1" checked> <?= $t['print_1'] ?></label>
            <label><input type="radio" name="trukk" value="2"> <?= $t['print_2'] ?></label>
        </div>
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
        <input type="hidden" name="paper_type" id="hidden_paper_type">

        <input type="text" name="client_name" class="calc-input form-spacing" placeholder="<?= $t['ph_name'] ?>" required>
        <input type="email" name="client_email" class="calc-input form-spacing" placeholder="<?= $t['ph_email'] ?>" required>
        <input type="text" name="client_phone" class="calc-input form-spacing" placeholder="<?= $t['ph_phone'] ?>" required>
        <textarea name="client_message" class="calc-input form-spacing" placeholder="<?= $t['ph_msg'] ?>" style="height:80px;"></textarea>
        
        <button type="submit" class="btn-submit"><?= $t['btn_send'] ?></button>
    </form>
    
    <button id="showOrder" class="btn-submit"><?= $t['btn_order'] ?></button>
</div>

<style>
/* Стили для калькулятора */
.calc-container { font-family: sans-serif; }
.calc-group { margin-top: 22px; }
.calc-label { font-weight: 700; display: block; margin-bottom: 8px; color: #333; font-size: 15px; }

/* Инпуты и селекты */
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

/* МОБИЛЬНАЯ ВЕРСИЯ */
@media (max-width: 480px) {
    .qty-row { flex-direction: column; align-items: stretch; gap: 10px; }
    .qty-number { width: 100%; text-align: left; }
    .price-value { font-size: 32px; }
    .calc-container { padding-bottom: 20px; }
}
</style>

<script>
function updatePrice() {
    let qty = parseInt(document.getElementById('q_input').value);
    if (isNaN(qty) || qty < 1) qty = 1;

    const formaat = document.getElementById('formaat').value;
    const trukk = document.querySelector('input[name="trukk"]:checked').value;
    
    let baseTkPrice = 0; 

    // 1. Ищем базовую цену за 1 штуку (по формату A4)
    if (trukk === "1") { // Односторонняя
        if (qty < 200) baseTkPrice = 0.14;
        else if (qty < 500) baseTkPrice = 0.13;
        else if (qty < 1000) baseTkPrice = 0.12;
        else baseTkPrice = 0.11;
    } else { // Двусторонняя
        if (qty < 200) baseTkPrice = 0.23;
        else if (qty < 500) baseTkPrice = 0.22;
        else if (qty < 1000) baseTkPrice = 0.20;
        else baseTkPrice = 0.18;
    }

    // 2. Коэффициенты форматов
    let multiplier = 1; 
    let lisatasu = 5;   

    if (formaat === "A4") {
        multiplier = 1;
        lisatasu = 5;
    } else if (formaat === "A5") {
        multiplier = 0.5; 
        lisatasu = 5;     
    } else if (formaat === "A6") {
        multiplier = 0.25; 
        lisatasu = 6;      
    } else if (formaat === "A3") {
        multiplier = 2;   
        lisatasu = 5;     
    }

    // 3. Считаем итоговую цену: (Цена штуки * коэффициент * количество) + надбавка
    let total = (baseTkPrice * multiplier * qty) + lisatasu;

    // 4. Минимальная сумма заказа 10 евро
    if (total < 10) {
        total = 10;
    }

    // Вывод цены
    const finalDisplay = total.toFixed(2);
    document.getElementById('final_price').innerText = finalDisplay;

    // --- ПЕРЕДАЧА ДАННЫХ ДЛЯ ОБРАБОТЧИКА ПИСЕМ ---
    document.getElementById('hidden_qty').value = qty;
    document.getElementById('hidden_total').value = finalDisplay + ' €';
    
    // Получаем названия выбранных параметров бумаги и печати
    const paberVal = document.getElementById('paber').value;
    const grammVal = document.getElementById('gramm').value;
    const trukkName = (trukk === "1") ? "4+0 Ühepoolne" : "4+4 Kahepoolne";
    
    // Склеиваем всё в одно поле, чтобы в письме была вся информация о флаере
    const hiddenPaperField = document.getElementById('hidden_paper_type');
    if (hiddenPaperField) {
        hiddenPaperField.value = "Formaat: " + formaat + " | Paber: " + paberVal + " " + grammVal + " | Trükk: " + trukkName;
    }
}

// Синхронизация ползунка и поля ввода
document.getElementById('q_range').addEventListener('input', function() {
    document.getElementById('q_input').value = this.value;
    updatePrice();
});
document.getElementById('q_input').addEventListener('input', function() {
    document.getElementById('q_range').value = this.value;
    updatePrice();
});

// Слушатели изменений
document.getElementById('formaat').addEventListener('change', updatePrice);
document.getElementById('paber').addEventListener('change', updatePrice);
document.getElementById('gramm').addEventListener('change', updatePrice);
document.querySelectorAll('input[name="trukk"]').forEach(radio => {
    radio.addEventListener('change', updatePrice);
});

// Показ формы
document.getElementById('showOrder').addEventListener('click', function() {
    this.style.display = 'none';
    document.getElementById('orderForm').style.display = 'block';
    updatePrice();
});

// Инициализация при загрузке
updatePrice();
</script>
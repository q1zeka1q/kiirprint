<?php
// --- МИНИ-СЛОВАРЬ ДЛЯ КАЛЬКУЛЯТОРА ВИЗИТОК ---
// Проверяем текущий язык сайта
$l = isset($current_lang) ? $current_lang : 'et';

$calc_lang = [
    'et' => [
        'qty' => 'Vali kogus:',
        'qty_hint' => 'Kirjuta kogus siia',
        'paper' => 'Vali visiitkaartide paber:',
        'paper_def' => '300g kaetud matt kartong',
        'paper_330' => '330g kaetud poolläikiv kartong',
        'paper_335' => '335g katmata matt kartong',
        'paper_re' => '300g taaskasutatud paber',
        'print' => 'Vali trükk:',
        'print_1' => 'Ühepoolne trükk',
        'print_2' => 'Kahepoolne trükk',
        'lam' => 'Kas soovid lisada laminaadi?',
        'lam_no' => 'Ei soovi laminaati',
        'lam_yes' => 'Jah soovin laminaadiga',
        'total' => 'Hind kokku (KM-ta):',
        'vat' => 'Käibemaks ei sisaldu lõpphinnas',
        'ph_name' => 'Teie nimi',
        'ph_email' => 'Teie e-mail',
        'ph_phone' => 'Telefon',
        'ph_msg' => 'Lisainfo (kuhu tarnida, erisoovid jne)',
        'btn_send' => 'SAADA TELLIMUS'
    ],
    'ru' => [
        'qty' => 'Выберите количество:',
        'qty_hint' => 'Впишите количество',
        'paper' => 'Выберите бумагу для визиток:',
        'paper_def' => '300г матовый картон',
        'paper_330' => '330г полуглянцевый картон',
        'paper_335' => '335г немелованный матовый',
        'paper_re' => '300г переработанная бумага',
        'print' => 'Выберите печать:',
        'print_1' => 'Односторонняя печать',
        'print_2' => 'Двусторонняя печать',
        'lam' => 'Хотите добавить ламинат?',
        'lam_no' => 'Без ламината',
        'lam_yes' => 'Да, с ламинатом',
        'total' => 'Итого (без НДС):',
        'vat' => 'НДС не включен в стоимость',
        'ph_name' => 'Ваше имя',
        'ph_email' => 'Ваш e-mail',
        'ph_phone' => 'Телефон',
        'ph_msg' => 'Доп. инфо (куда доставить, пожелания)',
        'btn_send' => 'ОТПРАВИТЬ ЗАКАЗ'
    ],
    'en' => [
        'qty' => 'Select quantity:',
        'qty_hint' => 'Type quantity here',
        'paper' => 'Select business card paper:',
        'paper_def' => '300g coated matte cardboard',
        'paper_330' => '330g coated semi-gloss',
        'paper_335' => '335g uncoated matte',
        'paper_re' => '300g recycled paper',
        'print' => 'Select printing:',
        'print_1' => 'Single-sided printing',
        'print_2' => 'Double-sided printing',
        'lam' => 'Do you want to add laminate?',
        'lam_no' => 'No laminate',
        'lam_yes' => 'Yes, with laminate',
        'total' => 'Total price (excl. VAT):',
        'vat' => 'VAT is not included in the final price',
        'ph_name' => 'Your name',
        'ph_email' => 'Your e-mail',
        'ph_phone' => 'Phone',
        'ph_msg' => 'Additional info (delivery address, requests)',
        'btn_send' => 'SEND ORDER'
    ],
    'fi' => [
        'qty' => 'Valitse määrä:',
        'qty_hint' => 'Kirjoita määrä tähän',
        'paper' => 'Valitse käyntikortin paperi:',
        'paper_def' => '300g päällystetty mattakartonki',
        'paper_330' => '330g puolikiiltävä kartonki',
        'paper_335' => '335g päällystämätön matta',
        'paper_re' => '300g uusiopaperi',
        'print' => 'Valitse painatus:',
        'print_1' => 'Yksipuolinen painatus',
        'print_2' => 'Kaksipuolinen painatus',
        'lam' => 'Haluatko lisätä laminaatin?',
        'lam_no' => 'Ei laminaattia',
        'lam_yes' => 'Kyllä, laminaatilla',
        'total' => 'Yhteensä (alv 0%):',
        'vat' => 'ALV ei sisälly lopulliseen hintaan',
        'ph_name' => 'Sinun nimesi',
        'ph_email' => 'Sähköpostisi',
        'ph_phone' => 'Puhelin',
        'ph_msg' => 'Lisätiedot (toimitusosoite, toiveet)',
        'btn_send' => 'LÄHETÄ TILAUS'
    ]
];

// Страховка
$t = isset($calc_lang[$l]) ? $calc_lang[$l] : $calc_lang['et'];
?>

<div class="calc-container">
    <div class="calc-group">
        <label class="calc-label"><?= $t['qty'] ?></label>
        <div class="qty-row">
            <input type="range" id="q_range" class="qty-range" min="100" max="2000" step="50" value="100">
            <div class="qty-input-wrapper">
                <input type="number" id="q_input" class="qty-number" value="100" min="100">
                <div class="qty-hint"><?= $t['qty_hint'] ?></div>
            </div>
        </div>
    </div>

    <div class="calc-group">
        <label class="calc-label"><?= $t['paper'] ?></label>
        <select id="paber" class="calc-select">
            <option value="def" data-name="300g matt kartong" selected><?= $t['paper_def'] ?></option>
            <option value="extra" data-name="330g poolläikiv"><?= $t['paper_330'] ?></option>
            <option value="extra" data-name="335g katmata matt"><?= $t['paper_335'] ?></option>
            <option value="extra" data-name="300g taaskasutatud"><?= $t['paper_re'] ?></option>
        </select>
    </div>

    <div class="calc-group">
        <label class="calc-label"><?= $t['print'] ?></label>
        <div class="radio-group">
            <label><input type="radio" name="print" value="4_0" checked> <?= $t['print_1'] ?></label>
            <label><input type="radio" name="print" value="4_4"> <?= $t['print_2'] ?></label>
        </div>
    </div>

    <div class="calc-group">
        <label class="calc-label"><?= $t['lam'] ?></label>
        <select id="laminaat" class="calc-select">
            <option value="no" data-name="ilma laminaadita" selected><?= $t['lam_no'] ?></option>
            <option value="yes" data-name="laminaadiga"><?= $t['lam_yes'] ?></option>
        </select>
    </div>

    <div class="price-box">
        <div class="price-label"><?= $t['total'] ?></div>
        <div class="price-value"><span id="final_price">0.00</span> €</div>
        <div class="price-vat"><?= $t['vat'] ?></div>
    </div>

    <form id="orderForm" action="../submit_order.php" method="POST" class="order-form">
        <input type="hidden" name="service_id" value="<?= $id ?>">
        <input type="hidden" name="quantity" id="hidden_qty">
        <input type="hidden" name="total_price" id="hidden_total">
        <input type="hidden" name="paper_type" id="hidden_paper">

        <input type="text" name="client_name" class="calc-input form-spacing" placeholder="<?= $t['ph_name'] ?>" required>
        <input type="email" name="client_email" class="calc-input form-spacing" placeholder="<?= $t['ph_email'] ?>" required>
        <input type="text" name="client_phone" class="calc-input form-spacing" placeholder="<?= $t['ph_phone'] ?>" required>
        <textarea name="client_message" class="calc-input form-spacing" placeholder="<?= $t['ph_msg'] ?>" style="height:80px;"></textarea>
        
        <button type="submit" class="btn-submit"><?= $t['btn_send'] ?></button>
    </form>
</div>

<style>
/* Стили для калькулятора */
.calc-container { font-family: sans-serif; }
.calc-group { margin-top: 22px; }
.calc-label { font-weight: 700; display: block; margin-bottom: 8px; color: #333; font-size: 15px; }

/* Инпуты и селекты */
.calc-input, .calc-select { width: 100%; padding: 14px; border: 1px solid #ddd; border-radius: 8px; font-size: 15px; box-sizing: border-box; background: #fff; transition: 0.2s; }
.calc-select:focus, .calc-input:focus { outline: none; border-color: #f36f21; box-shadow: 0 0 0 3px rgba(243, 111, 33, 0.1); }

/* Ползунок и количество */
.qty-row { display: flex; align-items: center; gap: 15px; }
.qty-range { flex-grow: 1; accent-color: #f36f21; height: 6px; }
.qty-input-wrapper { display: flex; flex-direction: column; align-items: center; }
.qty-number { width: 100px; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 16px; text-align: center; box-sizing: border-box; font-weight: bold; color: #f36f21;}
.qty-hint { font-size: 11px; color: #888; margin-top: 5px; text-align: center; }

/* Радиокнопки */
.radio-group label { display: block; padding: 12px 15px; background: #fdfdfd; border: 1px solid #eee; border-radius: 8px; margin-bottom: 8px; cursor: pointer; transition: 0.2s; }
.radio-group label:hover { background: #fff8f4; border-color: #f36f21; }
.radio-group input { margin-right: 10px; accent-color: #f36f21; transform: scale(1.2); }

/* Блок цены */
.price-box { margin-top: 35px; padding: 25px 20px; background: #fff8f4; border-radius: 12px; border: 2px solid rgba(243, 111, 33, 0.3); text-align: center; }
.price-label { font-size: 13px; color: #666; text-transform: uppercase; letter-spacing: 0.5px; font-weight: bold;}
.price-value { font-size: 38px; font-weight: 900; color: #f36f21; margin: 10px 0; }
.price-vat { font-size: 12px; color: #999; }

/* Форма и кнопки */
.order-form { margin-top: 25px; border-top: 2px dashed #eee; padding-top: 25px; }
.form-spacing { margin-bottom: 12px; }
.btn-submit { width: 100%; background: #f36f21; color: white; border: none; padding: 18px; font-size: 16px; font-weight: 800; border-radius: 8px; cursor: pointer; text-transform: uppercase; transition: 0.3s; margin-top: 15px; letter-spacing: 1px; }
.btn-submit:hover { background: #d95d16; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(243, 111, 33, 0.25); }

/* МОБИЛЬНАЯ ВЕРСИЯ */
@media (max-width: 480px) {
    .qty-row { flex-direction: column; align-items: stretch; gap: 15px; }
    .qty-input-wrapper { width: 100%; align-items: stretch; }
    .qty-number { width: 100%; text-align: left; padding-left: 15px; }
    .qty-hint { text-align: left; padding-left: 5px; width: 100%; }
    .price-value { font-size: 32px; }
    .calc-container { padding-bottom: 20px; }
}
</style>

<script>
function updatePrice() {
    let qty = parseInt(document.getElementById('q_input').value);
    if (isNaN(qty) || qty < 100) qty = 100;

    const paberVal = document.getElementById('paber').value;
    const wantsLaminate = document.getElementById('laminaat').value === 'yes';
    const isDouble = document.querySelector('input[name="print"]:checked').value === '4_4';

    let baseUnit = 0;

    // Базовые цены из PDF документа
    if (qty < 300) {
        baseUnit = isDouble ? 0.12 : 0.10;
    } else if (qty < 500) {
        baseUnit = isDouble ? 0.11 : 0.09;
    } else if (qty < 700) {
        baseUnit = isDouble ? 0.10 : 0.08;
    } else if (qty < 1000) {
        baseUnit = isDouble ? 0.09 : 0.07;
    } else if (qty < 1500) {
        baseUnit = isDouble ? 0.085 : 0.065;
    } else {
        baseUnit = isDouble ? 0.08 : 0.06;
    }

    // Надбавка за спец-бумагу (0.005 € за шт)
    let paperExtra = (paberVal === 'extra') ? 0.005 : 0;

    // Динамическая надбавка за ламинат (по количеству)
    let lamExtra = 0;
    if (wantsLaminate) {
        if (qty < 500) {
            lamExtra = 0.08;
        } else if (qty < 1000) {
            lamExtra = 0.07;
        } else {
            lamExtra = 0.06;
        }
    }

    // Считаем итоговую цену
    const totalPrice = (baseUnit + paperExtra + lamExtra) * qty;
    const finalDisplay = totalPrice.toFixed(2);
    
    document.getElementById('final_price').innerText = finalDisplay;

    // Передаем в скрытые поля для отправки на почту
    document.getElementById('hidden_qty').value = qty;
    document.getElementById('hidden_total').value = finalDisplay + ' €';
    
    const paberElem = document.getElementById('paber');
    const paperName = paberElem.options[paberElem.selectedIndex].getAttribute('data-name');
    const lamElem = document.getElementById('laminaat');
    const lamName = lamElem.options[lamElem.selectedIndex].getAttribute('data-name');
    document.getElementById('hidden_paper').value = paperName + " / " + lamName;
}

document.getElementById('q_range').addEventListener('input', function() {
    document.getElementById('q_input').value = this.value;
    updatePrice();
});
document.getElementById('q_input').addEventListener('input', function() {
    document.getElementById('q_range').value = this.value;
    updatePrice();
});
document.getElementById('paber').addEventListener('change', updatePrice);
document.getElementById('laminaat').addEventListener('change', updatePrice);
document.querySelectorAll('input[name="print"]').forEach(radio => {
    radio.addEventListener('change', updatePrice);
});

// Первичный расчет при загрузке
updatePrice();
</script>
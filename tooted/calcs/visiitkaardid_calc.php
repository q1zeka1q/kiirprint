<?php
// Выбираем все цены из базы для этого товара
$price_query = $conn->query("SELECT * FROM prices WHERE service_id = $id ORDER BY kogus_alates ASC");
$prices = [];
while($p = $price_query->fetch_assoc()) {
    $prices[] = $p;
}

// --- МИНИ-СЛОВАРЬ ДЛЯ КАЛЬКУЛЯТОРА ВИЗИТОК ---
// Проверяем текущий язык сайта (переменная $current_lang должна прийти из config.php)
$l = isset($current_lang) ? $current_lang : 'et';

$calc_lang = [
    'et' => [
        'qty' => 'Vali kogus:',
        'paper' => 'Vali visiitkaartide paber:',
        'paper_def' => '300g kaetud matt kartong (Default)',
        'paper_330' => '330g kaetud poolläikiv kartong (+0.05€/tk)',
        'paper_335' => '335g katmata matt kartong (+0.05€/tk)',
        'paper_re' => '300g taaskasutatud paber (+0.05€/tk)',
        'print' => 'Vali trükk:',
        'print_1' => 'Ühepoolne trükk',
        'print_2' => 'Kahepoolne trükk',
        'lam' => 'Kas soovid lisada laminaadi?',
        'lam_no' => 'Ei soovi laminaati',
        'lam_yes' => 'Jah, soovin laminaadiga (+0.08€/tk)',
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
        'paper' => 'Выберите бумагу для визиток:',
        'paper_def' => '300г матовый картон (Стандарт)',
        'paper_330' => '330г полуглянцевый картон (+0.05€/шт)',
        'paper_335' => '335г немелованный матовый (+0.05€/шт)',
        'paper_re' => '300г переработанная бумага (+0.05€/шт)',
        'print' => 'Выберите печать:',
        'print_1' => 'Односторонняя печать',
        'print_2' => 'Двусторонняя печать',
        'lam' => 'Хотите добавить ламинат?',
        'lam_no' => 'Без ламината',
        'lam_yes' => 'Да, с ламинатом (+0.08€/шт)',
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
        'paper' => 'Select business card paper:',
        'paper_def' => '300g coated matte cardboard (Default)',
        'paper_330' => '330g coated semi-gloss (+0.05€/pc)',
        'paper_335' => '335g uncoated matte (+0.05€/pc)',
        'paper_re' => '300g recycled paper (+0.05€/pc)',
        'print' => 'Select printing:',
        'print_1' => 'Single-sided printing',
        'print_2' => 'Double-sided printing',
        'lam' => 'Do you want to add laminate?',
        'lam_no' => 'No laminate',
        'lam_yes' => 'Yes, with laminate (+0.08€/pc)',
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
        'paper' => 'Valitse käyntikortin paperi:',
        'paper_def' => '300g päällystetty mattakartonki (Vakio)',
        'paper_330' => '330g puolikiiltävä kartonki (+0.05€/kpl)',
        'paper_335' => '335g päällystämätön matta (+0.05€/kpl)',
        'paper_re' => '300g uusiopaperi (+0.05€/kpl)',
        'print' => 'Valitse painatus:',
        'print_1' => 'Yksipuolinen painatus',
        'print_2' => 'Kaksipuolinen painatus',
        'lam' => 'Haluatko lisätä laminaatin?',
        'lam_no' => 'Ei laminaattia',
        'lam_yes' => 'Kyllä, laminaatilla (+0.08€/kpl)',
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

// Страховка: если язык не найден в массиве, используем эстонский
$t = isset($calc_lang[$l]) ? $calc_lang[$l] : $calc_lang['et'];
?>

<div class="calc-container">
    <div class="calc-group">
        <label class="calc-label"><?= $t['qty'] ?></label>
        <div class="qty-row">
            <input type="range" id="q_range" class="qty-range" min="100" max="2000" step="50" value="100">
            <input type="number" id="q_input" class="qty-number" value="100" min="100">
        </div>
    </div>

    <div class="calc-group">
        <label class="calc-label"><?= $t['paper'] ?></label>
        <select id="paber" class="calc-select">
            <option value="0" data-name="300g matt kartong" selected><?= $t['paper_def'] ?></option>
            <option value="0.05" data-name="330g poolläikiv"><?= $t['paper_330'] ?></option>
            <option value="0.05" data-name="335g katmata matt"><?= $t['paper_335'] ?></option>
            <option value="0.05" data-name="300g taaskasutatud"><?= $t['paper_re'] ?></option>
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
            <option value="0" data-name="ilma laminaadita" selected><?= $t['lam_no'] ?></option>
            <option value="0.08" data-name="laminaadiga"><?= $t['lam_yes'] ?></option>
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
        <input type="hidden" name="paper_type" id="hidden_paper">

        <input type="text" name="client_name" class="calc-input form-spacing" placeholder="<?= $t['ph_name'] ?>" required>
        <input type="email" name="client_email" class="calc-input form-spacing" placeholder="<?= $t['ph_email'] ?>" required>
        <input type="text" name="client_phone" class="calc-input form-spacing" placeholder="<?= $t['ph_phone'] ?>" required>
        <textarea name="client_message" class="calc-input form-spacing" placeholder="<?= $t['ph_msg'] ?>" style="height:80px;"></textarea>
        
        <button type="submit" class="btn-submit"><?= $t['btn_send'] ?></button>
    </form>
    
    <button id="showOrder" class="btn-submit"><?= $t['btn_order'] ?></button>
</div>

<style>
/* Стили для калькулятора (Мобильный подход) */
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
const priceSteps = <?php echo json_encode($prices); ?>;

function updatePrice() {
    const qty = parseInt(document.getElementById('q_input').value) || 0;
    const paberElem = document.getElementById('paber');
    const paperExtra = parseFloat(paberElem.value);
    
    const lamElem = document.getElementById('laminaat');
    const lamExtra = parseFloat(lamElem.value);
    
    const isDouble = document.querySelector('input[name="print"]:checked').value === '4_4';

    let basePricePerUnit = 0;
    for (let i = priceSteps.length - 1; i >= 0; i--) {
        if (qty >= parseInt(priceSteps[i].kogus_alates)) {
            basePricePerUnit = isDouble ? parseFloat(priceSteps[i].hind_4_4) : parseFloat(priceSteps[i].hind_4_0);
            break;
        }
    }

    const totalPrice = (basePricePerUnit + paperExtra + lamExtra) * qty;
    const finalDisplay = totalPrice.toFixed(2);
    
    document.getElementById('final_price').innerText = finalDisplay;

    document.getElementById('hidden_qty').value = qty;
    document.getElementById('hidden_total').value = finalDisplay;
    
    const paperName = paberElem.options[paberElem.selectedIndex].getAttribute('data-name');
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

document.getElementById('showOrder').addEventListener('click', function() {
    this.style.display = 'none';
    document.getElementById('orderForm').style.display = 'block';
    updatePrice();
});

updatePrice();
</script>
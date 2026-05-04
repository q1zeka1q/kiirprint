<?php
// --- МИНИ-СЛОВАРЬ ДЛЯ КАЛЬКУЛЯТОРА БУКЛЕТОВ ---
$l = isset($current_lang) ? $current_lang : 'et';

$calc_lang = [
    'et' => [
        'format' => 'Vali formaat:',
        'format_a65' => 'A65',
        'format_a5' => 'A5',
        'format_a4' => 'A4',
        'fold' => 'Vali voltimise tüüp:',
        'fold_v' => 'V-volt',
        'fold_g' => 'G-volt',
        'fold_z' => 'Z-volt',
        'fold_aken' => 'Aken',
        'paper' => 'Vali paber:',
        'paper_matt' => 'Matt offset',
        'paper_silk' => 'Silk (poolläikiv)',
        'weight' => 'Vali paberi grammkaal:',
        'weight_120' => '120g',
        'weight_150' => '150g',
        'weight_170' => '170g',
        'weight_200' => '200g',
        'weight_250' => '250g',
        'qty' => 'Vali kogus:',
        'qty_hint' => 'Kirjuta kogus siia',
        'total' => 'Hind kokku (KM-ta):',
        'vat' => 'Käibemaks ei sisaldu lõpphinnas',
        'ph_name' => 'Teie nimi',
        'ph_email' => 'Teie e-mail',
        'ph_phone' => 'Telefon',
        'ph_msg' => 'Lisainfo (kuhu tarnida, erisoovid jne)',
        'btn_send' => 'SAADA TELLIMUS'
    ],
    'ru' => [
        'format' => 'Выберите формат:',
        'format_a65' => 'A65',
        'format_a5' => 'A5',
        'format_a4' => 'A4',
        'fold' => 'Выберите тип фальцовки:',
        'fold_v' => 'V-фальц (книжка)',
        'fold_g' => 'G-фальц (в намотку)',
        'fold_z' => 'Z-фальц гармошкой',
        'fold_aken' => 'Оконный фальц (Aken)',
        'paper' => 'Выберите бумагу:',
        'paper_matt' => 'Matt offset (Матовый офсет)',
        'paper_silk' => 'Silk (Полуглянцевая)',
        'weight' => 'Выберите плотность бумаги:',
        'weight_120' => '120г',
        'weight_150' => '150г',
        'weight_170' => '170г',
        'weight_200' => '200г',
        'weight_250' => '250г',
        'qty' => 'Выберите количество:',
        'qty_hint' => 'Впишите количество',
        'total' => 'Итого (без НДС):',
        'vat' => 'НДС не включен в стоимость',
        'ph_name' => 'Ваше имя',
        'ph_email' => 'Ваш e-mail',
        'ph_phone' => 'Телефон',
        'ph_msg' => 'Доп. инфо (куда доставить, пожелания)',
        'btn_send' => 'ОТПРАВИТЬ ЗАКАЗ'
    ],
    'en' => [
        'format' => 'Select format:',
        'format_a65' => 'A65',
        'format_a5' => 'A5',
        'format_a4' => 'A4',
        'fold' => 'Select folding type:',
        'fold_v' => 'Half fold (V-fold)',
        'fold_g' => 'Letter fold (G-fold)',
        'fold_z' => 'Z-fold',
        'fold_aken' => 'Gate fold (Aken)',
        'paper' => 'Select paper:',
        'paper_matt' => 'Matt offset',
        'paper_silk' => 'Silk (semi-gloss)',
        'weight' => 'Select paper weight:',
        'weight_120' => '120g',
        'weight_150' => '150g',
        'weight_170' => '170g',
        'weight_200' => '200g',
        'weight_250' => '250g',
        'qty' => 'Select quantity:',
        'qty_hint' => 'Type quantity here',
        'total' => 'Total price (excl. VAT):',
        'vat' => 'VAT is not included in the final price',
        'ph_name' => 'Your name',
        'ph_email' => 'Your e-mail',
        'ph_phone' => 'Phone',
        'ph_msg' => 'Additional info (delivery address, requests)',
        'btn_send' => 'SEND ORDER'
    ],
    'fi' => [
        'format' => 'Valitse koko:',
        'format_a65' => 'A65',
        'format_a5' => 'A5',
        'format_a4' => 'A4',
        'fold' => 'Valitse taitos:',
        'fold_v' => 'V-taitos',
        'fold_g' => 'G-taitos (kirje)',
        'fold_z' => 'Z-taitos (haitari)',
        'fold_aken' => 'Ikkunataitos',
        'paper' => 'Valitse paperi:',
        'paper_matt' => 'Matt offset',
        'paper_silk' => 'Silk (puolikiiltävä)',
        'weight' => 'Valitse paperin paksuus:',
        'weight_120' => '120g',
        'weight_150' => '150g',
        'weight_170' => '170g',
        'weight_200' => '200g',
        'weight_250' => '250g',
        'qty' => 'Valitse määrä:',
        'qty_hint' => 'Kirjoita määrä tähän',
        'total' => 'Yhteensä (alv 0%):',
        'vat' => 'ALV ei sisälly lopulliseen hintaan',
        'ph_name' => 'Sinun nimesi',
        'ph_email' => 'Sähköpostisi',
        'ph_phone' => 'Puhelin',
        'ph_msg' => 'Lisätiedot (toimitusosoite, toiveet)',
        'btn_send' => 'LÄHETÄ TILAUS'
    ]
];

$t = isset($calc_lang[$l]) ? $calc_lang[$l] : $calc_lang['et'];
?>

<div class="calc-container">
    
    <div class="calc-group">
        <label class="calc-label"><?= $t['format'] ?></label>
        <select id="formaat" class="calc-select">
            <option value="A65_A5" data-name="A65" selected><?= $t['format_a65'] ?></option>
            <option value="A65_A5" data-name="A5"><?= $t['format_a5'] ?></option>
            <option value="A4" data-name="A4"><?= $t['format_a4'] ?></option>
        </select>
    </div>

    <div class="calc-group">
        <label class="calc-label"><?= $t['fold'] ?></label>
        <select id="volt" class="calc-select">
            <option value="V-volt" data-name="V-volt" selected><?= $t['fold_v'] ?></option>
            <option value="G-volt" data-name="G-volt"><?= $t['fold_g'] ?></option>
            <option value="Z-volt" data-name="Z-volt"><?= $t['fold_z'] ?></option>
            <option value="Aken" data-name="Aken"><?= $t['fold_aken'] ?></option>
        </select>
        
        <div class="fold-guide-wrapper">
            <img src="../img/voldikud_types.jpg" alt="Voltimise tüübid" class="fold-guide-img">
        </div>
    </div>

    <div class="calc-group">
        <label class="calc-label"><?= $t['paper'] ?></label>
        <div class="radio-group">
            <label><input type="radio" name="paber" value="Matt offset" checked> <?= $t['paper_matt'] ?></label>
            <label><input type="radio" name="paber" value="Silk"> <?= $t['paper_silk'] ?></label>
        </div>
    </div>

    <div class="calc-group">
        <label class="calc-label"><?= $t['weight'] ?></label>
        <select id="kaal" class="calc-select">
            <option value="120" data-name="120g" selected><?= $t['weight_120'] ?></option>
            <option value="150" data-name="150g"><?= $t['weight_150'] ?></option>
            <option value="170" data-name="170g"><?= $t['weight_170'] ?></option>
            <option value="200" data-name="200g"><?= $t['weight_200'] ?></option>
            <option value="250" data-name="250g"><?= $t['weight_250'] ?></option>
        </select>
    </div>

    <div class="calc-group">
        <label class="calc-label"><?= $t['qty'] ?></label>
        <div class="qty-row">
            <input type="range" id="q_range" class="qty-range" min="10" max="2000" step="10" value="10">
            <div class="qty-input-wrapper">
                <input type="number" id="q_input" class="qty-number" value="10" min="10">
                <div class="qty-hint"><?= $t['qty_hint'] ?></div>
            </div>
        </div>
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
/* Стили калькулятора */
.calc-container { font-family: sans-serif; }
.calc-group { margin-top: 22px; }
.calc-label { font-weight: 700; display: block; margin-bottom: 8px; color: #333; font-size: 15px; }

.calc-input, .calc-select { width: 100%; padding: 14px; border: 1px solid #ddd; border-radius: 8px; font-size: 15px; box-sizing: border-box; background: #fff; transition: 0.2s; }
.calc-select:focus, .calc-input:focus { outline: none; border-color: #f36f21; box-shadow: 0 0 0 3px rgba(243, 111, 33, 0.1); }

.qty-row { display: flex; align-items: center; gap: 15px; }
.qty-range { flex-grow: 1; accent-color: #f36f21; height: 6px; }
.qty-input-wrapper { display: flex; flex-direction: column; align-items: center; }
.qty-number { width: 100px; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 16px; text-align: center; box-sizing: border-box; font-weight: bold; color: #f36f21;}
.qty-hint { font-size: 11px; color: #888; margin-top: 5px; text-align: center; }

.radio-group label { display: block; padding: 12px 15px; background: #fdfdfd; border: 1px solid #eee; border-radius: 8px; margin-bottom: 8px; cursor: pointer; transition: 0.2s; }
.radio-group label:hover { background: #fff8f4; border-color: #f36f21; }
.radio-group input { margin-right: 10px; accent-color: #f36f21; transform: scale(1.2); }

.price-box { margin-top: 35px; padding: 25px 20px; background: #fff8f4; border-radius: 12px; border: 2px solid rgba(243, 111, 33, 0.3); text-align: center; }
.price-label { font-size: 13px; color: #666; text-transform: uppercase; letter-spacing: 0.5px; font-weight: bold;}
.price-value { font-size: 38px; font-weight: 900; color: #f36f21; margin: 10px 0; }
.price-vat { font-size: 12px; color: #999; }

.order-form { margin-top: 25px; border-top: 2px dashed #eee; padding-top: 25px; }
.form-spacing { margin-bottom: 12px; }
.btn-submit { width: 100%; background: #f36f21; color: white; border: none; padding: 18px; font-size: 16px; font-weight: 800; border-radius: 8px; cursor: pointer; text-transform: uppercase; transition: 0.3s; margin-top: 15px; letter-spacing: 1px; }
.btn-submit:hover { background: #d95d16; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(243, 111, 33, 0.25); }

/* Стили для картинки с типами сгибов */
.fold-guide-wrapper {
    margin-top: 12px;
    background: #fff;
    padding: 10px;
    border: 1px solid #edf2f7;
    border-radius: 8px;
    text-align: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.02);
}
.fold-guide-img {
    max-width: 100%;
    height: auto;
    border-radius: 4px;
    display: block;
    margin: 0 auto;
}

/* Мобильная версия с выравниванием по левому краю */
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
    if (isNaN(qty) || qty < 10) qty = 10;

    const formaatElem = document.getElementById('formaat');
    const formatType = formaatElem.value; // 'A65_A5' или 'A4'
    
    const kaalElem = document.getElementById('kaal');
    const weightVal = kaalElem.value; // '120', '150', '200' и т.д.

    let basePrice = 0;

    // Логика цен для A65 и A5
    if (formatType === 'A65_A5') {
        if (qty <= 20) basePrice = 10;
        else if (qty <= 39) basePrice = (qty * 0.30) + 5;
        else if (qty <= 99) basePrice = (qty * 0.26) + 5;
        else if (qty <= 299) basePrice = (qty * 0.24) + 5;
        else if (qty <= 499) basePrice = (qty * 0.23) + 5;
        else if (qty <= 799) basePrice = (qty * 0.22) + 5;
        else if (qty <= 999) basePrice = (qty * 0.21) + 5;
        else basePrice = qty * 0.19;
    } 
    // Логика цен для A4
    else if (formatType === 'A4') {
        if (qty <= 10) basePrice = 10;
        else if (qty <= 29) basePrice = (qty * 0.55) + 5;
        else if (qty <= 49) basePrice = (qty * 0.52) + 5;
        else if (qty <= 99) basePrice = (qty * 0.49) + 5;
        else if (qty <= 299) basePrice = (qty * 0.47) + 5;
        else if (qty <= 499) basePrice = (qty * 0.46) + 5;
        else if (qty <= 799) basePrice = (qty * 0.44) + 5;
        else if (qty <= 999) basePrice = (qty * 0.42) + 5;
        else basePrice = qty * 0.39;
    }

    // Наценки за плотность бумаги
    let extraPerPiece = 0;
    if (weightVal === '200') {
        extraPerPiece = (formatType === 'A4') ? 0.013 : 0.0065;
    } else if (weightVal === '250') {
        extraPerPiece = (formatType === 'A4') ? 0.024 : 0.012;
    }

    let totalPrice = basePrice + (extraPerPiece * qty);
    
    // Минимальная сумма заказа всегда 10 EUR
    if (totalPrice < 10) totalPrice = 10;

    const finalDisplay = totalPrice.toFixed(2);
    document.getElementById('final_price').innerText = finalDisplay;

    // Формируем данные для заказа
    const formatName = formaatElem.options[formaatElem.selectedIndex].getAttribute('data-name');
    const voltElem = document.getElementById('volt');
    const voltName = voltElem.options[voltElem.selectedIndex].getAttribute('data-name');
    const paberName = document.querySelector('input[name="paber"]:checked').value;
    const kaalName = kaalElem.options[kaalElem.selectedIndex].getAttribute('data-name');

    document.getElementById('hidden_qty').value = qty;
    document.getElementById('hidden_total').value = finalDisplay;
    document.getElementById('hidden_paper').value = `${formatName} | ${voltName} | ${paberName} | ${kaalName}`;
}

// Слушатели событий
document.getElementById('q_range').addEventListener('input', function() {
    document.getElementById('q_input').value = this.value;
    updatePrice();
});
document.getElementById('q_input').addEventListener('input', function() {
    document.getElementById('q_range').value = this.value;
    updatePrice();
});
document.getElementById('formaat').addEventListener('change', updatePrice);
document.getElementById('kaal').addEventListener('change', updatePrice);
document.querySelectorAll('input[name="paber"]').forEach(radio => {
    radio.addEventListener('change', updatePrice);
});
document.getElementById('volt').addEventListener('change', updatePrice);

// Инициализация
updatePrice();
</script>
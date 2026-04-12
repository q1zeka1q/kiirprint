<?php
// Проверяем текущий язык сайта
$l = isset($current_lang) ? $current_lang : 'et';

// --- МИНИ-СЛОВАРЬ ДЛЯ КАЛЬКУЛЯТОРА БРОШЮР ---
$calc_lang = [
    'et' => [
        'qty' => 'Vali kogus:',
        'pages' => 'Lehekülgede arv (koos kaantega):',
        'format' => 'Vali formaat:',
        'binding' => 'Köitmise tüüp:',
        'bind_klamber' => 'Klamberköide',
        'bind_kamm' => 'Kammköide (plastkamm)',
        'content_paper' => 'Sisu paber:',
        'cover_paper' => 'Kaane paber:',
        'plast_cover' => 'Plastkaaned (ainult kammköitele):',
        'yes' => 'Jah (+lisatasu)',
        'no' => 'Ei',
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
        'pages' => 'Количество страниц (с обложкой):',
        'format' => 'Выберите формат:',
        'binding' => 'Тип переплета:',
        'bind_klamber' => 'Скрепка',
        'bind_kamm' => 'Пластиковая пружина',
        'content_paper' => 'Бумага внутреннего блока:',
        'cover_paper' => 'Бумага обложки:',
        'plast_cover' => 'Пластиковые обложки (для пружины):',
        'yes' => 'Да (+доплата)',
        'no' => 'Нет',
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
        'pages' => 'Number of pages (including cover):',
        'format' => 'Select format:',
        'binding' => 'Binding type:',
        'bind_klamber' => 'Staple binding',
        'bind_kamm' => 'Comb binding (plastic)',
        'content_paper' => 'Content paper:',
        'cover_paper' => 'Cover paper:',
        'plast_cover' => 'Plastic covers (for comb binding only):',
        'yes' => 'Yes (+extra fee)',
        'no' => 'No',
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
        'pages' => 'Sivujen määrä (kannet mukaan lukien):',
        'format' => 'Valitse koko:',
        'binding' => 'Sidonnan tyyppi:',
        'bind_klamber' => 'Stiftattu (vihkosidonta)',
        'bind_kamm' => 'Kierresidonta (muovikampa)',
        'content_paper' => 'Sisäsivujen paperi:',
        'cover_paper' => 'Kansipaperi:',
        'plast_cover' => 'Muovikannet (vain kierresidontaan):',
        'yes' => 'Kyllä (+lisämaksu)',
        'no' => 'Ei',
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
            <input type="range" id="q_range" class="qty-range" min="1" max="1000" step="1" value="10">
            <input type="number" id="q_input" class="qty-number" value="10" min="1">
        </div>
    </div>

    <div class="calc-group">
        <label class="calc-label"><?= $t['pages'] ?></label>
        <div class="qty-row">
            <input type="range" id="p_range" class="qty-range" min="8" max="150" step="2" value="8">
            <input type="number" id="pages_input" class="qty-number" value="8" min="8">
        </div>
        <small style="color: #666; font-size: 12px; margin-top: 8px; display: block;">Klamberköite puhul peab arv jaguma 4-ga.</small>
    </div>

    <div class="calc-group">
        <label class="calc-label"><?= $t['format'] ?></label>
        <div class="radio-group">
            <label><input type="radio" name="formaat" value="A5"> A5</label>
            <label><input type="radio" name="formaat" value="A4" checked> A4</label>
        </div>
    </div>

    <div class="calc-group">
        <label class="calc-label"><?= $t['binding'] ?></label>
        <div class="radio-group">
            <label><input type="radio" name="binding" value="klamber" checked> <?= $t['bind_klamber'] ?></label>
            <label><input type="radio" name="binding" value="kamm"> <?= $t['bind_kamm'] ?></label>
        </div>
    </div>

    <div class="calc-group">
        <label class="calc-label"><?= $t['content_paper'] ?></label>
        <select id="sisu_paber" class="calc-select">
            <option value="120-150g" selected>120g - 150g (Default)</option>
            <option value="200g">200g Silk</option>
        </select>
    </div>

    <div class="calc-group">
        <label class="calc-label"><?= $t['cover_paper'] ?></label>
        <select id="kaane_paber" class="calc-select">
            <option value="120-150g">120g - 150g</option>
            <option value="200g">200g Silk</option>
            <option value="250g" selected>250g Silk (Default)</option>
            <option value="300g">300g Kartong</option>
        </select>
    </div>

    <div class="calc-group" id="plast_group" style="display: none;">
        <label class="calc-label"><?= $t['plast_cover'] ?></label>
        <select id="plastkaaned" class="calc-select">
            <option value="no" selected><?= $t['no'] ?></option>
            <option value="yes"><?= $t['yes'] ?></option>
        </select>
    </div>

    <div class="price-box">
        <div class="price-label"><?= $t['total'] ?></div>
        <div class="price-value"><span id="final_price">0.00</span> €</div>
        <div id="discount_badge" style="display: none; font-size: 14px; background: #f36f21; color: white; padding: 4px 12px; border-radius: 20px; display: inline-block; margin-bottom: 8px; font-weight: bold;"></div>
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
/* Твои оригинальные стили визиток на 100% */
.calc-container { font-family: sans-serif; }
.calc-group { margin-top: 22px; }
.calc-label { font-weight: 700; display: block; margin-bottom: 8px; color: #333; font-size: 15px; }

.calc-input, .calc-select { 
    width: 100%; padding: 14px; border: 1px solid #ddd; border-radius: 8px; 
    font-size: 15px; box-sizing: border-box; background: #fff; transition: 0.2s;
}
.calc-select:focus, .calc-input:focus { outline: none; border-color: #f36f21; box-shadow: 0 0 0 3px rgba(243, 111, 33, 0.1); }

.qty-row { display: flex; align-items: center; gap: 15px; }
.qty-range { flex-grow: 1; accent-color: #f36f21; height: 6px; }
.qty-number { width: 90px; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 16px; text-align: center; box-sizing: border-box; font-weight: bold; color: #f36f21;}

.radio-group label { 
    display: block; padding: 12px 15px; background: #fdfdfd; border: 1px solid #eee; 
    border-radius: 8px; margin-bottom: 8px; cursor: pointer; transition: 0.2s;
}
.radio-group label:hover { background: #fff8f4; border-color: #f36f21; }
.radio-group input { margin-right: 10px; accent-color: #f36f21; transform: scale(1.2); }

.price-box { margin-top: 35px; padding: 25px 20px; background: #fff8f4; border-radius: 12px; border: 2px solid rgba(243, 111, 33, 0.3); text-align: center; }
.price-label { font-size: 13px; color: #666; text-transform: uppercase; letter-spacing: 0.5px; font-weight: bold;}
.price-value { font-size: 38px; font-weight: 900; color: #f36f21; margin: 10px 0; }
.price-vat { font-size: 12px; color: #999; }

.order-form { margin-top: 20px; border-top: 2px dashed #eee; padding-top: 25px; }
.form-spacing { margin-bottom: 12px; }
.btn-submit { 
    width: 100%; background: #f36f21; color: white; border: none; padding: 18px; 
    font-size: 16px; font-weight: 800; border-radius: 8px; cursor: pointer; 
    text-transform: uppercase; transition: 0.3s; margin-top: 15px; letter-spacing: 1px;
}
.btn-submit:hover { background: #d95d16; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(243, 111, 33, 0.25); }

@media (max-width: 480px) {
    .qty-row { flex-direction: column; align-items: stretch; gap: 10px; }
    .qty-number { width: 100%; text-align: left; }
    .price-value { font-size: 32px; }
    .calc-container { padding-bottom: 20px; }
}
</style>

<script>
function updatePrice() {
    let qty = parseInt(document.getElementById('q_input').value) || 1;
    let pages = parseInt(document.getElementById('pages_input').value) || 8;
    if (pages < 4) pages = 4; // Защита от ошибок

    const formaat = document.querySelector('input[name="formaat"]:checked').value;
    const binding = document.querySelector('input[name="binding"]:checked').value;
    const sisuPaber = document.getElementById('sisu_paber').value;
    const kaanePaber = document.getElementById('kaane_paber').value;
    const plastkaaned = document.getElementById('plastkaaned').value === 'yes';

    // Показываем/скрываем блок пластиковых обложек
    document.getElementById('plast_group').style.display = (binding === 'kamm') ? 'block' : 'none';

    let contentPrice = 0;
    let coverPrice = 0;
    let plastPrice = 0;

    let sisuLehedKlamber = Math.max(0, Math.ceil((pages - 4) / 4));
    let sisuLehedKamm = Math.max(0, Math.ceil((pages - 4) / 2));

    if (binding === 'klamber') {
        if (formaat === 'A5') {
            let contentUnit = (sisuPaber === '200g') ? (sisuLehedKlamber * 0.24 + 0.45) : (sisuLehedKlamber * 0.23 + 0.45);
            contentPrice = contentUnit * qty;

            let coverUnit = 0.23;
            if (kaanePaber === '200g') coverUnit = 0.24;
            else if (kaanePaber === '250g' || kaanePaber === '300g') coverUnit = 0.26; 
            coverPrice = coverUnit * qty;

        } else if (formaat === 'A4') {
            let contentUnit = (sisuPaber === '200g') ? (sisuLehedKlamber * 0.48 + 0.45) : (sisuLehedKlamber * 0.46 + 0.45);
            contentPrice = contentUnit * qty;

            let coverUnit = 0.46;
            if (kaanePaber === '200g') coverUnit = 0.48;
            else if (kaanePaber === '250g' || kaanePaber === '300g') coverUnit = 0.52;
            coverPrice = coverUnit * qty;
        }
    } else if (binding === 'kamm') {
        if (formaat === 'A5') {
            let contentUnit = sisuLehedKamm * 0.115 + 0.85; 
            contentPrice = contentUnit * qty;

            let coverUnit = 0.23;
            if (kaanePaber === '200g') coverUnit = 0.24;
            else if (kaanePaber === '250g' || kaanePaber === '300g') coverUnit = 0.26;
            coverPrice = coverUnit * qty;

            if (plastkaaned) plastPrice = 0.60 * qty;

        } else if (formaat === 'A4') {
            let contentUnit = sisuLehedKamm * 0.23 + 0.85;
            contentPrice = contentUnit * qty;

            let coverUnit = 0.46;
            if (kaanePaber === '300g') coverUnit = 0.64; 
            else if (kaanePaber === '250g' || kaanePaber === '200g') coverUnit = 0.55; 
            coverPrice = coverUnit * qty;

            if (plastkaaned) plastPrice = 0.95 * qty;
        }
    }

    let total = contentPrice + coverPrice + plastPrice;
    let discountMsg = "";

    if (total > 200) {
        total = total * 0.90; // -10%
        
    } else if (total > 110) {
        total = total * 0.95; // -5%
        
    }

    if (total < 10) {
        total = 10;
        discountMsg = ""; 
    }

    const finalDisplay = total.toFixed(2);
    document.getElementById('final_price').innerText = finalDisplay;
    
    const badge = document.getElementById('discount_badge');
    if (discountMsg !== "") {
        badge.innerText = discountMsg;
        badge.style.display = 'inline-block';
    } else {
        badge.style.display = 'none';
    }

    document.getElementById('hidden_qty').value = qty;
    document.getElementById('hidden_total').value = finalDisplay + ' €';
    
    let bindingName = binding === 'klamber' ? 'Klamberköide' : 'Kammköide';
    let plastName = (binding === 'kamm' && plastkaaned) ? ' | Plastkaaned: JAH' : '';
    let details = "Formaat: " + formaat + " | " + bindingName + " | Lehti: " + pages + " | Sisu: " + sisuPaber + " | Kaaned: " + kaanePaber + plastName;
    
    document.getElementById('hidden_paper_type').value = details;
}

// Привязки ползунков
document.getElementById('q_range').addEventListener('input', function() { document.getElementById('q_input').value = this.value; updatePrice(); });
document.getElementById('q_input').addEventListener('input', function() { document.getElementById('q_range').value = this.value; updatePrice(); });

document.getElementById('p_range').addEventListener('input', function() { document.getElementById('pages_input').value = this.value; updatePrice(); });
document.getElementById('pages_input').addEventListener('input', function() { document.getElementById('p_range').value = this.value; updatePrice(); });

document.querySelectorAll('input[name="formaat"]').forEach(r => r.addEventListener('change', updatePrice));
document.querySelectorAll('input[name="binding"]').forEach(r => r.addEventListener('change', updatePrice));
document.getElementById('sisu_paber').addEventListener('change', updatePrice);
document.getElementById('kaane_paber').addEventListener('change', updatePrice);
document.getElementById('plastkaaned').addEventListener('change', updatePrice);

document.getElementById('showOrder').addEventListener('click', function() {
    this.style.display = 'none';
    document.getElementById('orderForm').style.display = 'block';
    updatePrice();
});

updatePrice();
</script>
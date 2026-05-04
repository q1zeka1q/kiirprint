<?php
// Проверяем текущий язык сайта
$l = isset($current_lang) ? $current_lang : 'et';

// --- МИНИ-СЛОВАРЬ ДЛЯ КАЛЬКУЛЯТОРА БРОШЮР ---
$calc_lang = [
    'et' => [
        'qty' => 'Vali kogus:',
        'qty_hint' => 'Kirjuta kogus siia',
        'pages' => 'Lehekülgede arv (koos kaantega):',
        'format' => 'Vali formaat:',
        'binding' => 'Köitmise tüüp:',
        'bind_klamber' => 'Klamberköide',
        'bind_kamm' => 'Kammköide (plastkamm)',
        'content_paper' => 'Sisu paber:',
        'cover_paper' => 'Kaane paber:',
        'plast_cover' => 'Plastkaaned (ainult kammköitele):',
        'yes' => 'Jah',
        'no' => 'Ei',
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
        'pages' => 'Количество страниц (с обложкой):',
        'format' => 'Выберите формат:',
        'binding' => 'Тип переплета:',
        'bind_klamber' => 'Скрепка',
        'bind_kamm' => 'Пластиковая пружина',
        'content_paper' => 'Бумага внутреннего блока:',
        'cover_paper' => 'Бумага обложки:',
        'plast_cover' => 'Пластиковые обложки (для пружины):',
        'yes' => 'Да',
        'no' => 'Нет',
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
        'pages' => 'Number of pages (including cover):',
        'format' => 'Select format:',
        'binding' => 'Binding type:',
        'bind_klamber' => 'Staple binding',
        'bind_kamm' => 'Comb binding (plastic)',
        'content_paper' => 'Content paper:',
        'cover_paper' => 'Cover paper:',
        'plast_cover' => 'Plastic covers (for comb binding only):',
        'yes' => 'Yes',
        'no' => 'No',
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
        'pages' => 'Sivujen määrä (kannet mukaan lukien):',
        'format' => 'Valitse koko:',
        'binding' => 'Sidonnan tyyppi:',
        'bind_klamber' => 'Stiftattu (vihkosidonta)',
        'bind_kamm' => 'Kierresidonta (muovikampa)',
        'content_paper' => 'Sisäsivujen paperi:',
        'cover_paper' => 'Kansipaperi:',
        'plast_cover' => 'Muovikannet (vain kierresidontaan):',
        'yes' => 'Kyllä',
        'no' => 'Ei',
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

    <!-- 1. ТИП ПЕРЕПЛЕТА (Главный переключатель) -->
    <div class="calc-group">
        <label class="calc-label"><?= $t['binding'] ?></label>
        <div class="radio-group">
            <label><input type="radio" name="binding" value="klamber" checked> <?= $t['bind_klamber'] ?></label>
            <label><input type="radio" name="binding" value="kamm"> <?= $t['bind_kamm'] ?></label>
        </div>
    </div>

    <!-- 2. ФОРМАТ -->
    <div class="calc-group">
        <label class="calc-label"><?= $t['format'] ?></label>
        <div class="radio-group">
            <label><input type="radio" name="formaat" value="A5"> A5</label>
            <label><input type="radio" name="formaat" value="A4" checked> A4</label>
        </div>
    </div>

    <!-- 3. СТРАНИЦЫ (Динамический выпадающий список) -->
    <div class="calc-group">
        <label class="calc-label"><?= $t['pages'] ?></label>
        <select id="pages_input" class="calc-select"></select>
    </div>

    <!-- 4. БУМАГА ВНУТРИ (Динамический выпадающий список) -->
    <div class="calc-group">
        <label class="calc-label"><?= $t['content_paper'] ?></label>
        <select id="sisu_paber" class="calc-select"></select>
    </div>

    <!-- 5. БУМАГА ОБЛОЖКИ (Динамический выпадающий список) -->
    <div class="calc-group">
        <label class="calc-label"><?= $t['cover_paper'] ?></label>
        <select id="kaane_paber" class="calc-select"></select>
    </div>

    <!-- 6. ПЛАСТИКОВЫЕ ОБЛОЖКИ (Скрываются для скрепки) -->
    <div class="calc-group" id="plast_group" style="display: none;">
        <label class="calc-label"><?= $t['plast_cover'] ?></label>
        <select id="plastkaaned" class="calc-select">
            <option value="no" selected><?= $t['no'] ?></option>
            <option value="yes"><?= $t['yes'] ?></option>
        </select>
    </div>

    <!-- 7. ТИРАЖ -->
    <div class="calc-group">
        <label class="calc-label"><?= $t['qty'] ?></label>
        <div class="qty-row">
            <input type="range" id="q_range" class="qty-range" min="1" max="1000" step="1" value="10">
            <div class="qty-input-wrapper">
                <input type="number" id="q_input" class="qty-number" value="10" min="1">
                <div class="qty-hint"><?= $t['qty_hint'] ?></div>
            </div>
        </div>
    </div>

    <!-- БЛОК ЦЕНЫ -->
    <div class="price-box">
        <div class="price-label"><?= $t['total'] ?></div>
        <div class="price-value"><span id="final_price">0.00</span> €</div>
        <div id="discount_badge" style="display: none; font-size: 14px; background: #f36f21; color: white; padding: 4px 12px; border-radius: 20px; margin-bottom: 8px; font-weight: bold;"></div>
        <div class="price-vat"><?= $t['vat'] ?></div>
    </div>

    <form id="orderForm" action="../submit_order.php" method="POST" class="order-form">
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
    
</div>

<style>
/* Стили для калькулятора */
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
.qty-input-wrapper { display: flex; flex-direction: column; align-items: center; }
.qty-number { width: 100px; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 16px; text-align: center; box-sizing: border-box; font-weight: bold; color: #f36f21;}
.qty-hint { font-size: 11px; color: #888; margin-top: 5px; text-align: center; }

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

.order-form { margin-top: 25px; border-top: 2px dashed #eee; padding-top: 25px; }
.form-spacing { margin-bottom: 12px; }
.btn-submit { 
    width: 100%; background: #f36f21; color: white; border: none; padding: 18px; 
    font-size: 16px; font-weight: 800; border-radius: 8px; cursor: pointer; 
    text-transform: uppercase; transition: 0.3s; margin-top: 15px; letter-spacing: 1px;
}
.btn-submit:hover { background: #d95d16; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(243, 111, 33, 0.25); }

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
// --- КОНФИГУРАЦИЯ БУМАГИ И СТРАНИЦ ИЗ PDF ФАЙЛОВ ---
const config = {
    klamber: {
        pages: { min: 8, max: 40, step: 4 }, // Скрепка кратна 4, до 40 стр
        content: [
            { val: '120g matt', text: '120g matt' },
            { val: '140g matt', text: '140g matt' },
            { val: '150g silk', text: '150g Silk' },
            { val: '200g silk', text: '200g Silk' }
        ],
        defaultContent: '150g silk',
        cover: [
            { val: '120g matt', text: '120g matt' },
            { val: '140g matt', text: '140g matt' },
            { val: '150g silk', text: '150g Silk' },
            { val: '200g silk', text: '200g Silk' },
            { val: '250g silk', text: '250g Silk' }
        ],
        defaultCover: '150g silk'
    },
    kamm: {
        pages: { min: 8, max: 150, step: 2 }, // Пружина кратна 2, до 150 стр
        content: [
            { val: '120g matt', text: '120g matt' },
            { val: '130g silk', text: '130g Silk' },
            { val: '140g matt', text: '140g matt' },
            { val: '150g silk', text: '150g Silk' }
        ],
        defaultContent: '120g matt',
        cover: [
            { val: 'sama', text: 'Sama mis sisupaber' },
            { val: '250g kartong', text: '250g kartong' },
            { val: '300g kartong', text: '300g kartong' }
        ],
        defaultCover: '250g kartong'
    }
};

// Функция перестроения всех списков при смене переплета
function buildDropdowns() {
    const binding = document.querySelector('input[name="binding"]:checked').value;
    const currentData = config[binding];

    // 1. Строим страницы
    const pagesSelect = document.getElementById('pages_input');
    const oldPageVal = parseInt(pagesSelect.value) || 8;
    pagesSelect.innerHTML = '';
    let closestPage = currentData.pages.min;
    let minDiff = Infinity;
    
    for(let i = currentData.pages.min; i <= currentData.pages.max; i += currentData.pages.step) {
        let opt = document.createElement('option');
        opt.value = i;
        opt.innerText = i;
        pagesSelect.appendChild(opt);
        if (Math.abs(i - oldPageVal) < minDiff) {
            minDiff = Math.abs(i - oldPageVal);
            closestPage = i;
        }
    }
    pagesSelect.value = closestPage;

    // 2. Строим бумагу внутреннего блока
    const sisuSelect = document.getElementById('sisu_paber');
    const oldSisu = sisuSelect.value;
    sisuSelect.innerHTML = '';
    currentData.content.forEach(p => {
        let opt = document.createElement('option');
        opt.value = p.val;
        opt.innerText = p.text;
        sisuSelect.appendChild(opt);
    });
    // Если старая бумага есть в новом списке — оставляем, если нет — ставим дефолт
    if(Array.from(sisuSelect.options).some(o => o.value === oldSisu)) {
         sisuSelect.value = oldSisu;
    } else {
         sisuSelect.value = currentData.defaultContent;
    }

    // 3. Строим бумагу обложки
    const kaaneSelect = document.getElementById('kaane_paber');
    const oldKaane = kaaneSelect.value;
    kaaneSelect.innerHTML = '';
    currentData.cover.forEach(p => {
        let opt = document.createElement('option');
        opt.value = p.val;
        opt.innerText = p.text;
        kaaneSelect.appendChild(opt);
    });
    if(Array.from(kaaneSelect.options).some(o => o.value === oldKaane)) {
         kaaneSelect.value = oldKaane;
    } else {
         kaaneSelect.value = currentData.defaultCover;
    }

    // 4. Показываем/Скрываем пластиковые обложки
    document.getElementById('plast_group').style.display = (binding === 'kamm') ? 'block' : 'none';

    updatePrice();
}

function updatePrice() {
    let qty = parseInt(document.getElementById('q_input').value);
    if (isNaN(qty) || qty < 1) qty = 1;

    let pages = parseInt(document.getElementById('pages_input').value) || 8;

    const formaat = document.querySelector('input[name="formaat"]:checked').value;
    const binding = document.querySelector('input[name="binding"]:checked').value;
    const sisuPaber = document.getElementById('sisu_paber').value;
    const kaanePaber = document.getElementById('kaane_paber').value;
    const plastkaaned = document.getElementById('plastkaaned').value === 'yes';

    let contentPrice = 0;
    let coverPrice = 0;
    let plastPrice = 0;

    let sisuLehedKlamber = Math.max(0, Math.ceil((pages - 4) / 4));
    let sisuLehedKamm = Math.max(0, Math.ceil((pages - 4) / 2));

    // Проверяем плотность для наценок
    let isSisu200 = sisuPaber.includes('200g');
    let isKaane200 = kaanePaber.includes('200g');
    let isKaane250or300 = kaanePaber.includes('250g') || kaanePaber.includes('300g');

    if (binding === 'klamber') {
        if (formaat === 'A5') {
            let contentUnit = isSisu200 ? (sisuLehedKlamber * 0.24 + 0.45) : (sisuLehedKlamber * 0.23 + 0.45);
            contentPrice = contentUnit * qty;

            let coverUnit = 0.23;
            if (isKaane200) coverUnit = 0.24;
            else if (isKaane250or300) coverUnit = 0.26; 
            coverPrice = coverUnit * qty;

        } else if (formaat === 'A4') {
            let contentUnit = isSisu200 ? (sisuLehedKlamber * 0.48 + 0.45) : (sisuLehedKlamber * 0.46 + 0.45);
            contentPrice = contentUnit * qty;

            let coverUnit = 0.46;
            if (isKaane200) coverUnit = 0.48;
            else if (isKaane250or300) coverUnit = 0.52;
            coverPrice = coverUnit * qty;
        }
    } else if (binding === 'kamm') {
        if (formaat === 'A5') {
            let contentUnit = sisuLehedKamm * 0.115 + 0.85; 
            contentPrice = contentUnit * qty;

            let coverUnit = 0.23;
            if (isKaane200) coverUnit = 0.24;
            else if (isKaane250or300) coverUnit = 0.26;
            coverPrice = coverUnit * qty;

            if (plastkaaned) plastPrice = 0.60 * qty;

        } else if (formaat === 'A4') {
            let contentUnit = sisuLehedKamm * 0.23 + 0.85;
            contentPrice = contentUnit * qty;

            let coverUnit = 0.46;
            if (kaanePaber.includes('300g')) coverUnit = 0.64; 
            else if (isKaane200 || kaanePaber.includes('250g')) coverUnit = 0.55; 
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

    // Подготовка данных для письма на email
    document.getElementById('hidden_qty').value = qty;
    document.getElementById('hidden_total').value = finalDisplay + ' €';
    
    let bindingName = binding === 'klamber' ? 'Klamberköide' : 'Kammköide';
    let plastName = (binding === 'kamm' && plastkaaned) ? ' | Plastkaaned: JAH' : '';
    
    // Получаем красивые названия бумаги из дропдаунов
    let sisuName = document.getElementById('sisu_paber').options[document.getElementById('sisu_paber').selectedIndex].text;
    let kaaneName = document.getElementById('kaane_paber').options[document.getElementById('kaane_paber').selectedIndex].text;
    
    let details = "Formaat: " + formaat + " | " + bindingName + " | Lehti: " + pages + " | Sisu: " + sisuName + " | Kaaned: " + kaaneName + plastName;
    document.getElementById('hidden_paper_type').value = details;
}

// Привязываем слушатели событий
document.querySelectorAll('input[name="binding"]').forEach(r => r.addEventListener('change', buildDropdowns));
document.querySelectorAll('input[name="formaat"]').forEach(r => r.addEventListener('change', updatePrice));
document.getElementById('pages_input').addEventListener('change', updatePrice);
document.getElementById('sisu_paber').addEventListener('change', updatePrice);
document.getElementById('kaane_paber').addEventListener('change', updatePrice);
document.getElementById('plastkaaned').addEventListener('change', updatePrice);

document.getElementById('q_range').addEventListener('input', function() { document.getElementById('q_input').value = this.value; updatePrice(); });
document.getElementById('q_input').addEventListener('input', function() { document.getElementById('q_range').value = this.value; updatePrice(); });

// Запускаем сборку интерфейса при первой загрузке страницы
buildDropdowns();
</script>
<?php
// Проверяем текущий язык сайта
$l = isset($current_lang) ? $current_lang : 'et';

// --- МИНИ-СЛОВАРЬ ДЛЯ КАЛЬКУЛЯТОРА ПЛАКАТОВ ---
$calc_lang = [
    'et' => [
        'qty' => 'Vali kogus:',
        'format' => 'Vali formaat:',
        'paper' => 'Vali paber:',
        'paper_150' => '150g matt',
        'paper_200' => '200g fotosatiin',
        'paper_plast' => 'Plastpaber',
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
        'paper_150' => '150г матовая',
        'paper_200' => '200г фотосатин',
        'paper_plast' => 'Пластиковая бумага',
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
        'paper_150' => '150g matte',
        'paper_200' => '200g photo satin',
        'paper_plast' => 'Plastic paper',
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
        'paper_150' => '150g matta',
        'paper_200' => '200g fotosatiini',
        'paper_plast' => 'Muovipaperi',
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
            <input type="range" id="q_range" class="qty-range" min="1" max="200" step="1" value="1">
            <input type="number" id="q_input" class="qty-number" value="1" min="1" max="200">
        </div>
    </div>

    <div class="calc-group">
        <label class="calc-label"><?= $t['format'] ?></label>
        <div class="radio-group">
            <label><input type="radio" name="formaat" value="A2" checked> A2</label>
            <label><input type="radio" name="formaat" value="A1"> A1</label>
            <label><input type="radio" name="formaat" value="A0"> A0</label>
        </div>
    </div>

    <div class="calc-group">
        <label class="calc-label"><?= $t['paper'] ?></label>
        <select id="paber" class="calc-select">
            <option value="150g_matt"><?= $t['paper_150'] ?></option>
            <option value="200g_fotosatiin" selected><?= $t['paper_200'] ?></option>
            <option value="plastpaber"><?= $t['paper_plast'] ?></option>
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
/* Стили для калькулятора (Те же, что и у флаеров) */
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
    let qty = parseInt(document.getElementById('q_input').value);
    if (isNaN(qty) || qty < 1) qty = 1;

    const formaat = document.querySelector('input[name="formaat"]:checked').value;
    const paber = document.getElementById('paber').value;
    
    let baseTkPrice = 0; 

    // 1. Ищем базовую цену за 1 штуку (по формату A2)
    if (paber === "150g_matt") {
        if (qty < 50) baseTkPrice = 1.75;
        else baseTkPrice = 1.70;
    } else if (paber === "200g_fotosatiin") {
        if (qty < 50) baseTkPrice = 2.75;
        else baseTkPrice = 2.50;
    } else if (paber === "plastpaber") {
        if (qty < 50) baseTkPrice = 4.00;
        else baseTkPrice = 3.75;
    }

    // 2. Коэффициенты форматов
    let multiplier = 1; 

    if (formaat === "A2") {
        multiplier = 1;
    } else if (formaat === "A1") {
        multiplier = 2; 
    } else if (formaat === "A0") {
        multiplier = 4;      
    }

    // 3. Считаем итоговую цену: (Цена штуки * коэффициент * количество)
    let total = (baseTkPrice * multiplier * qty);

    // 4. Минимальная сумма заказа 9 евро
    if (total < 9) {
        total = 9;
    }

    // Вывод цены
    const finalDisplay = total.toFixed(2);
    document.getElementById('final_price').innerText = finalDisplay;

    // --- ПЕРЕДАЧА ДАННЫХ ДЛЯ ОБРАБОТЧИКА ПИСЕМ ---
    document.getElementById('hidden_qty').value = qty;
    document.getElementById('hidden_total').value = finalDisplay + ' €';
    
    // Получаем красивое название бумаги для email и склеиваем с форматом
    const paberSelect = document.getElementById('paber');
    const paberName = paberSelect.options[paberSelect.selectedIndex].text;
    
    const hiddenPaperField = document.getElementById('hidden_paper_type');
    if (hiddenPaperField) {
        hiddenPaperField.value = "Formaat: " + formaat + " | Paber: " + paberName;
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
document.querySelectorAll('input[name="formaat"]').forEach(radio => {
    radio.addEventListener('change', updatePrice);
});
document.getElementById('paber').addEventListener('change', updatePrice);

// Показ формы
document.getElementById('showOrder').addEventListener('click', function() {
    this.style.display = 'none';
    document.getElementById('orderForm').style.display = 'block';
    updatePrice();
});

// Инициализация при загрузке
updatePrice();
</script>
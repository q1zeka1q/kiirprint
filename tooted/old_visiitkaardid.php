<?php include '../includes/header.php'; ?>

<div class="container" style="padding: 60px 0;">
    <h1 style="text-align: center; color: #f36f21; margin-bottom: 40px;">Visiitkaartide kalkulaator</h1>

    <div class="calc-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">
        <div class="calc-settings" style="background: #fdfdfd; padding: 30px; border-radius: 15px; border: 1px solid #eee;">
            
            <label><b>1. Vali kogus:</b></label>
            <div style="display: flex; align-items: center; gap: 20px; margin: 15px 0 30px 0;">
                <input type="range" id="qRange" min="100" max="2000" step="50" value="100" style="flex: 1; accent-color: #f36f21;">
                <input type="number" id="qInput" value="100" min="100" style="width: 80px; padding: 8px; border: 1px solid #ddd;">
            </div>

            <label><b>2. Vali paber:</b></label>
            <select id="paper" style="width: 100%; padding: 12px; margin: 15px 0 30px 0; border: 1px solid #ddd; border-radius: 5px;">
                <option value="standard">300g kaetud matt kartong (Default)</option>
                <option value="premium">330g kaetud poolläikiv kartong</option>
                <option value="special">335g katmata matt / 300g taaskasutatud (+0.005€/tk)</option>
            </select>

            <label><b>3. Trükk:</b></label>
            <div style="margin: 15px 0 30px 0;">
                <label><input type="radio" name="sides" value="1" checked> Ühepoolne</label> &nbsp;
                <label><input type="radio" name="sides" value="2"> Kahepoolne</label>
            </div>

            <label><b>4. Laminaat:</b></label>
            <div style="margin: 15px 0 30px 0;">
                <label><input type="radio" name="lam" value="0" checked> Ei soovi</label> &nbsp;
                <label><input type="radio" name="lam" value="1"> Jah, soovin laminaati</label>
            </div>
        </div>

        <div class="calc-result" style="background: #333; color: #fff; padding: 40px; border-radius: 15px; position: sticky; top: 20px;">
            <h2 style="margin-top: 0; color: #f36f21;">Hind kokku:</h2>
            <div id="totalPrice" style="font-size: 3rem; font-weight: bold; margin-bottom: 10px;">0.00 €</div>
            <p style="color: #ccc; font-size: 0.9rem;">* Käibemaks ei sisaldu hinnas</p>
            
            <hr style="border: 0; border-top: 1px solid #555; margin: 30px 0;">

            <form action="send_order.php" method="POST">
                <input type="hidden" name="details" id="order_details">
                <input type="text" name="name" placeholder="Sinu nimi" required style="width: 100%; padding: 12px; margin-bottom: 15px; border-radius: 5px; border: none;">
                <input type="email" name="email" placeholder="Sinu e-mail" required style="width: 100%; padding: 12px; margin-bottom: 15px; border-radius: 5px; border: none;">
                <textarea name="info" placeholder="Lisainfo" style="width: 100%; padding: 12px; height: 80px; border-radius: 5px; border: none;"></textarea>
                <button type="submit" style="width: 100%; background: #f36f21; color: white; border: none; padding: 15px; font-weight: bold; font-size: 1.1rem; border-radius: 5px; cursor: pointer; margin-top: 20px;">SAADA TELLIMUS</button>
            </form>
        </div>
    </div>
</div>

<script>
const qRange = document.getElementById('qRange');
const qInput = document.getElementById('qInput');
const paper = document.getElementById('paper');
const priceEl = document.getElementById('totalPrice');

function calculate() {
    let q = parseInt(qInput.value);
    if (q < 100) q = 100;

    // Логика цен из PDF [cite: 31, 32, 33, 34, 35, 36]
    let base = 0.10; let base2 = 0.12;
    if (q >= 1500) { base = 0.06; base2 = 0.08; }
    else if (q >= 1000) { base = 0.065; base2 = 0.085; }
    else if (q >= 700) { base = 0.07; base2 = 0.09; }
    else if (q >= 500) { base = 0.08; base2 = 0.10; }
    else if (q >= 300) { base = 0.09; base2 = 0.11; }

    let isDouble = document.querySelector('input[name="sides"]:checked').value == "2";
    let currentPrice = isDouble ? base2 : base;

    // Добавка за бумагу 
    if (paper.value === 'special') currentPrice += 0.005;

    // Ламинат 
    let lam = document.querySelector('input[name="lam"]:checked').value == "1";
    if (lam) {
        if (q >= 1000) currentPrice += 0.06;
        else if (q >= 500) currentPrice += 0.07;
        else currentPrice += 0.08;
    }

    let total = q * currentPrice;
    priceEl.innerText = total.toFixed(2) + " €";
}

qRange.oninput = () => { qInput.value = qRange.value; calculate(); };
qInput.oninput = () => { qRange.value = qInput.value; calculate(); };
document.querySelectorAll('input, select').forEach(el => el.onchange = calculate);
calculate();
</script>

<?php include '../includes/footer.php'; ?>
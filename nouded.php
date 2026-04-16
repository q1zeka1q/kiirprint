<?php 
require_once 'includes/config.php';

// Massiiv kõikide tekstidega 4 keeles (täispikk versioon)
$page_lang = [
    'et' => [
        'title' => 'Nõuded failidele',
        'subtitle' => 'Kuidas valmistada trükifail õigesti ette',
        'general_title' => 'Üldised nõuded',
        'general_list' => '
            <li>Trükifailid peavad olema alati <strong>PDF CMYK</strong>.</li>
            <li>Tekstid tuleks konverteerida kurvideks (Curves, Outlines).</li>
            <li>Lõikevaru peab olema igas servas võrdselt 3 mm.</li>
            <li>Lõikemärke ega trükimärke ei tohi olla lisatud.</li>
            <li>Failis ei tohi olla valgeid ääri, kui see ei ole soovitud kujunduse osa.</li>
            <li>Faili mõõt peab olema 1:1 –le soovitud trükise mõõduga + bleed.</li>
            <li>Ühe trükise leheküljed peavad kõik olema ühes PDF failis.</li>
            <li>Kõik samasuguse formaadi ja trükiarvuga erinevad kujundused peavad olema ühes PDF failis.</li>
            <li>Pinnalaotusi ei tohiks saata, need teeb meie töövoo tarkvara.</li>
            <li>Pildi resolutsioon võiks olla 300 dpi.</li>
            <li>Failid peavad olema CMYK-is.</li>
            <li>Olulised kujunduselemendid peavad olema kõigist välisäärtest vähemalt 4 mm kaugusel, muidu võib teie jaoks oluline info lõikamise käigus maha minna. Lisaks tuleb arvestada ka bleed, mis ära lõigatakse.</li>',
        'brochures_title' => 'Nõuded brošüüride failidele',
        'brochures_text' => 'Kõik brošüüris olevad leheküljed peavad olema ühes failis ja tulema järjest, alustades kaane välisküljest, siis kaane sisekülg jne. Leheküljed ei tohi olla kõrvuti paigutatud, pinnalaotuse teeme ise.<br>Klamberköite brošüüri puhul peab lehekülgede arv kindlasti jaguma 4-ga.',
        'stickers_title' => 'Nõuded kleebistele',
        'stickers_text' => 'Kõik tekstid peavad olema konverteeritud kurvideks (tekstidele tuleb teha outline), kui see on tegemata, siis me ei vastuta selle eest, kui kleebistel osa tekste on puudu, kadunud või asukohta muutnud.<br>Kui kleebised tulevad erikujulised, siis tuleb kaasa panna ka eraldi lõikejoonis, mis peab olema vektoris.<br>Failid peavad olema CMYK-is.',
        'bleed_title' => 'Lõikevaru ehk bleed',
        'bleed_text' => 'Lõikevaru ehk bleed 3 mm igas ääres on vajalik selleks, et tellitud trükiseid saaks pakis lõigata. Kujundamisel tuleks samuti arvestada, et olulisi kujunduselemente ei tohi panna välisäärtele liiga lähedale (peale lõikamist peaks see vahe olema vähemalt 4 mm).',
        'color_title' => 'Värvisüsteem',
        'color_text' => 'Kasutada tuleb ainult <strong>CMYK värve</strong>, Pantone ega Spot värve ei tohi failis olla, samuti ei või kasutada RGB värvisüsteemi. Juhul kui seda nõuet ei ole täidetud, siis automaatselt toimub trükkimine ikkagi CMYK –is, meie ei vastuta sel juhul värvitulemuse ega kvaliteedi eest. Kui soovite, et kontrollime teie faili vastavust soovitud toonidele, peate saatma trükitud värvi näidise ja teenuse meilt eraldi tellima.<br><br>Toonid, mida te ekraanil näete, ei pruugi tulla samasugused trükkides. Värvide edastamist mõjutavad oluliselt arvuti kuvar, valgus jne. Kui failid ei ole tehtud CMYK-is, siis mõningal juhul võivad toonid muutuda oluliselt.',
        'res_title' => 'Resolutsioon',
        'res_text' => 'Faili resolutsioon sõltub trükitoote suurusest: mida väiksem on trükk, seda suurem peab olema dpi, sest mida väiksem on trükitud kujundus, seda lähedamalt seda vaadatakse. Näiteks väikese formaadilisel (kuni A3) printimisel kvaliteedi saavutamiseks on soovitav resolutsioon vähemalt 300 dpi. Suureformaadilistel trükistel võib resolutsioon olla ka 150 dpi.<br><br>Saadetav trükifail peab olema lõppmõõdus või proportsionaalselt vähendatud. Kui te saadate vähendatud faili, siis tuleb tõsta ka vastavalt resolutsiooni.',
        'sending_text' => 'Alla 10 mb failid võib saata e-mailiga aadressile <a href="mailto:info@kiirprint.ee">info@kiirprint.ee</a><br>Suuremad failid saab saata näiteks - <a href="https://www.wetransfer.com" target="_blank">www.wetransfer.com</a> lingina'
    ],
    'ru' => [
        'title' => 'Требования к файлам',
        'subtitle' => 'Как правильно подготовить файл к печати',
        'general_title' => 'Общие требования',
        'general_list' => '
            <li>Файлы для печати всегда должны быть в формате <strong>PDF CMYK</strong>.</li>
            <li>Все тексты должны быть переведены в кривые (Curves, Outlines).</li>
            <li>Вылеты под обрез (bleed) должны быть ровно 3 мм с каждой стороны.</li>
            <li>Не добавляйте метки реза или печатные шкалы.</li>
            <li>В файле не должно быть белых полей, если они не являются частью дизайна.</li>
            <li>Размер файла должен быть 1:1 к желаемому размеру изделия + вылеты.</li>
            <li>Все страницы одного изделия должны находиться в одном PDF файле.</li>
            <li>Разные макеты одного формата и тиража должны быть в одном PDF файле.</li>
            <li>Не присылайте развороты, спуск полос делает наша программа.</li>
            <li>Разрешение изображения должно быть 300 dpi.</li>
            <li>Файлы должны быть в CMYK.</li>
            <li>Важные элементы дизайна должны находиться на расстоянии не менее 4 мм от края, иначе они могут быть обрезаны. Также учитывайте вылеты (bleed), которые срезаются.</li>',
        'brochures_title' => 'Требования к брошюрам',
        'brochures_text' => 'Все страницы брошюры должны быть в одном файле по порядку: первая обложка, вторая страница обложки и т.д. Страницы не должны располагаться разворотами, спуск полос мы делаем сами.<br>Для брошюр на скрепке количество страниц обязательно должно делиться на 4.',
        'stickers_title' => 'Требования к наклейкам',
        'stickers_text' => 'Все тексты должны быть переведены в кривые (outline). Если это не сделано, мы не несем ответственности за пропавший или съехавший текст на наклейках.<br>Для фигурных наклеек необходимо приложить отдельный контур реза в векторном формате.<br>Файлы должны быть в CMYK.',
        'bleed_title' => 'Вылеты под обрез (bleed)',
        'bleed_text' => 'Вылеты под обрез (bleed) по 3 мм с каждого края необходимы для того, чтобы напечатанные листы можно было ровно разрезать в стопке. При создании дизайна также учитывайте, что важные элементы нельзя располагать слишком близко к краю (после реза безопасное расстояние должно быть не менее 4 мм).',
        'color_title' => 'Цветовая модель',
        'color_text' => 'Необходимо использовать только <strong>CMYK</strong>. В файле не должно быть цветов Pantone или Spot, а также RGB. Если это требование не выполнено, печать автоматически пройдет в CMYK, и мы не несем ответственности за точность цветопередачи и качество. Если вы хотите, чтобы мы проверили файл на соответствие тонам, пришлите образец цвета и закажите эту услугу отдельно.<br><br>Цвета на мониторе могут отличаться от напечатанных. На восприятие цвета сильно влияют монитор, освещение и т.д. Если файлы сделаны не в CMYK, цвета могут значительно измениться.',
        'res_title' => 'Разрешение',
        'res_text' => 'Разрешение зависит от размера изделия: чем меньше отпечаток, тем больше должен быть dpi, так как мелкий текст рассматривают с близкого расстояния. Для качественной печати малых форматов (до А3) рекомендуется не менее 300 dpi. Для широкоформатной печати допускается 150 dpi.<br><br>Файл должен быть в итоговом размере или пропорционально уменьшен. Если вы уменьшаете размер файла, необходимо пропорционально увеличить разрешение.',
        'sending_text' => 'Файлы до 10 МБ можно присылать на <a href="mailto:info@kiirprint.ee">info@kiirprint.ee</a><br>Более крупные файлы можно отправить ссылкой через <a href="https://www.wetransfer.com" target="_blank">www.wetransfer.com</a>'
    ],
    'en' => [
        'title' => 'File Requirements',
        'subtitle' => 'How to prepare your print files correctly',
        'general_title' => 'General Requirements',
        'general_list' => '
            <li>Print files must always be <strong>PDF CMYK</strong>.</li>
            <li>All texts should be converted to curves/outlines.</li>
            <li>Bleed must be exactly 3 mm on all sides.</li>
            <li>Do not include crop marks or print marks.</li>
            <li>The file should not have white borders unless it is part of the design.</li>
            <li>File size must be 1:1 to the finished product size + bleed.</li>
            <li>All pages of a single product must be in one PDF file.</li>
            <li>Different designs of the same format and quantity must be in one PDF file.</li>
            <li>Do not send spreads, our workflow software will handle imposition.</li>
            <li>Image resolution should be 300 dpi.</li>
            <li>Files must be in CMYK.</li>
            <li>Important design elements should be at least 4 mm away from the cutting edges, otherwise they may be cut off. Also remember to account for the bleed that will be trimmed.</li>',
        'brochures_title' => 'Brochure Requirements',
        'brochures_text' => 'All pages in the brochure must be in a single file in consecutive order, starting from the outside cover. Pages must not be set up as spreads, we do the imposition.<br>For saddle-stitched brochures, the total page count must be divisible by 4.',
        'stickers_title' => 'Sticker Requirements',
        'stickers_text' => 'All texts must be converted to curves. If not done, we are not responsible for missing or shifted texts on the stickers.<br>If the stickers have a custom shape, a separate vector cutline must be included.<br>Files must be in CMYK.',
        'bleed_title' => 'Bleed',
        'bleed_text' => 'A 3 mm bleed on all sides is necessary so that the printed sheets can be cut cleanly in a stack. When designing, ensure important elements are not placed too close to the edge (leave a safe margin of at least 4 mm after cutting).',
        'color_title' => 'Color System',
        'color_text' => 'Use only <strong>CMYK colors</strong>. No Pantone, Spot, or RGB colors are allowed. If this requirement is not met, printing will automatically be done in CMYK, and we are not responsible for the color accuracy or quality. If you want us to check the file for color matching, you must send a printed color sample and order this service separately.<br><br>The colors you see on your screen may not look the same when printed. Screens use RGB and are affected by lighting. If files are not prepared in CMYK, colors may change significantly.',
        'res_title' => 'Resolution',
        'res_text' => 'File resolution depends on the print size: the smaller the print, the higher the dpi needs to be, as it will be viewed closer. For high-quality small format printing (up to A3), at least 300 dpi is recommended. For large format prints, 150 dpi is acceptable.<br><br>The print file must be at the final size or proportionally scaled down. If you scale down the file, you must increase the resolution accordingly.',
        'sending_text' => 'Files under 10 MB can be sent via email to <a href="mailto:info@kiirprint.ee">info@kiirprint.ee</a><br>Larger files can be sent using a link via <a href="https://www.wetransfer.com" target="_blank">www.wetransfer.com</a>'
    ],
    'fi' => [
        'title' => 'Tiedostovaatimukset',
        'subtitle' => 'Kuinka valmistaa painotiedosto oikein',
        'general_title' => 'Yleiset vaatimukset',
        'general_list' => '
            <li>Painotiedostojen tulee aina olla <strong>PDF CMYK</strong>.</li>
            <li>Tekstit tulee muuntaa poluiksi (Curves, Outlines).</li>
            <li>Leikkuuvarojen (bleed) on oltava tasan 3 mm jokaisella sivulla.</li>
            <li>Älä lisää leikkuumerkkejä.</li>
            <li>Tiedostossa ei saa olla valkoisia reunoja, elleivät ne kuulu suunnitteluun.</li>
            <li>Tiedoston koon on oltava 1:1 valmiin tuotteen kanssa + leikkuuvarat.</li>
            <li>Kaikki yhden tuotteen sivut on oltava yhdessä PDF-tiedostossa.</li>
            <li>Saman koon ja painosmäärän eri mallit on oltava samassa PDF-tiedostossa.</li>
            <li>Älä tee aukeamia, ohjelmistomme hoitaa asemoinnin.</li>
            <li>Kuvan resoluution tulisi olla 300 dpi.</li>
            <li>Tiedostojen on oltava CMYK-muodossa.</li>
            <li>Tärkeät suunnitteluelementit on sijoitettava vähintään 4 mm etäisyydelle leikkuureunasta, muuten tärkeää tietoa voi leikkautua pois. Ota myös huomioon pois leikattava leikkuuvara.</li>',
        'brochures_title' => 'Esitteiden vaatimukset',
        'brochures_text' => 'Kaikkien esitteen sivujen on oltava samassa tiedostossa järjestyksessä, alkaen etukannesta. Sivuja ei saa asettaa aukeamiksi.<br>Nidottujen esitteiden sivumäärän on ehdottomasti oltava jaollinen 4:llä.',
        'stickers_title' => 'Tarrojen vaatimukset',
        'stickers_text' => 'Kaikki tekstit on muutettava poluiksi (outline). Jos näin ei tehdä, emme ota vastuuta puuttuvista tai siirtyneistä teksteistä.<br>Erikoismuotoisille tarroille on toimitettava erillinen vektorimuotoinen leikkuulinja.<br>Tiedostojen on oltava CMYK-muodossa.',
        'bleed_title' => 'Leikkuuvara (bleed)',
        'bleed_text' => '3 mm leikkuuvara joka reunalla on välttämätön, jotta painetut arkit voidaan leikata siististi pinossa. Tärkeitä elementtejä ei myöskään saa asettaa liian lähelle reunaa (leikkauksen jälkeen turvamarginaalin tulisi olla vähintään 4 mm).',
        'color_title' => 'Värijärjestelmä',
        'color_text' => 'Käytä vain <strong>CMYK-värejä</strong>. Pantone, Spot tai RGB -värejä ei saa käyttää. Jos tiedosto on RGB-muodossa, se muunnetaan automaattisesti CMYK-muotoon, emmekä vastaa tällöin värien tarkkuudesta. Jos haluat meidän tarkistavan värit, sinun on lähetettävä painettu värimalli ja tilattava tämä palvelu erikseen.<br><br>Näytöllä näkyvät värit eivät välttämättä näytä samalta painettuna. Näytöt käyttävät RGB-värejä.',
        'res_title' => 'Resoluutio',
        'res_text' => 'Tiedoston resoluutio riippuu painotuotteen koosta. Pienissä formaateissa (A3 asti) suositellaan vähintään 300 dpi resoluutiota laadun takaamiseksi. Suurkuvatulosteissa resoluutio voi olla 150 dpi.<br><br>Tiedoston on oltava joko lopullisessa koossa tai suhteutettuna pienennetty. Jos pienennät tiedostoa, sinun on vastaavasti suurennettava resoluutiota.',
        'sending_text' => 'Alle 10 MB tiedostot voi lähettää sähköpostitse osoitteeseen <a href="mailto:info@kiirprint.ee">info@kiirprint.ee</a><br>Suuremmat tiedostot voi lähettää linkkinä, esim. <a href="https://www.wetransfer.com" target="_blank">www.wetransfer.com</a> kautta.'
    ]
];

// Leiame õige keele
$cl = isset($current_lang) && isset($page_lang[$current_lang]) ? $current_lang : 'et';
$text = $page_lang[$cl];

include 'includes/header.php'; 
?>

<main class="main-content">
    <section class="section-white">
        <div class="container" style="max-width: 900px; margin: 0 auto; padding-top: 40px; padding-bottom: 60px;">
            
            <div style="text-align: center; margin-bottom: 40px;">
                <h1 class="main-title"><?= $text['title'] ?></h1>
                <div class="accent-line"></div>
                <p style="color: #718096; font-size: 18px;"><?= $text['subtitle'] ?></p>
            </div>

            <div class="rules-block">
                
                <h2><?= $text['general_title'] ?></h2>
                <ul class="styled-list">
                    <?= $text['general_list'] ?>
                </ul>

                <h2 style="margin-top: 40px;"><?= $text['brochures_title'] ?></h2>
                <p><?= $text['brochures_text'] ?></p>

                <h2 style="margin-top: 40px;"><?= $text['stickers_title'] ?></h2>
                <p><?= $text['stickers_text'] ?></p>

                <h2 style="margin-top: 40px;"><?= $text['bleed_title'] ?></h2>
                <p><?= $text['bleed_text'] ?></p>
                
                <div style="margin: 30px 0; text-align: center;">
                    <img src="img/Bleed_äär-01-768x337.jpg" alt="Bleed Information" style="max-width: 100%; border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); border: 1px solid #edf2f7;">
                </div>

                <h2 style="margin-top: 40px;"><?= $text['color_title'] ?></h2>
                <p><?= $text['color_text'] ?></p>

                <h2 style="margin-top: 40px;"><?= $text['res_title'] ?></h2>
                <p><?= $text['res_text'] ?></p>

                <div style="margin-top: 50px; padding: 25px; background: #fff5f0; border-left: 4px solid #f36f21; border-radius: 0 8px 8px 0;">
                    <p style="margin: 0; font-weight: 500;"><?= $text['sending_text'] ?></p>
                </div>

            </div>

        </div>
    </section>
</main>

<style>
/* Kujunduse stiilid */
.rules-block {
    background: #fcfcfc;
    padding: 50px;
    border-radius: 16px;
    border: 1px solid #edf2f7;
    box-shadow: 0 4px 20px rgba(0,0,0,0.04);
}

.rules-block h2 {
    color: #2d3748;
    font-size: 24px;
    margin-bottom: 15px;
    border-bottom: 2px solid #f36f21;
    padding-bottom: 8px;
    display: inline-block;
}

.rules-block p {
    color: #4a5568;
    font-size: 16px;
    line-height: 1.8;
}

.rules-block a {
    color: #f36f21;
    text-decoration: none;
    font-weight: 600;
}

.rules-block a:hover {
    text-decoration: underline;
}

.styled-list {
    list-style-type: none;
    padding-left: 0;
}

.styled-list li {
    position: relative;
    padding-left: 30px;
    margin-bottom: 12px;
    color: #4a5568;
    font-size: 16px;
    line-height: 1.6;
}

.styled-list li:before {
    content: '✓';
    position: absolute;
    left: 0;
    top: 0;
    color: #f36f21;
    font-weight: bold;
    font-size: 18px;
}

@media (max-width: 768px) {
    .rules-block {
        padding: 25px;
    }
}
</style>

<?php include 'includes/footer.php'; ?>
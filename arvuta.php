<?php
// Andmebaasi ühendus
require_once 'includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Andmed vormist
    $kogus = intval($_POST['kogus']);
    $tyyp = $_POST['tyyp'];
    $paber = $_POST['paber'];
    $laminaat_hind = floatval($_POST['laminaat']);
    $nimi = $_POST['klient_nimi'];
    $email = $_POST['klient_email'];

    // Otsime baashinna andmebaasist
    $sql = "SELECT * FROM visiitkaardid_hinnad 
            WHERE kogus_alates <= $kogus 
            AND (kogus_kuni >= $kogus OR kogus_kuni = 0) 
            LIMIT 1";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Määrame baashinna vastavalt trükile
        $baashind = ($tyyp == '4_4') ? $row['hind_4_4'] : $row['hind_4_0'];

        // Arvutame lõpliku tüki hinna (baashind + laminaat)
        $yksuse_hind = $baashind + $laminaat_hind;
        $summa_ilma_km = $kogus * $yksuse_hind;

        // --- PARANDATUD KÄIBEMAKS 24% ---
        $km_protsent = 0.24; 
        $km_summa = $summa_ilma_km * $km_protsent;
        $kokku_km_ga = $summa_ilma_km + $km_summa;

        // Kuvame tulemuse
        echo "<div style='font-family: Arial; padding: 20px; max-width: 600px; background: white; border: 1px solid #ddd;'>";
        echo "<h1>Arvutamise tulemus</h1>";
        echo "<strong>Klient:</strong> $nimi ($email)<br>";
        echo "<strong>Kogus:</strong> $kogus tk<br>";
        echo "<strong>Paber:</strong> $paber<br>";
        echo "<hr>";
        echo "Ühe tüki hind (KM-ta): " . number_format($yksuse_hind, 3) . " EUR<br>";
        echo "Summa kokku (KM-ta): " . number_format($summa_ilma_km, 2) . " EUR<br>";
        echo "Käibemaks (24%): " . number_format($km_summa, 2) . " EUR<br>";
        echo "<h2 style='color: #28a745;'>KOKKU TASUDA: " . number_format($kokku_km_ga, 2) . " EUR</h2>";
        
        echo "<br><a href='visiitkaardid.php'>Tagasi arvutama</a>";
        echo "</div>";

    } else {
        echo "Viga: Kogust ei leitud hinnakirjast.";
    }
}

$conn->close();
?>
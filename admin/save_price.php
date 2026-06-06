<?php
session_start();
if (!isset($_SESSION['logged_in'])) { exit; }

require_once '../includes/config.php';

if (isset($_POST['add_price'])) {
    $service_id = (int)$_POST['service_id'];
    $kogus_alates = (int)$_POST['kogus_alates'];
    
    $hind_4_0 = (float)str_replace(',', '.', $_POST['hind_4_0']);
    $hind_4_4 = (float)str_replace(',', '.', $_POST['hind_4_4']);

    $sql = "INSERT INTO prices (service_id, kogus_alates, hind_4_0, hind_4_4) 
            VALUES (:sid, :kogus, :h40, :h44)";
    
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([
        'sid'   => $service_id,
        'kogus' => $kogus_alates,
        'h40'   => $hind_4_0,
        'h44'   => $hind_4_4
    ])) {
        header("Location: admin.php?page=prices&service_id=" . $service_id);
        exit;
    } else {
        die("Viga andmete salvestamisel.");
    }
}
?>
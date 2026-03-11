<?php
require_once 'includes/config.php';
require_once 'includes/mailer.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Принимаем данные
    $service_id = intval($_POST['service_id']);
    $quantity   = intval($_POST['quantity']);
    $price      = floatval($_POST['total_price']);
    $paper_type = mysqli_real_escape_string($conn, $_POST['paper_type']);
    $name       = mysqli_real_escape_string($conn, $_POST['client_name']);
    $email      = mysqli_real_escape_string($conn, $_POST['client_email']);
    $phone      = mysqli_real_escape_string($conn, $_POST['client_phone']);
    $client_message = mysqli_real_escape_string($conn, $_POST['client_message']);

    // 2. Записываем в базу
    $sql = "INSERT INTO orders (service_id, quantity, paper_type, total_price, client_name, client_email, client_phone, client_message, status, order_date) 
            VALUES ('$service_id', '$quantity', '$paper_type', '$price', '$name', '$email', '$phone', '$client_message', 'uus', NOW())";

    if ($conn->query($sql)) {
        $order_id = $conn->insert_id; // Номер заказа получен!

        // Достаем название услуги
        $serv_res = $conn->query("SELECT title FROM services WHERE id = $service_id");
        $serv_row = $serv_res->fetch_assoc();
        $service_title = $serv_row ? $serv_row['title'] : 'Teenus';

        // --- ОТПРАВКА ПИСЬМА КЛИЕНТУ С НОМЕРОМ ЗАКАЗА ---
        $to = $email;
        $subject = "Tellimus nr #$order_id on vastu võetud - Kiirprint.ee";
        
        $message = "Tere, $name!\n\n";
        $message .= "Täname tellimuse eest! Teie tellimus nr #$order_id ($service_title) on edukalt vastu võetud.\n\n";
        $message .= "Tellimuse detailid:\n";
        $message .= "-----------------------------\n";
        $message .= "Teenus: $service_title\n";
        $message .= "Kogus: $quantity tk\n";
        $message .= "Paber ja lisad: $paper_type\n";
        $message .= "Summa kokku: " . number_format($price, 2) . " €\n";
        $message .= "-----------------------------\n\n";
        $message .= "Teavitame Teid e-maili teel, kui tellimus on valmis.\n\n";
        $message .= "Lugupidamisega,\nKiirprint.ee meeskond";

        // Если функция send_kiirprint_email использует заголовки внутри себя, то оставляем как есть.
        // Если нет, убедись, что она корректно отправляет $message как UTF-8.
        send_kiirprint_email($to, $subject, $message);
        // -----------------------------------------------

        echo "<script>alert('Aitäh! Teie tellimus nr #$order_id on vastu võetud. Võtame teiega peagi ühendust.'); window.location.href='index.php';</script>";
    } else {
        echo "Viga: " . $conn->error;
    }
}
?>
<?php
// send_order.php - обработка заказа
require_once 'includes/config.php'; // Убедись, что тут подключение через PDO
require_once 'includes/mailer.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Принимаем и очищаем данные
    $service_id     = (int)$_POST['service_id'];
    $quantity       = (int)$_POST['quantity'];
    $price          = (float)$_POST['total_price'];
    $paper_type     = strip_tags($_POST['paper_type']);
    $name           = strip_tags($_POST['client_name']);
    $email          = filter_var($_POST['client_email'], FILTER_SANITIZE_EMAIL);
    $phone          = strip_tags($_POST['client_phone']);
    $client_message = strip_tags($_POST['client_message']);

    // 2. Подготовленный запрос PDO (безопасен от SQL-инъекций)
    $sql = "INSERT INTO orders (service_id, quantity, paper_type, total_price, client_name, client_email, client_phone, client_message, status, order_date) 
            VALUES (:sid, :qty, :paper, :price, :name, :email, :phone, :msg, 'uus', NOW())";
    
    $stmt = $pdo->prepare($sql);
    
    // Выполняем запрос
    if ($stmt->execute([
        'sid'   => $service_id,
        'qty'   => $quantity,
        'paper' => $paper_type,
        'price' => $price,
        'name'  => $name,
        'email' => $email,
        'phone' => $phone,
        'msg'   => $client_message
    ])) {
        // Получаем ID заказа
        $order_id = $pdo->lastInsertId();

        // 3. Получаем название услуги для письма
        $stmt_serv = $pdo->prepare("SELECT title FROM services WHERE id = :sid");
        $stmt_serv->execute(['sid' => $service_id]);
        $service_title = $stmt_serv->fetchColumn() ?: 'Teenus';

        // 4. Отправка письма
        $subject = "Tellimus nr #$order_id on vastu võetud - Kiirprint.ee";
        $message = "Tere, $name!\n\nTäname tellimuse eest! Teie tellimus nr #$order_id ($service_title) on edukalt vastu võetud.\n\n" .
                   "Tellimuse detailid:\n" .
                   "Teenus: $service_title\n" .
                   "Kogus: $quantity tk\n" .
                   "Paber ja lisad: $paper_type\n" .
                   "Summa kokku: " . number_format($price, 2) . " €\n\n" .
                   "Lugupidamisega,\nKiirprint.ee meeskond";

        send_kiirprint_email($email, $subject, $message);

        // 5. Успешный результат
        echo "<script>alert('Aitäh! Teie tellimus nr #$order_id on vastu võetud.'); window.location.href='index.php';</script>";
    } else {
        echo "Viga tellimuse salvestamisel.";
    }
} else {
    // Если кто-то пытается открыть файл напрямую
    header("Location: index.php");
    exit;
}
?>
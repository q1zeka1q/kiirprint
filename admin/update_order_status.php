<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/mailer.php';

// Проверка на админа
if (!isset($_SESSION['logged_in'])) { 
    header("Location: login.php"); 
    exit; 
}

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = intval($_GET['id']);
    $status = mysqli_real_escape_string($conn, $_GET['status']); // 'valmis'

    // 1. Обновляем статус заказа в базе
    $conn->query("UPDATE orders SET status = '$status' WHERE id = $id");

    // 2. Если мы пометили как "Готово", шлем письмо!
    if ($status == 'valmis') {
        // Достаем email клиента, имя и ТОЧНОЕ НАЗВАНИЕ УСЛУГИ
        $sql = "SELECT o.client_email, o.client_name, s.title as service_name 
                FROM orders o 
                LEFT JOIN services s ON o.service_id = s.id 
                WHERE o.id = $id";
        $res = $conn->query($sql);
        
        if ($res && $res->num_rows > 0) {
            $user = $res->fetch_assoc();
            
            $to = $user['client_email'];
            $product_name = $user['service_name'] ? $user['service_name'] : 'Teie tellimus'; // Если услуга вдруг удалена, напишет "Ваш заказ"
            
            $subject = "Teie tellimus on VALMIS! - Kiirprint.ee";
            
            $message = "Tere, " . $user['client_name'] . "!\n\n";
            $message .= "Meil on rõõm teatada, et teie tellimus: **" . $product_name . "** on valmis!\n\n";
            $message .= "Võite sellele järele tulla meie kontorisse.\n\n";
            $message .= "Aitäh, et valisite Kiirprint.ee!\n\n";
            $message .= "Lugupidamisega,\nKiirprint.ee meeskond";
            
            $headers = "From: info@kiirprint.ee\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8";
            
            send_kiirprint_email($to, $subject, $message);
        }
    }
}

// Возвращаемся обратно на страницу заказов
header("Location: admin.php?page=orders");
exit;
?>
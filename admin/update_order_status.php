<?php
session_start();
// Проверка авторизации
if (!isset($_SESSION['logged_in'])) { exit; }

require_once '../includes/config.php'; // Используем $pdo
require_once '../includes/mailer.php';

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = (int)$_GET['id'];
    $status = $_GET['status']; // 'valmis'

    // 1. Безопасное обновление статуса заказа (PDO)
    $stmt = $pdo->prepare("UPDATE orders SET status = :status WHERE id = :id");
    $stmt->execute(['status' => $status, 'id' => $id]);

    // 2. Если мы пометили как "Готово", шлем письмо!
    if ($status == 'valmis') {
        // Достаем email клиента и название услуги
        $sql = "SELECT o.client_email, o.client_name, s.title as service_name 
                FROM orders o 
                LEFT JOIN services s ON o.service_id = s.id 
                WHERE o.id = :id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();
        
        if ($user) {
            $to = $user['client_email'];
            $product_name = $user['service_name'] ?? 'Teie tellimus';
            
            $subject = "Teie tellimus on VALMIS! - Kiirprint.ee";
            
            $message = "Tere, " . $user['client_name'] . "!\n\n";
            $message .= "Meil on rõõm teatada, et teie tellimus: " . $product_name . " on valmis!\n\n";
            $message .= "Võite sellele järele tulla meie kontorisse.\n\n";
            $message .= "Aitäh, et valisite Kiirprint.ee!\n\n";
            $message .= "Lugupidamisega,\nKiirprint.ee meeskond";
            
            // Используем твою функцию отправки почты
            send_kiirprint_email($to, $subject, $message);
        }
    }
}

// Возвращаемся обратно на страницу заказов
header("Location: admin.php?page=orders");
exit;
?>
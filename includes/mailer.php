<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Подключаем файлы PHPMailer
require_once 'PHPMailer/Exception.php';
require_once 'PHPMailer/PHPMailer.php';
require_once 'PHPMailer/SMTP.php';

function send_kiirprint_email($to, $subject, $message) {
    $mail = new PHPMailer(true);

    try {
        // Настройки сервера
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        
        // ВАЖНО: Впиши сюда свои данные!
        $mail->Username   = 'vasilievevgeniy5@gmail.com'; // Твой реальный Gmail
        $mail->Password   = 'aggl xouh xvij grgy'; // Пароль из Шага 1 (без пробелов)
        
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;
        $mail->CharSet    = 'UTF-8';

        // От кого и кому
        $mail->setFrom('vasilievevgeniy5@gmail.com', 'Kiirprint.ee');
        $mail->addAddress($to);

        // Контент
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
        return true;
    } catch (Exception $e) {
        // Если ошибка, можно раскомментировать строку ниже, чтобы увидеть причину:
        // echo "Viga: {$mail->ErrorInfo}";
        return false;
    }
}
?>
<?php
// Подключаем базу данных
require_once 'includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Берем данные из POST (имена должны совпадать с атрибутами name в форме)
    $pealkiri = mysqli_real_escape_string($conn, $_POST['pealkiri']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $tekst = mysqli_real_escape_string($conn, $_POST['tekst']);

    // Запрос к базе
    $sql = "INSERT INTO paringud (pealkiri, email, tekst, kuupaev) 
            VALUES ('$pealkiri', '$email', '$tekst', NOW())";

    if (mysqli_query($conn, $sql)) {
        // Если всё ок, возвращаемся на главную
        header("Location: index.php?success=1");
    } else {
        echo "Viga: " . mysqli_error($conn);
    }
}
?>
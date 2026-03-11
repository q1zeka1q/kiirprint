<?php
require_once '../includes/config.php';

if (isset($_POST['add_price'])) {
    // Получаем данные из формы
    $service_id = intval($_POST['service_id']);
    $kogus_alates = intval($_POST['kogus_alates']);
    
    // Очищаем цену от запятых (заменяем на точки), чтобы база данных приняла число
    $hind_4_0 = str_replace(',', '.', $_POST['hind_4_0']);
    $hind_4_4 = str_replace(',', '.', $_POST['hind_4_4']);
    
    $hind_4_0 = mysqli_real_escape_string($conn, $hind_4_0);
    $hind_4_4 = mysqli_real_escape_string($conn, $hind_4_4);

    // Вставляем данные в НОВУЮ универсальную таблицу prices
    $sql = "INSERT INTO prices (service_id, kogus_alates, hind_4_0, hind_4_4) 
            VALUES ('$service_id', '$kogus_alates', '$hind_4_0', '$hind_4_4')";

    if ($conn->query($sql)) {
        // Возвращаемся обратно на страницу цен с тем же выбранным товаром
        header("Location: admin.php?page=prices&service_id=" . $service_id);
    } else {
        echo "Viga: " . $conn->error;
    }
}
?>
<?php
global $mysqli;

    $db_name = "qrget";
    $db_user = "root";
    $db_pass = "";
    $db_addr = "localhost";

    $mysqli = mysqli_connect($db_addr,$db_user,$db_pass,$db_name);

		

if (!$mysqli) {
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
$mysqli->query("SET NAMES utf8mb4");
$mysqli->query('SET CHARACTER SET utf8mb4');
$mysqli->query('SET COLLATION_CONNECTION="utf8mb4_general_ci"');?>
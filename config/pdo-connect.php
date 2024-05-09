<?php

require __DIR__ . '/connect-config.php';

// echo $db_name;
$dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4";

$pdo_options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

$pdo = new PDO($dsn, $db_user, $db_pass, $pdo_options);


if (!isset($_SESSION)) {
    session_start();
}

// try {
//     $pdo = new PDO("mysql:host=主機名稱;dbname=資料庫名稱", "資料庫帳號", "資料庫密碼");
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     echo "資料庫連線成功";
// } catch(PDOException $e) {
//     echo "資料庫連線失敗：" . $e->getMessage();
// }

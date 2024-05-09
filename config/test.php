<?php

require __DIR__ . '/connect-config.php';

$dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4";

$pdo_options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $db_user, $db_pass, $pdo_options);
    echo "資料庫連線成功";
} catch(PDOException $e) {
    echo "資料庫連線失敗：" . $e->getMessage();
}
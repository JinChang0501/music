<?php
require __DIR__ . '/admin-required.php';
require __DIR__ . '/../config/pdo-connect.php';

header('Content-Type: application/json');

$output = [
    'success' => false, # 有沒有新增成功
    'bodyData' => $_POST,
    'newId' => 0,
];

// TODO: 欄位資料檢查
// 檢查是否有接收到必要的欄位資料
if (!isset($_POST['first_name']) || !isset($_POST['last_name']) || !isset($_POST['email']) || !isset($_POST['passwords']) || !isset($_POST['gender']) || !isset($_POST['phone_number']) || !isset($_POST['birthday']) || !isset($_POST['address'])) {
    echo json_encode($output);
    exit; // 結束 PHP 程式
}

$sql = "INSERT INTO `members`(`first_name`, `last_name`, `email`, `passwords`, `gender`, `phone_number`, `birthday`, `address`,`created_at`) VALUES (
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,NOW() )";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['first_name'],
    $_POST['last_name'],
    $_POST['email'],
    $_POST['passwords'],
    $_POST['gender'],
    $_POST['phone_number'],
    $_POST['birthday'],
    $_POST['address']
]);


$output['success'] = !!$stmt->rowCount(); # 新增了幾筆
$output['newId'] = $pdo->lastInsertId(); # 取得最近的新增資料的primary key

echo json_encode($output);

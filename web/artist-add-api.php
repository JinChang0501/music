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
if (!isset($_POST['artist_name']) || !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['ManagementCompany']) || !isset($_POST['phone_number']) || !isset($_POST['debutDate']) || !isset($_POST['artist_picture'])) {
    echo json_encode($output);
    exit; // 結束 PHP 程式
}

$sql = "INSERT INTO `artist`(`artist_name`, `email`, `password`, `ManagementCompany`, `phone_number`, `debutDate`, `artist_picture`) VALUES (
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
    $_POST['artist_name'],
    $_POST['email'],
    $_POST['password'],
    $_POST['ManagementCompany'],
    $_POST['phone_number'],
    $_POST['debutDate'],
    $_POST['artist_picture'],
]);


$output['success'] = !!$stmt->rowCount(); # 新增了幾筆
$output['newId'] = $pdo->lastInsertId(); # 取得最近的新增資料的primary key

echo json_encode($output);
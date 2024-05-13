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
if (!isset($_POST['product_name']) || !isset($_POST['picture']) || !isset($_POST['price']) || !isset($_POST['purchase_quantity']) || !isset($_POST['activitie_id'])) {
    echo json_encode($output);
    exit; // 結束 PHP 程式
}

$sql = "INSERT INTO `products`(`product_name`, `picture`, `price`, `purchase_quantity`, `activitie_id`) VALUES (
    ?,
    ?,
    ?,
    ?,
    ?, NOW() )";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['product_name'],
    $_POST['picture'],
    $_POST['price'],
    $_POST['purchase_quantity'],
    $_POST['activitie_id']
]);


$output['success'] = !!$stmt->rowCount(); # 新增了幾筆
$output['newId'] = $pdo->lastInsertId(); # 取得最近的新增資料的primary key

echo json_encode($output);

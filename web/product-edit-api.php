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
if (!isset($_POST['product_name'])) {
    echo json_encode($output);
    exit; # 結束 php 程式
}

$sql = "UPDATE `products` SET
 `product_name`=?,
 `picture`=?,
 `price`=?,
 `purchase_quantity`=?,
 `activitie_id`=? 
 WHERE id=?";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['product_name'],
    $_FILES['picture']['name'],
    $_POST['price'],
    $_POST['purchase_quantity'],
    $_POST['activitie_id'],
    $_POST['id'],
]);


$output['success'] = !!$stmt->rowCount(); # 修改了幾筆

echo json_encode($output);

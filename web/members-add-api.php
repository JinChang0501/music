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
if (
    !isset($_POST['first_name']) ||
    !isset($_POST['last_name']) ||
    !isset($_POST['email']) ||
    !isset($_POST['passwords']) ||
    !isset($_POST['gender']) ||
    !isset($_POST['phone_number']) ||
    !isset($_POST['birthday']) ||
    !isset($_POST['address'])
) {
    echo json_encode($output);
    exit; // 結束 PHP 程式
}


// 檢查信箱是否已存在
$email = $_POST['email'];
$sqlCheckEmail = "SELECT * FROM `members` WHERE `email` = ?";
$stmtCheckEmail = $pdo->prepare($sqlCheckEmail);
$stmtCheckEmail->execute([$email]);
if ($stmtCheckEmail->rowCount() > 0) {
    $output['message'] = '電子信箱已被註冊，請使用其他信箱進行註冊';
    echo json_encode($output);
    exit; // 结束 PHP 程序
}

// 檢查是否有上傳照片
if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
    $output['message'] = '未上傳照片或上傳照片失敗';
    echo json_encode($output);
    exit;
}

// 獲取上傳的照片的二進位數據
$photoData = file_get_contents($_FILES['photo']['tmp_name']);

// 插入新的成員資料到資料庫
$sql = "INSERT INTO `members`(`first_name`, `last_name`, `email`, `passwords`, `gender`, `phone_number`, `birthday`, `address`, `photo`, `created_at`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(1, $_POST['first_name']);
$stmt->bindParam(2, $_POST['last_name']);
$stmt->bindParam(3, $_POST['email']);
$stmt->bindParam(4, $_POST['passwords']);
$stmt->bindParam(5, $_POST['gender']);
$stmt->bindParam(6, $_POST['phone_number']);
$stmt->bindParam(7, $_POST['birthday']);
$stmt->bindParam(8, $_POST['address']);
$stmt->bindParam(9, $photoData, PDO::PARAM_LOB);
$stmt->execute();

// $stmt = $pdo->prepare($sql);
// $stmt->execute([
//     $_POST['first_name'],
//     $_POST['last_name'],
//     $_POST['email'],
//     $_POST['passwords'],
//     $_POST['gender'],
//     $_POST['phone_number'],
//     $_POST['birthday'],
//     $_POST['address'],
//     $_POST['photo']
// ]);


$output['success'] = !!$stmt->rowCount(); # 新增了幾筆
$output['newId'] = $pdo->lastInsertId(); # 取得最近的新增資料的primary key

echo json_encode($output);

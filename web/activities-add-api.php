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
if (!isset($_POST['activity_name'])) {
    echo json_encode($output);
    exit; // 結束 PHP 程式
}

// if (!isset($_POST['activity_class']) || !isset($_POST['activity_name']) || !isset($_POST['a_date']) || !isset($_POST['a_time']) || !isset($_POST['location']) || !isset($_POST['address']) || !isset($_POST['descriptions']) || !isset($_POST['organizer']) || !isset($_POST['artist_id']) || !isset($_POST['picture'])) {
//     echo json_encode($output);
//     exit; // 結束 PHP 程式
// }

$a_date = strtotime($_POST['a_date']);
if ($a_date === false) {
    $a_date = null;
} else {
    $a_date = date('Y-m-d', $a_date);
}


$sql = "INSERT INTO `activities`(`activity_class`, `activity_name`, `a_date`, `a_time`, `location`, `address`, `descriptions`, `organizer`, `artist_id`,`picture`) VALUES (
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['activity_class'],
    $_POST['activity_name'],
    $a_date,
    $_POST['a_time'],
    $_POST['location'],
    $_POST['address'],
    $_POST['descriptions'],
    $_POST['organizer'],
    $_POST['artist_id'],
    $_POST['picture'],
]);


$output['success'] = !!$stmt->rowCount(); # 新增了幾筆
$output['newId'] = $pdo->lastInsertId(); # 取得最近的新增資料的primary key

echo json_encode($output);

// // 檢查是否有表單提交
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // 這裡處理表單的提交
//     // try
//     // 清空相應的欄位值
//     $field1 = "";
//     $field2 = "";
//     // 以此類推，清空所有需要清空的欄位值

//     // 假設這裡是將表單資料儲存到資料庫的程式碼

//     // 重定向到另一個頁面或者顯示成功消息
//     // header("Location: success.php");
//     exit();
// }

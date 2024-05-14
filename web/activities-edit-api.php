<?php
require __DIR__ . '/../config/pdo-connect.php';

header('Content-Type: application/json');

$output = [
  'success' => false, # 有沒有新增成功
  'bodyData' => $_POST,
];

// TODO: 欄位資料檢查
if (!isset($_POST['actid'])) {
  echo json_encode($output);
  exit; # 結束 php 程式
}

# preg_match(): regexp 比對用 

# mb_strlen(): 算字串的長度

# filter_var('bob@example.com', FILTER_VALIDATE_EMAIL): 檢查 email 格式


$a_date = strtotime($_POST['a_date']);
if ($a_date === false) {
  $a_date = null;
} else {
  $a_date = date('Y-m-d', $a_date);
}

$sql = "UPDATE `activities` SET 
`activity_class`=?,
`activity_name`=?,
`a_date`=?,
`a_time`=?,
`location`=?,
`address`=?,
`descriptions`=?,
`organizer`=?,
`artist_id`=?,
`picture`=?
WHERE actid=?";

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
  $_POST['actid'],
]);


$output['success'] = !!$stmt->rowCount(); # 修改了幾筆


echo json_encode($output);

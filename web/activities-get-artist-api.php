<?php
require __DIR__ . '/../config/pdo-connect.php';

$title = '獲取artist資料';
$pageName = 'activities-get-artist';

header('Content-Type: application/json');

// 準備 SQL 查詢
$sql = "SELECT 
actid,
aclass.class,
activities.activity_name,
artist_id,
artist.art_name
FROM 
activities
JOIN 
artist ON activities.artist_id = artist.id
JOIN 
aclass ON activities.activity_class = aclass.id";

// 執行 SQL 查詢並獲取結果集
$stmt = $pdo->query($sql);

// 將結果集轉換為關聯數組
$activities = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 將結果轉換為 JSON 格式
$json = json_encode($activities);

// 返回 JSON 數據
echo $json;

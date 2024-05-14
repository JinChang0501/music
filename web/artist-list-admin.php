<?php
if (!isset($_SESSION)) {
  session_start();
}


$title = '藝人列表';
$pageName = 'artist-list';

require __DIR__ . '/../config/pdo-connect.php';

$per_page = 10; #每頁有幾筆

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

if ($page < 1) {
  header('Location: ?page=1');
  exit;
}

#總筆數
$t_sql = "SELECT COUNT(id) FROM `artist`";

$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

# 總頁數
$totalPages = ceil($totalRows / $per_page);
if ($page > $totalPages) {
  header("Location: ?page={$totalPages}");
  exit; # 結束這支程式
}


$sql = sprintf(
  "SELECT * FROM `artist` order by id desc LIMIT %s,%s",
  ($page - 1) * $per_page,
  $per_page
);

$rows = $pdo->query($sql)->fetchAll();


include __DIR__ . "/part/html-header.php";
include __DIR__ . "/part/navbar-head.php";
?>


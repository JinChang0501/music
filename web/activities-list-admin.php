<?php
require __DIR__ . '/../config/pdo-connect.php';
$title = '活動列表';
$pageName = 'list-activities';

$perPage = 10;

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
  header('Location: ?page=1');
  exit;
}

$t_sql = "SELECT COUNT(id) FROM activities";

# 總筆數
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];


# 預設值
$totalPages = 0;
$rows = [];

if ($totalRows) {
  # 總頁數
  $totalPages = ceil($totalRows / $perPage);
  if ($page > $totalPages) {
    header("Location: ?page={$totalPages}");
    exit; # 結束這支程式
  }

  # 取得分頁資料
  $sql = sprintf(
    "SELECT * FROM `activities` ORDER BY id DESC LIMIT %s, %s",
    ($page - 1) * $perPage,
    $perPage
  );
  $rows = $pdo->query($sql)->fetchAll();
}

?>

<?php include __DIR__ . '/part/html-header.php' ?>
<?php include __DIR__ . '/part/navbar-head.php' ?>

<!-- 列表 -->
<div class="container-fluid">
  <div class="row">
    <div class="col-2 p-0">
      <?php include __DIR__ . "/part/left-bar.php"; ?>
    </div>
    <div class="col-10">
      <!-- 頁碼 -->
      <div class="row">
        <div class="col d-flex justify-content-center my-4">
          <nav aria-label="Page Navigation Example">
            <ul class="pagination">
              <li class="page-item">
                <a class="page-link" href="?page=1">
                  <i class="fa-solid fa-angles-left"></i>
                </a>
              </li>
              <li class="page-item ">
                <a class="page-link" href="?page=<?= $page - 1 ?>">
                  <i class="fa-solid fa-angle-left"></i>
                </a>
              </li>
              <?php for ($i = $page - 5; $i <= $page + 5; $i++):
                if ($i >= 1 and $i <= $totalPages): ?>
                  <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                  </li>
                <?php endif;
              endfor; ?>
              <li class="page-item ">
                <a class="page-link" href="?page=<?= $page + 1 ?>">
                  <i class="fa-solid fa-angle-right"></i>
                </a>
              </li>
              <li class="page-item ">
                <a class="page-link" href="?page=<?= $totalPages ?>">
                  <i class="fa-solid fa-angles-right"></i>
                </a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
      <!-- 按鈕群組 -->
      <div class="col mb-3">
        <input class="btn btn-primary" type="button" value="一鍵全選">
        <input class="btn btn-secondary" type="button" value="一鍵取消">
        <button class="btn btn-danger" type="submit">刪除所選</button>
      </div>
      <!-- 列表 -->
      <div class="col">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th scope="col">選取</th>
              <th scope="col">#</th>
              <th scope="col">類別</th>
              <th scope="col">活動名稱</th>
              <th scope="col">日期</th>
              <th scope="col">時間</th>
              <th scope="col">地點</th>
              <th scope="col">活動內容</th>
              <th scope="col">主辦單位</th>
              <th scope="col">表演者</th>
              <th scope="col">圖片</th>
              <th scope="col"><i class="fa-solid fa-trash"></i></th>
              <th scope="col"><i class="fa-solid fa-pen-to-square"></i></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rows as $r): ?>
              <tr>
                <td>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                  </div>
                </td>
                <td><?= $r['id'] ?></td>
                <td><?= $r['activity_class'] ?></td>
                <td><?= $r['activity_name'] ?></td>
                <td><?= $r['a_date'] ?></td>
                <td><?= $r['a_time'] ?></td>
                <td><?= $r['location'] ?></td>
                <td><?= $r['descriptions'] ?></td>
                <td><?= $r['organizer'] ?></td>
                <td><?= $r['artist_id'] ?></td>
                <td><?= $r['picture'] ?></td>
                <td><a href="javascript: deleteOne(<?= $r['id'] ?>)">
                    <i class="fa-solid fa-trash"></i></a></td>
                <td><a href="activities-edit.php?id=<?= $r['id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- 確認刪除 彈出視窗 -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">確定刪除此筆資料？</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">保留</button>
        <!-- 這裡有問題 -->
        <button type="button" class="btn btn-danger" herf="activities-delete.php?id=<?php $r['id'] ?>">確認刪除</button>
      </div>
    </div>
  </div>
</div>
</div>
<?php include __DIR__ . '/part/scripts.php' ?>
<script>
  // const delModal = new bootstrap.Modal('#deleteModal');
  // delModal.show();
  const deleteOne = (id) => {
    if (confirm(`是否要刪除編號為 ${id} 的資料？`)) {
      location.herf = `activities-delete.php?id=${id}`;
    }
  }
</script>
<?php include __DIR__ . '/part/html-footer.php' ?>
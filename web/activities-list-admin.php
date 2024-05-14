<?php
require __DIR__ . '/../config/pdo-connect.php';
$title = '活動列表';
$pageName = 'activities-list';

$perPage = 5;

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
  header('Location: ?page=1');
  exit;
}

$t_sql = "SELECT COUNT(actid) FROM activities";

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
    "SELECT * FROM activities JOIN aclass ON activities.activity_class = aclass.id JOIN artist ON artist_id = artist.id ORDER BY activities.actid ASC LIMIT %s, %s",
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
              <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
                if ($i >= 1 and $i <= $totalPages) : ?>
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
      <div class="col-6 mb-3">
        <button class="btn btn-danger" type="submit" id="dltAllSelect">刪除所選</button>
        <a href="activities-add.php"><button class="btn btn-primary" type="button">新增活動</button></a>
      </div>
      <!-- 搜尋 -->
      <div class="col-6 mb-3">


      </div>
      <!-- 列表 -->
      <div class="col">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th scope="col"><input class="form-check-input" type="checkbox" value="" id="checkAll"> </th>
              <th scope="col">#</th>
              <th scope="col">類別</th>
              <th scope="col">活動名稱</th>
              <th scope="col">日期</th>
              <th scope="col">時間</th>
              <th scope="col">地點</th>
              <th scope="col">地址</th>
              <th scope="col">活動內容</th>
              <th scope="col">主辦單位</th>
              <th scope="col">表演者</th>
              <th scope="col">圖片</th>
              <th scope="col"><i class="fa-solid fa-trash"></i></th>
              <th scope="col"><i class="fa-solid fa-pen-to-square"></i></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rows as $r) : ?>
              <tr>
                <td>
                  <input class="checkboxes form-check-input" type="checkbox" value="<?= $r['actid'] ?>" id="flexCheckDefault<?= $r['actid'] ?>">
                </td>
                <td><?= $r['actid'] ?></td>
                <td><?= $r['class'] ?></td>
                <td><?= $r['activity_name'] ?></td>
                <td><?= $r['a_date'] ?></td>
                <td><?= $r['a_time'] ?></td>
                <td><?= $r['location'] ?></td>
                <td><?= $r['address'] ?></td>
                <td><?= $r['descriptions'] ?></td>
                <td><?= $r['organizer'] ?></td>
                <td><?= $r['art_name'] ?></td>
                <td><img src="<?= $r['picture'] ?>" class="image img-thumbnail" alt="activities_picture"></td>
                <td><a href="javascript: deleteOne(<?= $r['actid'] ?>)">
                    <button type="button" class="btn btn-danger"><i class="fa-solid fa-trash text-white"></i></a></td>
                </button>
                <td><a href="activities-edit.php?actid=<?= $r['actid'] ?>">
                    <button type="button" class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></button></a>
                </td>
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
        <button type="button" class="btn btn-danger" herf="activities-delete.php?actid=<?php $r['actid'] ?>">確認刪除</button>
      </div>
    </div>
  </div>
</div>
</div>
<?php include __DIR__ . '/part/scripts.php' ?>
<script>
  const deleteOne = (actid) => {
    if (confirm(`確定要刪除${actid}的資料嗎?`)) {
      location.href = `activities-delete.php?actid=${actid}`;
    }
  }

  const checkAll = document.getElementById("checkAll");
  const checkboxes = document.getElementsByClassName("checkboxes");

  checkAll.addEventListener('change', function() {
    if (checkAll.checked === true) {
      for (let i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = true;
      }
    } else {
      for (let i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = false;
      }
    }
  });

  // 刪除所選Script
  const dltAllSelect = document.getElementById("dltAllSelect");
  const checkboxes2 = document.querySelectorAll(".checkboxes");

  dltAllSelect.addEventListener('click', function() {
    let selectedIds = []; // 儲存被勾選項目的 ID

    for (let i = 0; i < checkboxes2.length; i++) {
      if (checkboxes2[i].checked) {
        const actid = checkboxes2[i].value; // 獲取被勾選項目的 ID
        selectedIds.push(actid); // 將 ID 加入到 selectedIds 陣列中
      }
    }

    if (selectedIds.length > 0) {
      if (confirm(`確定要刪除這 ${selectedIds.length} 筆資料嗎?`)) {
        // 執行刪除操作，這裡可以使用 AJAX 或者其他方式向後端發送刪除請求
        // 這裡假設你已經有了一個可以處理刪除的後端接口
        location.href = `activities-delete-sel.php?actid=${selectedIds.join(',')}`;
      }
    } else {
      alert('請先選擇要刪除的資料');
    }
  });
</script>
<?php include __DIR__ . '/part/html-footer.php' ?>
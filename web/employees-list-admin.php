<?php
if (!isset($_SESSION)) {
  session_start();
}


$title = '員工列表(已登入)';
$pageName = 'employees-list';

require __DIR__ . './../config/pdo-connect.php';

$per_page = 20; #每頁有幾筆

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

if ($page < 1) {
  header('Location: ?page=1');
  exit;
}

#總筆數
$t_sql = "SELECT COUNT(id) FROM employees";

$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

# 總頁數
$totalPages = ceil($totalRows / $per_page);
if ($page > $totalPages) {
  header("Location: ?page={$totalPages}");
  exit; # 結束這支程式
}


// SELECT * FROM `address_book` ORDER BY id DESC LIMIT 0, 20
// SELECT * FROM `address_book` ORDER BY id DESC LIMIT 20, 20
// SELECT * FROM `address_book` ORDER BY id DESC LIMIT 40, 20
// SELECT * FROM `address_book` ORDER BY id DESC LIMIT 60, 20



$sql = sprintf(
  "SELECT * FROM `employees` order by id desc LIMIT %s,%s",
  ($page - 1) * $per_page,
  $per_page
);

$rows = $pdo->query($sql)->fetchAll();

// echo json_encode([
//     'totalRows' => $totalRows,
//     'totalPages' => $totalPages,
//     'rows' => $rows,
// ]);


include __DIR__ . "/part/html-header.php";
include __DIR__ . "/part/navbar-head.php";

?>



<div class="container-fluid">
  <div class="row">
    <!--  -->
    <div class="col-2 p-0">
      <?php include __DIR__ . "/part/left-bar.php"; ?>
    </div>

    <div class="col-10">
      <nav aria-label="Page navigation example">
        <ul class="pagination">
          <!-- arrow left start -->
          <li class="page-item ">
            <a class="page-link" href="#">
              <i class="fa-solid fa-angles-left"></i>
            </a>
          </li>
          <li class="page-item ">
            <a class="page-link" href="#">
              <i class="fa-solid fa-angle-left"></i>
            </a>
          </li>
          <!-- arrow left end -->
          <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
            if ($i >= 1 and $i <= $totalPages) : ?>
              <li class="page-item <?php $page == $i ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
              </li>
          <?php endif;
          endfor; ?>
          <!-- arrow right start -->
          <li class="page-item">
            <a class="page-link" href="#">
              <i class="fa-solid fa-angle-right"></i>
            </a>
          </li>
          <li class="page-item">
            <a class="page-link" href="#">
              <i class="fa-solid fa-angles-right"></i>
            </a>
          </li>
          <!-- arrow right end -->
        </ul>
      </nav>

      <!--  -->
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th scope="col" style="text-align: center;">#</th>
            <th scope="col">First_name</th>
            <th scope="col">Last_name</th>
            <th scope="col">Email</th>
            <th scope="col">Passwords</th>
            <th scope="col">Gender</th>
            <th scope="col">Phone_Number</th>
            <th scope="col">Created_at</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $r) : ?>
            <tr>
              <td style="text-align: center;"><?= $r['id'] ?></td>
              <td style="text-align: center;"><?= $r['first_name'] ?></td>
              <td style="text-align: center;"><?= $r['last_name'] ?></td>
              <td style="text-align: center;"><?= $r['email'] ?></td>
              <td style="text-align: center;"><?= $r['passwords'] ?></td>
              <td style="text-align: center;"><?= $r['gender'] ?></td>
              <td style="text-align: center;"><?= $r['phone_number'] ?></td>
              <td style="text-align: center;"><?= $r['created_at'] ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include __DIR__ . "/part/scripts.php" ?>
<script>
  const deleteOne = (id) => {
    if (confirm(`確定要刪除${id}的資料嗎?`)) {
      location.href = `delete.php?id=${id}`;
    }
  }
</script>

<?php include __DIR__ . "/part/html-footer.php" ?>
<?php
require __DIR__ . '/../config/pdo-connect.php';
$title = '商品列表';
$pageName = 'list';

$perPage = 20; # 每頁有幾筆

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

if ($page < 1) {
  header('Location: ?page=1');
  exit;
}

# 算總筆數 $totalRows
$t_sql = "SELECT COUNT(id) FROM `products`";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

$totalPages = 0;
$rows = []; # 預設值
# 如果有資料的話
if ($totalRows) {
  // # 總頁數
  $totalPages = ceil($totalRows / $perPage);
  if ($page > $totalPages) {
    header("Location: ?page={$totalPages}");
    exit;
  }

  $sql = sprintf("SELECT * FROM `products` ORDER BY id DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
  $rows = $pdo->query($sql)->fetchAll();
}

?>
<?php include __DIR__ . '/part/html-header.php' ?>
<?php include __DIR__ . '/part/navbar-head.php' ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-2 p-0">
      <?php include __DIR__ . '/part/left-bar.php' ?>
    </div>
    <div  class="col-10">
      <h5 class="card-title text-primary fs-3 fw-bold mb-5 text-center">商品列表</h5>
      <nav aria-label="Page navigation example">
        <ul class="pagination">
          <li class="page-item">
            <a class="page-link" href="#">
              <i class="fa-solid fa-angles-left"></i>
            </a>
          </li>

          <li class="page-item">
            <a class="page-link" href="#">
              <i class="fa-solid fa-angle-left"></i>
            </a>
          </li>

          <?php for ($i = $page - 5; $i <= $page + 5; $i++) : ?>
            <?php if ($i >= 1 and $i <= $totalPages) : ?>
              <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
              </li>
            <?php endif; endfor ?>
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
        </ul>
      </nav>
      <div class="col">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th scope="col" class="text-center">
                <i class="fa-solid fa-file-pen"></i>編輯
              </th>
              <th scope="col" class="text-center">編號</th>
              <th scope="col" class="text-center">商品名稱</th>
              <th scope="col" class="text-center">商品圖片</th>
              <th scope="col" class="text-center">定價</th>
              <th scope="col" class="text-center">進貨數量</th>
              <th scope="col" class="text-center">活動名稱</th>
              <th scope="col" class="text-center">
                  <i class="fa-solid fa-trash"></i>刪除
              </th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rows as $r) : ?>
              <tr>
              <td class="text-center">
                <a href="product-edit.php?id=<?= $r['id'] ?>" class="btn btn-success"> 
                  <i class="fa-solid fa-file-pen"></i>編輯
                </a>
              </td>
              <td><?= $r['id'] ?></td>
              <td><?= $r['product_name'] ?></td>
              <td><?= $r['picture'] ?></td>
              <td><?= $r['price'] ?></td>
              <td><?= $r['purchase_quantity'] ?></td>
              <td><?= $r['activitie_id'] ?></td>
              <td>
                <a href="javascript: delete_one(<?= $r['id'] ?>)"  class="btn btn-danger">
                  <i class="fa-solid fa-trash"></i>刪除 
                </a>
              </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
  </div>
  </div>

</div>      
<?php include __DIR__ . '/part/scripts.php' ?>
<script>
  const delete_one = (id) =>{
    if(confirm(`是否要刪除編號為 ${id} 的資料?`)){
      location.href = `product-delete.php?id=${id}`;
    }
  }

</script>
<?php include __DIR__ . '/part/html-footer.php' ?>
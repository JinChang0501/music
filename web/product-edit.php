<?php
require __DIR__ . '/admin-required.php';
require __DIR__ . '/../config/pdo-connect.php';

$title = '修改商品';
$pageName = 'product-edit';

$sid = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id < 1) {
  header('Location: product-list.php');
  exit;
}

$sql = "Select * FROM `products` WHERE id=$id";
$row = $pdo->query($sql)->fetch();

if (empty($row)) {
  header('Location: product-list.php');
  exit;
}

// echo json_encode($row);

?>

<?php include __DIR__ . '/part/html-header.php' ?>
<?php include __DIR__ . '/part/navbar-head.php' ?>

<style>
  form .mb-3 .form-text {
    color: red;
    font-weight: 800;
  }
</style>

<div class="container-fluid">
  <div class="row">
    <div class="col-2"><?php include __DIR__ . '/part/left-bar.php' ?></div>
    <div class="col-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title text-primary fs-3 fw-bold mb-5 text-center">修改商品</h5>
          <form name="form1" onsubmit="sendData(event)">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <div class="mb-3">
             <label for="id" class="form-label">編號</label>
             <input type="text" class="form-control" value="<?= $row['id'] ?>" disabled>
            </div>
            <div class="mb-4">
              <label for="product_name" class="form-label fw-bold">商品名稱</label>
              <input type="text" class="form-control" id="product_name" name="product_name" required>
              <div class="form-text"></div>
            </div>
            <div class="mb-4">
              <label for="picture" class="form-label fw-bold">商品圖片</label>
              <input class="form-control" type="file" id="picture" multiple required>
            </div>
            <div class="mb-4">
              <label for="price" class="form-label fw-bold">定價</label>
              <input type="text" class="form-control" id="price" name="price" required>
              <div class="form-text"></div>
            </div>
            <div class="mb-4">
              <label for="purchase_quantity" class="form-label fw-bold">進貨數量</label>
              <input type="text" class="form-control" id="purchase_quantity" name="purchase_quantity" maxlength="6" required>
              <div class="form-text"></div>
            </div>
            <div class="mb-4">
              <label for="activitie_id" class="form-label fw-bold">活動名稱</label>
              <input type="text" class="form-control" id="activitie_id" name="activitie_id">
              <div class="form-text"></div>
            </div>
            
            <button type="submit" class="btn btn-primary my-5 px-5" data-bs-toggle="modal" data-bs-target="#staticBackdrop">修改</button>
            <a href="product-list.php" class="btn  btn-info mx-5 px-3">取消</a>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal start-->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="staticBackdropLabel">編輯成功</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="alert alert-success" role="alert">
					資料編輯成功
				</div>
			</div>
			<div class="modal-footer">

				<button type="button" class="btn btn-primary" onclick="location.href='product-list.php'">到列表頁</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續編輯</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="failureModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">資料沒有修改</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger" role="alert" id="failureInfo">
          資料沒有修改
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" onclick="location.href='product-list.php'">到列表頁</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
        
      </div>
    </div>
  </div>
</div>
<!-- Modal End-->

<?php include __DIR__ . '/part/scripts.php' ?>
<script>
  const nameField = document.form1.product_name;
  const quantityField = document.form1.purchase_quantity;
  
  const sendData = e => {
    e.preventDefault(); // 不要讓表單以傳統的方式送出
    // 回復欄位的外觀
    nameField.style.border = '1px solid #CCC';
    nameField.nextElementSibling.innerHTML = '';
    
    quantityField.style.border = '1px solid #CCC';
    quantityField.nextElementSibling.innerHTML = '';
        
    let isPass = true; // 整個表單有沒有通過檢查

    // TODO: 檢查各個欄位的資料, 有沒有符合規定
    if (nameField.value.length < 2) {
      isPass = false; // 沒有通過檢查
      nameField.style.border = '1px solid red';
      nameField.nextElementSibling.innerHTML = '請填寫正確的商品名稱';
    }
    if (quantityEl.value.length < 1) {
      isPass = false; // 沒有通過檢查
      quantityEl.style.border = '1px solid red';
      quantityEl.nextElementSibling.innerHTML = '請填寫進貨數量';
    }

    
    // 有通過檢查才發送表單
    if (isPass) {
      const fd = new FormData(document.form1); // 沒有外觀的表單物件

      fetch(`product-edit-api.php`, {
        method: 'POST',
        body: fd,
      }).then(r => r.json())
      .then(data => {
        console.log(data);
        if (data.success) {
          successModal.show();
        } else {
          document.querySelector('#failureInfo').innerHTML = data.error;
          failureModal.show();
        }

      })
      .catch(ex => console.log(ex))
    }
  };

  const successModal = new bootstrap.Modal('#staticBackdrop')
  const failureModal = new bootstrap.Modal('#failureModal')

</script>

<?php include __DIR__ . '/part/html-footer.php' ?>
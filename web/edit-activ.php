<?php
require __DIR__ . '/admin-required.php';
require __DIR__ . '/../config/pdo-connect.php';
$title = "修改活動列表";


$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id < 1) {
  header('Location: list-activ.php');
  exit;
}

$sql = "SELECT * FROM activities WHERE id={$id}";

$row = $pdo->query($sql)->fetch();
if (empty($row)) {
  header('Location: list-activ.php');
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
<div class="container">
  <div class="row d-flex justify-content-center my-5">
    <div class="col-6">
      <div class="card">
        <!-- 待修改 -->
        <div class="card-body">
          <h5 class="card-title">編輯資料</h5>
          <form name="form1" onsubmit="sendData(event)">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <div class="mb-3">
              <label for="id" class="form-label">編號</label>
              <input type="text" class="form-control" disabled value="<?= $row['id'] ?>">
            </div>
            <div class="mb-3">
              <label for="aclass" class="form-label">類別</label>
              <input type="text" class="form-control" id="aclass" name="aclass" value="<?= $row['activity_class'] ?>">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="aname" class="form-label">活動名稱</label>
              <input type="text" class="form-control" id="aname" name="aname" value="<?= $row['activity_name'] ?>">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="adate" class="form-label">日期</label>
              <input type="date" class="form-control" id="adate" name="adate" value="<?= $row['a_date'] ?>">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="atime" class="form-label">時間</label>
              <input type="time" class="form-control" id="atime" name="atime" value="<?= $row['a_time'] ?>">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="location" class="form-label">地點</label>
              <input type="text" class="form-control" id="location" name="location" value="<?= $row['location'] ?>">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="descriptions" class="form-label">活動內容</label>
              <textarea class="form-control" id="descriptions" name="descriptions" cols="30"
                rows="3"><?= $row['descriptions'] ?></textarea>
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="organizer" class="form-label">主辦單位</label>
              <input type="text" class="form-control" id="organizer" name="organizer" value="<?= $row['organizer'] ?>">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="artist" class="form-label">表演者</label>
              <input type="text" class="form-control" id="artist" name="artist" value="<?= $row['artist_id'] ?>">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="picture" class="form-label">圖片</label>
              <input type="file" class="form-control" id="picture" name="picture" value="<?= $row['picture'] ?>">
              <div class="form-text"></div>
            </div>

            <button type="submit" class="btn btn-primary">修改</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">修改成功</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success" role="alert">
          資料修改成功
        </div>
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-primary" onclick="location.href='list-activ.php'">到列表頁</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續編輯</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal2 -->
<div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel2">資料沒有修改</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger" role="alert">
          資料沒有修改
        </div>
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-primary" onclick="location.href='list-activ.php'">到列表頁</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續編輯</button>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/part/scripts.php' ?>
<script>
  const nameField = document.form1.name;
  const emailField = document.form1.email;

  function validateEmail(email) {
    const re =
      /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
  }

  const sendData = e => {
    e.preventDefault(); // 不要讓 form1 以傳統的方式送出

    nameField.style.border = '1px solid #CCCCCC';
    nameField.nextElementSibling.innerText = '';
    emailField.style.border = '1px solid #CCCCCC';
    emailField.nextElementSibling.innerText = '';
    // TODO: 欄位資料檢查

    let isPass = true;  // 表單有沒有通過檢查
    // if (nameField.value.length < 2) {
    //   isPass = false;
    //   nameField.style.border = '1px solid red';
    //   nameField.nextElementSibling.innerText = '請填寫正確的姓名';

    // }
    // if (!validateEmail(emailField.value)) {
    //   isPass = false;
    //   emailField.style.border = '1px solid red';
    //   emailField.nextElementSibling.innerText = '請填寫正確的 Email';
    // }


    // 有通過檢查, 才要送表單
    if (isPass) {
      const fd = new FormData(document.form1); // 沒有外觀的表單物件

      fetch('edit-activ-api.php', {
        method: 'POST',
        body: fd, // Content-Type: multipart/form-data
      }).then(r => r.json())
        .then(data => {
          console.log(data);
          if (data.success) {
            myModal.show();
          } else {
            myModal2.show();
          }
        })
        .catch(ex => console.log(ex))
    }
  };

  const myModal = new bootstrap.Modal('#staticBackdrop');
  const myModal2 = new bootstrap.Modal('#staticBackdrop2');

</script>
<?php include __DIR__ . '/part/html-footer.php' ?>
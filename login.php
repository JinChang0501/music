<?php
if (!isset($_SESSION)) {
  session_start();
}
if (isset($_SESSION['admin'])) {
  header('Location: index_R3.php');
  exit;
}


$title = '登入';
$pageName = 'login';
?>


<?php include __DIR__ . "/part/html-header.php"; ?>
<?php include __DIR__ . "/part/navbar-head.php"; ?>


<style>
  form .mb-3 .form-text {
    color: red;
    font-weight: 800;
  }
</style>

<div class="container-fluid">
  <div class="row">
    <div class="col-2 p-0">
      <?php include __DIR__ . "/part/left-bar.php"; ?>
    </div>
    <div class="col-10">
      <div class="card mt-5" style="width: 18rem;">
        <div class="card-body">
          <h5 class="card-title">帳號登入</h5>
          <form name="form1" onsubmit="sendData(event)">
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="text" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">密碼</label>
              <input type="password" class="form-control" id="password" name="passwords">
            </div>
            <button type="submit" class="btn btn-primary">登入</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal Start-->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">登入失敗</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger" role="alert">
          帳號或密碼錯誤!
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">重新登入</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal End-->

<?php include __DIR__ . "/part/scripts.php"; ?>
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

    // nameField.style.border = '1px solid #CCCCCC';
    // nameField.nextElementSibling.innerText = '';
    // emailField.style.border = '1px solid #CCCCCC';
    // emailField.nextElementSibling.innerText = '';
    // TODO: 欄位資料檢查

    let isPass = true; // 表單有沒有通過檢查
    if (!validateEmail(emailField.value)) {
      isPass = false;
      emailField.style.border = '1px solid red';
      emailField.nextElementSibling.innerText = '請填寫正確的 Email';
    }
    // 有通過檢查, 才要送表單
    if (isPass) {
      const fd = new FormData(document.form1); // 沒有外觀的表單物件
      fetch('login-api.php', {
          method: 'POST',
          body: fd, // Content-Type: multipart/form-data
        }).then(r => r.json())
        .then(data => {
          console.log(data);
          if (data.success) {
            location.href = 'index_R3.php'; //登入成功後跳轉頁面
          } else {
            myModal.show();
          }
        })
        .catch(ex => console.log(ex))
    }
  };
  const myModal = new bootstrap.Modal('#staticBackdrop')
</script>
<?php include __DIR__ . "/part/html-footer.php"; ?>
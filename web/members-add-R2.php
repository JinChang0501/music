<?php
require __DIR__ . '/admin-required.php';

if (!isset($_SESSION)) {
  session_start();
}


$title = '新增會員列表';
$pageName = 'members-add';
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
    <div class="col-2 p-0"><?php include __DIR__ . "/part/left-bar.php"; ?></div>
    <div class="col-10">
      <div class="row">
        <div class="col-8 mx-auto">
          <h4 class="my-3">新增會員</h4>
          <form class="needs-validation" novalidate>
            <div class="row g-3">
              <div class="col-sm-6">
                <label for="first_name" class="form-label">First name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="" value="" required>
                <div class="invalid-feedback">
                  Valid first name is required.
                </div>
              </div>

              <div class="col-sm-6">
                <label for="last_name" class="form-label">Last name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="" value="" required>
                <div class="invalid-feedback">
                  Valid last name is required.
                </div>
              </div>


              <div class="col-12">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" required>
                <div class="invalid-feedback">
                  Please enter a valid email address for shipping updates.
                </div>
              </div>

              <div class="col-12">
                <label for="passwords" class="form-label">Passwords</label>
                <input type="password" class="form-control" id="passwords" name="passwords" placeholder="" required>
                <div class="invalid-feedback">
                  Please enter a valid password for shipping updates.
                </div>
              </div>

              <div class="col-4">
                <label for="gender" class="form-label">Gender</label><br>
                <div class="form-control">
                  <div class="row">
                    <div class="col-6"><input type="radio" name="gender" value="male" required>男 (Male)</div>

                    <div class="col-6"><input type="radio" name="gender" value="female" required>女 (Female)</div>
                    <div class="invalid-feedback">
                      Gender required.
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-4">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="09xxxxxxxx" required>
                <div class="invalid-feedback">
                  Phone number required.
                </div>
              </div>

              <div class="col-4">
                <label for="birthday" class="form-label">Birthday</label>
                <input type="date" class="form-control" id="birthday" name="birthday" placeholder="" required>
                <div class="invalid-feedback">
                  Birthday required.
                </div>
              </div>

              <div class="col-12">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="1234 Main St" required>
                <div class="invalid-feedback">
                  Please enter your shipping address.
                </div>
              </div>

              <button class="btn btn-primary" type="submit">新增</button>
            </div>
          </form>
        </div>
      </div>
      <!-- OLD -->
      <div class="card mt-3" style="width: 18rem;">
        <div class="card-body">
          <h5 class="card-title">新增會員資料</h5>
          <form name="form1" onsubmit="sendData(event)">
            <div class="mb-3">
              <label for="first_name" class="form-label">名字(First_name)</label>
              <input type="text" class="form-control" id="first_name" name="first_name">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="last_name" class="form-label">姓氏(Last_name)</label>
              <input type="text" class="form-control" id="last_name" name="last_name">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="passwords">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="gender" class="form-label">性別</label><br>
              <input type="radio" name="gender" value="male">男
              <input type="radio" name="gender" value="female">女
            </div>

            <div class="mb-3">
              <label for="mobile" class="form-label">電話號碼</label>
              <input type="text" class="form-control" id="mobile" name="phone_number" pattern="[0]{1}[9]{1}[0-9]{8}" maxlength="10">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="birthday" class="form-label">生日</label>
              <input type="date" class="form-control" id="birthday" name="birthday">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="address" class="form-label">地址</label>
              <textarea id="address" cols="30" rows="3" name="address"></textarea>
              <div class="form-text"></div>
            </div>

            <button type="submit" class="btn btn-primary">新增</button>
          </form>
        </div>
      </div>
      <!-- OLD -->
    </div>
  </div>
</div>

<!-- Modal Start-->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">新增成功</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success" role="alert">
          資料新增成功
        </div>
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-primary" onclick="location.href='members-list.php'">到列表頁</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續新增</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal End-->

<?php include __DIR__ . "/part/scripts.php"; ?>
<script>
  const first_nameField = document.form1.first_name;
  const last_nameField = document.form1.last_name;
  const emailField = document.form1.email;

  function validateEmail(email) {
    const re =
      /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
  }


  const sendData = e => {
    e.preventDefault(); // 不要讓 form1 以傳統的方式送出

    first_nameField.style.border = '1px solid #CCCCCC';
    first_nameField.nextElementSibling.innerText = '';
    last_nameField.style.border = '1px solid #CCCCCC';
    last_nameField.nextElementSibling.innerText = '';
    emailField.style.border = '1px solid #CCCCCC';
    emailField.nextElementSibling.innerText = '';

    // TODO: 欄位資料檢查
    let isPass = true; // 表單有沒有通過檢查
    if (first_nameField.value.length < 0) {
      isPass = false;
      first_nameField.style.border = '1px solid red';
      first_nameField.nextElementSibling.innerText = '請填寫正確的姓名';
    }

    if (last_nameField.value.length < 0) {
      isPass = false;
      last_nameField.style.border = '1px solid red';
      last_nameField.nextElementSibling.innerText = '請填寫正確的姓名';
    }

    if (!validateEmail(emailField.value)) {
      isPass = false;
      emailField.style.border = '1px solid red';
      emailField.nextElementSibling.innerText = '請填寫正確的 Email';
    }
    // 有通過檢查, 才要送表單
    if (isPass) {
      const fd = new FormData(document.form1); // 沒有外觀的表單物件
      fetch('members-add-api.php', {
          method: 'POST',
          body: fd, // Content-Type: multipart/form-data
        }).then(r => r.json())
        .then(data => {
          console.log(data);
          if (data.success) {
            myModal.show();
          } else {

          }
        })
        .catch(ex => console.log(ex))
    }
  };
  const myModal = new bootstrap.Modal('#staticBackdrop')
</script>
<?php include __DIR__ . "/part/html-footer.php"; ?>
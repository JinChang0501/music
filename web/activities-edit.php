<?php
require __DIR__ . '/admin-required.php';
require __DIR__ . '/../config/pdo-connect.php';
$title = "修改活動列表";


$actid = isset($_GET['actid']) ? intval($_GET['actid']) : 0;
if ($actid < 1) {
  header('Location: activities-list.php');
  exit;
}

// $sql = "SELECT * FROM activities WHERE actid={$actid}";
$sql = "SELECT * FROM activities JOIN artist ON artist_id = artist.id JOIN aclass ON activities.activity_class = aclass.id WHERE actid={$actid}";

$row = $pdo->query($sql)->fetch();
if (empty($row)) {
  header('Location: activities-list.php');
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
    <div class="col-2 p-0">
      <?php include __DIR__ . "/part/left-bar.php"; ?>
    </div>
    <div class="col-8  mt-3 mx-auto">
      <div class="card my-3">
        <div class="card-body">
          <h4 class="card-title fw-bold">編輯資料</h4>
          <form name="form1" onsubmit="sendData(event)">
            <input type="hidden" name="actid" value="<?= $row['actid'] ?>">
            <div class="mb-3">
              <label for="actid" class="form-label">編號</label>
              <input type="text" class="form-control" disabled value="<?= $row['actid'] ?>">
            </div>
            <div class="mb-3">
              <label for="activity_class" class="form-label">類別</label>
              <select class="form-select" aria-label="Default select example" id="activity_class" name="activity_class">
                <option value="<?= $row['activity_class'] ?>" selected><?= $row['class'] ?></option>
                <option value="1">concert</option>
                <option value="2">music festival</option>
              </select>
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
              <label for="address" class="form-label">地址</label>
              <input type="text" class="form-control" id="address" name="address" value="<?= $row['address'] ?>">
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
              <label for="artist_id" class="form-label">表演者</label>
              <select class="form-select" aria-label="Default select example" id="artist_id" name="artist_id">
                <option value="<?= $row['artist_id'] ?>" selected><?= $row['art_name'] ?></option>
                <option value="<?= $row['artist_id'] ?>"><?= $row['art_name'] ?></option>
              </select>
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
<!-- ModalA -->
<div class="modal fade" id="staticBackdropA" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabelA" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabelA">修改成功</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success" role="alert">
          資料修改成功
        </div>
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-primary" onclick="location.href='activities-list.php'">到列表頁</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續編輯</button>
      </div>
    </div>
  </div>
</div>

<!-- ModalB -->
<div class="modal fade" id="staticBackdropB" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabelB" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabelB">資料沒有修改</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger" role="alert">
          資料沒有修改
        </div>
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-primary" onclick="location.href='activities-list.php'">到列表頁</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續編輯</button>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/part/scripts.php' ?>
<script>
  // const activity_class = document.form_activities.activity_class;
  const activity_nameField = document.form_activities.activity_name;

  const sendData = e => {
    e.preventDefault(); // 不要讓 form_activities 以傳統的方式送出

    // activity_class.style.border = '1px solid #CCCCCC';
    // activity_class.nextElementSibling.innerText = '';
    activity_nameField.style.border = '1px solid #CCCCCC';
    activity_nameField.nextElementSibling.innerText = '';

    // TODO: 欄位資料檢查
    let isPass = true; // 表單有沒有通過檢查

    // if ((activity_class.value < 1) || (activity_class.value > 2)) {
    // 	isPass = false;
    // 	activity_nameField.style.border = '1px solid red';
    // 	activity_nameField.nextElementSibling.innerText = '請選擇類別';
    // }

    if (activity_nameField.value.length < 2) {
      isPass = false;
      activity_nameField.style.border = '1px solid red';
      activity_nameField.nextElementSibling.innerText = '請填寫正確的活動名稱';
    }

    // 有通過檢查, 才要送表單
    if (isPass) {
      const fd = new FormData(document.form_activities); // 沒有外觀的表單物件

      fetch('activities-edit-api.php', {
        method: 'POST',
        body: fd, // Content-Type: multipart/form-data
      }).then(r => r.json())
        .then(data => {
          console.log(data);
          if (data.success) {
            myModalA.show();
          } else {
            myModalB.show();
          }
        })
        .catch(ex => console.log(ex))
    }
  };

  const myModalA = new bootstrap.Modal('#staticBackdropA');
  const myModalB = new bootstrap.Modal('#staticBackdropB');
</script>
<?php include __DIR__ . '/part/html-footer.php' ?>
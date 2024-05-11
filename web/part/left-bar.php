<?php
if (!isset($pageName))
  $pageName = '';
?>
<style>
  /* .container-85 {
    width: 100%;
    margin: auto;
  } */
  .li-hover a:hover {
    color: white;
    transform: scale(1.3);
    font-weight: 900;
    background-color: #BEBEBE;
  }

  .li-hover {
    overflow: hidden;
  }

  .logo {
    width: 200px;
    height: 70px;
    background-color: aliceblue;
  }

  .bg-color {
    background-color: #EEA9A9;
  }

  .dropdown-item.active {
    color: #fff;
    text-decoration: none;
    background-color: #0d6efd;
    font-size: 1.3em;
    font-weight: 900;
  }
</style>



<div class="container-fluid p-0">
  <div class="row m-0">
    <div class="col-12 p-0 ">

      <ul class="nav flex-column text-center">
        <!-- 1 -->
        <div class="accordion" id="accordionExample">
          <div class="accordion-item">
            <h2 class="accordion-header" id="heading1">
              <button class="accordion-button fs-5 fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                會員資料管理
              </button>
            </h2>
            <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#accordionExample">
              <div class="accordion-body p-0"> <!-- p-0 把li上下左右的空間清掉不要動-->
                <li class="li-hover"><a class="dropdown-item py-3 border <?= $pageName == 'members-add' ? 'active' : '' ?> " href="members-add.php">增加會員資料</a></li>

                <li class="li-hover"><a class="dropdown-item py-3 border <?= $pageName == 'members-delete-list' ? 'active' : '' ?> " href="members-delete-list.php">刪除會員資料</a></li>

                <li class="li-hover"><a class="dropdown-item py-3 border <?= $pageName == 'members-edit-list' ? 'active' : '' ?>" href="members-edit.php">編輯會員資料</a></li>

                <li class="li-hover"><a class="dropdown-item py-3 border <?= $pageName == 'members-list' ? 'active' : '' ?>" href="members-list.php">查詢會員資料</a></li>
              </div>
            </div>
          </div>

          <!-- 2 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="heading2">
              <button class="accordion-button collapsed fs-5 fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                員工資料管理
              </button>
            </h2>
            <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#accordionExample">
              <div class="accordion-body p-0"> <!-- p-0 把li上下左右的空間清掉不要動-->
                <li class="li-hover"><a class="dropdown-item py-3 border <?= $pageName == 'employees-add' ? 'active' : '' ?> " href="employees-add.php">增加員工資料</a></li>
                <li class="li-hover"><a class="dropdown-item py-3 border <?= $pageName == 'employees-delete' ? 'active' : '' ?> " href="employees-delete-list.php">刪除員工資料</a></li>
                <li class="li-hover"><a class="dropdown-item py-3 border <?= $pageName == 'employees-edit' ? 'active' : '' ?> " href="employees-edit-list.php">編輯員工資料</a></li>
                <li class="li-hover"><a class="dropdown-item py-3 border <?= $pageName == 'employees-list' ? 'active' : '' ?> " href="employees-list.php">查詢員工資料</a></li>
              </div>
            </div>
          </div>
          <!-- 3 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="heading3">
              <button class="accordion-button collapsed fs-5 fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                購票資料管理
              </button>
            </h2>
            <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#accordionExample">
              <div class="accordion-body p-0"> <!-- p-0 把li上下左右的空間清掉不要動-->
                <li class="li-hover"><a class="dropdown-item py-3 border <?= $pageName == 'ticket-order-list' ? 'bg-color' : '' ?>" href="ticket-order-list.php" href="#">購票訂單</a></li>
                <li class="li-hover"><a class="dropdown-item py-3 border <?= $pageName == 'ticket-list' ? 'bg-color' : '' ?>" href="ticket-list.php">上架購票清單</a></li>
                <li class="li-hover"><a class="dropdown-item py-3 border <?= $pageName == 'ticket-add' ? 'bg-color' : '' ?>" href="ticket-add.php">新增購票</a></li>
                <li class="li-hover"><a class="dropdown-item py-3 border <?= $pageName == 'ticket-edit' ? 'bg-color' : '' ?>" href="ticket-edit.php" href="#">編輯購票</a></li>
              </div>
            </div>
          </div>
          <!-- 4 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="heading4">
              <button class="accordion-button collapsed fs-5 fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                XX資料管理
              </button>
            </h2>
            <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionExample">
              <div class="accordion-body p-0"> <!-- p-0 把li上下左右的空間清掉不要動-->
                <li class="li-hover"><a class="dropdown-item py-3 border  " href="#">增加會員資料</a></li>
                <li class="li-hover"><a class="dropdown-item py-3 border" href="#">刪除會員資料</a></li>
                <li class="li-hover"><a class="dropdown-item py-3 border" href="#">編輯會員資料</a></li>
                <li class="li-hover"><a class="dropdown-item py-3 border" href="#">查詢會員資料</a></li>
              </div>
            </div>
          </div>
          <!-- 5 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="heading5">
              <button class="accordion-button collapsed fs-5 fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                XX資料管理
              </button>
            </h2>
            <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#accordionExample">
              <div class="accordion-body p-0"> <!-- p-0 把li上下左右的空間清掉不要動-->
                <li class="li-hover"><a class="dropdown-item py-3 border  " href="#">增加會員資料</a></li>
                <li class="li-hover"><a class="dropdown-item py-3 border" href="#">刪除會員資料</a></li>
                <li class="li-hover"><a class="dropdown-item py-3 border" href="#">編輯會員資料</a></li>
                <li class="li-hover"><a class="dropdown-item py-3 border" href="#">查詢會員資料</a></li>
              </div>
            </div>
          </div>



        </div>
      </ul>
    </div>
  </div>
</div>
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
    font-size: larger;
    font-weight: 900;
    background-color: #7B7B7B;
    transform: scale(1.3);
  }

  .li-hover {
    transition: font-size 0.3s ease;
    overflow: hidden;
  }

  .accordion-button {
    overflow: hidden;
  }

  .logo {
    width: 200px;
    height: 70px;
    background-color: aliceblue;
  }
</style>



<div class="container-fluid p-0">
  <div class="row m-0">
    <div class="col-12 bg-primary border p-0">
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
                <li class="li-hover"><a class="dropdown-item py-3 border  " href="#">增加會員資料</a></li>
                <li class="li-hover"><a class="dropdown-item py-3 border" href="#">刪除會員資料</a></li>
                <li class="li-hover"><a class="dropdown-item py-3 border" href="#">編輯會員資料</a></li>
                <li class="li-hover"><a class="dropdown-item py-3 border <?= $pageName == 'list' ? 'active' : '' ?>" href="list.php">查詢會員資料</a></li>
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
                <li class="li-hover"><a class="dropdown-item py-3 border  " href="#">增加會員資料</a></li>
                <li class="li-hover"><a class="dropdown-item py-3 border" href="#">刪除會員資料</a></li>
                <li class="li-hover"><a class="dropdown-item py-3 border" href="#">編輯會員資料</a></li>
                <li class="li-hover"><a class="dropdown-item py-3 border" href="#">查詢會員資料</a></li>
              </div>
            </div>
          </div>
          <!-- 3 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="heading3">
              <button class="accordion-button collapsed fs-5 fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                XX資料管理
              </button>
            </h2>
            <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#accordionExample">
              <div class="accordion-body p-0"> <!-- p-0 把li上下左右的空間清掉不要動-->
                <li class="li-hover"><a class="dropdown-item py-3 border  " href="#">增加會員資料</a></li>
                <li class="li-hover"><a class="dropdown-item py-3 border" href="#">刪除會員資料</a></li>
                <li class="li-hover"><a class="dropdown-item py-3 border" href="#">編輯會員資料</a></li>
                <li class="li-hover"><a class="dropdown-item py-3 border" href="#">查詢會員資料</a></li>
              </div>
            </div>
          </div>
          <!-- 4 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="heading4">
              <button class="accordion-button collapsed fs-5 fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                訂票資料管理
              </button>
            </h2>
            <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionExample">
              <div class="accordion-body p-0"> <!-- p-0 把li上下左右的空間清掉不要動-->
                <li class="li-hover"><a class="dropdown-item py-3 border  " href="#">票務系統</a></li>
                <li class="li-hover"><a class="dropdown-item py-3 border" href="#">座位系統</a></li>
                <li class="li-hover"><a class="dropdown-item py-3 border" href="#">支付系統</a></li>
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
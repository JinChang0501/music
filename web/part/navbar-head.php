<?php
if (!isset($pageName))
  $pageName = '';
?>
<style>
  /* .container-85 {
    width: 100%;
    margin: auto;
  } */
  /* .li-hover a:hover {
    color: white;
    font-size: larger;
    font-weight: 900;
    background-color: #7B7B7B;
  } */

  .logo {
    width: 200px;
    height: 70px;
    background-color: aliceblue;
  }
</style>



<div class="container-fluid p-0">
  <div class="row m-0">
    <div class="col-2 bg-primary py-3">
      <div class="w-100 logo mx-auto">
        <img src="" alt="">
      </div>
    </div>
    <div class="col-10 bg-secondary">
      <ul class="list-unstyled d-flex justify-content-end h-100 m-0 align-items-center">
        <?php if (isset($_SESSION['admin'])) : ?>
          <li class="nav-item me-3">
            <a class="nav-link"><?= $_SESSION['admin']['first_name'] ?></a>
          </li>
          <li class="nav-item me-3">
            <a class="nav-link" href="logout.php">登出</a>
          </li>
        <?php else : ?>
          <li class="nav-item me-3">
            <a class="nav-link <?= $pageName == 'login' ? 'active' : '' ?>" href="login.php">登入</a>
          </li>
          <li class="nav-item me-3">
            <a class="nav-link <?= $pageName == 'register' ? 'active' : '' ?>" href="register.php">註冊</a>
          </li>
        <?php endif ?>
      </ul>
    </div>
  </div>
</div>
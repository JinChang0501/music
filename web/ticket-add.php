<?php
require __DIR__. '/admin-required.php';
require __DIR__ . '/../config/pdo-connect.php';
if (!isset($_SESSION)) {
    session_start();
}
$title = '票務系統';
$pageName = 'ticket';
?>
<?php include __DIR__ . "/part/html-header.php"; ?>
<?php include __DIR__ . "/part/navbar-head.php"; ?>
<style>
    .bi {
        font-size: 20px;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-2 p-0"><?php include __DIR__ . "/part/left-bar.php"; ?></div>
    </div>
</div>
<?php include __DIR__ . "/part/scripts.php"; ?>
<?php include __DIR__ . "/part/html-footer.php"; ?>


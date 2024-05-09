<?php
if (!isset($_SESSION)) {
    session_start();
}


$title = '首頁';
$pageName = 'home';
?>
<style>
    /* .container-85 {
        width: 85%;
        margin: auto;
    } */
</style>



<?php include __DIR__ . "/part/html-header.php"; ?>
<?php include __DIR__ . "/part/navbar-head.php"; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-2 p-0"><?php include __DIR__ . "/part/left-bar.php"; ?></div>
    </div>
</div>
<?php include __DIR__ . "/part/scripts.php"; ?>
<?php include __DIR__ . "/part/html-footer.php"; ?>
<?php
require __DIR__ . '/admin-required.php';
require __DIR__ . '/../config/pdo-connect.php';
if (!isset($_SESSION)) {
    session_start();
}
$title = '上架購票清單';
$pageName = 'ticket-list';
?>

<?php include __DIR__ . "/part/html-header.php"; ?>
<?php include __DIR__ . "/part/navbar-head.php"; ?>

    <style>

    .image {
        background: url(./2019102146596149.jpg) no-repeat center center;
        background-size: cover;
        width: 200px;
        height: 200px;
    }

    </style>

<div class="container-fluid p-0">
    <div class="row m-0">

        <div class="col-2 p-0"><?php include __DIR__ . "/part/left-bar.php"; ?></div>

        <div class="col-10 p-4">

            <h2 class="col-12 mt-5 fw-bold">上架購票管理</h2>

            <div class="col-12 mb-4 text-end">
                <a class="btn btn-primary" href="ticket-add.php">新增購票</a>
            </div>

            <div class="col-12">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="col-12">
                <table class="table table-hover table-striped table-bordered caption-top text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">選取</th>
                            <th scope="col">刪除資料</th>
                            <th scope="col">購票編號</th>
                            <th scope="col">活動圖片</th>
                            <th scope="col">活動名稱</th>
                            <th scope="col">演出藝人</th>
                            <th scope="col">活動地點</th>
                            <th scope="col">活動描述</th>
                            <th scope="col">活動時間</th>
                            <th scope="col">可購票數</th>
                            <th scope="col">購票價格</th>
                            <th scope="col">活動分類</th>
                            <th scope="col">活動座位</th>
                            <th scope="col">主辦單位</th>
                            <th scope="col">建立時間</th>
                            <th scope="col">修改時間</th>
                            <th scope="col">修改資料</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row"><input type="checkbox"></th>
                            <td><a class="btn btn-danger" href="javascript:;"><i class="bi bi-trash3"></i></a></td>
                            <td>1</td>
                            <td class="image"></td>
                            <td>黑暗榮耀</td>
                            <td>Jin、Chloe、Daniel、Yun</td>
                            <td>資展國際</td>
                            <td>好看</td>
                            <td>2021-05-30<br>18:00</td>
                            <td>1000</td>
                            <td>7999</td>
                            <td>演唱會</td>
                            <td>A、B、C、D、E</td>
                            <td>資展國際</td>
                            <td>2021-05-11<br>17:00</td>
                            <td>2021-05-11<br>18:00</td>
                            <td><a class="btn btn-warning" href="ticket-edit.php"><i class="bi bi-pencil-square"></i></a></td>
                    </tbody>
                </table>
            </div>

        </div>

    </div>

</div>
<?php include __DIR__ . "/part/scripts.php"; ?>
<?php include __DIR__ . "/part/html-footer.php"; ?>
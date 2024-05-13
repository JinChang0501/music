<?php
require __DIR__ . '/admin-required.php';
require __DIR__ . '/../config/pdo-connect.php';

$title = '上架購票清單';
$pageName = 'ticket-list';

$perPage = 3; # 每一頁最多有幾筆

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    header('Location: ?page=1');
    exit; # 結束這支程式
}

$t_sql = "SELECT COUNT(tid) FROM ticket;";

# 總筆數
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

# 預設值
$totalPages = 0;
$rows = [];

if ($totalRows) {
    # 總頁數
    $totalPages = ceil($totalRows / $perPage);
    if ($page > $totalPages) {
        header("Location: ?page={$totalPages}");
        exit; # 結束這支程式
    }

    # 取得分頁資料
    $sql = sprintf(
        "SELECT * FROM ticket JOIN activities ON ticket.activities_id = activities.id JOIN aclass ON activities.id = aclass.id JOIN artist ON activities.id = artist.id ORDER BY ticket.tid ASC LIMIT %s, %s",
        ($page - 1) * $perPage,
        $perPage
    );
    $rows = $pdo->query($sql)->fetchAll();
}

/*
echo json_encode([
'totalRows' => $totalRows,
'totalPages' => $totalPages,
'page' => $page,
'rows' => $rows,
]);
*/
?>

<?php include __DIR__ . "/part/html-header.php"; ?>
<?php include __DIR__ . "/part/navbar-head.php"; ?>

<style>
    .image {
        max-width: 300px;
    }

    .model-a {
        text-decoration: none;
        color: lightgray;
    }

    .model-a:hover {
        color: white;
    }
</style>

<div class="container-fluid p-0">
    <div class="row m-0">

        <div class="col-2 p-0"><?php include __DIR__ . "/part/left-bar.php"; ?></div>

        <div class="col-10 p-4">

            <h2 class="col-12 mt-5 mb-4 fw-bold">上架購票管理</h2>

            <div class="col-12 mb-3 d-flex justify-content-end">

                <div class="input-group mb-3 w-50">
                    <button class="btn btn-secondary dropdown-toggle fw-bold" type="button" id="dropdownMenuButton2"
                        data-bs-toggle="dropdown">
                        請選擇要查詢的項目
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item active" href="#">活動名稱</a></li>
                        <li><a class="dropdown-item" href="#">活動描述</a></li>
                    </ul>
                    <input type="search" class="form-control border-5" name="search" placeholder="請輸入要搜尋的內容...">
                    <input type="submit" class="btn btn-secondary fw-bold" value="搜尋">
                </div>

            </div>

            <div class="col-12 mb-3 d-flex justify-content-end">
                <div class="d-flex mb-3">
                    <input type="number" class="form-control border-5" name="number" placeholder="最小價格">
                    <span class="mx-4 d-flex align-items-center fw-bold">一</span>
                    <input type="number" class="form-control border-5 me-4" name="number" placeholder="最大價格">
                    <input type="submit" class="btn btn-secondary fw-bold" value="搜尋價格範圍">
                </div>
            </div>

            <div class="col-12 mb-3 d-flex justify-content-end">

                <div class="d-flex align-items-center fs-5 me-4 fw-bold bg-secondary text-white rounded-pill px-4">
                    篩選活動座位</div>

                <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                    <input type="checkbox" class="btn-check" id="btncheck1" name="btncheck1" autocomplete="off">
                    <label class="btn btn-outline-secondary fw-bold" for="btncheck1">A</label>

                    <input type="checkbox" class="btn-check" id="btncheck2" name="btncheck2" autocomplete="off">
                    <label class="btn btn-outline-secondary fw-bold" for="btncheck2">B</label>

                    <input type="checkbox" class="btn-check" id="btncheck3" name="btncheck3" autocomplete="off">
                    <label class="btn btn-outline-secondary fw-bold" for="btncheck3">C</label>

                    <input type="checkbox" class="btn-check" id="btncheck4" name="btncheck4" autocomplete="off">
                    <label class="btn btn-outline-secondary fw-bold" for="btncheck4">D</label>

                    <input type="checkbox" class="btn-check" id="btncheck5" name="btncheck5" autocomplete="off">
                    <label class="btn btn-outline-secondary fw-bold" for="btncheck5">E</label>
                </div>

            </div>


            <div class="d-flex justify-content-between col-12 mb-4">
                <div>
                    <a class="btn btn-secondary fw-bold" href="ticket-add.php">新增購票</a>
                    <a class="btn btn-secondary fw-bold" href="ticket-add.php">刪除所選</a>
                    <a class="btn btn-secondary fw-bold" href="javascript:;">音樂祭</a>
                    <a class="btn btn-secondary fw-bold" href="javascript:;">演唱會</a>
                    <a class="btn btn-secondary fw-bold" href="javascript:;">顯示全部</a>
                </div>

                <div data-bs-toggle="modal" data-bs-target="#Modal">
                    <a class="btn btn-secondary fw-bold" href="javascript:;">篩選器&nbsp;&nbsp;<i
                            class="bi bi-filter"></i></a>
                </div>
            </div>

            <div class="col-12 mb-4">
                <table
                    class="table table-hover table-striped table-bordered caption-top text-center align-middle fw-bold">
                    <thead class="table-light">
                        <tr class="align-middle">
                            <th scope="col">全選<br><input type="checkbox" class="cb_all"></th>
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
                    <tbody class="tb">
                        <?php foreach ($rows as $r): ?>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td><a class="btn btn-danger" href="javascript: deleteOne(<?= $r['tid'] ?>)">
                                        <i class="bi bi-trash3"></i>
                                    </a></td>
                                <td><?= $r['tid'] ?></td>
                                <td><img src="<?= $r['picture'] ?>" class="image img-thumbnail" alt="activities_picture">
                                </td>
                                <td><?= $r['activity_name'] ?></td>
                                <td><?= $r['art_name'] ?></td>
                                <td><?= $r['location'] ?></td>
                                <td><?= $r['descriptions'] ?></td>
                                <td><?= $r['a_date'] . '<br><br>' . $r['a_time'] ?></td>
                                <td><?= $r['counts'] ?></td>
                                <td><?= $r['price'] ?></td>
                                <td><?= $r['class'] ?></td>
                                <td><?= $r['ticket_area'] ?></td>
                                <td><?= $r['organizer'] ?></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <a class="btn btn-warning" href="ticket-edit.php?tid=<?= $r['tid'] ?>">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="col-12">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=1">
                                <i class="fa-solid fa-angles-left"></i>
                            </a>
                        </li>
                        <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= max(1, $page - 1) ?>">
                                <i class="fa-solid fa-angle-left"></i>
                            </a>
                        </li>

                        <?php for ($i = $page - 5; $i <= $page + 5; $i++):
                            if ($i >= 1 and $i <= $totalPages): ?>
                                <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endif; endfor; ?>
                        <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= min($totalPages, $page + 1) ?>">
                                <i class="fa-solid fa-angle-right"></i>
                            </a>
                        </li>

                        <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $totalPages ?>">
                                <i class="fa-solid fa-angles-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

        </div>

    </div>

</div>

<!-- model -->

<div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="Modal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark position-relative">

            <div class="position-absolute top-0 end-0">
                <button type="button" class="btn-close bg-white fs-4" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="d-flex justify-content-center my-4 mb-3">
                <div>
                    <h4 class="fw-bold text-white">搜尋篩選器</h4>
                </div>
            </div>

            <div class="modal-body">
                <div class="container-fluid">
                    <table class="table table-borderless table-dark">
                        <thead>
                            <tr>
                                <th>購票編號</th>
                                <th>可購票數</th>
                                <th>購票價格</th>
                                <th>活動時間</th>
                                <th>建立時間</th>
                                <th>修改時間</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a class="model-a" href="">由大到小</a></th>
                                <td><a class="model-a" href="">由多到少</a></td>
                                <td><a class="model-a" href="">由高到低</a></td>
                                <td><a class="model-a" href="">最近活動時間</a></td>
                                <td><a class="model-a" href="">最新建立時間</a></td>
                                <td><a class="model-a" href="">最新修改時間</a></td>
                            </tr>
                            <tr>
                                <td><a class="model-a" href="">由小到大</a></th>
                                <td><a class="model-a" href="">由少到多</a></td>
                                <td><a class="model-a" href="">由低到高</a></td>
                                <td><a class="model-a" href="">最遠活動時間</a></td>
                                <td><a class="model-a" href="">最舊建立時間</a></td>
                                <td><a class="model-a" href="">最舊修改時間</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . "/part/scripts.php"; ?>
<script>
    const deleteOne = (tid) => {
        if (confirm(`是否要刪除編號為 ${tid} 的資料?`)) {
            location.href = `ticket-list-delete.php?tid=${tid}`;
        }
    }

    let cb_all = document.querySelector('.cb_all');
    let tbs = document.querySelector('.tb').querySelectorAll('input');

    cb_all.addEventListener('click', function () {
        for (let i = 0; i < tbs.length; i++) {
            tbs[i].checked = this.checked;
        }
    });

    for (let i = 0; i < tbs.length; i++) {
        tbs[i].onclick = function () {
            let flag = true;
            for (let i = 0; i < tbs.length; i++) {
                if (!tbs[i].checked) {
                    flag = false;
                    break;
                }
            }
            cb_all.checked = flag;
        }
    }
</script>
<?php include __DIR__ . "/part/html-footer.php"; ?>
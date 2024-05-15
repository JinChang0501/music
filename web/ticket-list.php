<?php
require __DIR__ . '/admin-required.php';
require __DIR__ . '/../config/pdo-connect.php';

$title = '上架購票清單';
$pageName = 'ticket-list';

$perPage = 5; # 每一頁最多有幾筆

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    header('Location: ?page=1');
    exit; # 結束這支程式
}

$sort = isset($_GET['sort']) ? $_GET['sort'] : 'tid';
$order = isset($_GET['order']) ? $_GET['order'] : 'asc';
$order = $order === 'desc' ? 'DESC' : 'ASC';

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
        "SELECT 
        *
    FROM 
        ticket
    JOIN 
        activities ON ticket.activities_id = activities.actid
    JOIN 
        aclass ON activities.activity_class = aclass.id
    JOIN 
        artist ON activities.artist_id = artist.id ORDER BY $sort $order LIMIT %s, %s",
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

    .tb .description {
        max-width: 400px;
        /* 设置最大宽度为400px */
        overflow: hidden;
        /* 当文字溢出时隐藏 */
        text-overflow: ellipsis;
        /* 当文字溢出时以省略号显示 */
        white-space: nowrap;
        /* 禁止文字换行 */
    }

    .spacing {
        letter-spacing: 2px;
    }

    .bg-color {
        background-color: tomato;
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
                    <input type="search" class="textSearch form-control border-5" name="search"
                        placeholder="請輸入要搜尋的內容...">
                    <input type="submit" class="search btn btn-secondary fw-bold" value="搜尋">
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
                    <a id="dltAllSelect" class="btn btn-secondary fw-bold">刪除所選</a>
                    <a class="musicFestival btn btn-secondary fw-bold">music festival</a>
                    <a class="concert btn lightgraytn btn-secondary fw-bold">concert</a>
                    <a class="reload btn btn-secondary fw-bold">顯示全部</a>
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
                                <td>
                                    <div>
                                        <input class="checkboxes form-check-input mx-auto text-center d-flex "
                                            type="checkbox" value="<?= $r['tid'] ?>" id="flexCheckDefault<?= $r['tid'] ?>">
                                    </div>
                                </td>
                                <td><a class="btn btn-danger" href="javascript: deleteOne(<?= $r['tid'] ?>)">
                                        <i class="bi bi-trash3"></i>
                                    </a></td>
                                <td><?= $r['tid'] ?></td>
                                <td><img src="<?= $r['picture'] ?>" class="image img-thumbnail" alt="activities_picture">
                                </td>
                                <td><?= $r['activity_name'] ?></td>
                                <td><?= $r['art_name'] ?></td>
                                <td><?= $r['location'] ?></td>
                                <td class="description" data-bs-toggle="modal" data-bs-target="#description">
                                    <?= $r['descriptions'] ?>
                                </td>
                                <td><?= $r['a_date'] . '<br><br>' . $r['a_time'] ?></td>
                                <td><?= $r['counts'] ?></td>
                                <td><?= $r['price'] ?></td>
                                <td><?= $r['class'] ?></td>
                                <td><?= $r['ticket_area'] ?></td>
                                <td><?= $r['organizer'] ?></td>
                                <td><?= $r['created_at'] ?></td>
                                <td><?= $r['editTime'] ?></td>
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
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content bg-dark position-relative">

            <div class="position-absolute top-0 end-0">
                <button type="button" class="btn-close bg-white fs-4" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="d-flex justify-content-center my-4 mb-3">
                <div>
                    <h4 class="fw-bold text-white fs-3">搜尋篩選器</h4>
                </div>
            </div>

            <div class="modal-body fs-3 fw-bold text-white p-5 lh-lg spacing">
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
                        <tbody class="filter">
                            <tr>
                                <td><a class="model-a" href="?sort=tid&order=desc&page=<?= $page ?>">由大到小</a></td>
                                <td><a class="model-a" href="?sort=tid&order=desc&page=<?= $page ?>">由多到少</a></td>
                                <td><a class="model-a" href="?sort=tid&order=desc&page=<?= $page ?>">由高到低</a></td>
                                <td><a class="model-a" href="?sort=tid&order=desc&page=<?= $page ?>">最近活動時間</a></td>
                                <td><a class="model-a" href="?sort=tid&order=desc&page=<?= $page ?>">最新建立時間</a></td>
                                <td><a class="model-a" href="?sort=tid&order=desc&page=<?= $page ?>">最新修改時間</a></td>
                            </tr>
                            <tr>
                                <td><a class="model-a" href="?sort=tid&order=asc&page=<?= $page ?>">由小到大</a></th>
                                <td><a class="model-a" href="?sort=tid&order=asc&page=<?= $page ?>">由少到多</a></td>
                                <td><a class="model-a" href="?sort=tid&order=asc&page=<?= $page ?>">由低到高</a></td>
                                <td><a class="model-a" href="?sort=tid&order=asc&page=<?= $page ?>">最遠活動時間</a></td>
                                <td><a class="model-a" href="?sort=tid&order=asc&page=<?= $page ?>">最舊建立時間</a></td>
                                <td><a class="model-a" href="?sort=tid&order=asc&page=<?= $page ?>">最舊修改時間</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- description -->

<!-- Modal -->
<div class="modal fade " id="description" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content bg-dark position-relative">
            <div class="position-absolute top-0 end-0">
                <button type="button" class="btn-close bg-white fs-4" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="d-flex justify-content-center my-4 mb-3">
                <div>
                    <h4 class="fw-bold text-white fs-2">搜尋篩選器</h4>
                </div>
            </div>
            <div class="modal-body fs-2 fw-bold text-white p-5 lh-lg spacing">
                <?= $r['descriptions'] ?>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . "/part/scripts.php"; ?>
<script>
    // search

    const searchInput = document.querySelector('.textSearch');
    const searchButton = document.querySelector('.search');

    searchButton.addEventListener('click', function () {
        const searchText = searchInput.value;
        // 使用 AJAX 向後端發送請求
        fetch(`ticket-search-api.php?keyword=${searchText}`)
            .then(response => response.json())
            .then(data => {
                // 更新前端頁面，例如更新表格內容
                updateTable(data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });

    // search

    // reload

    const reload = document.querySelector('.reload');

    reload.addEventListener('click', function () {
        // 在 JavaScript 中重新整理頁面
        location.reload();
    });

    // reload

    /* musicFestival-api */

    const musicFestival = document.querySelector('.musicFestival');

    musicFestival.addEventListener('click', function () {
        // 發送 AJAX 請求到後端
        fetch('ticket-musicFestival-api.php')
            .then(response => response.json())
            .then(data => {
                // 更新前端頁面
                updateTable(data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });

    function updateTable(data) {
        const tbody = document.querySelector('.tb');
        tbody.innerHTML = ''; // 清空表格內容
        data.forEach(row => {
            const tr = document.createElement('tr');
            // 創建表格行並填充數據
            tr.innerHTML = `
            <td><input type="checkbox"></td>
            <td><a class="btn btn-danger" href="javascript: deleteOne(${row['tid']})">
                <i class="bi bi-trash3"></i>
                </a></td>
            <td>${row['tid']}</td>
            <td><img src="${row['picture']}" class="image img-thumbnail" alt="activities_picture"></td>
            <td>${row['activity_name']}</td>
            <td>${row['art_name']}</td>
            <td>${row['location']}</td>
            <td>${row['descriptions']}</td>
            <td>${row['a_date']}<br><br>${row['a_time']}</td>
            <td>${row['counts']}</td>
            <td>${row['price']}</td>
            <td>${row['class']}</td>
            <td>${row['ticket_area']}</td>
            <td>${row['organizer']}</td>
            <td></td>
            <td></td>
            <td>
                <a class="btn btn-warning" href="ticket-edit.php?id=${row['tid']}">
                    <i class="bi bi-pencil-square"></i>
                </a>
            </td>
        `;
            tbody.appendChild(tr);
        });
    }

    /* musicFestival-api */

    /* concert-api */

    const concert = document.querySelector('.concert');

    concert.addEventListener('click', function () {
        // 發送 AJAX 請求到後端
        fetch('ticket-concert-api.php')
            .then(response => response.json())
            .then(data => {
                // 更新前端頁面
                updateTable(data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });

    function updateTable(data) {
        const tbody = document.querySelector('.tb');
        tbody.innerHTML = ''; // 清空表格內容
        data.forEach(row => {
            const tr = document.createElement('tr');
            // 創建表格行並填充數據
            tr.innerHTML = `
        <td><input type="checkbox"></td>
        <td><a class="btn btn-danger" href="javascript: deleteOne(${row['tid']})">
            <i class="bi bi-trash3"></i>
            </a></td>
        <td>${row['tid']}</td>
        <td><img src="${row['picture']}" class="image img-thumbnail" alt="activities_picture"></td>
        <td>${row['activity_name']}</td>
        <td>${row['art_name']}</td>
        <td>${row['location']}</td>
        <td>${row['descriptions']}</td>
        <td>${row['a_date']}<br><br>${row['a_time']}</td>
        <td>${row['counts']}</td>
        <td>${row['price']}</td>
        <td>${row['class']}</td>
        <td>${row['ticket_area']}</td>
        <td>${row['organizer']}</td>
        <td></td>
        <td></td>
        <td>
            <a class="btn btn-warning" href="ticket-edit.php?id=${row['tid']}">
                <i class="bi bi-pencil-square"></i>
            </a>
        </td>
    `;
            tbody.appendChild(tr);
        });
    }

    /* concert-api */

    // delete

    const deleteOne = (tid) => {
        if (confirm(`是否要刪除編號為 ${tid} 的資料?`)) {
            location.href = `ticket-list-delete.php?tid=${tid}`;
        }
    }

    // delete

    // 全選反選

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

    // 全選反選

    // 刪除所選Script

    const dltAllSelect = document.getElementById("dltAllSelect");
    const checkboxes2 = document.querySelectorAll(".checkboxes");

    dltAllSelect.addEventListener('click', function () {
        let selectedIds = []; // 儲存被勾選項目的 ID

        for (let i = 0; i < checkboxes2.length; i++) {
            if (checkboxes2[i].checked) {
                const id = checkboxes2[i].value; // 獲取被勾選項目的 ID
                selectedIds.push(id); // 將 ID 加入到 selectedIds 陣列中
            }
        }

        if (selectedIds.length > 0) {
            if (confirm(`確定要刪除這 ${selectedIds.length} 筆資料嗎?`)) {
                // 執行刪除操作，這裡可以使用 AJAX 或者其他方式向後端發送刪除請求
                // 這裡假設你已經有了一個可以處理刪除的後端接口
                location.href = `ticket-delete-more.php?tids=${selectedIds.join(',')}`;
            }
        } else {
            alert('請先選擇要刪除的資料');
        }
    });

    // 刪除所選Script

    // 獲取所有帶有類名 "model-a" 的元素
    const filter = document.querySelector('.filter');
    const links = filter.querySelectorAll('.model-a');
    for (let i = 0; i < links.length; i++) {
        links[i].addEventListener('click', function () {
            // 先清除所有連結的背景色
            for (let j = 0; j < links.length; j++) {
                links[j].style.backgroundColor = '';
            }
            // 然後設定被點擊的連結的背景色
            this.style.backgroundColor = 'tomato';
        });
    }



</script>
<?php include __DIR__ . "/part/html-footer.php"; ?>
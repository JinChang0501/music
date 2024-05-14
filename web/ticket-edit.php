<?php
require __DIR__ . '/admin-required.php';
require __DIR__ . '/../config/pdo-connect.php';

$title = '編輯購票';
$pageName = 'ticket-edit';

$tid = isset($_GET['tid']) ? intval($_GET['tid']) : 0;
if ($tid < 1) {
    header('Location: ticket-list.php');
    exit;
}

$sql = "SELECT 
*
FROM 
ticket
JOIN 
activities ON ticket.activities_id = activities.actid
JOIN 
aclass ON activities.activity_class = aclass.id
JOIN 
artist ON activities.artist_id = artist.id WHERE tid={$tid}";

$row = $pdo->query($sql)->fetch();
if (empty($row)) {
    header('Location: ticket-list.php');
    exit;
}

?>

<?php include __DIR__ . "/part/html-header.php"; ?>
<?php include __DIR__ . "/part/navbar-head.php"; ?>

<style>
    .add {
        border-radius: 30px;
        margin-top: 120px;
        padding: 40px 100px;
    }
</style>

<div class="container-fluid p-0 mb-5">
    <div class="row m-0">
        <div class="col-2 p-0"><?php include __DIR__ . "/part/left-bar.php"; ?></div>
        <div class="col-7 mx-auto">

            <form id="ticketForm" name="ticketForm" class="needs-validation shadow-lg add" novalidate>

                <input type="hidden" name="sid" value="<?= $row['tid'] ?>">


                <h1 class="text-center mb-5 fw-bold">新增購票</h1>

                <div class="row mb-4 justify-content-evenly">
                    <div class="col-2 form-label">
                        <label for="activities_id" class="form-label fs-5 fw-bold">選擇活動</label>
                    </div>
                    <div class="col-8">
                        <select name="activities_id" class="form-select rounded-3 border-4" id="activities_id" required>
                        </select>
                        <div class="invalid-feedback">
                            請選擇活動
                        </div>
                    </div>
                </div>

                <div class="row mb-4 justify-content-evenly">
                    <div class="col-2 form-label">
                        <label for="ticket_area" class="form-label fs-5 fw-bold">選擇區域</label>
                    </div>
                    <div class="col-8">
                        <select name="ticket_area" class="form-select rounded-3 border-4" id="ticket_area" required>
                        </select>
                        <div class="invalid-feedback">
                            請選擇區域
                        </div>
                    </div>
                </div>

                <div class="row mb-4 justify-content-evenly">
                    <div class="col-2 form-label">
                        <label for="counts" class="form-label fs-5 fw-bold">區域票數</label>
                    </div>
                    <div class="col-8">
                        <input type="text" id="counts" name="counts" class="form-control rounded-3 border-4" required
                            placeholder="請輸入票數" value="<?= $row['counts'] ?>">
                        <div class="invalid-feedback">
                            請輸入票數
                        </div>
                    </div>
                </div>

                <div class="row mb-4 justify-content-evenly">
                    <div class="col-2 form-label">
                        <label for="price" class="form-label fs-5 fw-bold">區域票價</label>
                    </div>
                    <div class="col-8">
                        <input type="text" id="price" name="price" class="form-control rounded-3 border-4" required
                            placeholder="請輸入票價" value="<?= $row['price'] ?>">
                        <div class="invalid-feedback">
                            請輸入票價
                        </div>
                    </div>
                </div>

                <!-- <div class="row mb-4 justify-content-evenly">
                    <div class="col-2 form-label">
                        <label for="date" class="form-label fs-5 fw-bold">上架時間</label>
                    </div>
                    <div class="col-8">
                        <input type="datetime-local" id="date" name="date" class="form-control rounded-3 border-4"
                            required>
                        <div class="invalid-feedback">
                            請選擇上架時間
                        </div>
                    </div>
                </div> -->

                <div class="text-start ms-5">
                    <button type="submit" class="btn btn-primary fs-5 fw-bold">送出</button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- Modal edit-success -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">修改成功</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success" role="alert">
                    資料修改成功
                </div>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-primary" onclick="location.href='ticket-list.php'">到列表頁</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續新增</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal edit-fail -->
<div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">新增失敗</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success" role="alert">
                    資料新增失敗
                </div>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-primary" onclick="location.href='ticket-list.php'">到列表頁</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續新增</button>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . "/part/scripts.php"; ?>

<script>
    const myModal = new bootstrap.Modal('#staticBackdrop')
    const myModal2 = new bootstrap.Modal('#staticBackdrop2')
    const sendData = e => {
        e.preventDefault(); // 不要讓 form1 以傳統的方式送出

        let isPass = true;  // 表單有沒有通過檢查

        const activities_id = document.getElementById('activities_id').value;
        const ticket_area = document.getElementById('ticket_area').value;
        const counts = document.getElementById('counts').value;
        const price = document.getElementById('price').value;

        // 檢查每個欄位是否有值
        if (!activities_id.trim() || !ticket_area.trim() || !counts.trim() || !price.trim()) {
            isPass = false;
        }

        // 有通過檢查, 才要送表單
        if (isPass) {
            const fd = new FormData(); // 創建 FormData 物件
            fd.append('activities_id', activities_id);
            fd.append('ticket_area', ticket_area);
            fd.append('counts', counts);
            fd.append('price', price);

            fetch('ticket-add-api.php', {
                method: 'POST',
                body: fd,
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.success) {
                        // 顯示成功提示
                        myModal.show();
                    } else {
                        // 處理錯誤
                        myModal2.show();
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    };



    // 發送AJAX請求獲取activities資料
    fetch('ticket-get-activities-api.php')
        .then(response => response.json())
        .then(data => {


            // ticket_area

            const areaSelect = document.getElementById('ticket_area');

            // 清空下拉選單
            areaSelect.innerHTML = '';
            // 先添加預設的選項
            const areaValue = "<?php echo $row['ticket_area'] ?>";
            const areaDefaultOption = document.createElement('option');
            areaDefaultOption.value = areaValue;
            areaDefaultOption.innerText = areaValue;
            // 動態生成 ABCDE 選項
            data.forEach(optionText => {
                const option = document.createElement('option');
                option.value = optionText;
                option.textContent = optionText;
                areaSelect.appendChild(option);
            });

            // ticket_area








            // 獲取下拉選單元素
            const activitiesSelect = document.getElementById('activities_id');
            // 清空下拉選單
            activitiesSelect.innerHTML = '';

            // 先添加預設的選項
            const actidOp = "<?php echo $row['actid'] ?>";
            const acnameOp = "<?php echo $row['activity_name'] ?>";
            const defaultOption = document.createElement('option');
            defaultOption.value = actidOp;
            defaultOption.innerText = acnameOp;
            // defaultOption.value = ""; // 給定一個空的 value
            activitiesSelect.appendChild(defaultOption);
            // 將activities資料動態添加到下拉選單中
            data.forEach(activities => {
                const option = document.createElement('option');
                option.value = activities.actid;
                option.textContent = activities.activity_name;
                activitiesSelect.appendChild(option);
            });

            // 為表單添加提交事件監聽器
            const ticketForm = document.getElementById('ticketForm');
            ticketForm.addEventListener('submit', sendData);

            // 在選擇活動 select 欄位變化時執行的函數
            const onActivitySelectChange = () => {
                const selectedActivityId = activitiesSelect.value; // 取得選擇的活動ID
                console.log(selectedActivityId);
                // 找到選擇的活動的對象
                const selectedActivity = data.find(activity => activity.actid === parseInt(selectedActivityId));
                // 在這裡處理從後端獲取的單個活動資訊
                console.log(selectedActivity);
            };

            // 監聽選擇活動 select 欄位的變化事件
            activitiesSelect.addEventListener('change', onActivitySelectChange);
        })
        .catch(error => console.error('Error fetching activities:', error));

</script>

<?php include __DIR__ . "/part/html-footer.php"; ?>
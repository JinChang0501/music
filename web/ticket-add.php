<?php
require __DIR__ . '/admin-required.php';
if (!isset($_SESSION)) {
    session_start();
}
$title = '新增購票';
$pageName = 'ticket-add';
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

            <form name="ticketForm" action="ticket-list.php" class="needs-validation shadow-lg add" novalidate
                onsubmit="sendData(event)">

                <h1 class="text-center mb-5 fw-bold">新增購票</h1>

                <div class="row mb-4 justify-content-evenly">
                    <div class="col-2 form-label">
                        <label for="activities_id" class="form-label fs-5 fw-bold">選擇活動</label>
                    </div>
                    <div class="col-8">
                        <select name="activities_id" class="form-select rounded-3 border-4" id="activities_id" required>
                            <option selected disabled value="">--- &nbsp;選擇活動&nbsp;---</option>
                            <option>IU</option>
                            <option>ED Sheeran</option>
                            <option>Clodplay</option>
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
                            <option selected disabled value="">--- &nbsp;選擇區域&nbsp;---</option>
                            <option>A</option>
                            <option>B</option>
                            <option>C</option>
                            <option>D</option>
                            <option>E</option>
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
                            placeholder="請輸入票數">
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
                            placeholder="請輸入票價">
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
                    <input class="btn btn-primary fs-5 fw-bold" type="submit" value="送出">
                </div>

            </form>

        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">新增成功</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success" role="alert">
                    資料新增成功
                </div>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-primary" onclick="location.href='list.php'">到列表頁</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續新增</button>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . "/part/scripts.php"; ?>

<script>
    const activities_id = document.ticketForm.activities_id;
    const ticket_area = document.ticketForm.ticket_area;
    const counts = document.ticketForm.counts;
    const price = document.ticketForm.price;

    const sendData = e => {
        e.preventDefault(); // 不要讓 form1 以傳統的方式送出

        let isPass = true;  // 表單有沒有通過檢查

        if (!activities_id.value.trim()) {
            isPass = false;
        }
        if (!ticket_area.value.trim()) {
            isPass = false;
        }
        if (!counts.value.trim()) {
            isPass = false;
        }
        if (!price.value.trim()) {
            isPass = false;
        }

        // 有通過檢查, 才要送表單
        if (isPass) {
            const fd = new FormData(document.ticketForm); // 沒有外觀的表單物件

            fetch('ticket-add-api.php', {
                method: 'POST',
                body: fd, // Content-Type: multipart/form-data
            }).then(r => r.json())
                .then(data => {
                    console.log(data);
                    if (data.success) {
                        window.location.href = 'ticket-list.php';
                        myModal.show();
                    } else {
                    }
                })
                .catch(ex => console.log(ex))
        }
    };

    const myModal = new bootstrap.Modal('#staticBackdrop')
</script>

<?php include __DIR__ . "/part/html-footer.php"; ?>
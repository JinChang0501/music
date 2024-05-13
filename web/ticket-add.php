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

<div class="container-fluid p-0">
    <div class="row m-0">
        <div class="col-2 p-0"><?php include __DIR__ . "/part/left-bar.php"; ?></div>
        <div class="col-7 mx-auto">

            <form action="ticket-list.php" class="needs-validation shadow-lg add" novalidate onsubmit="sendData(event)">

                <h1 class="text-center mb-5 fw-bold">新增購票</h1>

                <div class="row mb-4 justify-content-evenly">
                    <div class="col-2 form-label">
                        <label for="activities" class="form-label fs-5 fw-bold">選擇活動</label>
                    </div>
                    <div class="col-8">
                        <select class="form-select rounded-3 border-4" id="activities" required>
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
                        <label for="area" class="form-label fs-5 fw-bold">選擇區域</label>
                    </div>
                    <div class="col-8">
                        <select class="form-select rounded-3 border-4" id="area" required>
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

                <div class="row mb-4 justify-content-evenly">
                    <div class="col-2 form-label">
                        <label for="count" class="form-label fs-5 fw-bold">區域票數</label>
                    </div>
                    <div class="col-8">
                        <input type="text" id="count" name="count" class="form-control rounded-3 border-4" required
                            placeholder="請輸入票數">
                        <div class="invalid-feedback">
                            請輸入票數
                        </div>
                    </div>
                </div>

                <div class="row mb-4 justify-content-evenly">
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
                </div>

                <div class="text-start ms-5">
                    <input class="btn btn-primary fs-5 fw-bold" type="submit" value="送出">
                </div>

            </form>

        </div>
    </div>
</div>

<?php include __DIR__ . "/part/scripts.php"; ?>
<?php include __DIR__ . "/part/html-footer.php"; ?>
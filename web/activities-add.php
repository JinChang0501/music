<?php
require __DIR__ . '/admin-required.php';

if (!isset($_SESSION)) {
	session_start();
}


$title = '新增活動列表';
$pageName = 'add-activities';
?>


<?php include __DIR__ . "/part/html-header.php"; ?>
<?php include __DIR__ . "/part/navbar-head.php"; ?>

<style>
	form .mb-3 .form-text {
		color: red;
		font-weight: 800;
	}
</style>
<div class="container-fluid">
	<div class="row">
		<div class="col-2 p-0">
			<?php include __DIR__ . "/part/left-bar.php"; ?></div>
		<div class="col-10">
			<div class="card mt-3">
				<div class="card-body">
					<h5 class="card-title">新增活動資料</h5>
					<form name="form1" onsubmit="sendData(event)">
						<div class="mb-3">
							<label for="activity_class" class="form-label">類別</label>
							<input type="text" class="form-control" id="activity_class" name="activity_class">
							<div class="form-text"></div>
						</div>

						<div class="mb-3">
							<label for="activity_name" class="form-label">活動名稱</label>
							<input type="text" class="form-control" id="activity_name" name="activity_name">
							<div class="form-text"></div>
						</div>

						<div class="mb-3">
							<label for="a_date" class="form-label">日期</label>
							<input type="date" class="form-control" id="a_date" name="a_date">
							<div class="form-text"></div>
						</div>

						<div class="mb-3">
							<label for="a_time" class="form-label">時間</label>
							<input type="time" class="form-control" id="a_time" name="a_time">
							<div class="form-text"></div>
						</div>

						<div class="mb-3">
							<label for="location" class="form-label">地點</label>
							<input type="text" class="form-control" id="location" name="location">
							<div class="form-text"></div>
						</div>

						<div class="mb-3">
							<label for="descriptions" class="form-label">活動內容</label>
							<textarea id="descriptions" cols="60" rows="3" name="descriptions"></textarea>
							<div class="form-text"></div>
						</div>

						<div class="mb-3">
							<label for="organizer" class="form-label">主辦單位</label>
							<input type="text" class="form-control" id="organizer" name="organizer">
							<div class="form-text"></div>
						</div>

						<div class="mb-3">
							<label for="artist_id" class="form-label">表演者</label>
							<input type="text" class="form-control" id="artist_id" name="artist_id">
							<div class="form-text"></div>
						</div>

						<div class="mb-3">
							<label for="picture" class="form-label">圖片</label>
							<input type="text" class="form-control" id="picture" name="picture">
							<div class="form-text"></div>
						</div>

						<button type="submit" class="btn btn-primary">新增</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal Start-->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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

				<button type="button" class="btn btn-primary" onclick="location.href='list-members.php'">到列表頁</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續新增</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal End-->

<?php include __DIR__ . "/part/scripts.php"; ?>
<script>
	const first_nameField = document.form1.first_name;
	const last_nameField = document.form1.last_name;
	const emailField = document.form1.email;

	function validateEmail(email) {
		const re =
			/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}


	const sendData = e => {
		e.preventDefault(); // 不要讓 form1 以傳統的方式送出

		first_nameField.style.border = '1px solid #CCCCCC';
		first_nameField.nextElementSibling.innerText = '';
		last_nameField.style.border = '1px solid #CCCCCC';
		last_nameField.nextElementSibling.innerText = '';
		emailField.style.border = '1px solid #CCCCCC';
		emailField.nextElementSibling.innerText = '';

		// TODO: 欄位資料檢查
		let isPass = true; // 表單有沒有通過檢查
		if (first_nameField.value.length < 2) {
			isPass = false;
			first_nameField.style.border = '1px solid red';
			first_nameField.nextElementSibling.innerText = '請填寫正確的姓名';
		}

		if (last_nameField.value.length < 0) {
			isPass = false;
			last_nameField.style.border = '1px solid red';
			last_nameField.nextElementSibling.innerText = '請填寫正確的姓名';
		}

		if (!validateEmail(emailField.value)) {
			isPass = false;
			emailField.style.border = '1px solid red';
			emailField.nextElementSibling.innerText = '請填寫正確的 Email';
		}
		// 有通過檢查, 才要送表單
		if (isPass) {
			const fd = new FormData(document.form1); // 沒有外觀的表單物件
			fetch('members-add-api.php', {
					method: 'POST',
					body: fd, // Content-Type: multipart/form-data
				}).then(r => r.json())
				.then(data => {
					console.log(data);
					if (data.success) {
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
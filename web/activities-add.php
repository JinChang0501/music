<?php
require __DIR__ . '/admin-required.php';

if (!isset($_SESSION)) {
	session_start();
}

$title = '新增活動列表';
$pageName = 'activities-add';
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
			<?php include __DIR__ . "/part/left-bar.php"; ?>
		</div>
		<div class="col-8 mt-3 mx-auto">
			<div class="card my-3">
				<div class="card-body">
					<h4 class="card-title fw-bold">新增活動資料</h4>
					<form name="form_activities" onsubmit="sendData(event)">
						<div class="mb-3">
							<label for="activity_class" class="form-label">類別</label>
							<select class="form-select" aria-label="Default select example" id="activity_class" name="activity_class">
								<option selected>--</option>
								<option value="1">演唱會</option>
								<option value="2">音樂祭</option>
							</select>
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
							<label for="address" class="form-label">地址</label>
							<input type="text" class="form-control" id="address" name="address">
							<div class="form-text"></div>
						</div>

						<div class="mb-3">
							<label for="descriptions" class="form-label">活動內容</label>
							<textarea class="form-control" id="descriptions" rows="4" name="descriptions"></textarea>
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
						<!-- 藝人多選 -->
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
							<label class="form-check-label" for="flexCheckDefault">
								Default checkbox
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
							<label class="form-check-label" for="flexCheckChecked">
								Checked checkbox
							</label>
						</div>
						<!-- 藝人多選 -->
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
<div class="modal fade" id="staticBackdropA" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabelA" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="staticBackdropLabelA">新增成功</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="alert alert-success" role="alert">
					資料新增成功
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" onclick="location.href='activities-list.php'">到列表頁</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續新增</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal End-->

<?php include __DIR__ . "/part/scripts.php"; ?>
<script>
	// const activity_class = document.form_activities.activity_class;
	const activity_nameField = document.form_activities.activity_name;

	const sendData = e => {
		e.preventDefault(); // 不要讓 form_activities 以傳統的方式送出

		// activity_class.style.border = '1px solid #CCCCCC';
		// activity_class.nextElementSibling.innerText = '';
		activity_nameField.style.border = '1px solid #CCCCCC';
		activity_nameField.nextElementSibling.innerText = '';

		// TODO: 欄位資料檢查
		let isPass = true; // 表單有沒有通過檢查

		// if ((activity_class.value < 1) || (activity_class.value > 2)) {
		// 	isPass = false;
		// 	activity_nameField.style.border = '1px solid red';
		// 	activity_nameField.nextElementSibling.innerText = '請選擇類別';
		// }

		if (activity_nameField.value.length < 2) {
			isPass = false;
			activity_nameField.style.border = '1px solid red';
			activity_nameField.nextElementSibling.innerText = '請填寫正確的活動名稱';
		}

		// 有通過檢查, 才要送表單
		if (isPass) {
			const fd = new FormData(document.form_activities); // 沒有外觀的表單物件

			fetch('activities-add-api.php', {
					method: 'POST',
					body: fd, // Content-Type: multipart/form-data
				}).then(r => r.json())
				.then(data => {
					console.log(data);
					if (data.success) {
						myModalA.show();
					} else {}
				})
				.catch(ex => console.log(ex))
		}
	};

	const myModalA = new bootstrap.Modal('#staticBackdropA')
</script>
<?php include __DIR__ . "/part/html-footer.php"; ?>
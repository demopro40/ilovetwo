<div class="container">
	<div class="row">
		<div class="col-md-3">
			<form action="UploadPost" method="post" enctype="multipart/form-data">
				@csrf
				<input type="hidden" name=""  value="" />
				<input type="file" name="file"  accept=".xlsx" />
				<br>
				<input type="submit" class="btn btn-primary" value="送出" />
			</form>
		</div>
		<div class="col-md-9">
			<ul>
				<li>約會調查表上傳(男生版)檔名請改成 dating_survey_m.xlsx </li>
				<li>約會調查表上傳(女生版)檔名請改成 dating_survey_f.xlsx </li>
			</ul>
		</div>
	</div>
</div>

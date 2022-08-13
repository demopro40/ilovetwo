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
				<!-- <li>上傳排約資料表檔名請改成 data.xlsx</li> -->
				 
			</ul>
		</div>
	</div>
</div>

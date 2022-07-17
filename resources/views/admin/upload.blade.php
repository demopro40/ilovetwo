<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
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
		<div class="col-md-12">
			<br>
			<br>
			<canvas id="dating_survey" width="400" height="200"></canvas>
		</div>
	</div>
</div>
<script>
  	var ctx = document.getElementById( "dating_survey" ),
  		example = new Chart(ctx, {
  			type: "bar", // 圖表類型
  			data: {
  				labels: [ "1", "2", "3","1", "2", "3" ], // 標題
  				datasets: [{
  					label: "約會調查表", // 標籤
  					data: [ 12, 19, 3, 12, 19, 3 ], // 資料
  					backgroundColor: [ // 背景色
						"#FF0000",
						"#00FF00",
						"#0000FF",
						"#FF0000",
						"#00FF00",
						"#0000FF",
  					],
  					borderWidth: 1 // 外框寬度
  				}]
  			}
  		});
  </script>
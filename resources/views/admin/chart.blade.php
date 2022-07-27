<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<br>
			<br>
			<canvas id="dating_survey" width="400" height="200"></canvas><br>
			<canvas id="dating_survey2" width="400" height="200"></canvas><br>
		</div>
	</div>
</div>
<script>
  	var chart = new Chart(document.getElementById( "dating_survey" ), {
  			type: "bar", // 圖表類型
  			data: {
  				labels: [ 
					"外在形象(髮型、妝容、穿著、體態)",
					"儀態(行為舉動、禮儀姿態)",
					"談吐情商(內在涵養、表達能力)",
					"互動狀況(主動度、交流意願)",
					"約會整體滿意度",
				], // 標題
  				datasets: [{
  					label: "約會調查表", // 標籤
  					data: [ 10/5, 25/5, 18/5, 15/5, 20/5, 0], // 資料
  					backgroundColor: [ // 背景色
						"red",
						"pink",
						"green",
						"blue",
						"gray",
  					],
  					borderWidth: 1 // 外框寬度
  				}]
  			}
  		});
	var chart2 = new Chart(document.getElementById( "dating_survey2" ), {
  			type: "bar", // 圖表類型
  			data: {
  				labels: [ 
					"外在形象(髮型、妝容、穿著、體態)",
					"儀態(行為舉動、禮儀姿態)",
					"談吐情商(內在涵養、表達能力)",
					"互動狀況(主動度、交流意願)",
					"約會整體滿意度",
				], // 標題
  				datasets: [{
  					label: "約會調查表", // 標籤
  					data: [ 10/5, 25/5, 18/5, 15/5, 5/5, 0], // 資料
  					backgroundColor: [ // 背景色
						"red",
						"pink",
						"green",
						"blue",
						"gray",
  					],
  					borderWidth: 1 // 外框寬度
  				}]
  			}
  		});
  </script>